<div class="all-achievements" wire:poll.300ms>
    @if($users->isNotEmpty())
    <div class="search-navbar">
        <div class="group">
            <svg viewBox="0 0 24 24" aria-hidden="true" class="iconSearch">
                <g>
                    <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                </g>
            </svg>
            <input class="input" type="search" placeholder="{{__('translate.search')}}" wire:model.debounce.300ms="search" name="search" />
        </div>
    </div>
    @endif
    <div class="achievements">
        <div class="requestsAchievements">
            @forelse($users as $user)
            <div class="achievement">
                <x-header-status icon="bi bi-send" text="{{ __('translate.request') }}" status="" />

                <div class="body">
                    <div class="profileRequest">
                        <img src="https://ui-avatars.com/api/?uppercase=true&size=60&font-size=0.35&rounded=true&background=random&color=radnom&name={{ $user->name }}" alt="">
                        <strong class="name">{{$user->name}}</strong>
                    </div>
                    <div class="request-information">
                        <div class="info">
                            <span>{{ __('translate.usertype') }}
                                <strong class="mark @switch($user?->type) @case('Customer') scarlet @break @case('Company') goldenYellow @break @case('Governmental') || @case('AdminGovernmental') electricPurple @break @endswitch">
                                    {{ optional($user)->type }}
                                </strong>
                            </span>
                            <span>{{ __('translate.email') }} <strong class="details">{{$user->email}}</strong></span>
                            <span>{{ __('translate.totalRequests') }} <strong class="details"> {{ $user->requests_count }}</strong></span>
                        </div>
                    </div>
                </div>
                <div class="footer" wire:ignore>
                    <div class="requestButtons">
                        <x-tooltip-form :route="route('View-Achievement')" name="uid" class="button hoverButton" :rid=null :uid="encrypt($user->id)" icon="bi bi-eye bt-icon" text="{{ __('translate.view') }}" />
                    </div>
                </div>
            </div>

            @empty
            <div class="empty emptyCenter emptyText">
                <i class="bi bi-eye icon"></i>
                &nbsp;
                <span>{{ __('translate.noAchievementsScene') }}</span>
            </div>
            @endforelse
        </div>
    </div>
</div>