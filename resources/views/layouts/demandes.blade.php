<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>edemande</title>
        <link rel="stylesheet"
  href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">


  <link rel="dns-prefetch" href="//fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- Font Awesome -->


<link href="{{ asset('backend/assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

<!-- Tempusdominus Bootstrap 4 -->

<link href="{{ asset('backend/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}"
  rel="stylesheet">
<!-- iCheck -->

<link href="{{ asset('backend/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" rel="stylesheet">
<!-- JQVMap -->

<link href="{{ asset('backend/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}"
  rel="stylesheet">
<link href="{{ asset('backend/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}"
  rel="stylesheet">
<link href="{{ asset('backend/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}"
  rel="stylesheet">

<!-- Theme style -->

<link href="{{ asset('backend/assets/dist/css/adminlte.min.css') }}" rel="stylesheet">
<!-- overlayScrollbars -->
<link href="{{ asset('backend/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}" rel="stylesheet">

<!-- Daterange picker -->
<link href="{{ asset('backend/assets/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">

<!-- summernote -->

<link href="{{ asset('backend/assets/plugins/summernote/summernote-bs4.min.css') }}" rel="stylesheet">

  <!-- Favicons -->
  <link href="{{ asset('frontend/assets/img/armoirie.png') }}" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <link href={{ asset('accueil/css/styles.css') }} rel="stylesheet" />
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-lg-5">
                <a class="navbar-brand" href="/">edemande</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <!-- Liens accessibles à tous les utilisateurs -->
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="/">Accueil</a></li>
                       
                        <li class="nav-item"><a class="nav-link" href="#!">Contact</a></li>
                
                        <!-- Liens visibles seulement pour les utilisateurs authentifiés -->
                        @auth
                            <li class="nav-item"><a class="nav-link" href="/dashboard">Dashboard</a></li>
                            <!-- Exemple de condition basée sur le rôle de l'utilisateur -->
                            @if(Auth::user()->role == 'admin')
                                <li class="nav-item"><a class="nav-link" href="/admin">Admin</a></li>
                            @endif
                            <!-- Lien pour se déconnecter -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Déconnexion
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endauth
                
                        <!-- Lien pour les visiteurs non authentifiés -->
                        @guest
                            
                            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Inscription</a></li>
                        @endguest
                    </ul>
                </div>
                
            </div>
        </nav>
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center mt-3">
                    <div class="col-md-12">

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success text-center" role="alert">
                                {{ $message }}
                            </div>
                        @endif

                     

                        <div class="row justify-content-center text-center mt-3">

                        </div>


                    </div>
                </div>
            </div>
        </main>
        
        @yield('content')
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">© Copyright edemande. Tous droit reservés
                Conçu par Pool DGTD / MTDPCE</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src= {{ asset('accueil/js/scripts.js') }}></script>
       
    </body>
</html>
