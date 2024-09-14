<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Message;
use App\Models\User;

class Chats extends Component
{
    use WithFileUploads;

    public $selectedOption = 'Conversations';
    public $selectedUser;
    public $auth;

    public $message;
    public $photo;
    public $file;

    public $search;

    public function mount($uid)
    {
        $this->auth = auth()->user()->chats_id;
        $this->selectedUser = $uid ? $uid : session('selectedUser');
    }

    // Render the Livewire component.
    public function render()
    {
        $users = $this->fetchesUsers();
        $userConversations = $this->fetchesUsersConversation();
        $this->updateSeen();
        $conversations = $this->selectedUser ? $this->conversations($this->selectedUser) : collect();

        if ($this->file) {
            $this->message = $this->file->getClientOriginalName();
        } else if ($this->photo) {
            $this->message = $this->photo->getClientOriginalName();
        }

        return view('livewire.admin.chats', compact('users', 'userConversations', 'conversations'));
    }

    // Create a Message
    public function createMessage()
    {
        $this->validate(
            [
                'message' => 'required|string',
                'file' => 'nullable|file|mimes:pdf,doc,docx,xlsx,xls,pptx,ppt|max:10240',
                'photo' => 'nullable|image|mimes:jpeg,png,gif|max:10240',
            ]
        );

        try {
            $message = [
                'user_id' => $this->auth,
                'recipient_id' => $this->selectedUser,
                'seen' => 0,
                'message' => $this->message,
                'photo_path' => '',
                'file_path' => '',
            ];

            $this->processFileUpload($message);
            Message::create($message);

            $this->reset(['message', 'photo', 'file']);
            $this->dispatch('scrollBottom');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    // Upload photos and files
    private function processFileUpload(&$messageData)
    {
        if ($this->photo || $this->file) {
            if ($this->photo) {
                $photoPath = $this->photo->store('photos', 'public');
                $messageData['photo_path'] .= 'storage/' . $photoPath;
            } elseif ($this->file) {
                $filePath = $this->file->store('files', 'public');
                $messageData['file_path'] .= 'storage/' . $filePath;
            }
        }
    }

    // Fetches users that has conversations or not
    public function fetchesUsersConversation()
    {
        $usersWithLastMessages = collect();

        if ($this->selectedOption == 'Conversations') {
            // Get All Users Unique Has Message
            $allUserIds = Message::where('user_id', $this->auth)
                ->orWhere('recipient_id', $this->auth)
                ->distinct()
                ->pluck('user_id')
                ->merge(Message::where('recipient_id', $this->auth)
                    ->orWhere('user_id', $this->auth)
                    ->distinct()
                    ->pluck('recipient_id'))
                ->unique();

            $allUserIds = $allUserIds->reject(function ($userId) {
                return $userId == $this->auth;
            });

            foreach ($allUserIds as $userId) {
                $latestMessage = Message::whereIn('user_id', [$this->auth, $userId])
                    ->whereIn('recipient_id', [$this->auth, $userId])
                    ->latest()
                    ->first();

                if ($latestMessage) {
                    $lastMessageInSession = session("last_message_$userId", '');

                    if ($lastMessageInSession != $latestMessage->message) {
                        session(["last_message_$userId" => $latestMessage->message]);
                        $this->dispatch('scrollBottom');
                    }

                    $users = User::withCount(['messages' => function ($query) {
                        $query->where('seen', 0);
                    }])->where('id', $userId)->where('archive', 0)->first();

                    $message = $latestMessage->message;

                    $usersWithLastMessages->push([
                        'user' => $users,
                        'lastmessage' => $message,
                        'lastmessage_time' => $latestMessage->created_at->format('h:i A'),
                    ]);
                }
            }
        } elseif ($this->selectedOption == 'Archives') {
            $users = User::where('usertype', 'Customer')->where('archive', 1)->get();
            foreach ($users as $user) {
                $usersWithLastMessages->push([
                    'user' => $user,
                ]);
            }
        } else {
            $users = User::where('usertype', 'Customer')->where('archive', 0)->get();
            foreach ($users as $user) {
                $usersWithLastMessages->push([
                    'user' => $user,
                ]);
            }
        }

        if ($this->search) {
            $usersWithLastMessages = $usersWithLastMessages->filter(function ($user) {
                return
                    stripos($user['user']?->name, $this->search) !== false ||
                    stripos($user['user']?->type, $this->search) !== false;
            });
        }

        return $usersWithLastMessages;
    }
    // Fetches users that has conversations or not
    public function fetchesUsers()
    {
        return User::where('usertype', 'Customer')->get();
    }

    // Fetches conversations between users
    private function conversations($selectedUser)
    {
        $conversations = Message::whereIn('user_id', [$this->auth, $selectedUser])
            ->whereIn('recipient_id', [$this->auth, $selectedUser])
            ->orderBy('created_at', 'asc')
            ->get();

        $groupedConversation = [];

        foreach ($conversations as $conversation) {
            $date = $conversation['created_at']->toDateString();
            $isToday = $conversation['created_at']->isToday();
            $isYesterday = $conversation['created_at']->isYesterday();

            if ($isToday) {
                $groupedConversation['Today'][$date][] = $conversation;
            } elseif ($isYesterday) {
                $groupedConversation['Yesterday'][$date][] = $conversation;
            } else {
                // For older dates, use the actual date
                $formattedDate = $conversation['created_at']->format('F j, Y');
                $groupedConversation[$formattedDate][$date][] = $conversation;
            }
        }
        return collect($groupedConversation);
    }

    // Selected UserId
    public function setSelectedUser($uid)
    {
        $this->selectedUser = $uid;
        session(['selectedUser' =>  $this->selectedUser]);
        $this->dispatch('scrollBottom');
        $this->updateSeen();
    }

    // Update Seen
    public function updateSeen()
    {
        Message::where('user_id', $this->selectedUser)
            ->where('recipient_id', $this->auth)
            ->update(['seen' => 1]);
    }

    // Archives Chats
    public function archives($chatId)
    {
        abort_unless($user = User::find($chatId), 400);
        $user->archive ?  $user->update(['archive' => 0]) : $user->update(['archive' => 1]);
    }

    // Delete Chats
    public function delete($chatId)
    {
        abort_unless(User::find($chatId), 400);

        Message::whereIn('user_id', [$this->auth, $chatId])
            ->whereIn('recipient_id', [$this->auth, $chatId])
            ->delete();
    }
}
