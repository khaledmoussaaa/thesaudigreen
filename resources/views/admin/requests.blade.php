@extends('layouts.admin')

@section('title')
{{ __('translate.requests') }}
@endsection

@section('main')
<div class="main toggleActive">
    <livewire:admin.requests :viewReq="$view ?? 'all'"/>
</div>
@endsection