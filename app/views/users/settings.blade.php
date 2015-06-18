@extends('layouts.default')

@section('title')
{{ lang('Perfil de usuario') }} - @parent
@stop

@section('content')
<div class="col-md-6 col-md-offset-3">
    <h3 class="text-muted">{{ lang('Actualizar perfil') }}</h3>
    {{ Form::model($currentUser, ['route' => ['users.update', $currentUser->id], 'method' => 'patch']) }}
        @include('layouts.partials.errors')
        <div class="form-group">
            <label for="display_name">{{ lang('Nombre a mostrar:') }}</label>

           {{ Form::text('display_name', Input::old('display_name') ? : null, ['class' => 'form-control', 'placeholder' => lang('Agrega tu nombre a mostrar')]) }}
        </div>
        <hr>
        <div class="form-group">
            <button tabindex="3" type="submit" class="btn btn-primary">{{ lang('Terminar') }}</button>
        </div>
    {{ Form::close() }}
</div>
<div class="clearfix"></div>
@stop
