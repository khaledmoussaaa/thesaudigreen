@extends('layouts.customer')

@section('title')
{{ __('translate.createRequest') }}
@endsection

@section('main')
<div class="main toggleActive">
    <livewire:customer.create-request :rnumber="$rnumber ?? null" :rid="$rid ?? null"/>
</div>
@endsection