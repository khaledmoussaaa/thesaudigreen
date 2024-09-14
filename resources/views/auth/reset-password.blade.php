@extends('layouts.login')

@section('sections')
<div class="login open wow fadeInUp" id="loged">
    <!-- contact section -->
    <section id="contact" class="loginPage">
        <div class="container">
            <div class="col-md-offset-2 col-md-8 col-sm-12">
                <div class="section-title">
                    <h1 class="wow fadeInUp" data-wow-delay="0.3s">Reset Password</h1>
                </div>

                <div class="contact-form wow fadeInUp login open" data-wow-delay="1.0s" id="signIn">

                    <form id="contact-form" method="POST" action="{{ route('password.store') }}">
                        @csrf

                        @if ($errors->any())
                        <p class="wow fadeInUp alert-center alert-danger" data-wow-delay="0.6s">
                            @foreach ($errors->all() as $error)
                            {{ $error }}
                            @endforeach
                        </p>
                        @endif

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="col-md-12 col-sm-6">
                            <input name="email" type="email" class="form-control" placeholder="Your Email" :value="old('email', $request->email)" required>
                        </div>

                        <div class="col-md-12 col-sm-6">
                            <input name="password" type="password" class="form-control" placeholder="Password" required>
                        </div>

                        <div class="col-md-12 col-sm-6">
                            <input name="password_confirmation" type="password" class="form-control" placeholder="Password" required>
                        </div>

                        <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 login-buttons">
                            <input name="submit" type="submit" class="form-control submit" id="submit" value="{{ __('Reset Password') }}">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>



    @endsection