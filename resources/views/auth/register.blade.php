@extends('template')

@section('contenu')

	<div class="container"  style="margin: 5% auto">
        @if (session('status'))
            <div class="alert alert-success" role='alert'>
                {{ session('status') }}
            </div>
        @endif
        
        @if ($errors->any())
            <div class="alert alert-danger" role='alert'>
                {{ $errors->first() }}
            </div>
        @endif

        <div class="row">
            <div class="card col s8 offset-s2 blue-grey darken-3 hoverable">
                <div class="card-content">
                    <div class="center-align">
                        <img src="{{ asset('images/logo.png') }}">
                    </div>
                    <span class="card-title center">Sign up to start playing !</span>
                    
                    <form method="POST" action="{{ route('register') }}">
                        
                        @csrf
                        
                        <div class="input-field">
                            <i class="material-icons prefix">person</i>
                            <input id="name" type="text" class="text-color-white form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                            <label for="name">Name</label>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="input-field">
                            <i class="material-icons prefix">mail</i>
                            <input id="email" type="email" class="text-color-white form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                            <label for="email">Email Address</label>
                            
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>


                        <div class="row">
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">vpn_key</i>
                                <input id="password" type="password" class="text-color-white validate {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                <label for="password">Password</label>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">vpn_key</i>
                                <input id="password-confirm" type="password" name="password_confirmation" class="text-color-white validate">
                                <label for="password-confirm">Confirm Password</label>
                            </div>
                        </div>
                        
                        <div>
                            <button type="submit" class="btn">
                                {{ __('Register') }}
                            </button>
                        </div>

                    </form>
                    <hr>Already have an account ? <a href="{{ url('/login') }}">Sign in here</a></p>
                </div>
            </div>
        </div>
    </div>

@endsection
