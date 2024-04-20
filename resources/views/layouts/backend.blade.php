<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>billetAvion</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href="{{ asset('frontend/assets/img/armoirie.png') }}" rel="icon">


    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Font Awesome -->

    <link rel="stylesheet" href=" {{ asset('backend/assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href=" {{ asset('backend/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">


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


    <!-- jQuery -->
    <script src="{{ asset('backend/assets/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap 4 -->
    <script src="{{ asset('backend/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ asset('backend/assets/plugins/select2/js/select2.full.min.js') }}"></script>


    <!-- Theme style -->

    <link href="{{ asset('backend/assets/dist/css/adminlte.min.css') }}" rel="stylesheet">
    <!-- overlayScrollbars -->
    <link href="{{ asset('backend/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}" rel="stylesheet">

    <!-- Daterange picker -->
    <link href="{{ asset('backend/assets/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">

    <!-- summernote -->

    <link href="{{ asset('backend/assets/plugins/summernote/summernote-bs4.min.css') }}" rel="stylesheet">



</head>



<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('frontend/assets/img/loadings.gif') }}" alt="AdminLTELogo"
                height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <!-- Exemple avec Bootstrap -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-danger navbar-badge">{{ auth()->user()->unreadNotifications->count()
                            }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        @foreach(auth()->user()->unreadNotifications as $notification)
                        <a href="{{ route('notifications.read', $notification->id) }}" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('backend/assets/dist/img/armoirie.png') }}" alt="User Avatar"
                                    class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Notification
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">{{ $notification->data['message'] }}</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> {{
                                        $notification->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        @endforeach

                    </div>
                </li>


                @guest
                @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @endif


                @else
                @canany(['create-role', 'edit-role', 'delete-role'])
                <li><a class="nav-link" href="{{ route('roles.index') }}">Gestion Roles</a></li>
                @endcanany
                @canany(['create-user', 'edit-user', 'delete-user'])
                <li><a class="nav-link" href="{{ route('users.index') }}">Gestion des utilisateurs</a></li>
                @endcanany
                @canany(['create-demande-billet','propose-demande-billet'])
                <li><a class="nav-link" href="{{ route('demandes.index') }}">Gestion des demandes</a></li>
                @endcanany
                @canany(['propose-demande-billet'])
                <li><a class="nav-link" href="{{ route('offres.index') }}">Gestion des offres</a></li>
                @endcanany

                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        @if (isset(Auth::user()->ministere))
                        <a class="dropdown-item text-primary">{{' DAF '.Auth::user()->ministere->libelleCourt }}</a>
                        @endif
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            <i class=""></i>
                            {{ __('Déconnecter') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>

                    </div>
                </li>
                @endguest


            </ul>


        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="{{ asset('frontend/assets/img/armoirie.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">BilletAvion</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('backend/assets/dist/img/user2-160x160.jpg') }}"
                            class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>



                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                        @canany(['create-demande-billet','propose-demande-billet'])
                        <li class="nav-item">
                            <a href="{{ route('demandes.index') }}" class="nav-link">
                                <i class="nav-icon far fa-calendar-alt"></i>
                                <p>
                                    Gestion des demandes
                                    {{-- <span class="badge badge-info right">2</span> --}}
                                </p>
                            </a>
                        </li>
                        @endcanany
                        @canany(['propose-demande-billet'])
                        <li class="nav-item">
                            <a href="{{ route('offres.index') }}" class="nav-link">
                                <i class="nav-icon far fa-calendar-alt"></i>
                                <p>
                                    Gestion des offres

                                </p>
                            </a>
                        </li>
                        @endcanany



                        @canany(['create-user', 'edit-user', 'delete-user'])
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Gestion des utilisateur
                                    {{-- <span class="badge badge-info right"> </span> --}}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ministeres.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Gestion des ministeres
                                    {{-- <span class="badge badge-info right"> </span> --}}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('structures.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Gestion des structures
                                    {{-- <span class="badge badge-info right"> </span> --}}
                                </p>
                            </a>
                        </li>
                        @endcanany


                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Tableau de bord</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; Pool DGTD / MTDPCE.</strong>
            All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->

    <script src="{{ asset('backend/assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->

    <script src="{{ asset('backend/assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->

    <script src="{{ asset('backend/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->

    <script src="{{ asset('backend/assets/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->

    <script src="{{ asset('backend/assets/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->

    <script src="{{ asset('backend/assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->

    <script src="{{ asset('backend/assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('backend/assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->

    <script src="{{ asset('backend/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
    </script>
    <!-- Summernote -->

    <script src="{{ asset('backend/assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->

    <script src="{{ asset('backend/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->

    <script src="{{ asset('backend/assets/dist/js/adminlte.js') }}"></script>

    <!-- AdminLTE for demo purposes -->

    {{-- <script src="{{ asset('backend/assets/dist/js/demo.js') }}"></script> --}}

    <!-- DataTables  & Plugins -->

    <script src="{{ asset('backend/assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script src="{{ asset('backend/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('backend/assets/dist/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <link href="{{ asset('backend/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    {{-- <script src="{{ asset('backend/assets/plugins/jquery/jquery.min.js') }}"></script> --}}
    {{-- <script src="path/to/bootstrap.min.js"></script> --}}
    {{-- <script src="{{ asset('backend/assets/plugins') }}/to/select2.min.js"></script> --}}
    <!-- Insérer avant la fermeture de la balise </body> -->

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>





    <script>
        $(function() {
            //Initialize Select2 Elements
    $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
            theme: 'bootstrap4'
            })

            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>


    <script>
        $(document).ready(function() {
    // Utilisation de Select2 pour l'autocomplétion
    $('#cities').select2({
        placeholder: 'Rechercher une ville...',
        ajax: {
            url: '/cities', // URL de l'endpoint pour récupérer les données d'autocomplétion
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: data.data, // Assurez-vous d'accéder à la propriété 'data' des résultats paginés
                    pagination: {
                        more: data.next_page_url ? true : false // Activer la pagination si une page suivante est disponible
                    }
                };
            },
            cache: true
        },
        templateResult: formatCity // Appel de la fonction pour le rendu de l'option
    });

    // Fonction pour formater le rendu de l'option
    function formatCity(city) {
    if (!city.id) {
        return city.city;
    }

    var cityOption = '<option value="' + city.id + '">' + city.city + '</option>';
    return $(cityOption);
}
});

$(document).ready(function() {
    // Utilisation de Select2 pour l'autocomplétion
    $('#cities2').select2({
        placeholder: 'Rechercher une ville...',
        ajax: {
            url: '/cities', // URL de l'endpoint pour récupérer les données d'autocomplétion
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: data.data, // Assurez-vous d'accéder à la propriété 'data' des résultats paginés
                    pagination: {
                        more: data.next_page_url ? true : false // Activer la pagination si une page suivante est disponible
                    }
                };
            },
            cache: true
        },
        templateResult: formatCity
    });

    function formatCity(city) {
    if (!city.id) {
        return city.city;
    }

    var cityOption = '<option value="' + city.id + '">' + city.city + '</option>';
    return $(cityOption);
}
});
    </script>




</body>

</html>
