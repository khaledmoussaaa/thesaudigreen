@extends('layouts.customer')

@section('title')
{{ __('translate.chats') }}
@endsection

@section('main')
<div class="main toggleActive overFlowHidden">
    <livewire:customer.customer-chats />
</div>
@endsection