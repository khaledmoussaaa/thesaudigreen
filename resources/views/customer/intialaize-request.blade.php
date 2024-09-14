@extends('layouts.customer')

@section('title')
{{ __('translate.numberCars') }}
@endsection

@section('main')
<div class="main toggleActive">
    <div class="generate">
        <div class="header">
            <i class="bi bi-card-list">
                {{ __('translate.generateMsg') }}
            </i>
        </div>
        <form method="GET" action="{{ route('Create-Request') }}" class="generateForm">
            @csrf
            <div class="labelInput posaitionRelative">
                <label for="name" class="label bolder">{{__('translate.numberOfCars') }} <span class="required">*</span></label>
                <input type="number" name="rnumber" value="{{ old('rnumber') }}" class="input inputs" placeholder="{{__('translate.enterNumberOfCars') }}">
                <x-input-error class="alert-danger" :messages="$errors->get('rnumber')" />
            </div>
            <br>
            <button class="submit hoverButton"> {{__('translate.generate')}}</button>
        </form>
    </div>
</div>
@endsection