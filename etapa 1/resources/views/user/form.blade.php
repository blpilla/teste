<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Nome' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ isset($user->name) ? $user->name : ''}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email" class="control-label">{{ 'Email' }}</label>
    <input class="form-control" name="email" type="email" id="email" value="{{ isset($user->email) ? $user->email : ''}}" >
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>

<input name="password" type="hidden" id="password" value=" ">


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Alterar' : 'Cadastrar' }}">
</div>
