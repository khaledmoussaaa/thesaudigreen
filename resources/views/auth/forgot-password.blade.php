@extends('layouts.login')

@section('sections')
<div class="login open wow fadeInUp" id="loged">

    <section id="contact" class="loginPage">
        <!-- Container -->
        <div class="container">
            <div class="col-md-offset-2 col-md-8 col-sm-12">
                <div class="section-title">
                    <!-- Title -->
                    <h1 class="wow fadeInUp" data-wow-delay="0.3s">Forget Password</h1>

                    <!-- Message -->
                    <div class="wow fadeInUp" data-wow-delay="0.3s">
                        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                    </div>

                    <!-- Alert -->
                    @if(Session('status'))
                    <div class="alert-center alert-success" wire:ignore>
                        {{ session('status') }}
                    </div>
                    @endif
                </div>

                <!-- Form -->
                <div class="contact-form wow fadeInUp login open" data-wow-delay="1.0s" id="signIn">
                    <form id="contact-form" method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <x-input-error :messages="$errors->get('email')" class="wow fadeInUp alert-center alert-danger" data-wow-delay="0.6s" />

                        <div class="col-md-12">
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email Here" required autofocus />
                        </div>

                        <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 login-buttons">
                            <a href="{{ route('login') }}"><input type="" class="form-control submit" value="Back" readonly></a>
                            <input name="submit" type="submit" class="form-control submit" id="submit" value="{{ __('Send Link') }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <div class="container" class="footerPage">
            <div class="row">
                <svg class="svgcolor-light" preserveAspectRatio="none" viewBox="0 0 100 102" height="80" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0 L50 100 L100 0 Z"></path>
                </svg>
            </div>
        </div>
    </footer>
</div>
@endsection