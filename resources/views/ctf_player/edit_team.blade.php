@extends('template')

@section('contenu')

    @if (Auth::user()->ctf_player && Auth::user()->isLeader() &&  Auth::user()->isLeaderOf(Auth::user()->team()) )
        @if (isset($info))
            <div class="row alert alert-info"> {{ $info }} </div>
        @endif

    <!-- container -->
	<div class="container">

        <nav class="clean">
            <div class="nav-wrapper">
              <div class="col s12">
                <a href="{{ url('/home') }}" class="breadcrumb">Home</a>
                <a href="{{ url('/team') }}" class="breadcrumb">Team</a>
                <span class="active breadcrumb">Edit a team</span>
              </div>
            </div>
        </nav>

        <div style="margin: 5% auto">
            <div class="row">
                <div class="card blue-grey darken-3 col s7 offset-s3 hoverable">
                    <div class="card-content align-warper">
                        <span class="card-title center"><i class="material-icons prefix">edit </i> Edit the team "{{ $team->team_name }}"</span>
                        {!! Form::model($team,['route' => ['team.update', $team->id], 'method' => 'put']) !!}
                            @csrf
                            <div class="input-field {!! $errors->has('team_name') ? 'has-error' : '' !!}">
                                {!! Form::label('team_name', "New name") !!}
                                {!! Form::text('team_name', null, ['class' => 'validate']) !!}
                                {!! $errors->first('team_name', '<script>M.toast({html: ":message", classes: "red"})</script>') !!}
                            </div>
                            <br>
                            {!! Form::submit('Send !', ['class' => 'btn btn-info pull-right']) !!}
                            {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else
        <div class="container center-align center">
            <h3 class="center">It seems like you are smart ! But sorry ... actually you can't edit a team that is not yours. Nice try :D</h3>
            {!! link_to(route('home'), 'Home', ['class' => 'btn btn-large center']) !!}
        </div>
    @endif

@endsection

