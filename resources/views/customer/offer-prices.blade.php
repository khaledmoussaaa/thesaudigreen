@extends('layouts.customer')

@section('title')
{{ __('translate.offerPrice') }}
@endsection

@section('main')
<div class="main toggleActive">
    <livewire:common.offer-prices :rid="$rid" />
</div>
@endsection