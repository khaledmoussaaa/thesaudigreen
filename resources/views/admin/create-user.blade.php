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
                    <x-input-error class="alert-danger" :messages="$errors->first('name')" />
                </div>

                <div class="labelInput">
                    <label for="email" class="label">{{ __('translate.email') }} <span class="required">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="example@gmail.com" id="email" class="input inputs" required autocomplete="email" />
                    <x-input-error class="alert-danger" :messages="$errors->first('email')" />
                </div>

                <div class="labelInput">
                    <label for="phone" class="label">{{ __('translate.phone') }} <span class="required">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="966XXXXXXXXXX" id="phone" class="input inputs" required>
                    <x-input-error class="alert-danger" :messages="$errors->first('phone')" />
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
                    <x-input-error class="alert-danger" :messages="$errors->first('usertype')" />
                </div>

                <div class="labelInput">
                    <label for="tax_number" class="label">{{ __('translate.taxNumber') }} <span class="required"></span></label>
                    <input type="text" name="tax_number" id="tax_number" value="{{ old('tax_number') }}" placeholder="123456789ABC" class="input inputs">
                    <x-input-error class="alert-danger" :messages="$errors->first('tax_number')" />
                </div>

                <div class="labelInput">
                    <label for="address" class="label">{{ __('translate.address') }} <span class="required"></span></label>
                    <input type="text" name="address" value="{{ old('address') }}" placeholder="123 Main St, City, Country" class="input inputs">
                    <x-input-error class="alert-danger" :messages="$errors->first('address')" />
                </div>

                <!-- Password fields hidden by default -->
                <div class="labelInput" id="passwordSection" style="display: none;">
                    <label for="password" class="label">{{ __('translate.password') }} <span class="required">*</span></label>
                    <input type="password" name="password" id="password" value="{{ old('password') }}" placeholder="Your password" class="input inputs">
                    <x-input-error class="alert-danger" :messages="$errors->first('password')" />
                </div>

                <div class="labelInput" id="confirmPasswordSection" style="display: none;">
                    <label for="confirmPassword" class="label">{{ __('translate.password_confirmation') }} <span class="required">*</span></label>
                    <input type="password" name="password_confirmation" id="confirmPassword" value="{{ old('password_confirmation') }}" placeholder="Confirm password" class="input inputs">
                    <x-input-error class="alert-danger" :messages="$errors->first('password_confirmation')" />
                </div>

                <!-- Checkbox to toggle password visibility -->
                <div class="request-remark labelInput">
                    <input type="checkbox" name="usingPassword" id="showPassword" @checked(old('usingPassword')) class="check" onclick="togglePasswordVisibility()">
                    <label for="showPassword">Using Manual Passowrd</label>
                </div>

                <div class="footer">
                    <button type="submit" class="submit hoverButton"> {{ __('translate.create') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="{{ asset('JS/password.js') }}"></script>
@endsection