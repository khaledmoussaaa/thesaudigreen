@extends('layouts.admin')

@section('title')
{{ __('translate.createOffer') }}
@endsection

@section('main')
<div class="main toggleActive">
    <livewire:admin.create-offer :rid="$rid"/>
</div>
@endsection