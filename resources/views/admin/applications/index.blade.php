@extends('layouts.backend')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Gestion des demandes pour la procedure de {{ $procedure->name }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        
<a href="{{ route('procedures.applications.create', $procedure)  }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i>Faire une nouvelle demande</a>


 
    
    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Code de la demande</th>  
                <th>Identité</th>
                <th>Email</th>
                <th>Date de soumission</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($applications as $application)
            <tr>
                <td>{{ $application->request_number}}</td>
                <td>{{ $application->user->name}}</td>               
                <td>{{ $application->user->email }}</td>
                <td>{{ $application->created_at->format('d M Y H:i:s') }}</td>
                <td>
                    @switch($application->status)
                        @case('submitted')
                            <span class="badge bg-warning">En attente</span>
                            @break
                        @case('approved')
                            <span class="badge bg-success">Approuvé</span>
                            @break
                        @default
                            <span class="badge bg-danger">Rejeté</span>
                    @endswitch
                </td>
               
            <td>
                <button type="button" class="btn btn-primary btn-sm detailButton" data-bs-toggle="modal"
                        data-bs-target="#applicationDetailModal{{ $application->id }}">
                    <i class="bi bi-eye"></i> Détails
                </button>
            </td>
            @php
$iconMap = [
    'text' => 'bi-fonts',
    'email' => 'bi-envelope-fill',
    'phone' => 'bi-telephone-fill',
    'address' => 'bi-geo-alt-fill',
    'date' => 'bi-calendar-event',
    'number' => 'bi-hash',
    'url' => 'bi-link-45deg',
    'textarea' => 'bi-textarea-t',
    'select' => 'bi-list-ul',
    'checkbox' => 'bi-check-square',
    'file' => 'bi-file-earmark-arrow-down', // Icône pour les champs de type fichier
    // Ajoutez d'autres types et leurs icônes ici
];
@endphp

            <!-- Modal pour les détails d'une application -->
         <div class="modal fade" id="applicationDetailModal{{ $application->id }}" tabindex="-1" aria-labelledby="applicationDetailModalLabel{{ $application->id }}" aria-hidden="true">
            
        <div class="modal-dialog modal-dialog-centered modal-lg">
         <div class="modal-content">
            <div class="modal-header bg-gray-dark text-white">
                <h5 class="modal-title" id="applicationDetailModalLabel">Détails de la Demande</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light">
                
                
                    <div class="row">
                        <!-- Affichage des champs dynamiques avec icônes -->
                        @foreach ($uniqueFieldNames as $fieldName)
                            @php
                                $field = $application->fields->firstWhere('label', $fieldName);
                                $fieldValue = $field ? $field->pivot->value : 'N/A';
                                $fieldType = $field ? $field->type : 'text';
                                $icon = $iconMap[$fieldType] ?? 'bi-file-earmark-text';
                            @endphp
                            
                            @if ($fieldType === 'file' && $fieldValue !== 'N/A')
                                <div class="col-md-6 mb-3">
                                    <i class="{{ $icon }} me-2"></i><strong>{{ $fieldName }}:</strong>
                                    <a href="{{ asset('storage/' . str_replace('public/', '', $fieldValue)) }}" class="btn btn-info btn-sm" target="_blank">
                                        <i class="bi bi-download"></i> Télécharger
                                    </a>
                                </div>
                            @else
                                <div class="col-md-6 mb-3">
                                    <i class="{{ $icon }} me-2"></i>
                                    <strong>{{ $fieldName }}:</strong> {{ $fieldValue }}
                                </div>
                            @endif
                        @endforeach
                    </div>
               
                
                
                

            
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

            
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
