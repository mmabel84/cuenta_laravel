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
<div class="container" >
    <div id="loginModal" class="row modal show" tabindex="-1" role="dialog" aria-hidden="true" style="top: 10%">
        <div class="modal-dialog">
            <div class="panel panel-default modal-content">
                <div class="panel-heading modal-header" ><b>BIENVENIDO AL SISTEMA DE CUENTA</b>
                
                </div>
                <div class="panel-body modal-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}


                        {{ Session::pull('midred') }}

                       <div class="form-group{{ Session::get('loginrfcerr') ? ' has-error' : '' }}">

                           <div class="col-md-8 col-md-offset-2 input-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-star"></i></span>
                                    <input id="login_rfc" name="login_rfc" type="text" class="rfc form-control" value="{{ old('login_rfc') }}" required placeholder="RFC" />
                                </div>

                               @if (Session::has('loginrfcerr'))
                                    <span class="help-block">
                                        <strong>{{ Session::get('loginrfcerr') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                            <div class="col-md-8 col-md-offset-2 input-group">
                            
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Correo electrónico">
                                </div>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                            <div class="col-md-8 col-md-offset-2 input-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                    <input id="password" type="password" class="form-control" name="password" required placeholder="Contraseña">
                                </div>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!--<div class="form-group">
                            <div class="col-md-12 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recordar contraseña
                                    </label>
                                </div>
                            </div>
                        </div>-->

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-2 input-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" style="background-color: #5c154d; width: 100%">
                                    Entrar
                                </button>
                            </div>

                            

                            <div class="col-md-12 col-md-offset-4">
                                
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Olvidó la constraseña?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
