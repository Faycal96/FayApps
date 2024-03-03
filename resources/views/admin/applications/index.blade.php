 @extends('layouts.backend')
  @section('content')
   <div class="container-fluid">
 

    @if(auth()->user()->hasRole(['Client']))  

    <div class="row">
        <div class="col-lg-3">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $userStats['total'] }}</h3>
                    @if ($userStats['total']<= 1)
                    <p>Total des demandes</p>
                    @else
                    <p>Total des demandes</p>
                    @endif

                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{  $userStats['validated']  }}</h3>
                    @if ( $userStats['validated'] <= 1)
                    <p>Demandes validées</p>
                    @else
                    <p>Demandes Validées</p>
                    @endif

                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{  $userStats['submitted']  }}</h3>
                    @if ( $userStats['submitted'] <= 1)
                    <p>Demandes deposées</p>
                    @else
                    <p>Demandes deposées</p>
                    @endif

                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
   

        <div class="col-lg-3">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $userStats['rejected'] }}</h3>
                    @if ($userStats['rejected'] <= 1)
                    <p>Demandes Rejetées</p>
                    @else
                    <p>Demandes Rejetées</p>
                    @endif

                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>


    @elseif(auth()->user()->hasRole(['Agent','Superieur']))
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $procedureStats['total'] }}</h3>

                    <p>Total Demandes</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $procedureStats['validated'] }}</h3>

                    <p>Total demandes validées </p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $procedureStats['rejected'] }}</h3>

                    <p>Total Demandes rejetées</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $procedureStats['submitted'] }}</h3>

                    <p>Total Demandes soumises</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- ./col -->
    </div>
    @endif




    
     <div class="card">
        <div class="col-12">
      <div class="card-header">
        <h3 class="card-title">Gestion des demandes de {{ $procedure->name }}</h3>
      </div>
      <div class="card-body">
        @if(auth()->user()->hasRole(['Client']))  
       
        <a href="{{ route('procedures.applications.create', $procedure)  }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i>Faire une nouvelle demande</a>
              
        
        
        @endif
        
        <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Code de la demande</th>
                        <th>Identité</th>
                    
                        <th>Date de soumission</th>
                        <th>Statut</th>
                        @if($procedure->is_paid) <th>Paiement</th>@endif
                        <th>Action</th>
                    </tr>
                </thead>
              <tbody>
                @forelse ($applications as $application)
                <tr>
                    <td>{{ $application->request_number }}</td>
                    <td>{{ $application->user->name }}</td>
                    
                    <td>{{ $application->created_at->format('d M Y H:i:s') }}</td>
                    <td>
                        @switch($application->status)
                            @case('submitted')<span class="badge bg-warning">En attente</span>@break
                            @case('validated_by_agent')
                            <span class="badge bg-warning">Receptionné</span>@break
                            @case('validated_by_superior')<span class="badge bg-success">Approuvé</span>@break
                            @default<span class="badge bg-danger">Rejeté</span>
                        @endswitch
                    </td>
                    @if($procedure->is_paid)
                    <td>
                        @if ($application->payment_status == 'non payé')
                                    <span class="badge bg-warning">Non payé</span>
                                @else
                                    <span class="badge bg-success">Payé</span>
                                    @endif
                       
                    </td>
                    @endif
                    <td>
                        @if($procedure->is_paid && $application->payment_status == 'non payé' && auth()->user()->hasRole(['Client']) && $application->status == 'submitted')
                        <a href="{{ route('admin.payments.create', ['procedure' => $application->procedure_id, 'application' => $application->id]) }}" class="btn btn-success btn-sm">Payer</a>
                        @endif
                        
                        @if ($application->status == 'submitted' && auth()->user()->hasRole(['Client']) || $application->motif == 'document_incomplet' && auth()->user()->hasRole(['Client']))
                        <!-- Bouton de modification -->
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $application->id }}">
                            <i class="bi bi-pencil"></i> Modifier
                        </button>
                        @endif
                        @if ($application->status == 'submitted' && auth()->user()->hasRole(['Client']) )

                        <!-- Bouton de suppression -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $application->id }}">
                            <i class="bi bi-trash"></i> Supprimer
                        </button>
                        @endif
                        @if ($application->status == 'validated_by_superior' && auth()->user()->hasRole(['Client']))
                        @if ($application->document_path)
                            <a href="{{ asset('storage/' . str_replace('public/', '', $application->document_path)) }}" class="btn btn-info btn-sm" target="_blank">
                                <i class="bi bi-download"></i> Télécharger le Document
                            </a>
                        @endif
                    @endif
                                
                        <button type="button" class="btn btn-primary btn-sm detailButton" data-bs-toggle="modal"
                        data-bs-target="#applicationDetailModal{{ $application->id }}">
                    <i class="bi bi-eye"></i> Détails
                </button>
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
    
    
    
                        @if(auth()->user()->hasRole('Agent') && $application->status == 'submitted' &&   $procedure->is_paid=='0'
                        || auth()->user()->hasRole('Agent') && $application->status == 'submitted' &&   $procedure->is_paid  && $application->payment_status == 'payé'
                        )
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#validateModalAgent{{ $application->id }}">Valider</button>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModalAgent{{ $application->id }}">Rejeter</button>
                        @elseif(auth()->user()->hasRole('Superieur') && $application->status == 'validated_by_agent' &&   $procedure->is_paid=='0'
                        || auth()->user()->hasRole('Superieur') && $application->status == 'validated_by_agent' &&   $procedure->is_paid  && $application->payment_status == 'payé'
                        )
                       
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#validateModalSuperior{{ $application->id }}">Valider</button>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModalSuperior{{ $application->id }}">Rejeter</button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Aucune demande trouvée!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
       </div>
      </div>
    </div>
</div>
</div>
       @foreach($applications as $application)
      <div class="modal fade" id="editModal{{ $application->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier la demande</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.applications.update', ['procedure' => $procedure->id, 'application' => $application->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Dynamically generated fields based on the procedure -->
                    @foreach ($procedure->fields as $field)
                        @php
                            $applicationField = $application->fields->where('field_id', $field->id)->first();
                            $value = $applicationField ? $applicationField->value : '';
                        @endphp
                        <div class="mb-3">
                            <label class="form-label">{{ $field->label }}</label>
                            @include('partials.field', ['field' => $field, 'value' => $value])
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-warning">Modifier</button>
                </div>
            </form>
        </div>
    </div>
 </div>


 <!-- Modale de suppression -->
 <div class="modal fade" id="deleteModal{{ $application->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmez la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cette demande ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('admin.applications.destroy', ['procedure' => $procedure->id, 'application' => $application->id]) }}" method="POST">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
 </div>

 @if(auth()->user()->hasRole('Agent') && $application->status == 'submitted')
 <div class="modal fade" id="validateModalAgent{{ $application->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Validation de la demande</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('applications.validate.agent', $application->id) }}" method="POST">@csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="motif" class="col-form-label">Motif (optionnel):</label>
                        <textarea class="form-control" id="motif" name="motif"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-success">Valider</button>
                </div>
            </form>
        </div>
    </div>
 </div>
 <div class="modal fade" id="rejectModalAgent{{ $application->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejet de la demande</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('applications.reject.agent', $application->id) }}" method="POST">@csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="motif" class="col-form-label">Motif (obligatoire):</label>
                        <select class="form-select" id="motif" name="motif" required >
                            <option value="infructueux">Infructueux</option>
                            <option value="document_incomplet">Document incomplet</option>
                        </select>
                       
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-danger">Rejeter</button>
                </div>
            </form>
        </div>
    </div>
 </div>
 @elseif(auth()->user()->hasRole('Superieur') && $application->status == 'validated_by_agent')
 <div class="modal fade" id="validateModalSuperior{{ $application->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Validation de la demande</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('applications.validate.superior', $application->id) }}" method="POST"enctype="multipart/form-data">@csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="motif" class="col-form-label">Motif (optionnel):</label>
                        <textarea class="form-control" id="motif" name="motif"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="document">Document</label>
                        <input type="file" class="form-control" id="document" name="document">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-success">Valider</button>
                </div>
            </form>
        </div>
    </div>
 </div>
 <div class="modal fade" id="rejectModalSuperior{{ $application->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejet de la demande</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('applications.reject.superior', $application->id) }}" method="POST">@csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="motif" class="col-form-label">Motif (obligatoire):</label>
                        <textarea class="form-control" id="motif" name="motif" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-danger">Rejeter</button>
                </div>
            </form>
        </div>
    </div>
 </div>
@endif
@endforeach




@endsection
