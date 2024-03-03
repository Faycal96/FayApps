@extends('layouts.backend')

@section('content')
<div class="container mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-gray-dark text-white">
                    <h5 class="card-title">Soumettre une Application pour "{{ $procedure->name }}"</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('procedures.applications.store', $procedure) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            @foreach ($procedure->fields as $index => $field)
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ $field->label }}</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">
                                            @switch($field->type)
                                                @case('text')
                                                    <i class="fas fa-pencil-alt"></i>
                                                    @break
                                                @case('textarea')
                                                    <i class="fas fa-align-left"></i>
                                                    @break
                                                @case('date')
                                                    <i class="fas fa-calendar-alt"></i>
                                                    @break
                                                @case('email')
                                                    <i class="fas fa-envelope"></i>
                                                    @break
                                                @case('select')
                                                    <i class="fas fa-caret-down"></i>
                                                    @break
                                                @case('radio')
                                                    <i class="fas fa-dot-circle"></i>
                                                    @break
                                                @case('checkbox')
                                                    <i class="fas fa-check-square"></i>
                                                    @break
                                                @case('file')
                                                    <i class="fas fa-upload"></i>
                                                    @break
                                                @case('number')
                                                    <i class="fas fa-hashtag"></i>
                                                    @break
                                            @endswitch
                                        </span>
                                        @switch($field->type)
                                            @case('text')
                                                <input type="text" name="field_{{ $field->id }}" class="form-control">
                                                @break
                                            @case('textarea')
                                                <textarea name="field_{{ $field->id }}" class="form-control" rows="2"></textarea>
                                                @break
                                            @case('date')
                                                <input type="date" name="field_{{ $field->id }}" class="form-control">
                                                @break
                                            @case('email')
                                                <input type="email" name="field_{{ $field->id }}" class="form-control">
                                                @break
                                            @case('select')
                                                <select name="field_{{ $field->id }}" class="form-select">
                                                    @if($field->options)
                                                        @foreach(json_decode($field->options, true) as $option)
                                                            <option value="{{ $option }}">{{ $option }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @break
                                            @case('radio')
                                                <div class="ms-2">
                                                    @if($field->options)
                                                        @foreach(json_decode($field->options, true) as $option)
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="field_{{ $field->id }}" value="{{ $option }}">
                                                                <label class="form-check-label">{{ $option }}</label>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                @break
                                            @case('checkbox')
                                                <div class="form-check ms-2">
                                                    <input class="form-check-input" type="checkbox" name="field_{{ $field->id }}" value="1">
                                                    <label class="form-check-label">Cocher pour valider</label>
                                                </div>
                                                @break
                                            @case('file')
                                                <input type="file" name="field_{{ $field->id }}" class="form-control">
                                                @break
                                            @case('number')
                                                <input type="number" name="field_{{ $field->id }}" class="form-control">
                                                @break
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <a href="{{ route('procedures.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Retour</a>
                            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check-lg"></i> Soumettre</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
