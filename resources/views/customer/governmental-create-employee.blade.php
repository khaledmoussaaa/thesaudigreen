@extends('layouts.customer')

@section('title')
{{ __('translate.createRequest') }}
@endsection

@section('main')
<div class="main toggleActive">
    <div class="create">
        @if(Session::has('error'))
        <div class="alert fail">
            {{ Session::get('error') }}
        </div>
        <script src="{{ asset('JS/alert.js') }}"></script>
        @endif

        <div class="body">
            <div class="header headSticky">
                <i class="bi bi-person-check"> {{ __('translate.createUser') }}</i>
            </div>

            <form method="POST" action="{{ route('Employees.store') }}" name="form" class="formCreated">
                @csrf
                <div class="labelInput">
                    <label for="name" class="label">{{ __('translate.name') }} <span class="required">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="John Doe" id="name" class="input inputs" required autofocus autocomplete="name" />
                    <x-input-error class="alert-danger" :messages="$errors->get('name')" />
                </div>

                <div class="labelInput">
                    <label for="email" class="label">{{ __('translate.email') }} <span class="required">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="example@gmail.com" id="email" class="input inputs" required autocomplete="email" />
                    <x-input-error class="alert-danger" :messages="$errors->get('email')" />

                </div>

                <div class="labelInput">
                    <label for="phone" class="label">{{ __('translate.phone') }} <span class="required">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="966XXXXXXXXXX" id="phone" class="input inputs" required>
                    <x-input-error class="alert-danger" :messages="$errors->get('phone')" />
                </div>

                <div class="labelInput">
                    <label for="address" class="label">{{ __('translate.address') }} <span class="required"></span></label>
                    <input type="text" name="address" value="{{ old('address') }}" placeholder="123 Main St, City, Country" class="input inputs">
                    <x-input-error class="alert-danger" :messages="$errors->get('address')" />
                </div>

                <div class="labelInput">
                    <label for="password" class="label">{{ __('translate.password') }} <span class="required">*</span></label>
                    <input type="password" name="password" value="{{ old('password') }}" placeholder="Your password" id="password" class="input inputs" required>
                    <x-input-error class="alert-danger" :messages="$errors->get('password')" />
                </div>

                <div class="labelInput">
                    <label for="password" class="label">{{ __('translate.password_confirmation') }} <span class="required">*</span></label>
                    <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Confirm password" id="confirmPassword" class="input inputs" required>
                    <x-input-error class="alert-danger" :messages="$errors->get('password_confirmation')" />
                </div>

                <div class="footer">
                    <button type="submit" class="submit hoverButton"> {{ __('translate.create') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection