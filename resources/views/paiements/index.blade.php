@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    

    <div class="">
        <div class="col-12">
            <p>
                @if(session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span class="alert-heading">{{session('success')}}</span>
                </div>

                <script>
                    setTimeout(function() {
                        document.querySelector('.alert.alert-success').style.display = 'none';
                    }, 6000);
                </script>
                @endif
            </p>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gestion des Paiements</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if(auth()->user()->hasRole(['Admin']))
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPaiementModal">
                        <i class="bi bi-plus-circle"></i>  Ajouter un Paiement
                    </button>
                    @endif
                   <div class="modal fade" id="createPaiementModal" tabindex="-1" aria-labelledby="createPaiementModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createPaiementModalLabel">Ajouter un Paiement</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form id="createPaymentForm" action="{{ route('paiements.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group mb-3">
                                            <label for="pelerin_id"><i class="bi bi-person-fill me-2"></i>Pèlerin</label>
                                            <select name="pelerin_id" id="pelerin_id" class="form-control select2bs4" style="width: 100%;" required>
                                                @foreach($pelerins as $pelerin)
                                                    <option value="{{ $pelerin->id }}" data-restant="{{ $pelerin->montantRestant() }}">
                                                        {{ $pelerin->nom }} {{ $pelerin->prenom }} -{{ $pelerin->passeport }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="form-group mb-3">
                                            <label for="montant"><i class="bi bi-cash-coin me-2"></i>Montant</label>
                                            <input type="number" name="montant" id="montant" class="form-control" required>
                                            <div id="montantError" class="text-danger mt-2"></div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="mode_paiement"><i class="bi bi-credit-card me-2"></i>Mode de Paiement</label>
                                            <select class="form-control" id="mode_paiement" name="mode_paiement" required>
                                                <option value="">Sélectionner le moyen de paiement</option>
                                                <option value="espece">Espèce</option>
                                                <option value="card_credit">Carte de Crédit</option>
                                                <option value="cheque">Chèque</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="note"><i class="bi bi-note-text me-2"></i>Note</label>
                                            <textarea name="note" id="note" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                        <button type="button" class="btn btn-primary" onclick="validateCreatePayment()">Ajouter</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        function validateCreatePayment() {
                            const pelerinId = document.getElementById('pelerin_id').value;
                            const montantInput = document.getElementById('montant');
                            const montantError = document.getElementById('montantError');
                            const selectedOption = document.querySelector(`#pelerin_id option[value="${pelerinId}"]`);
                            const montantRestant = parseFloat(selectedOption.dataset.restant);

                            const montant = parseFloat(montantInput.value);

                            if (montant > montantRestant ) {
                                montantError.textContent = 'Le montant payé ne peut pas dépasser le montant prix du hadj.';
                                return;
                            } else {
                                montantError.textContent = '';
                            }

                            document.getElementById('createPaymentForm').submit();
                        }
                    </script>

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Nom-Prenom</th>
                                <th>Passeport</th>
                                <th>Montant versé</th>
                                <th>Montant total du hadj </th>
                                
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($paiements as $payment)
                            
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $payment->created_at->translatedFormat('d M Y') }}</td>
                                <td>

                                    {{ strtoupper( $payment->pelerin->nom) }} {{ ucfirst( $payment->pelerin->prenom) }}
                                </td>
                                <td>{{  $payment->pelerin->passeport }}</td>
                               
                                <td>{{  number_format( $payment->montant, 0, ',', ' ') }} FCFA</td>
                                <td>{{  number_format( $payment->pelerin->prixTotalHadj(), 0, ',', ' ') }} FCFA</td>
                             
                                
                                
                                <td>
                                    @if ($payment->pelerin->montantRestant() == 0)
                                    <span class="badge bg-success">Payé</span>
                                @elseif ($payment->pelerin->montantTotalPaye() > 0 && $payment->pelerin->montantRestant() > 0)
                                    <span class="badge bg-warning">En cours</span>
                                @elseif ($payment->statut_paiement = 'annulé')
                                    <span class="badge bg-danger">Annulé</span>
                                @endif
                                </td>
                                <td>
                                    <a href="{{ asset('recu/' . $payment->id . '_recu.pdf') }}" 
                                        class="btn btn-info btn-sm" target="_blank">
                                        <i class="bi bi-download"></i> Récépissé
                                     </a>
                                    @if ($payment->pelerin->montantRestant() > 0 && auth()->user()->hasRole(['Admin']))
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#payPaymentModal{{ $payment->id }}">
                                        <i class="bi bi-credit-card"></i> Payer
                                    </button>
                                
                                    <!-- Modal de Paiement -->
                                    <div class="modal fade" id="payPaymentModal{{ $payment->id }}" tabindex="-1" aria-labelledby="payPaymentModalLabel{{ $payment->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-success text-white">
                                                    <h5 class="modal-title" id="payPaymentModalLabel{{ $payment->id }}">Payer pour {{ $payment->pelerin->nom }} {{ $payment->pelerin->prenom }}, le montant restant est de {{ number_format($payment->pelerin->montantRestant(), 0, ',', ' ') }} FCFA</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="paymentForm{{ $payment->id }}" action="{{ route('paiements.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="pelerin_id" value="{{ $payment->pelerin_id }}">
                                                        <input type="hidden" id="montantRestant{{ $payment->id }}" value="{{ $payment->pelerin->montantRestant() }}">
                                
                                                        <div class="form-group mb-3">
                                                            <label for="montant"><i class="bi bi-cash-coin me-2"></i>Montant</label>
                                                            <input type="number" name="montant" id="montant{{ $payment->id }}" class="form-control" required>
                                                            <div id="montantError{{ $payment->id }}" class="text-danger mt-2"></div>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="mode_paiement"><i class="bi bi-credit-card me-2"></i>Mode de Paiement</label>
                                                            <select class="form-control" id="mode_paiement" name="mode_paiement" required>
                                                                <option value="">Sélectionner le moyen de paiement</option>
                                                                <option value="espece">Espèce</option>  
                                                                <option value="card_credit">Carte de Crédit</option> 
                                                                <option value="cheque">Chèque</option> 
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="note"><i class="bi bi-note-text me-2"></i>Note</label>
                                                            <textarea name="note" id="note" class="form-control"></textarea>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                    <button type="button" class="btn btn-success" onclick="validatePayment({{ $payment->id }})">Enregistrer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <script>
                                    function validatePayment(paymentId) {
                                        const montantInput = document.getElementById(`montant${paymentId}`);
                                        const montantRestant = parseFloat(document.getElementById(`montantRestant${paymentId}`).value);
                                        const montantError = document.getElementById(`montantError${paymentId}`);
                                        
                                        const montant = parseFloat(montantInput.value);
                                        
                                        if (montant > montantRestant) {
                                            montantError.textContent = 'Le montant payé ne peut pas dépasser le montant restant à payer.';
                                            return;
                                        } else {
                                            montantError.textContent = '';
                                        }
                                
                                        document.getElementById(`paymentForm${paymentId}`).submit();
                                    }
                                </script>
                                
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#simpleDetailModal{{ $payment->id }}">
                                        <i class="bi bi-info-circle"></i> Détails
                                    </button>

                                    <!-- Modal de Détails -->
                                    <div class="modal fade" id="simpleDetailModal{{ $payment->id }}" tabindex="-1" aria-labelledby="simpleDetailModalLabel{{ $payment->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-dark text-white">
                                                    <h5 class="modal-title" id="simpleDetailModalLabel{{ $payment->id }}">Détails du Paiement</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body bg-light">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-person-fill me-2"></i><strong>Nom :</strong> {{ $payment->pelerin->nom }}
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-calendar-event-fill me-2"></i><strong>Date du paiement :</strong> {{ $payment->created_at->translatedFormat('d M Y à H:i:s') }}
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-cash-coin me-2"></i><strong>Montant :</strong> {{ $payment->montant }} FCFA
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-credit-card me-2"></i><strong>Mode de paiement :</strong> {{ $payment->mode_paiement }}
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-dark text-white">
                                                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Bouton pour annuler le paiement -->
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#cancelPaymentModal{{ $payment->id }}">
                                    <i class="bi bi-x-circle"></i> Annuler
                                </button>

                                <!-- Modal d'annulation -->
                                <div class="modal fade" id="cancelPaymentModal{{ $payment->id }}" tabindex="-1" aria-labelledby="cancelPaymentModalLabel{{ $payment->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="cancelPaymentModalLabel{{ $payment->id }}">Annuler le Paiement</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('paiements.cancel', $payment->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')

                                                    <div class="form-group">
                                                        <label for="motif_annulation">Motif d'Annulation</label>
                                                        <textarea name="motif_annulation" id="motif_annulation" class="form-control" rows="4" required></textarea>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger">Confirmer l'Annulation</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    @if(auth()->user()->hasRole(['Admin']))
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPaymentModal{{ $payment->id }}">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </button>
                                    

                                    <!-- Modal de Modification -->
                                    <div class="modal fade" id="editPaymentModal{{ $payment->id }}" tabindex="-1" aria-labelledby="editPaymentModalLabel{{ $payment->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-secondary text-white">
                                                    <h5 class="modal-title" id="editPaymentModalLabel{{ $payment->id }}">Modifier le Paiement pour {{ $payment->pelerin->nom }} {{ $payment->pelerin->prenom }}, le montant restant est de {{ number_format($payment->pelerin->montantRestant(), 0, ',', ' ') }} FCFA</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editPaymentForm{{ $payment->id }}" action="{{ route('paiements.update', $payment->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="pelerin_id" value="{{ $payment->pelerin_id }}">
                                                        <input type="hidden" id="montantRestant{{ $payment->id }}" value="{{ $payment->pelerin->montantRestant() }}">
                                                        
                                                        <div class="form-group mb-3">
                                                            <label for="montant"><i class="bi bi-cash-coin me-2"></i>Montant</label>
                                                            <input type="number" name="montant" id="montant{{ $payment->id }}" class="form-control" value="{{ $payment->montant }}" required>
                                                            <div id="montantError{{ $payment->id }}" class="text-danger mt-2"></div>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="mode_paiement"><i class="bi bi-credit-card me-2"></i>Mode de Paiement</label>
                                                            <select class="form-control" id="mode_paiement" name="mode_paiement" required>
                                                                <option value="espece" {{ $payment->mode_paiement == 'espece' ? 'selected' : '' }}>Espèce</option>
                                                                <option value="card_credit" {{ $payment->mode_paiement == 'card_credit' ? 'selected' : '' }}>Carte de Crédit</option>
                                                                <option value="cheque" {{ $payment->mode_paiement == 'cheque' ? 'selected' : '' }}>Chèque</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="note"><i class="bi bi-note-text me-2"></i>Note</label>
                                                            <textarea name="note" id="note" class="form-control">{{ $payment->note }}</textarea>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                    <button type="button" class="btn btn-primary" onclick="validateEditPayment({{ $payment->id }})">Enregistrer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <script>
                                      function validateEditPayment(paymentId) {
                                            const montantInput = document.getElementById('montant' + paymentId);
                                            const montantError = document.getElementById('montantError' + paymentId);
                                            const montantRestantInput = document.getElementById('montantRestant' + paymentId);
                                            const montantRestant = parseFloat(montantRestantInput.value);

                                            const montant = parseFloat(montantInput.value);

                                            if (montant > montantRestant + parseFloat(montantInput.dataset.original)) {
                                                montantError.textContent = 'Le montant payé ne peut pas dépasser le montant restant à payer après la modification.';
                                                return;
                                            } else {
                                                montantError.textContent = '';
                                            }

                                            document.getElementById('editPaymentForm' + paymentId).submit();
                                        }

                                    </script>
                                    



                                    {{-- <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deletePaymentModal{{ $payment->id }}">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>

                                    <!-- Modal de Suppression -->
                                    <div class="modal fade" id="deletePaymentModal{{ $payment->id }}" tabindex="-1" aria-labelledby="deletePaymentModalLabel{{ $payment->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="deletePaymentModalLabel{{ $payment->id }}">Supprimer le Paiement</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Êtes-vous sûr de vouloir supprimer ce paiement ? Cette action est irréversible.</p>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <form action="{{ route('paiements.destroy', $payment->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">Aucun paiement enregistré pour le moment.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
    });
</script>


@endsection
