@extends('layouts.login')

@section('sections')
<div class="landing open">
  <!-- home section -->
  <section id="home">
    <div class="container">
      <div class="row ">
        <div class="col-md-offset-2 col-md-8 col-sm-12">
          <div class="home-thumb ">
          <img src="{{ asset('Images/Logos/Logo-Light.svg') }}" class="img-responsive logo wow fadeInUp" alt="About">
            <h2 class="wow fadeInUp" data-wow-delay="0.6s">We are almost <strong>ready to a complet</strong> car <strong>service experience</strong>!</h2>
            <a href="#about" class="btn btn-lg btn-default smoothScroll wow fadeInUp" data-wow-delay="0.8s" onclick="openLogin()">Let's begin</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- about section -->
  <section id="about">
    <div class="container">
      <div class="row">

        <div class="col-md-6 col-sm-12">
          <img src="{{ asset('Images/Login/About.png') }}" class="img-responsive wow fadeInUp" alt="About">
        </div>

        <div class="col-md-6 col-sm-12">
          <div class="about-thumb">
            <div class="section-title">
              <h1 class="wow fadeIn" data-wow-delay="0.2s">our company</h1>
            </div>
            <div class="wow fadeInUp" data-wow-delay="0.8s">
              <p>At The Saudi Green, we are dedicated to providing exceptional car services tailored to meet your needs. With years of experience in the industry, consectetur vitae erat. our team of skilled professionals is committed to delivering top-quality solutions for all your automotive needs.
                From routine maintenance to complex repairs, we strive to ensure your vehicle stays in optimal condition, keeping you safe on the road. Trust us to provide reliable, efficient, and personalized services that exceed your expectations."
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- contact section -->
  @if(session('section') == 'contact')
  <script>
    window.location.hash = '#contact';
  </script>
  @endif

  <section id="contact">
    <div class="container">
      <div class="row">
        <div class="col-md-offset-2 col-md-8 col-sm-12">
          <div class="section-title">
            <h1 class="wow fadeInUp" data-wow-delay="0.3s">Get in touch</h1>
            <p class="wow fadeInUp" data-wow-delay="0.6s">"Get in touch with us today for top-notch car services. Contact us via phone or email to schedule an appointment or inquire about our offerings.</p>
          </div>

          @if(Session::has('success'))
          <p class="wow fadeInUp alert alert-center bg-success" data-wow-delay="0.1s">
            {{ Session::get('success') }}
          </p>
          <script src="{{ asset('JS/alert.js') }}"></script>
          @endif

          <div class="contact-form wow fadeInUp" data-wow-delay="1.0s">
            <form id="contact-form" method="POST" action="{{ route('Create-Inquiries') }}" enctype="multipart/form-data">
              @csrf
              <div class="col-md-6 col-sm-6">
                <input name="name" type="text" class="form-control" placeholder="Your Name" value="{{ old('name') }}" required>
                <x-input-error class="alert alert-danger" :messages="$errors->get('name')" />
              </div>
              <div class="col-md-6 col-sm-6">
                <input name="email" type="email" class="form-control" placeholder="Your Email" value="{{ old('email') }}" required>
                <x-input-error class="alert alert-danger" :messages="$errors->get('email')" />
              </div>
              <div class="col-md-12 col-sm-6">
                <input name="phone" type="text" class="form-control" placeholder="Your Phone" value="{{ old('phone') }}" required>
                <x-input-error class="alert alert-danger" :messages="$errors->get('phone')" />
              </div>
              <div class="col-md-12 col-sm-12">
                <textarea name="message" class="form-control" placeholder="Message" rows="6" value="{{ old('message') }}" required></textarea>
                <x-input-error class="alert alert-danger" :messages="$errors->get('message')" />
              </div>
              <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">
                <input name="submit" type="submit" class="form-control submit" id="submit" value="SEND MESSAGE">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- footer section -->
  <footer>
    <div class="container">
      <div class="row">

        <svg class="svgcolor-light" preserveAspectRatio="none" viewBox="0 0 100 102" height="100" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <path d="M0 0 L50 100 L100 0 Z"></path>
        </svg>

        <div class="col-md-4 col-sm-6">
          <h2>Locations</h2>
          <div class="wow fadeInUp" data-wow-delay="0.3s">
            <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3713.607293886007!2d39.26484677526803!3d21.444675380310724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMjHCsDI2JzQwLjgiTiAzOcKwMTYnMDIuNyJF!5e0!3m2!1sen!2seg!4v1716023965075!5m2!1sen!2seg" width="300" height="300" style="border:14px; border-radius: 15px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>

        <div class="col-md-1 col-sm-1"></div>

        <div class="col-md-4 col-sm-5">
          <h2>Contact</h2>
          <p class="wow fadeInUp" data-wow-delay="0.6s">
            info@thesaudigreen.sa<br>
            +966560889950 <br>
          </p>

          <ul class="social-icon">
            <li><a href="#" class="fa wow bounceIn"><i class="bi bi-twitter"></i></a></li>
            <li><a href="https://www.instagram.com/star_scs?igsh=MW1jZGFna3p3cHlsNg==" class="fa wow bounceIn"><i class="bi bi-instagram"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <!-- Back top -->
  <a href="#back-top" class="go-top"><i class="fa fa-angle-up"></i></a>
</div>


<div class="login open wow fadeInUp" id="loged">
  <!-- contact section -->
  <section id="contact" class="loginPage">
    <div class="container">
      <div class="col-md-offset-2 col-md-8 col-sm-12">
        <div class="section-title">
          <h1 class="wow fadeInUp" data-wow-delay="0.3s">Sign In</h1>
          <p class="wow fadeInUp" data-wow-delay="0.6s">"Get in touch with us today for top-notch car services. Contact us via phone or email to schedule an appointment or inquire about our offerings.</p>
        </div>

        <div class="contact-form wow fadeInUp login open" data-wow-delay="1.0s" id="signIn">

          <form id="contact-form" method="POST" action="{{ route('login') }}">
            @csrf
            @if ($errors->any())
            <p class="wow fadeInUp alert-center alert-danger" data-wow-delay="0.6s">
              @foreach ($errors->all() as $error)
              {{ $error }}
              @endforeach
            </p>
            @endif
            <div class="col-md-12 col-sm-6">
              <input name="email" type="email" class="form-control" placeholder="Your Email" :value="old('email')" required>
            </div>

            <div class="col-md-12 col-sm-6">
              <input name="password" type="password" class="form-control" placeholder="Password" required>
            </div>

            <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 login-buttons">
              <input name="submit" class="form-control submit" id="submit" value="Back" onclick="backHome()">
              <input name="submit" type="submit" class="form-control submit" id="submit" value="Sign In">
            </div>

          </form>

          <form method="GET" action="{{ route('password.request') }}">
            <button type="submit" class="forget">Forget Password ?</button>
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