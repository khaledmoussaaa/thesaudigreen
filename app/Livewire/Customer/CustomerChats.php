<?php

namespace App\Livewire\Customer;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class CustomerChats extends Component
{
    use WithFileUploads;

    public $admin;
    public $customer;

    public $message;
    public $photo;
    public $file;

    // Mount
    public function mount()
    {
        $this->admin = User::find(1)->chats_id;
        $this->customer = Auth::id();
    }

    // Render the Livewire component.
    public function render()
    {
        $conversations = $this->conversations();
        $this->updateSeen();
        $this->scrolling();

        if ($this->file) {
            $this->message = $this->file->getClientOriginalName();
        } else if ($this->photo) {
            $this->message = $this->photo->getClientOriginalName();
        }

        return view('livewire.customer.customer-chats', compact('conversations'));
    }

    // Create a Message
    public function createMessage()
    {
        $this->validate(
            [
                'message' => 'required||string',
                'file' => 'nullable|file|mimes:pdf,doc,docx,xlsx,xls,pptx,ppt|max:10240',
                'photo' => 'nullable|image|mimes:jpeg,png,gif|max:10240',
            ]
        );

        try {
            $message = [
                'user_id' => $this->customer,
                'recipient_id' => $this->admin,
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

    // Fetches Conversations
    public function conversations()
    {
        $conversations = Message::withTrashed()->whereIn('user_id', [$this->customer, $this->admin])
            ->whereIn('recipient_id', [$this->customer, $this->admin])->get();

        $groupedConversations = [];

        foreach ($conversations as $conversation) {
            $date = $conversation['created_at']->toDateString();
            $isToday = $conversation['created_at']->isToday();
            $isYesterday = $conversation['created_at']->isYesterday();

            if ($isToday) {
                $groupedConversations['Today'][$date][] = $conversation;
            } elseif ($isYesterday) {
                $groupedConversations['Yesterday'][$date][] = $conversation;
            } else {
                $formattedDate = $conversation['created_at']->format('F j, Y');
                $groupedConversations[$formattedDate][$date][] = $conversation;
            }
        }
        return collect($groupedConversations);
    }

    // Get last message
    public function scrolling()
    {
        $lastMessage = Message::where('user_id', $this->admin)->where('recipient_id', $this->customer)->latest()->first();

        if (session('last_message') != $lastMessage?->message) {
            session(['last_message' =>  $lastMessage?->message]);
            $this->dispatch('scrollBottom');
        }
    }

    // Update Seen
    public function updateSeen()
    {
        Message::where('user_id', $this->admin)
            ->where('recipient_id', $this->customer)
            ->update(['seen' => 1]);
    }
}
