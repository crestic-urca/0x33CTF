@extends('template')

@section('contenu')

    <!-- Header -->
    <div class="parallax-container valign-wrapper" style="height: 150px">
        <div class="parallax">
            <img src="{{ asset('images/bg_header.jpg') }}">
        </div>
        <div class="container center-align">
            <h2 style="margin: 0">Manage my challenges</h2>
        </div>
    </div>
    <!-- /Header -->

    @if (Auth::user()->ctf_player)
        @if (isset($info))
            <div class="row alert alert-info"> {{ $info }} </div>
        @endif

    <!-- container -->
	<div class="container">

        <nav class="clean">
            <div class="nav-wrapper">
              <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb">Home</a>
                <a href="{{ route('team.index') }}" class="breadcrumb">Team</a>
                <span class="active breadcrumb">Create a team</span>
              </div>
            </div>
        </nav>

        <div style="margin: 5% auto">
            <div class="row">
                <div class="card blue-grey darken-3 col s7 offset-s3 hoverable">
                    <div class="card-content align-warper center">
                        <span class="card-title center"><i class="material-icons prefix" style="display: inline-block; vertical-align: middle">edit</i> Create a team </span>
                        @if (Auth::user()->hasTeam() === false)
                            <p>To create a new team, please use the form below</p>
                            {!! Form::open(['route' => 'team.store']) !!}
                                @csrf
                                <div class="form-group {!! $errors->has('team_name') ? 'has-error' : '' !!}">
                                    <div class="input-field">
                                        {!!  Form::label("team_name", "Team name",  null) !!}
                                        {!! Form::text('team_name', null, ['class' => 'validate']) !!}
                                        {!! $errors->first('team_name', '<small class="help-block">:message</small>') !!}
                                    </div>
                                </div>
                                <br>
                                {!! Form::submit('Send !', ['class' => 'btn btn-info pull-right']) !!}
                            {!! Form::close() !!}
                        @else
                            <p>You have already created a team</p>
                            <br>
                            {!! link_to(route('home'), 'Home', ['class' => 'btn btn-action']) !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>	<!-- /container -->

    @else
        {!! link_to(route('login'), 'Sign in', ['class' => 'btn btn-action']) !!}
    @endif

@endsection

