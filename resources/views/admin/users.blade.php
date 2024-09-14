@extends('layouts.admin')

@section('title')
{{ __('translate.users') }}
@endsection

@section('main')
<div class="main toggleActive">
    <div class="request-navbar nav" style="margin-bottom: 5px;">
        <form method="GET" action="{{route('Users.create')}}">
            @csrf
            <button class="submit">
                <i class="bi bi-plus-lg bt-icon"></i>
                <span>{{ __('translate.create') }}</span>
            </button>
        </form>
    </div>
    <livewire:admin.users />
</div>
@endsection