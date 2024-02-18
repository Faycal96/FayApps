{{-- resources/views/admin/procedures/index.blade.php --}}
@extends('layouts.backend')

@section('content')
<h1>Procédures</h1>
<a href="{{ route('procedures.create') }}" class="btn btn-primary">Ajouter une procédure</a>
<table class="table">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Status</th>
            <th>Ministere</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($procedures as $procedure)
            <tr>
                <td>{{ $procedure->name }}</td>
                <td>{{ $procedure->status ? 'Actif' : 'Inactif' }}</td>
                <td> @foreach ($ministeres as $min)

                    {{ $procedure->ministry_id==$min->id ? $min->libelleLong : ''
                   }}
                   @endforeach</td>

               
                <td>
                    <a href="{{ route('procedures.applications.index', $procedure->id) }}" class="btn btn-sm btn-info">Gerer mes demandes</a>
                    <a href="{{ route('procedures.fields.index', $procedure->id) }}" class="btn btn-sm btn-info">Gérer les champs</a>
                    <a href="{{ route('procedures.show', $procedure->id) }}" class="btn btn-info">Voir</a>
                    <a href="{{ route('procedures.edit', $procedure->id) }}" class="btn btn-success">Éditer</a>
                    <form action="{{ route('procedures.destroy', $procedure->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
