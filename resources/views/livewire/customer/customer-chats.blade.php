<div class="chats-container" wire:poll.300ms>
    <div class="chats-conversation">
        <div class="conversation-header">
            <div class="user-profile">
                <div class="notificaionLogo">
                    <img src="{{ asset('Images/Logos/Logo.svg') }}" alt="">
                </div>
                <div class="about">
                    <strong class="details text-ellipsis">Admin Support</strong>
                </div>
            </div>
        </div>

        <div class="conversation-container">
            <div class="messages-container">
                @forelse ($conversations as $timePeriod => $messagesByDate)
                @foreach ($messagesByDate as $date => $conversations)
                <div class="timePeriod">
                    <span>{{ $timePeriod }} </span>
                    <span>{{ $date }}</span>
                </div>
                @foreach($conversations as $conversation)
                @if ($conversation->user_id != Auth()->user()->id)
                <div class="received message">
                    <div class="income {{ $conversation->photo_path ? 'photo' : '' }}">
                        @if($conversation->photo_path)
                        <img src="{{ asset($conversation->photo_path) }}" alt="Photo" class="chat-photo" onclick="openPhotoModal('{{ asset($conversation->photo_path) }}')">
                        @elseif($conversation->file_path)
                        <a href="{{ asset($conversation->file_path) }}">File</a>
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
                            <i class="bi bi-image gray transparent"><span>{{__('translate.photos')}}</span></i>
                        </label>
                        <label for="file" class="fileSelect pointer">
                            <i class="bi bi-file-text gray transparent"><span>{{__('translate.files')}}</span></i>
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
                <textarea name="message" id="typingMessage" cols="30" rows="10" placeholder="{{__('translate.typeMessage')}}" class="sendMessage" wire:model="message"></textarea>
                <button class="sendButton"><i class="bi bi-send-fill"></i></button>
            </form>
        </div>
        <div id="photoModal" class="modal" onclick="closePhotoModal()" wire:ignore>
            <span class="close">&times;</span>
            <img class="modal-content" id="modalPhoto">
        </div>
    </div>
</div>
@livewireScripts
<script src="{{ asset('JS/chats.js') }}"></script>