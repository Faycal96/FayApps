@extends('layouts.backend')

@section('content')
<div class="container">
    <h2>Mes Demandes</h2>
    <a href="{{ route('procedures.applications.create', $procedure) }}">Soumettre une nouvelle demande</a>
    <ul>
        @foreach ($applications as $application)
            <li>{{ $application->procedure->name }} </li>
        @endforeach
    </ul>
</div>
@endsection
