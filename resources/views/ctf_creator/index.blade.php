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

    @if (Auth::user()->ctf_creator)
        @if (isset($info))
            <div class="row alert alert-info"> {{ $info }} </div>
        @endif

        @php
            if (Session::get('inform') != NULL ) {
                $inform = Session::get('inform');
            }
        @endphp

        @if (isset($inform))
            <script>M.toast({html: "{{$inform}}", classes:"green darken-3"})</script>
        @endif

    <!-- container -->
	<div class="container">

        <nav class="clean">
            <div class="nav-wrapper">
                <div class="col s12">
                    <a href="{{ route('home') }}" class="breadcrumb">Home</a>
                    <span class="active breadcrumb">Your challenges</span>
                </div>
            </div>
        </nav>

        @if (!$sujets->isEmpty())

        <div class="card blue-grey darken-3 hoverable">
            <div class="card-content">
                <div class="card-title center">Your challenges</div>
            </div>
        </div>

            @foreach ($sujets as $sujet)
            <div class="row">
                <div class="card blue-grey darken-3 hoverable">
                    <div class="card-content">
                        <div class="card-title center">{{ $sujet->titre }}</div>

                        <ul class="list-group">
                            <li class="list-group-item ">{!! nl2br(e($sujet->enonce)) !!}</li>
                            <li class="list-group-item ">Flag : {{ $sujet->flag }}</li>
                            <li class="list-group-item ">Points : {{ $sujet->nb_points }}</li>
                            <li class="list-group-item "> Category : {{ $sujet->categorie->nom_categorie }}</li>
                            <li class="list-group-item "> Number of try : {{ $sujet->nb_try }}</li>
                            @if ($sujet->file_name != NULL)
                                <li class="list-group-item ">File attached :<a href="{{ Storage::url($sujet->file_name) }}" download>Download</a>
                                </li>
                            @endif
                            <li class="list-group-item ">
                                    <div class="row">
                                            <div class="col-md-3 ">
                                            {!! link_to(route('subjects.edit', $sujet->id), 'Modify this challenge', ['class' => 'btn']) !!}
                                            </div>
                                            <div class="col-md-3 ">
                                                <form action="{{ route('subjects.destroy', $sujet->id) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class ='btn btn-info'> Delete this challenge </button>
                                                </form>
                                            </div>
                                    </div>
                            </li>
                        </ul>
                    </div>
                </div>
            @endforeach

        @else
            <div style="margin: 5% auto">
                <div class="row">
                    <div class="card blue-grey darken-3 col s6 offset-s3 hoverable">
                        <div class="card-content">
                            <div class="center-align">
                                <div class=""><h4><i class="fas fa-frown"></i></h4></div>
                                <span class="card-title center">You haven't created any challenges</span>
                                {!! link_to('home', 'Back', ['class' => 'btn']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif


    </div>	<!-- /container -->

    @else
    {!! link_to('login', 'Sign in', ['class' => 'btn btn-action']) !!}
    @endif

@endsection
