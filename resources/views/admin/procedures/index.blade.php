{{-- resources/views/admin/procedures/index.blade.php --}}
@extends('layouts.backend')

@section('content')
<h1>Procédures</h1>
@if(auth()->user()->hasRole(['Admin']))
<a href="{{ route('procedures.create') }}" class="btn btn-primary">Ajouter une procédure</a>
@endif

<table class="table">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Status</th>
            
            <th>Paiement</th>
            <th>Ministere</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
       
                           
        @foreach ($procedures as $procedure)
        @if ($procedure->ministry_id ==auth()->user()->id_m  && auth()->user()->hasRole(['Admin']) || auth()->user()->hasRole(['Client'])|| $procedure->users->contains(auth()->user()->id))
            <tr>
                <td>{{ $procedure->name }}</td>
                <td>{{ $procedure->status ? 'Actif' : 'Inactif' }}</td>
                <td>{{ $procedure->is_paid ? 'Payant' : 'Gratuit' }}</td>
               
                <td> @foreach ($ministeres as $min)

                    {{ $procedure->ministry_id==$min->id ? $min->libelleLong : ''
                   }}
                   @endforeach</td>

               
                <td>
                    
                    @if(auth()->user()->hasRole(['Client','Agent','Superieur']))
                    <a href="{{ route('procedures.applications.index', $procedure->id) }}" class="btn btn-sm btn-info">Gerer mes demandes</a>
                    @endif
                    @if(auth()->user()->hasRole(['Admin']))
                    <a href="{{ route('procedures.fields.index', $procedure->id) }}" class="btn btn-sm btn-info">Gérer les champs</a>
                    <a href="{{ route('procedures.show', $procedure->id) }}" class="btn btn-info">Voir</a>
                    <a href="{{ route('procedures.edit', $procedure->id) }}" class="btn btn-success">Éditer</a>
                    <form action="{{ route('procedures.destroy', $procedure->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endif
        @endforeach
        
    </tbody>
</table>

@endsection
