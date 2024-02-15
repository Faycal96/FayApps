<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ACHAT DE BILLET AVION</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('frontend/assets/img/armoirie.png') }}" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('frontend/assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }} " rel="stylesheet">
    <link href=" {{ asset('frontend/assets/vendor/boxicons/css/boxicons.min.css') }} " rel="stylesheet">
    <link href=" {{ asset('frontend/assets/vendor/glightbox/css/glightbox.min.css') }} " rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">


</head>

<body>



    <!-- ======= Top Bar ======= -->
    <section id="topbar" class="d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-envelope d-flex align-items-center"><a
                        href="mailto:contact@example.com">achatbillet@tic.gov.bf   </a></i>
                <i class="bi bi-phone d-flex align-items-center ms-4"><span>+226 55 89 55 48</span></i>
            </div>
            <div class="social-links d-none d-md-flex align-items-center">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></i></a>
            </div>
        </div>
    </section>

    <!-- ======= Header ======= -->
    <header id="header" class="d-flex align-items-center">
        <div class="container d-flex justify-content-between align-items-center">

            <div class="logo">
                <h1><a href="index.html">AchatBillet</a></h1>

            </div>

            <nav id="navbar" class="navbar">
                {{-- @guest --}}
                {{-- @if (Route::has('login'))
                <li class="nav-item">
                    <a class="n" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @endif --}}

                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->



    <!-- ======= Hero Section ======= -->
    <section id="hero" style="height: 25rem !important">
        <div class="row">
            <div class="col-md-7">
                <div class="hero-container">
                    <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade"
                        data-bs-ride="carousel">

                        <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

                        <div class="carousel-inner" role="listbox">

                            <!-- Slide 1 -->
                            <div class="carousel-item active"
                                style="background-image: url(frontend/assets/img/slide2.jpg); width">
                                <div class="carousel-container">

                                </div>
                            </div>


                        </div>

                    </div>
                </div>

            </div>

            <div class="col-md-5">
                <div class="card">
                    <div class="card-header card-primary text-center"> Veuillez entrer vos identifiants ici</div>



                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="row col-md-8 mb-3 offset-3">
                                <input type="hidden" name="email" class="@error('email') is-invalid @enderror">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }} <sup class="text-danger">*</sup></strong>
                                </span>
                                @enderror


                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Adresse Email')
                                    }} <sup class="text-danger">*</sup></label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" id="exampleInputEmail1" required autocomplete="email" autofocus>

                                    {{-- @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror --}}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Mot de Passe')
                                    }} <sup class="text-danger">*</sup></label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    {{-- @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror --}}
                                </div>
                            </div>

                            <div class="row mb-3 text-center">
                                {{-- <div class="col-md-6 offset-md-4"> --}}
                                    <div class="form-check ">
                                        <input class="" type="checkbox" name="remember" id="remember" {{
                                            old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Se Souvenir de  Moi') }}
                                        </label>
                                    </div>
                                    {{--
                                </div> --}}
                            </div>

                            <div class=" text-center">
                                {{-- <div class="col-md-8 offset-md-4"> --}}
                                    <h3>
                                        <button type="submit" class="btn btn-success">
                                            {{ __('Connecter') }}
                                        </button>
                                    </h3>

                                    @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Mot de passe oublié ?') }}
                                    </a>
                                    @endif
                                    {{--
                                </div> --}}
                            </div><br>

                            <div class="text-center">
                                {{-- <div class="col-md-8 offset-md-4"> --}}
                                    <h3><a class="btn btn-primary" href="{{ route('login') }}"> Je n'ai pas de compte.</a> </h3>
                                    {{-- <a href="{{ route('register') }}">
                                        Agence |
                                    </a>
                                    <a href="{{ route('registerdaf') }}">
                                        DAF
                                    </a> --}}
                                    {{--
                                </div> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section><!-- End Hero -->



    <!-- ======= Footer ======= -->
    <footer id="footer">



        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>AchatBillet</span></strong>. Tous droit reservés
            </div>
            <div class="credits">

                Conçu par <a href="https://mdenp.com/">MTDPCE</a>
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('frontend/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>

</body>

</html>
