@extends('layouts.admin')

@section('title')
{{ __('translate.dashboard') }}
@endsection

@section('main')
<div class="main toggleActive">
    <livewire:admin.dashboard />
</div>
@endsection