<div class="all-requests" wire:poll.300ms>
    <div wire:ignore>
        @if(Session('success') || Session('error') )
        <div class="alert {{session('success') ? 'success' : 'danger'}}" wire:ignore>
            {{ session('success') ?? session('error') }}
        </div>
        @endif
    </div>
    <div class="request-navbar nav">
        @if($requests->isNotEmpty() || $search)
        <div class="search-navbar half-width">
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
        @cannot('adminGovernmental')
        <form method="GET" action="{{route('Intialize-Request')}}">
            @csrf
            <button type="submit" class="submit">
                <i class="bi bi-plus-lg bt-icon"></i>
                <span>{{ __('translate.create') }}</span>
            </button>
        </form>
        @endcannot
    </div>

    <div class="requests-container requests-container-customer">
        <div class="requests">
            @foreach($requests as $request)
            <div class="request">
                <x-header-status icon="bi bi-send" text="{{ __('translate.request') }}" status="{{ $request->status }}" />

                <div class="body">
                    <div class="profileRequest">
                        <img src="https://ui-avatars.com/api/?uppercase=true&size=60&font-size=0.35&rounded=true&background=random&color=radnom&name={{ $request->user->name }}" alt="">
                        <strong class="details">{{ $request->user ? $request->user->name : '' }}</strong>
                    </div>
                    <div class="request-information">
                        <div class="info">
                            @if($request->total_price)
                            <span class="mark {{ $request->total_price->status == 0 ? 'dodgerBlue' : ($request->total_price->status == in_array($request->total_price->status, [1,3]) ? 'mintCream' : 'scarlet') }}">
                                @switch($request->total_price->status)
                                @case(0)
                                {{ __('translate.checkYourOfferPrice') }}
                                @break

                                @case(1)
                                {{ __('translate.youAcceptedOffer') }}
                                @break

                                @case(2)
                                {{ __('translate.youDeclinedOffer') }}
                                @break

                                @case(3)
                                {{ __('translate.firstApproval') }}
                                @break

                                @case(4)
                                {{ __('translate.firstReject') }}
                                @break
                                @endswitch
                            </span>
                            @endif
                            <span>{{ __('translate.email') }} <strong class="details">{{ $request->user ? $request->user->email : '' }}</strong></span>
                            <span>{{ __('translate.requestID') }} <strong class="details">SS{{ $request->id }}</strong></span>
                            <span>{{ __('translate.numberOfCars') }} <strong class="details">{{ count($request->request_details) }}</strong></span>
                        </div>
                        <div class="info right">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ __('translate.factory') }}</th>
                                        <th>{{ __('translate.modelYear') }}</th>
                                        <th>{{ __('translate.plate') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($request->request_details as $details)
                                    <tr>
                                        <td data-title="{{ __('translate.factory') }}">{{ $details->factory }}</td>
                                        <td data-title="{{ __('translate.plate') }}">{{ $details->model_year }}</td>
                                        <td data-title="{{ __('translate.modelYear') }}">{{ $details->plate }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="footer">
                    <div class="date">
                        <span><i class="bi bi-calendar"></i>{{ $request->created_at->format('D - d/m/y') }}</span>
                        <span><i class="bi bi-clock"></i>{{ $request->created_at->format('h:i A') }}</span>
                    </div>

                    <div class="requestButtons">
                        <div class="requestButtons">
                            @cannot('adminGovernmental')
                            @if(!$request->total_price && $request->status == 0)
                            <x-tooltip-form :route="route('Edit-Request')" name="rid" class="button hoverButton success" :rid="encrypt($request->id)" :uid="null" icon="bi bi-pen bt-icon" text="{{ __('translate.edit') }}" />
                            @endif
                            @endcannot
                            <x-tooltip-form :route="route('Offer-Price')" name="rid" class="button hoverButton" :rid="encrypt($request->id)" :uid="null" icon="bi bi-receipt-cutoff bt-icon" text="{{ __('translate.offerPrice') }}" />
                            <x-tooltip-form :route="route('Customer-View-Request')" name="rid" class="button hoverButton" :rid="encrypt($request->id)" :uid=null icon="bi bi-eye bt-icon" text="{{ __('translate.view') }}" />
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($requests->isEmpty())
            @can('adminGovernmental')
            <div class="empty emptyText heyMessage">
                <span>{{ __('translate.heyMessageAdmin') }}</span>
            </div>
            @else
            <div class="empty emptyText heyMessage">
                <span>{{ __('translate.heyMessage') }}</span>
            </div>
            @endcan
        @endif
    </div>
</div>
<script src="{{ asset('JS/alert.js') }}"></script>