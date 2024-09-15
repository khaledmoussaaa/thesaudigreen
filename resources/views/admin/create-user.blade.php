@extends('layouts.admin')

@section('title')
{{ __('translate.create') }}
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

            <form method="POST" action="{{ route('Users.store') }}" name="form" class="formCreated">
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
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="966XXXXXXXXXX" id="phone" class="input inputs">
                    <x-input-error class="alert-danger" :messages="$errors->get('phone')" />
                </div>

                <div class="labelInput">
                    <label for="usertype" class="label">{{ __('translate.usertype') }} <span class="required">*</span></label>
                    <select name="usertype" id="usertype" class="input inputs" required>
                        <option value="empty" @selected(old('usertype')=='empty' )>{{ __('translate.usertype') }}</option>
                        <option value="Admin" @selected(old('usertype')=='Admin' )>{{ __('translate.admin') }}</option>
                        <option value="Requests" @selected(old('usertype')=='Requests' )>{{ __('translate.requests') }}</option>
                        <option value="Remarks" @selected(old('usertype')=='Remarks' )>{{ __('translate.remarks') }}</option>
                        <option disabled>------------------------------</option>
                        <option value="Customer" @selected(old('usertype')=='Customer' )>{{ __('translate.customer') }}</option>
                        <option value="Governmental" @selected(old('usertype')=='Governmental' )>{{ __('translate.governmental') }}</option>
                        <option value="AdminGovernmental" @selected(old('usertype')=='AdminGovernmental' )>{{ __('translate.admingovernmental') }}</option>
                        <option value="Company" @selected(old('usertype')=='Company' )>{{ __('translate.company') }}</option>
                    </select>
                    <x-input-error class="alert-danger" :messages="$errors->get('usertype')" />
                </div>

                <div class="labelInput">
                    <label for="tax_number" class="label">{{ __('translate.taxNumber') }} <span class="required"></span></label>
                    <input type="text" name="tax_number" id="tax_number" value="{{ old('tax_number') }}" placeholder="123456789ABC" class="input inputs">
                    <x-input-error class="alert-danger" :messages="$errors->get('tax_number')" />
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