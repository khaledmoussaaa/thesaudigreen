<div class="chats-container" wire:poll.300ms>
    <div class="chats-sidebar {{$selectedUser ? 'openChat' : ''}}">
        <div class="sidebar-rows">
            <div class="group sidebar-search">
                <svg viewBox="0 0 24 24" aria-hidden="true" class="iconSearch">
                    <g>
                        <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                    </g>
                </svg>
                <input class="input lightGray" type="search" placeholder="{{ __('translate.search') }}" wire:model.debounce.300ms="search" name="search" />
            </div>
            <div class="radio-inputs sidebar-radio">
                <label class="radio">
                    <input type="radio" name="radio" wire:model="selectedOption" class="create-choice" value="Conversations">
                    <span class="name">{{ __('translate.conversations') }}</span>
                </label>
                <label class="radio">
                    <input type="radio" name="radio" wire:model="selectedOption" class="create-choice" value="Users">
                    <span class="name">{{ __('translate.users') }}</span>
                </label>
            </div>
            <label class="archive pointer">
                <input type="radio" name="radio" wire:model="selectedOption" class="create-choice" value="Archives">
                <span class="name"><i class="bi bi-archive"></i>{{ __('translate.archived') }}</span>
            </label>
        </div>
        <div class="sidebar-users">
            @foreach($userConversations as $user)
            @if ($user['user'])
            <div class="mainProfile">
                <div class="user-profile hoverd pointer {{ $selectedUser ==  $user['user']->id ? 'hoverSelect' : '' }}" wire:click="setSelectedUser({{ $user['user']->id }})">
                    <div class="profile">
                        <img src="https://ui-avatars.com/api/?uppercase=true&size=60&font-size=0.35&rounded=true&background=random&color=radnom&name={{ $user['user']->name}}" alt="">
                    </div>
                    <div class="about">
                        <strong class="details text-ellipsis">{{ $user['user']->name }}</strong>
                        <span class="lastmessage text-ellipsis">{{ $user['lastmessage'] ?? $user['user']->type }}</span>
                    </div>
                    <span class="message-count {{ $user['user']?->messages_count && $selectedUser != $user['user']->id ? '' : 'hide' }}">{{ $user['user']?->messages_count }}</span>
                    <span class="line-row"></span>
                </div>
                @if($selectedOption != 'Users')
                <div x-data="{ open: false }">
                    <i class="bi bi-three-dots menus pointer" @click="open = ! open"></i>
                    <div x-show="open" class="toggle-menu">
                        <i class="bi bi-archive pointer" @click="open = ! open" wire:click="archives({{ $user['user']->id }})"> {{ $user['user']->archive ? __('translate.unarchive') : __('translate.archive') }}</i>
                        <i class="bi bi-trash scarlet transparent pointer" @click="open = ! open" wire:click="delete({{ $user['user']->id }})"> {{__('translate.delete')}}</i>
                    </div>
                </div>
                @endif
            </div>
            @endif
            @endforeach
        </div>
        @if($userConversations->isEmpty())
        <div class="empty emptyCenter emptyText">
            <i class="bi bi-{{ $selectedOption == 'Archives' ? 'archive' : ($selectedOption == 'Conversations' ? 'chat-text' : 'people') }} icon"></i>
            &nbsp; &nbsp;
            <span>{{$selectedOption == 'Archives' ? __('translate.archivesEmpty') : ($selectedOption == 'Conversations' ? __('translate.conversationsEmpty') : __('translate.usersEmpty')) }}</span>
        </div>
        @endif
    </div>

    @if($selectedUser != 0)
    <div class="chats-conversation {{ $selectedUser ? 'openChat' : '' }}">
        <div class="conversation-header">
            @foreach($users as $user)
            @if($user->id == $selectedUser)
            <div class="user-profile">
                <i class="bi bi-chevron-left backHide pointer" wire:click="setSelectedUser(0)"></i>
                <div class="profile">
                    <img src="https://ui-avatars.com/api/?uppercase=true&size=60&font-size=0.35&rounded=true&background=random&color=radnom&name={{ $user->name }}" alt="">
                </div>
                <div class="about">
                    <strong class="details text-ellipsis">{{ $user->name }}</strong>
                    <span class="user-status" wire:offline.attr="disabled"></span>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        <div class="conversation-container">
            <div class="messages-container">
                @forelse ($conversations as $timePeriod => $messagesByDate)
                @foreach ($messagesByDate as $date => $conversations)
                <div class="timePeriod">
                    <span>{{ $timePeriod }} </span>
                </div>
                @foreach($conversations as $conversation)
                @if ($conversation->user_id != Auth()->user()->chats_id)
                <div class="received message">
                    <div class="income {{ $conversation->photo_path ? 'photo' : '' }}">
                        @if($conversation->photo_path)
                        <img src="{{ asset($conversation->photo_path) }}" alt="Photo" class="chat-photo" onclick="openPhotoModal('{{ asset($conversation->photo_path) }}')">
                        @elseif($conversation->file_path)
                        <a href="{{ asset($conversation->file_path) }}"><i class="bi bi-file-earmark-text"> {{ __('translate.file') }}</i></a>
                        @else
                        {{ $conversation->message }}
                        @endif
                        <div class="message-about">
                            <div class="message-time">{{ $conversation->created_at->format('h:m A') }}</div>
                        </div>
                    </div>
                </div>
                @else
                <div class="send message">
                    <div class="outcome {{ $conversation->photo_path ? 'photo' : '' }}">
                        @if($conversation->photo_path)
                        <img src="{{ asset($conversation->photo_path) }}" alt="Photo" class="chat-photo" onclick="openPhotoModal('{{ asset($conversation->photo_path) }}')">
                        @elseif($conversation->file_path)
                        <a href="{{ asset($conversation->file_path) }}"><i class="bi bi-file-earmark-text"> {{ __('translate.file') }}</i></a>
                        @else
                        {{ $conversation->message }}
                        @endif
                        <div class="message-about">
                            <div class="message-time">{{ $conversation->created_at->format('h:m A') }}</div>
                            <i class="bi bi-check-all seen {{ $conversation->seen ? 'dodgerBlue transparent' : '' }}"></i>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
                @endforeach
                @empty
                <div class="empty emptyText">
                    <span>{{ __('translate.conversationEmpty') }}</span>
                </div>
                @endforelse
            </div>
        </div>

        <div class="input-container">
            <form wire:submit.prevent="createMessage" enctype="multipart/form-data" class="chatForm">
                <div for="file" class="attatchment" onclick="attatchment()" wire:ignore>
                    <i class="bi bi-paperclip"></i>
                    <div class="fileChoose">
                        <label for="photo" class="fileSelect pointer">
                            <i class="bi bi-image gray transparent"><span>{{ __('translate.photos') }}</span></i>
                        </label>
                        <label for="file" class="fileSelect pointer">
                            <i class="bi bi-file-text gray transparent"><span>{{ __('translate.files') }}</span></i>
                        </label>
                        <input type="file" id="file" name="file" wire:model.lazy="file" accept=".pdf,.doc,.docx,.xlsx,.xls,.pptx,.ppt">
                        <input type="file" id="photo" name="photo" wire:model.lazy="photo" accept="image/*">
                    </div>
                </div>
                @if ($errors->any())
                <div class="chat-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <span>{{ $error }}</span>
                        @endforeach
                    </ul>
                </div>
                @endif

                <textarea name="message" id="typingMessage" cols="30" rows="10" placeholder="{{ __('translate.typeMessage') }}" class="sendMessage" wire:model="message"></textarea>
                <button class="sendButton"><i class="bi bi-send-fill"></i></button>
            </form>
        </div>
        @else
        <div class="chats-conversation">
            <div class="conversation-container">
                <div class="empty emptyImg emptyCenter">
                    <img src="{{ asset('Images/ICONS/Chat-Icon.png') }}" alt="">
                    <span class="emptyText">{{ __('translate.noChatsSelected') }}</span>
                </div>
            </div>
        </div>
        @endif
        <div id="photoModal" class="modal" onclick="closePhotoModal()" wire:ignore>
            <span class="close">&times;</span>
            <img class="modal-content" id="modalPhoto">
        </div>
    </div>
</div>
@livewireScripts
<script src="{{ asset('JS/chats.js') }}"></script>