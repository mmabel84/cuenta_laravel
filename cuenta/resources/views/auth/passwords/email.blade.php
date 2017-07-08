@extends('layouts.app')

<style type="text/css">
      .rfc {
            font-family: 'Arial';
            font-size: 2rem;
            border-bottom: 1px solid $text-color;
            border-top: 1px solid $text-color;
            padding: 2rem 0;
            text-transform: uppercase;
            }
</style>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Resetear Contraseña</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        

                        <div class="form-group{{ Session::get('loginrfcerr') ? ' has-error' : '' }}">
                            <label for="login_rfc" class="col-md-4 control-label">RFC</label>

                           <div class="col-md-6">
                                <input id="login_rfc" name="login_rfc" type="text" class="rfc form-control" value="{{ old('login_rfc') }}" required >

                               @if (Session::has('loginrfcerr'))
                                    <span class="help-block">
                                        <strong>{{ Session::get('loginrfcerr') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Correo electrónico</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" style="background-color: #5c154d; width: 100%">
                                    Enviar correo para cambio de contraseña
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
