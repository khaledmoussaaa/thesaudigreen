@extends('layouts.customer')

@section('title')
{{__('translate.home')}}
@endsection

@section('main')
<div class="main toggleActive">
    <livewire:customer.customer-home />
</div>
@endsection