@extends('layouts.admin')

@section('title')
{{ __('translate.inquiries') }}
@endsection

@section('main')
<div class="main toggleActive">
    <div class="all-inquiries">
        <div class="inquiries">
            @foreach($inquires as $inquire)
            <div class="inquirie">
                <div class="header">
                    <i class="bi bi-send"> {{ __('translate.inquiries') }}</i>
                </div>
                <div class="body">
                    <div class="request-information">
                        <div class="info">
                            <span>{{ __('translate.inquireId') }}<strong class="details"> {{$inquire->id}}</strong></span>
                            <span>{{ __('translate.email') }} <strong class="details"> {{$inquire->name}}</strong></span>
                            <span>{{ __('translate.email') }} <strong class="details"> {{$inquire->email}}</strong></span>
                            <span>{{ __('translate.phone') }} <strong class="details"> {{$inquire->phone}}</strong></span>
                            <span>{{ __('translate.message') }}</span>
                            <textarea class="message-inquire" cols="30" rows="10" readonly>{{$inquire->message}}</textarea>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
        @if($inquires->isEmpty())
        <div class="empty emptyCenter emptyText">
            <i class="bi bi-chat-left-text icon"></i>
            &nbsp;
            <span>{{ __('translate.noInquires')}}</span>
        </div>
        @endif
    </div>
</div>
@endsection