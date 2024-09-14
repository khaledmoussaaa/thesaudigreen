@extends('layouts.admin')

@section('title')
{{ __('translate.remarks') }}
@endsection

@section('main')
<div class="main toggleActive">
    <livewire:admin.remarks />
</div>
@endsection