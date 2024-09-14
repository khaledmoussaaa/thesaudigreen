@extends('layouts.login')

@section('sections')
<div class="login open wow fadeInUp" id="loged">
    <!-- contact section -->
    <section id="contact" class="loginPage">
        <div class="container">
            <div class="col-md-offset-2 col-md-8 col-sm-12">
                <div class="section-title">
                    <h1 class="wow fadeInUp" data-wow-delay="0.3s">Verification Email</h1>
                    <div class="wow fadeInUp" data-wow-delay="0.3s">
                        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                    </div>
                </div>

                <div class="contact-form wow fadeInUp login open" data-wow-delay="1.0s" id="signIn">
                    @if (session('status') == 'verification-link-sent')
                    <div class="wow fadeInUp alert-center alert-success">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                    @endif
                    <div class="verifiyForm">
                        <form id="contact-form" method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <input name="submit" type="submit" class="form-control" id="submit" value="{{ __('Resend Verification Email') }}">
                        </form>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <input name="submit" type="submit" class="form-control" id="submit" value=" {{ __('Log Out') }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- footer section -->
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