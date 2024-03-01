@switch($field->type)
    @case('text')
    @case('date')
    @case('email')
    @case('number')
    @case('time')
        <input type="{{ $field->type }}" name="field_{{ $field->id }}" class="form-control" value="{{ old('field_'.$field->id, $value) }}">
        @break

    @case('textarea')
        <textarea name="field_{{ $field->id }}" class="form-control">{{ old('field_'.$field->id, $value) }}</textarea>
        @break

    @case('select')
        <select name="field_{{ $field->id }}" class="form-control">
            @if($field->options)
                @foreach(json_decode($field->options, true) as $option)
                    <option value="{{ $option }}" @if($value == $option) selected @endif>{{ $option }}</option>
                @endforeach
            @endif
        </select>
        @break

    @case('checkbox')
        <input type="checkbox" name="field_{{ $field->id }}" value="1" @if($value == '1') checked @endif> Cocher pour valider
        @break

    @case('file')
        @if($value)
            <div>Current File: <a href="{{ Storage::url($value) }}" target="_blank">View File</a></div>
        @endif
        <input type="file" name="field_{{ $field->id }}" class="form-control">
        @break

    @case('radio')
        @if($field->options)
            @foreach(json_decode($field->options, true) as $option)
                <div>
                    <input type="radio" name="field_{{ $field->id }}" value="{{ $option }}" @if($value == $option) checked @endif> {{ $option }}
                </div>
            @endforeach
        @endif
        @break

    <!-- Ajoutez d'autres cas au besoin -->
@endswitch
