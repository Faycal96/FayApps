@extends('layouts.backend')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Gestion des demandes pour la procedure de {{ $procedure->name }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        
<a href="{{ route('procedures.applications.create', $procedure)  }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New User</a>


 
    
    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Date de soumission</th>
               
                <th>Statut</th>
                @foreach ($uniqueFieldNames as $fieldName)
                <th>{{ $fieldName }}</th>
            @endforeach
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($applications as $application)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $application->created_at->format('d M Y H:i:s') }}</td>
                {{-- <td>{{ $application->user->name }}</td>
                <td>{{ $application->user->email }}</td> --}}
                <td>
                    @switch($application->status)
                        @case('pending')
                            <span class="badge bg-warning">En attente</span>
                            @break
                        @case('approved')
                            <span class="badge bg-success">Approuvé</span>
                            @break
                        @default
                            <span class="badge bg-danger">Rejeté</span>
                    @endswitch
                </td>
                @foreach ($uniqueFieldNames as $fieldName)
                @php
                    $field = $application->fields->firstWhere('label', $fieldName);
                    $fieldValue = $field ? $field->pivot->value : 'N/A';
                @endphp
                <td>{{ $fieldValue }}</td>
            @endforeach
                <td>
                    <!-- Actions comme afficher plus de détails, modifier, ou supprimer -->
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Aucune réponse trouvée pour cette procédure!</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
</div>
@endsection
