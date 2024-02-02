@extends('layouts.backend')

@section('content')
    <h1>Tout est bon</h1>
@endsection
{{ route('demandes.update', $demande) }}
