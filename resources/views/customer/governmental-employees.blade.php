@extends('layouts.customer')

@section('title')
{{ __('translate.chats') }}
@endsection

@section('main')
<div class="main toggleActive">
    <div class="request-navbar nav" style="margin-bottom: 5px;">
        <form method="GET" action="{{route('Employees.create')}}">
            @csrf
            <button class="submit">
                <i class="bi bi-plus-lg bt-icon"></i>
                <span>{{ __('translate.create') }}</span>
            </button>
        </form>
    </div>
    <livewire:customer.govermental-employees />
</div>
@endsection