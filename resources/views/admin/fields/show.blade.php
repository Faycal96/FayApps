{{-- resources/views/fields/show.blade.php --}}
@extends('layouts.backend')



@section('content')
<div class="container mt-4">
    <h1>Voir Champ: "{{ $field->label }}"</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $field->label }}</h5>
            <p class="card-text">Type: {{ $field->type }}</p>
        </div>
    </div>
    <a href="{{ route('procedures.fields.index', $procedure->id) }}" class="btn btn-primary mt-3">Retour à la liste</a>
</div>
@endsection
