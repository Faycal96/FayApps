@extends('layouts.header')

@section('content')
<div class="container">
      <!-- ======= Featured Section ======= -->
      <section id="featured" class="featured">
        <div class="container">
          <p>Veuillez vous inscrire ci dessous !</p>
          <div class="row">
            <div class="col-lg-6">
              <div class="icon-box">
                  <i class="bi bi-building"></i>
                <h3><a href="{{ route('register') }}">Je suis une agence acreditée</a></h3>
                <p>Description d'une agence acreditée</p>
              </div>
            </div>

            <div class="col-lg-6 mt-4 mt-lg-0">
              <div class="icon-box">
                {{-- <i class="bi bi-binoculars"></i> --}}
                <i class="bi bi-person"></i>
                <h3><a href="{{ route('registerdaf') }}">Je suis un agent du Ministère</a></h3>
                <p>cette espace est reservé au DAF des differents Ministère</p>
              </div>
            </div>
          </div>

        </div>
      </section><!-- End Featured Section -->

</div>
@endsection
