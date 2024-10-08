<div class="test" wire:poll>
    <!-- Dashboard -->
    <div class="dashboard">

        <!-- Cards -->
        <div class="cards" wire:ignore>
            <section class="splide" aria-label="Splide Basic HTML Example">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach($counts as $key => $count)
                        <li class="splide__slide">
                            <form method="GET" action="{{ route('Requests') }}" class="card formSubmit">
                                @csrf
                                <div class="cardTitle">
                                    <!-- Icon and Title based on key -->
                                    <i class="{{ $icons[$key] }} cardIcon {{ $colors[$key] }}"></i>
                                    <span class="cardText">{{ __('translate.' . $titles[$key]) }}</span>
                                </div>
                                <span class="cardCount">{{ $count }}</span>
                                <div class="cardRow {{ $colors[$key] }}"></div>
                                <input type="hidden" name="view" value="{{ $key }}" class="getId">
                            </form>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </section>
        </div>

        <!-- Abouts -->
        <div class="abouts">
            <div class="counters">
            <header class="semibold title">{{__('translate.overview')}}</header>
                <div class="design">
                    <img src="{{asset('Images/ICONS/Design.png')}}" alt="">
                </div>
                <div class="banner">
                    @foreach($typesCounts as $key => $count)
                    <div class="design-count">
                        <span class="numbers semibold">{{ $count }}</span>
                        <span class="lighter">{{ $title[$key] }}</span>
                    </div>
                    @if($key != 2)
                    <div class="vertical"></div>
                    @endif
                    @endforeach
                </div>
            </div>

            <div class="team-members">
                <header class="semibold headers">{{__('translate.members')}}</header>
                <div class="members">
                    @foreach($users as $user)
                    <div class="mbember">
                        <div class="profile-image {{$user->connection ? 'dot' : ''}}">
                            <img src="https://ui-avatars.com/api/?uppercase=true&size=60&font-size=0.35&rounded=true&background=random&color=radnom&name={{ $user->name }}" alt="">
                        </div>
                        <div class="profile-information">
                            <span class="name ">{{ $user->name }}</span>
                            <span class="lighter">{{ __('translate.' . strtolower($user->type)) }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Notice -->

        <div class="notice">
            <!-- Orders -->
            <header class="semibold headers">{{__('translate.requestUnseen')}}</header>
            <div class="orders">
                @forelse($requests as $request)
                <div class="order">
                    <div class="calender">
                        <span>{{$request->created_at->format('m') }}</span>
                        <span class="lighter">{{$request->created_at->format('D') }}</span>
                    </div>
                    <div class="about-order">
                        <span class="head">{{__('translate.requestFrom').' '.$request->user->name}}</span>
                        <span class="lighter">{{$user->type}} . <span class="heavy">{{$request->created_at->format('h:i a') }}</span></span>
                    </div>
                    <form method="GET" action="{{route('View-Request')}}" class="view-order">
                        @csrf
                        <input type="hidden" name="rid" value="{{encrypt($request->id)}}">
                        <button type="submit" class="reset pointer">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
            @if($requests->isEmpty())
            <div class="empty emptyCenter emptyText">
                <i class="bi bi-clipboard2-x icon"></i>
                &nbsp;
                <span>{{ __('translate.noRequest') }}</span>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('JS/submit.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var isRtl = "{{ app()->isLocale('ar') ? 'true' : 'false' }}"; // Adjust the condition based on your actual locale detection mechanism
        var direction = isRtl === 'true' ? 'rtl' : 'ltr';
        var index = isRtl === 'true' ? -7 : 0;
        var splide = new Splide('.splide', {
            width: '100%',
            start: index,
            perPage: 4,
            orient: 100,
            gap: 10,
            direction: direction,
            pagination: false,
            breakpoints: {
                525: {
                    perPage: 1,
                },
                1000: {
                    perPage: 2,
                },

                1200: {
                    perPage: 3,
                },

            },
        });
        splide.mount();
    });
</script>