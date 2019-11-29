<div class="form-group {{ $errors->has('number') ? 'has-error' : ''}}">
    <label for="number" class="control-label">{{ 'Número' }}</label>
    <input class="form-control" name="number" type="number" id="number" value="{{ isset($room->number) ? $room->number : ''}}" >
    {!! $errors->first('number', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Alterar' : 'Cadastrar' }}">
</div>
