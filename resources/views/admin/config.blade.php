@extends('template')

@section('contenu')
<!--
    bug : 
        * insertion du nombre de personne par team accéssible qu'en allant sur la case avec TAB, mais modification du chiffre disponible avec les flèches de la case
            correction : il suffit de cliquer sur la barre de la case
-->

    <!-- Header -->
    <div class="parallax-container valign-wrapper" style="height: 150px">
        <div class="parallax">
            <img src="{{ asset('images/bg_header.jpg') }}">
        </div>
        <div class="container center-align">
            <h2 style="margin: 0">CTF Configuration</h2>
        </div>
    </div>
    <!-- /Header -->

    @if (Auth::user()->admin)

        @if (isset($info))
            <div class="row alert red"> {{ $info }} </div>
        @endif

        @php
            if (Session::get('inform') != NULL ) {
                $inform = Session::get('inform');
            }
        @endphp

        @if (isset($inform))
            <script>M.toast({html: "{{$inform}}", classes:"green darken-3"})</script>
        @endif

        @php
            if(!isset($config))
                $config = null;
        @endphp


    <!-- container -->
	<div class="container">
         
        <nav class="clean">
            <div class="nav-wrapper">
              <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb">Home</a>
                <span class="active breadcrumb">Config</span>
              </div>
            </div>
        </nav>

        <div class="row">
            <div class="card blue-grey darken-3 col s8 offset-s2 hoverable">
                <div class="card-content">
                    <div class="card-title">
                        Configure the CTF
                    </div>

                    {!! Form::open(['route' => 'admin.configuration','files' => 'true']) !!}
                        @csrf
                        <div class="input-field">
                            <input value="{{$config->name ?? ''}}" name="name" id="name" type="text" class="text-color-white validate">
                            <label for="name">CTF name</label>
                            {!! $errors->first('name', '<small class="red-text">:message</small>') !!}
                        </div>
                        <div class="input-field">
                            
                            <textarea class="text-color-white" name="description" id="description" style="barder: 1px solid white; padding: 5px; resize: vertical">{{$config->description ?? ''}}</textarea>
                            <label for="description">CTF description (optional)(Mardown supported)</label>
                            {!! $errors->first('description', '<small class="red-text">:message</small>') !!}
                        </div>
                        <div class="input-field row">
                            <div class="col s6">
                                <input value="{{explode( ' ', $config->date_start ?? '' )[0] ?? ''}}" id="date_start" name="date_start" type="text" class="text-color-white datepicker">
                                <label for="date_start">Starting date</label>
                                {!! $errors->first('date_start', '<small class="red-text">:message</small>') !!}
                            </div>
                            <div class="col s6">
                                <input value="{{explode( ' ', $config->date_start ?? '' )[1] ?? ''}}" id="date_start_time" name="date_start_time" type="text" class="text-color-white timepicker">
                                <label for="date_start_time">Starting date time</label>
                                {!! $errors->first('date_start_time', '<small class="red-text">:message</small>') !!}

                            </div>
                        </div>

                        <div class="input-field row">
                            <div class="col s6">
                                <input value="{{explode( ' ', $config->date_end ?? '' )[0] ?? ''}}" id="date_end" name="date_end" type="text" class="text-color-white datepicker">
                                <label for="date_end">Ending date</label>
                                {!! $errors->first('date_end', '<small class="red-text">:message</small>') !!}

                            </div>
                            <div class="col s6">
                                <input value="{{explode( ' ', $config->date_end ?? '' )[1] ?? ''}}" id="date_end_time" name="date_end_time" type="text" class="text-color-white timepicker">
                                <label for="date_end_time">Ending date time</label>
                                {!! $errors->first('date_end_time', '<small class="red-text">:message</small>') !!}

                            </div>
                        </div>

                        <div class="input-field">
                            <p>
                                @if( $config->email_verification ?? '' || ( ($config->email_verification ?? '') == 0 ) )
                                    <label>
                                        <input checked name="email_verification" type="checkbox" />
                                        <span class="tooltipped" data-position="right" data-tooltip="Click if you want that users verified their emails after registration">Verified email after registration</span>
                                        {!! $errors->first('email_verification', '<small class="red-text">:message</small>') !!}
                                    </label>
                                @else
                                    <label>
                                        <input name="email_verification" type="checkbox" />
                                        <span class="text-color-white tooltipped" data-position="right" data-tooltip="Click if you want that users verified their emails after registration">Verified email after registration</span>
                                        {!! $errors->first('email_verification', '<small class="red-text">:message</small>') !!}
                                    </label>
                                   
                                @endif
                            </p>
                        </div>
                        
                        <div class="input-field">
                            <p>
                                @if( $config->max_players_per_team ?? '' || ( ($config->max_players_per_team ?? '') == -1 ) )
                                    <label>
                                        <input onclick="toggle_limitation(this.checked);"  name="use_limitation_players_per_team" type="checkbox" />
                                        <span>Use limitation for number of players per team</span>
                                        {!! $errors->first('use_limitation_players_per_team', '<small class="red-text">:message</small>') !!}
                                    </label>
                                    <div class="input-field">
                                        <i class="material-icons prefix">group</i>
                                        <input value="{{$config->max_players_per_team ?? ''}}" disabled name="max_players_per_team" id="max_players_per_team" type="number" class="validate">
                                        <label for="icon_prefix">Players per team</label>
                                        {!! $errors->first('max_players_per_team', '<small class="red-text">:message</small>') !!}
                                    </div>
                                @else
                                    <label>
                                        <input onclick="toggle_limitation(this.checked);" checked  name="use_limitation_players_per_team" type="checkbox" />
                                        <span>Use limitation for number of players per team</span>
                                        {!! $errors->first('use_limitation_players_per_team', '<small class="red-text">:message</small>') !!}
                                    </label>
                                    <div class="input-field">
                                        <i class="material-icons prefix">group</i>
                                        <input value="{{$config->max_players_per_team ?? ''}}"  name="max_players_per_team" id="max_players_per_team" type="number" class="text-color-white validate">
                                        <label for="icon_prefix">Players per team</label>
                                        {!! $errors->first('max_players_per_team', '<small class="red-text">:message</small>') !!}
                                    </div>
                                @endif
                               
                            </p>
                        </div>

                        

                        <div class="input-field">
                            <button class="btn" type="submit">{{$button}}</button>
                        </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>

    </div>
    <script>
        M.Datepicker.init(document.querySelectorAll('.datepicker'), {
            
        });
        M.Timepicker.init(document.querySelectorAll('.timepicker'), {});

        const input = document.getElementById("max_players_per_team");
        const toggle_limitation = (value) => {
            !value ? input.setAttribute("disabled", "") :input.removeAttribute("disabled")
        }


       
        M.Tooltip.init(document.querySelectorAll('.tooltipped'), {});
    
        
    </script>
    
    @else
        {!! link_to('login', 'Sign in', ['class' => 'btn btn-action']) !!}
    @endif



@endsection
