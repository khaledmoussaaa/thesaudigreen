<div class="all-requests" wire:poll>
    <div class="request-filter">
        <!-- Search Bar -->
        <div class="search-navbar">
            <div class="group">
                <svg viewBox="0 0 24 24" aria-hidden="true" class="iconSearch">
                    <g>
                        <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                    </g>
                </svg>
                <input class="input transparent" type="search" placeholder="{{ __('translate.search') }}" wire:model.debounce.300ms="search" name="search" />
            </div>
        </div>
        <!-- Request Staus Filter -->
        <div x-data="{ open: false }" class="filter pointer">
            <i class="bi bi-filter icon" @click="open = true"></i>
            <ul x-show="open" @click.outside="open = false" class="filter-dropdown">
                <li>
                    <label @click="open = false">
                        <input type="radio" name="radio" wire:model="selectedOption" class="create-choice" value="all">
                        <span class="name">{{ __('translate.all') }}</span>
                    </label>
                </li>
                @foreach(['pending', 'inprocess', 'declined', 'inprogress', 'finished', 'completed'] as $key => $status)
                <li wire:model="selectedOption" value="{{ $status }}">
                    <label @click="open = false">
                        <input type="radio" name="radio" wire:model="selectedOption" class="create-choice" value="{{ $key }}">
                        <span class="name">{{ __('translate.' . $status) }}</span>
                        <span class="count">{{ $counts[$status] }}</span>
                    </label>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Request Div -->
    <div class="requests-container adminRequest">
        <div class="requests">
            @foreach($requests as $request)
            <div class="request">

                <!-- Request Status -->
                <x-header-status icon="bi bi-send" text="{{ __('translate.request') }}" status="{{ $request->status }}" />

                <!-- Body OF Request -->
                <div class="body">

                    <!-- Profile Image -->
                    <div class="profileRequest">
                        <img src="https://ui-avatars.com/api/?uppercase=true&size=60&font-size=0.35&rounded=true&background=random&color=radnom&name={{ $request->user->name }}" alt="">
                        <strong class="name">{{ optional($request->user)->name }}</strong>
                    </div>

                    <!-- Request Inforamtion -->
                    <div class="request-information">
                        <div class="info">
                            @if($request->total_price)
                            <span class="mark {{ $request->total_price->status == 0 ? 'dodgerBlue' : ($request->total_price->status == in_array($request->total_price->status, [1,3]) ? 'mintCream' : 'scarlet') }}">
                                @switch($request->total_price->status)
                                @case(0)
                                {{ __('translate.checkYourOfferPrice') }}
                                @break

                                @case(1)
                                {{ __('translate.offerAccept') }}
                                @break

                                @case(2)
                                {{ __('translate.offerDecline') }}
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
                            <span>{{ __('translate.usertype') }}
                                <strong class="mark @switch($request->user->type) @case('Customer') scarlet @break @case('Company') goldenYellow @break @case('Governmental') || @case('EmployeeGovernmental')  electricPurple  @break @endswitch">
                                    {{ $request->user->type}}
                                </strong>
                            </span>
                            <span>{{ __('translate.address') }} <strong class="details">{{ optional($request->user)->address }}</strong></span>
                            <span>{{ __('translate.email') }} <strong class="details">{{ optional($request->user)->email }}</strong></span>
                            <span>{{ __('translate.requestID') }} <strong class="details">SS{{ $request->id }}</strong></span>
                            <span>{{ __('translate.numberOfCars') }} <strong class="details">{{ count($request->request_details) }}</strong></span>
                            <span>{{ __('translate.numberofferPrices') }} <strong class="details">{{ count($request->offers_prices) }}</strong></span>
                        </div>

                        <!-- Car Details -->
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
                <!-- Footer -->
                <div class="footer">

                    <div class="date">
                        <span><i class="bi bi-calendar"></i>{{ $request->created_at->format('D - d/m/y') }}</span>
                        <span><i class="bi bi-clock"></i>{{ $request->created_at->format('h:i A') }}</span>
                    </div>

                    <div class="requestButtons">
                        @can('admin')
                        <x-deleted-button click="$dispatch('alert', '{{ encrypt($request->id) }}')" />
                        @endcan
                        <x-tooltip-form :route="route('Offer-Prices', ['rid' => encrypt($request->id)])" name="rid" class="button hoverButton" :rid="null" :uid="null" icon="bi bi-receipt-cutoff bt-icon" text="{{ __('translate.offerPrice') }}" />
                        <x-tooltip-form :route="route('View-Request')" name="rid" class="button hoverButton" :rid="encrypt($request->id)" :uid=null icon="bi bi-eye bt-icon" text="{{ __('translate.view') }}" />
                    </div>
                </div>
            </div>
            @endforeach
            {{$requests->links('pagination-links')}}

        </div>

        <!-- If Reqquests Is Empty -->
        @if($requests->isEmpty())
        <div class="empty emptyCenter emptyText">
            <i class="bi bi-clipboard2-x icon"></i>
            &nbsp;
            <sparen>{{ __('translate.noRequest') }}</sparen>
        </div>
        @endif
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('JS/alert.js') }}"></script>