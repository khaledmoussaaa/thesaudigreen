@extends('layouts.admin')

@section('title')
{{ __('translate.achievements') }}
@endsection

@section('main')
<div class="main toggleActive">
    <livewire:admin.achievements />
</div>
@endsection