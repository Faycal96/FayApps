{{-- resources/views/admin/procedures/show.blade.php --}}
@extends('layouts.backend')


@section('content')
<h1>Procédure : {{ $procedure->name }}</h1>
<p>Statut : {{ $procedure->status ? 'Actif' : 'Inactif' }}</p>
<p>Description : {{ $procedure->description }}</p>
<p>Assignée à :</p>
<ul>
    @foreach ($procedure->users as $user)
        <li>{{ $user->name }}</li>
    @endforeach
</ul>
<a href="{{ route('procedures.index') }}" class="btn btn-primary">Retour à la liste</a>
@endsection
