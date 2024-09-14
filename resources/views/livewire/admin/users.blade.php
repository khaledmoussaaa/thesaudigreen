<div class="users scroll" wire:poll.300ms>
    <div class="header tableHead hiddenDesktop">
        <i class="bi bi-table"> {{ __('translate.users') }}</i>
    </div>
    <div wire:ignore>
        @if(Session('success') || Session('error') )
        <div class="alert {{session('success') ? 'success' : 'danger'}}" wire:ignore>
            {{ session('success') ?? session('error') }}
        </div>
        @endif
    </div>
    <div class="userTableNavbar">
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

        <div x-data="{ open: false }" class="filter pointer">
            <i class="bi bi-filter icon" @click="open = true"></i>
            <ul x-show="open" @click.outside="open = false" class="filter-dropdown">
                @foreach(['all', 'admin', 'employee', 'customer'] as $key => $status)
                <li wire:model="selectedOption" value="{{ $status }}">
                    <label @click="open = false">
                        <input type="radio" name="radio" wire:model="selectedOption" class="create-choice" value="{{ $status }}">
                        <span class="name">{{ __('translate.' . $status) }}</span>
                        <span class="count">{{ $counts[$status] }}</span>
                    </label>
                </li>
                @endforeach
            </ul>
        </div>

    </div>

    @if($users->isNotEmpty())
    <table class="table">
        <thead>
            <th>#</th>
            <th>{{ __('translate.profile') }}</th>
            <th>{{ __('translate.name') }}</th>
            <th>{{ __('translate.email') }}</th>
            <th>{{ __('translate.phone') }}</th>
            <th>{{ __('translate.address') }}</th>
            <th>{{ __('translate.usertype') }}</th>
            <th>{{ __('translate.status') }}</th>
            <th>{{ __('translate.actions') }}</th>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
            <tr>
                <td data-title="#">{{$index + 1}}</td>
                <td data-title="{{ __('translate.name') }}"><img src="https://ui-avatars.com/api/?uppercase=true&size=60&font-size=0.35&rounded=true&background=random&color=radnom&name={{ $user->name }}" alt=""></td>
                <td data-title="{{ __('translate.name') }}" class="name bolder">{{ $user->name }}</td>
                <td data-title="{{ __('translate.email') }}">{{ $user->email }}</td>
                <td data-title="{{ __('translate.phone') }}">{{ $user->phone }}</td>
                <td data-title="{{ __('translate.address') }}" class="name">{{ $user->address ? $user->address : '-' }}</td>
                <td data-title="{{ __('translate.type') }}">
                    <span class="mark @switch($user->type) @case('Customer') scarlet @break @case('Company') goldenYellow @break @case('Governmental') || @case('AdminGovernmental') || @case('EmployeeGovernmental') electricPurple @break @default {{ $user->usertype == 'Admin' ? 'mintCream' : 'dodgerBlue' }} @endswitch">
                        {{__('translate.'.strtolower($user->type))}}
                    </span>
                </td>
                <td data-title="{{ __('translate.address') }}"><span class=" mark {{ $user->deleted_at ? 'scarlet' : 'mintCream' }}">{{ $user->deleted_at ? __('translate.blocked') : __('translate.active') }}</span></td>

                <td data-title="{{ __('translate.actions') }}">
                    <div style="display: inline-flex;">
                        <form method="GET" action="{{ route('Users.edit', ['User' => encrypt($user->id)]) }}">
                            @csrf
                            <button type="submit" class="edit transparent" style="margin: 0 auto; border: none;">
                                <i class="bi bi-pen"></i>
                            </button>
                        </form>

                        <x-action-button class="actions" icon="bi {{ $user->deleted_at ? 'bi-arrow-counterclockwise' : 'bi bi-ban' }}" click="$dispatch('alert', [ '{{ encrypt($user->id) }}', '{{ $user->name }}', 'blockOrActive', '{{ $user->deleted_at ? 'block' : 'activate' }}' ] )" />
                        <x-action-button class="scarlet actions" icon="bi bi-trash" click="$dispatch('alert', [ '{{ encrypt($user->id) }}', '{{ $user->name }}', 'delete'] )" />
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty emptyCenter emptyText">
        <i class="bi bi-clipboard2-x icon"></i>
        &nbsp;
        <span>{{ __('translate.noRecords') }}</span>
    </div>
    @endif
</div>
<script src="{{ asset('JS/alert.js') }}"></script>