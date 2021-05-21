@extends('template')

@section('contenu')

	<!-- container -->
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
                    <span class="card-title center">Sign in to start playing !</span>
                    
                    <form method="POST" action="{{ route('login') }}">
                        
                        @csrf
                        
                        <div class="input-field">
                            <i class="material-icons prefix">mail</i>
                            <input id="email" type="email" class="text-color-white validate form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                            <label for="email">Email</label>

                            @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="input-field">
                            <i class="material-icons prefix">vpn_key</i>
                            <input id="password" type="password" class="text-color-white form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                            <label for="password">Password</label>

                            @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>
                                    <input type="checkbox" class="filled-in" checked="{{ old('remember') ? 'checked' : '' }}" name="remember" id="remember" >
                                    <span>{{ __('Remember Me') }}</span>
                                </label>   
                            </div> 
                            <div class="col">
                                @if (Route::has('password.request'))
                                    <a class="" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <button type="submit" class="btn waves-effect waves-light row btn-action" style="width: 100%">Sign in</button>
                        </div>

                    </form>
                    <hr>
                    <p>Not a member ? <a href="{{ url('/register') }}">Sign up here</a></p>
                </div>
            </div>
        </div>

        {{-- this only works with seeds, of course --}}
        @if (config('app.debug') === true)
            <hr>
            <div id="cheat">
                <button onclick="fillLogin('admin@gmail.com', 'admin');" class="btn btn-info">admin</button>
                <button onclick="fillLogin('creator@gmail.com', 'creator');" class="btn btn-info">creator</button>
                <button onclick="fillLogin('joueur@gmail.com', 'joueur');" class="btn btn-info">joueur</button>
                <button onclick="playerNumber();" class="btn btn-info">
                    player <input id="player-number" type="number" class="text-color-white" min="0" max="29" value="0">
                </button>
            </div>

            <script>
                function fillLogin(email, password) {
                    document.getElementById('email').value = email;
                    document.getElementById('password').value = password;
                }
                function playerNumber() {
                    const num = document.getElementById('player-number').value;
                    fillLogin('email'+num+'@crot.fr', 'p');
                }
            </script>
            
        @endif

    </div>	

@endsection
