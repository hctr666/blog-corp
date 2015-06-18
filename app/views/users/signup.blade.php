@extends('layouts.default')

@section('title')
{{ lang('Registro de usuario') }} - @parent
@stop

@section('content')
<div class="col-md-6 col-md-offset-3">
    <h3 class="text-muted">{{ lang('Crear nueva cuenta') }}</h3>
    <form method="POST" action="{{{ URL::to('users') }}}" accept-charset="UTF-8">
        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

        <div class="form-group">
            <input class="form-control" placeholder="{{{ lang('Nombre usuario') }}}" type="text" name="username" id="username" value="{{{ Input::old('username') }}}">
        </div>
        <div class="form-group">
            <input class="form-control" placeholder="{{{ lang('Email') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
        </div>
        <div class="form-group">
            <input class="form-control" placeholder="{{{ lang('Contraseña') }}}" type="password" name="password" id="password">
        </div>
        <div class="form-group">
            <input class="form-control" placeholder="{{{ lang('Confirmación de contraseña') }}}" type="password" name="password_confirmation" id="password_confirmation">
        </div>

        @if (Session::get('error'))
            <div class="alert alert-error alert-danger">
                @if (is_array(Session::get('error')))
                    {{ head(Session::get('error')) }}
                @endif
            </div>
        @endif

        @if (Session::get('notice'))
            <div class="alert alert-info">{{ Session::get('notice') }}</div>
        @endif

        <div class="form-actions form-group">
          <button type="submit" class="btn btn-primary">{{{ lang('Terminar') }}}</button>
        </div>
    </form>
</div>
<div class="clearfix"></div>
@stop
