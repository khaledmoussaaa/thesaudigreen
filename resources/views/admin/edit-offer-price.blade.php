@extends('layouts.admin')

@section('title')
{{ __('translate.createOffer') }}
@endsection

@section('main')
<div class="main toggleActive">
    <livewire:admin.edit-offer-price :rid="$rid" :ofd="$ofd"/>
</div>
@endsection