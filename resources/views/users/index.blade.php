@extends('layouts.backend')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gestion des Utilisateurs</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>S#</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @forelse ($user->getRoleNames() as $role)
                                        <span class="badge bg-primary">{{ $role }}</span>
                                    @empty
                                        <span>N/A</span>
                                    @endforelse
                                </td>
                                <td>
                                    <!-- Exemple de boutons d'action -->
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Afficher</a>
                                    
                                    @can('edit-user')
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Modifier</a>
                                    @endcan
                                    
                                    @can('delete-user')
                                    <form action="{{ route('users.destroy', $user->id) }}" method="post" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');"><i class="bi bi-trash"></i> Supprimer</button>
                                    </form>
                                    @endcan
                                   
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Aucun utilisateur trouvé!</td>
                            </tr>
                            @endforelse
                        </tbody>
                        
                        <tfoot>
                            <tr>
                                <th>S#</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->

    
@endsection