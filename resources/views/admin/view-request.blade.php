@extends('layouts.admin')

@section('title')
{{ __('translate.viewRequest') }}
@endsection

@section('main')
<div class="main toggleActive">
    <livewire:admin.view-request :rid="$rid" />
</div>
@endsection