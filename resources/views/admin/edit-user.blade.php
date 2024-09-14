@extends('layouts.admin')

@section('title')
{{ __('translate.editUser') }}
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
                <i class="bi bi-person-check"> {{ __('translate.editUser') }}</i>
            </div>

            <form method="POST" action="{{ route('Users.update', ['User' => encrypt($User->id)]) }}" name="form" class="formCreated">
                @csrf
                @method('PUT')
                <div class="labelInput">
                    <label for="name" class="label">{{ __('translate.name') }} <span class="required">*</span></label>
                    <input type="text" name="name" value="{{ $User->name }}" placeholder="John Doe" id="name" class="input inputs" required autofocus autocomplete="name" />
                    <x-input-error class="alert-danger" :messages="$errors->get('name')" />
                </div>

                <div class="labelInput">
                    <label for="email" class="label">{{ __('translate.email') }} <span class="required">*</span></label>
                    <input type="email" name="email" value="{{ $User->email }}" placeholder="example@gmail.com" id="email" class="input inputs" required autocomplete="email" />
                    <x-input-error class="alert-danger" :messages="$errors->get('email')" />
                </div>

                <div class="labelInput">
                    <label for="phone" class="label">{{ __('translate.phone') }} <span class="required">*</span></label>
                    <input type="text" name="phone" value="{{ $User->phone }}" placeholder="966XXXXXXXXXX" id="phone" class="input inputs" required>
                    <x-input-error class="alert-danger" :messages="$errors->get('phone')" />
                </div>

                <div class="labelInput">
                    <label for="usertype" class="label">{{ __('translate.usertype') }} <span class="required">*</span></label>
                    <select name="usertype" id="usertype" class="input inputs" required>
                        <option value="Admin" @selected($User->usertype === 'Admin')>{{ __('translate.admin') }}</option>
                        <option value="Requests" @selected($User->type === 'Requests')>{{ __('translate.requests') }}</option>
                        <option value="Remarks" @selected($User->type === 'Remarks')>{{ __('translate.remarks') }}</option>
                        <option disabled>------------------------------</option>
                        <option value="Customer" @selected($User->type === 'Customer')>{{ __('translate.customer') }}</option>
                        <option value="Governmental" @selected($User->type === 'Governmental')>{{ __('translate.governmental') }}</option>
                        <option value="AdminGovernmental" @selected($User->type=='AdminGovernmental' )>{{ __('translate.admingovernmental') }}</option>
                        <option value="Company" @selected($User->type === 'Company')>{{ __('translate.company') }}</option>
                    </select>
                    <x-input-error class="alert-danger" :messages="$errors->get('usertype')" />
                </div>

                <div class="labelInput additionalInputs">
                    <label for="tax_number" class="label">{{ __('translate.taxNumber') }} <span class="required"></span></label>
                    <input type="text" id="tax_number" value="{{ $User->tax_number }}" name="tax_number" placeholder="123456789ABC" class="input inputs">
                    <x-input-error class="alert-danger" :messages="$errors->get('tax_number')" />
                </div>

                <div class="labelInput additionalInputs">
                    <label for="address" class="label">{{ __('translate.address') }} <span class="required"></span></label>
                    <input type="text" name="address" value="{{ $User->address }}" placeholder="123 Main St, City, Country" class="input inputs">
                    <x-input-error class="alert-danger" :messages="$errors->get('address')" />
                </div>

                <div class="footer">
                    <button type="submit" class="submit hoverButton"> {{ __('translate.update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection