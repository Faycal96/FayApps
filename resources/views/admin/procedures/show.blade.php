{{-- resources/views/admin/procedures/show.blade.php --}}
@extends('layouts.backend')


@section('content')
<h1>Procédure : {{ $procedure->name }}</h1>
<p>Statut : {{ $procedure->status ? 'Actif' : 'Inactif' }}</p>
<a href="{{ route('procedures.index') }}" class="btn btn-primary">Retour à la liste</a>
@endsection
