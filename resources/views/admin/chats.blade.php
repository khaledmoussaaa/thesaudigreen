@extends('layouts.admin')

@section('title')
{{__('translate.chats')}}
@endsection

@section('main')
<div class="main toggleActive">
    <livewire:admin.chats :uid="$uid ?? 0" />
</div>
@endsection