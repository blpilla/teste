<div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    <label for="user_id" class="control-label">{{ 'Usuário' }}</label>
<?php
    $users = \App\User::pluck('name','id');
    $rooms = \App\Room::pluck('number','id');
?>

    {!! Form::select('user_id', $users, (isset($reservation->user_id) ? $reservation->user_id : ''), ['class' => 'form-control']) !!}
    {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('room_id') ? 'has-error' : ''}}">
    <label for="room_id" class="control-label">{{ 'Sala' }}</label>
    {!! Form::select('room_id', $rooms, (isset($reservation->room_id) ? $reservation->room_id : ''), ['class' => 'form-control']) !!}
    {!! $errors->first('room_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('date') ? 'has-error' : ''}}">
    <label for="date" class="control-label">{{ 'Data da Reserva' }}</label>
    <input class="form-control" name="date" type="datetime-local" id="date" value="{{ isset($reservation->date) ? $reservation->date : ''}}">
    {!! $errors->first('date', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Alterar' : 'Reservar' }}">
</div>

