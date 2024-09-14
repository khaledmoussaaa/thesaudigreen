@extends('layouts.admin')

@section('title')
{{ __('translate.offerPrices') }}
@endsection

@section('main')
<div class="main toggleActive">
    <livewire:common.offer-prices :rid="$rid" />
</div>
@endsection