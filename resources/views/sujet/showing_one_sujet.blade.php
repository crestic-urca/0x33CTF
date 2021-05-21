@extends('template')

@section('contenu')

    <!-- Header -->
    <div class="parallax-container valign-wrapper" style="height: 150px">
        <div class="parallax">
            <img src="{{ asset('images/bg_header.jpg') }}">
        </div>
        <div class="container center-align">
            <h2 style="margin: 0">Challenge {{$sujet->titre}} </h2>
        </div>
    </div>
    <!-- /Header -->

    @if (isset($info))
        <div class="row alert alert-info"> {{ $info }} </div>
    @endif

        <!-- container -->
        <div class="container">

            @if (Auth::user()->admin)
                <nav class="clean">
                    <div class="nav-wrapper">
                        <div class="col s12">
                        <a href="{{ route('home') }}" class="breadcrumb">Home</a>
                        <a href="{{ route('admin.show_categorie') }}" class="breadcrumb">Categories</a>
                        <span class="active breadcrumb">Chall {{$sujet->titre}}</span>
                        </div>
                    </div>
                </nav>
            @else
                <nav class="clean">
                    <div class="nav-wrapper">
                        <div class="col s12">
                        <a href="{{ route('home') }}" class="breadcrumb">Home</a>
                        <a href="{{ route('challenges.index') }}" class="breadcrumb">Subjects</a>
                        <span class="active breadcrumb">Subject {{$sujet->titre}}</span>
                        </div>
                    </div>
                </nav>
            @endif


            <h4 class="center">{{$sujet->categorie->nom_categorie}}</h4>

            @if(Auth::user()->hasTeam() && Auth::user()->team()->validated($sujet->id) )
                <div class="card green darken-3 col s7 offset-s3 hoverable">
            @elseif(Auth::user()->hasTeam() && Auth::user()->team()->max($sujet->id))
                <div class="card red  darken-3 col s7 offset-s3 hoverable">
            @else        
                <div class="card blue-grey  darken-3 col s7 offset-s3 hoverable">
            @endif
                <div class="card-content align-warper">
                <span class="card-title center" >
                    <h2>{{$sujet->titre}}</h2>
                    <div>({{$sujet->nb_points}} points)</div>
                    @if(Auth::user()->hasTeam() && !Auth::user()->team()->validated($sujet->id) )
                    <div>({{ Auth::user()->team()->try($sujet->id) }} / {{$sujet->nb_try}} try)</div>
                    @endif
                </span>
                        @if ($sujet->hide)
                            <div class="card-content">Not avaible now.</div>
                        @else
                            <div class="card-content">{!! $sujet->enonce !!}</div>
                            @if ($sujet->file_name != null)
                                <div>File attached : <a class="btn" href="{{ url('storage/'.$sujet->file_name) }}" download>Download {{$sujet->file_name}}</a></div>
                                    <!--place du bouton de DL de l'image Docker-->
                                <!--<div> docker : <a class="btn" href="{{ url('storage/'.$sujet->file_name) }}" download>Download {{$sujet->file_name}}</a> </div>-->
                            @else
                                <div>No file attached</div>
                            @endif

                            @if (Auth::user()->hasTeam())
                                @php
                                    $team = Auth::user()->team();
                                @endphp

                                @if ($team->validated($sujet->id))
                                    <div>Your team already validate the challenge</div>
                                @else
                                    @if ($team->max($sujet->id))
                                        <div>You have reach the maximum attempt for this challenge</div>
                                    @else
                                        <form action="{{route('player.validate_ctf', $sujet->id)}}" class="input-field inline" method="POST">
                                            @csrf
                                            <input class="inline" id="flag" type="text" name="flag" />
                                            <label for="flag">Test the flag</label>
                                            <button class="btn" onclick='return confirm(`Are you sure to test ${document.getElementById("flag").value} ?`)' type="submit">Test</button>
                                        </form>
                        
                                    @endif
                                @endif

                            @else
                                <div>You need a team to validate the flag</div>
                            @endif
                        @endif
                </div>
            </div>
        </div><!-- /container  -->

@endsection
