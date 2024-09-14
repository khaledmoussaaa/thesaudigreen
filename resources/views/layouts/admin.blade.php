<!-- Head -->
@include('layouts.head')

<body>
    <!-- Container -->
    <div class="container toggleActive sideActive" id="page">

        <!-- Navbar -->
        <div class="navbar toggleActive">
            <div class="navbar-items">
                <div class="pageTitle sideActive toggleActive">
                    <h1>@yield('title')</h1>
                </div>

                <!-- Notificaion Icon -->
                <div class="hidden toggleActive posaitionRelative">
                    <div class="notification" onclick="notification()">
                        <div class="bell-container">
                            <div class="bell">
                                <div id="count">
                                    <livewire:common.counts :status="'null'" :count="'notificationsAdmin'" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notificaion Container -->
                @extends('layouts.notifications')

                <!-- Languages Dropdown -->
                <div class="languages hidden toggleActive">
                    <div class="langShow">
                        <span>{{app()->getLocale() == 'en' ? 'English' : 'Arabic'}}</span>
                        <i class="bi bi-chevron-down" id="changeLang" onclick="changeLang()"></i>
                    </div>

                    <div class="dropItem">
                        <a href="{{ app()->getLocale() == 'en' ? route('languageConverter', 'ar') :  route('languageConverter', 'en')}}" type="button" class="lang-logo">
                            <img src="{{ app()->getLocale() == 'en' ? asset('Images/ICONS/Arabic-Logo.svg') : asset('Images/ICONS/English-Logo.svg') }}" class="">
                            <span>{{app()->getLocale() == 'en' ? 'Arabic' : 'English'}}</span>
                        </a>
                    </div>
                </div>

                <!-- Profile -->
                <div class="profile profileNav dot hidden toggleActive pointer profileBolder">
                    <a href="{{route ('profile.edit')}}"><img src="https://ui-avatars.com/api/?uppercase=true&size=60&font-size=0.35&rounded=true&background=random&color=radnom&name={{ Auth()->user()->name }}" alt=""></a>
                </div>

            </div>
            <!-- Toggle -->
            <div class="toggle">
                <label class="hamburger hiddenDesktop" for="toggleCheckbox">
                    <input type="checkbox" id="toggleCheckbox" onclick="toggle_active()">
                    <svg viewBox="0 0 32 32">
                        <path class="line line-top-bottom" d="M27 10 13 10C10.8 10 9 8.2 9 6 9 3.5 10.8 2 13 2 15.2 2 17 3.8 17 6L17 26C17 28.2 18.8 30 21 30 23.2 30 25 28.2 25 26 25 23.8 23.2 22 21 22L7 22">
                        </path>
                        <path class="line" d="M7 16 27 16"></path>
                    </svg>
                </label>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="sidebar sideActive toggleActive">

            <!-- Blur Container -->
            <div class="blur"></div>

            <!-- Logo -->
            <img src="{{ asset('Images/Logos/Logo.svg') }}" class="logoMenu hiddenMobile">
            <i class="bi bi-chevron-right swipe sideActive hiddenMobile" onclick="sidebar_active()"></i>

            <!-- Sidebar Menu -->
            <ul class="menu toggleActive">
                @can('admin')
                <li>
                    <a href="{{ route('Dashboard') }}">
                        <div class="item sideActive {{ request()->is('Dashboard*') ? 'menuStyle' : '' }}">
                            <i class="bi bi-houses icon"></i>
                            <span class="text sideActive">{{ __('translate.home') }}</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('Requests') }}">
                        <div class="item sideActive {{ request()->is('Requests*') || request()->is('View-Request*') || request()->is('Offer-Prices*') || request()->is('Create-Offer*') || request()->is('View-OfferPrice*') || request()->is('Edit-OfferPrice*') ? 'menuStyle' : '' }}">
                            <i class="bi bi-clipboard2 icon"></i>
                            <span class="text sideActive">{{ __('translate.requests') }}</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('Remarks') }}">
                        <div class="item sideActive {{ request()->is('Remarks*') ? 'menuStyle' : '' }}">
                            <i class="bi bi-bookmark icon"></i>
                            <span class="text sideActive">{{ __('translate.remarks') }}</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('Users.index') }}">
                        <div class="item sideActive {{ request()->is('Users*') || request()->is('Create-User*') || request()->is('Edit-User*') ? 'menuStyle' : '' }}">
                            <i class="bi bi-person-plus icon"></i>
                            <span class="text sideActive">{{ __('translate.create') }}</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('Achievements') }}">
                        <div class="item sideActive {{ request()->is('Achievements*') || request()->is('View-Achievement*')? 'menuStyle' : '' }}">
                            <i class="bi bi-eye icon"></i>
                            <span class="text sideActive">{{ __('translate.achievements') }}</span>
                        </div>
                    </a>
                </li>
                <li class="posaitionRelative">
                    <a href="{{ route('Chats-Admin') }}">
                        <div class="item sideActive {{ request()->is('Chats*') || request()->is('Contact*') ? 'menuStyle' : '' }}">
                            <i class="bi bi-chat-text icon"></i>
                            <span class="count countUnseen">
                                <livewire:common.counts :status="'null'" :count="'chatsAdmin'" />
                            </span>
                            <span class="text sideActive">{{ __('translate.chats') }}</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('Inquiries') }}">
                        <div class="item sideActive {{ request()->is('Inquiries*') ? 'menuStyle' : '' }}">
                            <i class="bi bi-chat-left-text icon"></i>
                            <span class="text sideActive">{{ __('translate.inquiries') }}</span>
                        </div>
                    </a>
                </li>
                @elsecan('requests')
                <li>
                    <a href="{{ route('Requests') }}">
                        <div class="item sideActive {{ request()->is('Requests*') || request()->is('View-Request*') || request()->is('Offer-Prices*') || request()->is('Create-Offer*') || request()->is('PDF/View-OfferPrice*') || request()->is('PDF/Edit-OfferPrice*') ? 'menuStyle' : '' }}">
                            <i class="bi bi-clipboard2 icon"></i>
                            <span class="text sideActive">{{ __('translate.requests') }}</span>
                        </div>
                    </a>
                </li>
                <li class="posaitionRelative">
                    <a href="{{ route('Chats-Admin') }}">
                        <div class="item sideActive {{ request()->is('Chats*') || request()->is('Contact*') ? 'menuStyle' : '' }}">
                            <i class="bi bi-chat-left-dots icon"></i>
                            <span class="count countUnseen">
                                <livewire:common.counts :status="'null'" :count="'chatsAdmin'" />
                            </span>
                            <span class="text sideActive">{{ __('translate.chats') }}</span>
                        </div>
                    </a>
                </li>
                @elsecan('remarks')
                <li>
                    <a href="{{ route('Remarks') }}">
                        <div class="item sideActive {{ request()->is('Remarks*') ? 'menuStyle' : '' }}">
                            <i class="bi bi-bookmark icon"></i>
                            <span class="text sideActive">{{ __('translate.remarks') }}</span>
                        </div>
                    </a>
                </li>
                @endcan
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="" class="sideActive" onclick="event.preventDefault();this.closest('form').submit();">
                            <div class="item sideActive">
                                <i class="bi bi-door-open icon"></i>
                                <span class="text sideActive"> {{ __('translate.logout') }}</span>
                            </div>
                        </a>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Main -->
        @yield('main')
    </div>

    @livewireScript
    <!-- Scripts -->
    <script src="{{ asset('JS/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>