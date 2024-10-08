@extends('layouts.admin')

@section('title')
{{ __('translate.dashboard') }}
@endsection

@section('main')
<div class="main toggleActive">
    <form action="{{ route('Mails.store') }}" method="POST">
        @csrf

        <select name="users[]" multiple>
            @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>

        <button type="submit">Send Email</button>
    </form>
</div>
@endsection