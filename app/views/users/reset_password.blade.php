@extends('layouts.default')

@section('title')
{{ lang('Reset Password') }} - @parent
@stop

@section('content')
<div class="col-md-6 col-md-offset-3">
    <form method="POST" action="{{{ URL::to('/users/reset_password') }}}" accept-charset="UTF-8">
        <input type="hidden" name="token" value="{{{ $token }}}">
        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

        <div class="form-group">
            <label for="password">{{{ lang('Contraseña') }}}</label>
            <input class="form-control" placeholder="{{{ lang('Contraseña') }}}" type="password" name="password" id="password">
        </div>
        <div class="form-group">
            <label for="password_confirmation">{{{ lang('Confirmar contraseña') }}}</label>
            <input class="form-control" placeholder="{{{ lang('Confirmar contraseña') }}}" type="password" name="password_confirmation" id="password_confirmation">
        </div>

        @if (Session::get('error'))
            <div class="alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
        @endif

        @if (Session::get('notice'))
            <div class="alert">{{{ Session::get('notice') }}}</div>
        @endif

        <div class="form-actions form-group">
            <button type="submit" class="btn btn-primary">{{{ lang('Terminar') }}}</button>
        </div>
    </form>
</div>
@stop
