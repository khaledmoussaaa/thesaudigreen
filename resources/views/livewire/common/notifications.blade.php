<!-- livewire/common/notifications.blade.php -->

<div wire:poll>
    @forelse($notifications as $notification)

    @if($type == 'Admin')
    <div class="formSubmit pointer" wire:click="navigateAdmin('{{ $notification['type'] }}', {{ $notification['rid'] }}, {{ $notification['ofd'] }})">
        <div class="content">
            <div class="body">
                <div class="profileRequest">
                    <div class="profile">
                        <img src="https://ui-avatars.com/api/?uppercase=false&background=random&color=radnom&name={{ $notification['name'] }}" alt="">
                    </div>
                    <div class="profileText">
                        <strong class="details">{{ $notification['name'] }}</strong>
                        @if($notification['type'] === 'Request')
                        <strong class="mark goldenYellow">
                            <i class="bi bi-dot"> {{__('translate.newRequest') }}</i>
                        </strong>
                        @else
                        <strong class="mark {{$notification['status'] == in_array($notification['status'], [1, 3]) ? 'mintCream' : 'scarlet'}}">
                            <i class="bi bi-dot">
                                @if ($notification['status'] == 1)
                                {{ __('translate.offerAccept') }}
                                @elseif ($notification['status'] == 2)
                                {{ __('translate.offerDecline') }}
                                @elseif ($notification['status'] == 3)
                                {{ __('translate.firstApproval') }}
                                @elseif ($notification['status'] == 4)
                                {{ __('translate.firstReject') }}
                                @endif
                            </i>
                        </strong>
                        @endif
                    </div>
                </div>
                <div class="notifcaionContent">
                    <span>{{ __('translate.email') }} <strong class="details">{{ $notification['email'] }}</strong></span>
                    <span>{{ $notification['type'] === 'Request' ? __('translate.requestID') : __('translate.offerNumber') }} <strong class="details">{{ $notification['type'] === 'Request' ? 'SS'.$notification['rid'] : $notification['ofn'] }}</strong></span>
                    <span> {{ $notification['type'] === 'OfferPrice' ? __('translate.forRequestId') : '' }} <strong class="details">{{ $notification['type'] === 'OfferPrice' ? 'SS'.$notification['rid']  : '' }}</strong></span>
                </div>
            </div>
            <div class="footer" wire:ignore>
                <div class="date">
                    <span><i class="bi bi-calendar"> {{ $notification['date'] }}</i></span>
                    <span><i class="bi bi-clock"></i> {{ $notification['time'] }}</span>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="formSubmit pointer" wire:click="navigateCustomer('{{ $notification['type'] }}', {{ $notification['rid'] }}, {{ $notification['ofd'] }})">
        <div class="content">
            <div class="body">
                <div class="profileRequest">
                    <div class="notificaionLogo">
                        <img src="{{ asset('Images/Logos/Logo.svg') }}" alt="">
                    </div>
                    <div class="profileText">
                        <strong>The Saudi Green</strong>
                        @if($notification['type'] === 'Request')
                        <strong class="mark bolder @switch($notification['status']) @case('1') gray @break @case('2') scarlet @break @case('3') mintCream @break @case('4') lightGray @break @case('5') lightBlue  @break @endswitch">
                            <i class="bi bi-dot">
                                @switch($notification['status'])
                                @case('1') {{__('translate.requestInprocess')}} @break
                                @case('2') {{__('translate.requestDeclined')}} @break
                                @case('3') {{__('translate.requestInProgress')}} @break
                                @case('4') {{__('translate.requestFinished')}} @break
                                @case('5') {{__('translate.requestCompleted')}} @break
                                @endswitch
                            </i>
                        </strong>
                        @else
                        <span class="mark dodgerBlue bolder">
                            <i class="bi bi-dot">{{__('translate.newOffer') }}</i>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="notifcaionContent">
                    <span>{{ $notification['type'] === 'Request' ? __('translate.requestID') : __('translate.offerNumber') }} <strong class="details">{{ $notification['type'] === 'Request' ? 'SS'.$notification['rid'] : $notification['ofn'] }}</strong></span>
                    <span> {{ $notification['type'] === 'OfferPrice' ? __('translate.forRequestId') : '' }} <strong class="details">{{ $notification['type'] === 'OfferPrice' ? 'SS'.$notification['rid']  : '' }}</strong></span>
                </div>
            </div>
            <div class="footer" wire:ignore>
                <div class="date">
                    <span><i class="bi bi-calendar"> {{ $notification['date'] }}</i></span>
                    <span><i class="bi bi-clock"></i> {{ $notification['time'] }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    @empty
    <div class="empty emptyCenter emptyText">
        <i class="bi bi-bell-slash icon"></i>
        &nbsp; &nbsp;
        <span>{{ __('translate.noNotifications') }}</span>
    </div>
    @endforelse
</div>

<script src="{{ asset('JS/submit.js') }}"></script>