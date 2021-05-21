@extends('template')

@section('contenu')

    <!-- Header -->
    <div class="parallax-container valign-wrapper" style="height: 150px">
        <div class="parallax">
            <img src="{{ asset('images/bg_header.jpg') }}">
        </div>
        <div class="container center-align">
            <h2 style="margin: 0">Congratulations !</h2>
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
                <span class="active breadcrumb">Wrong</span>
              </div>
            </div>
        </nav>

            <br>
            <h2 class="text-center top-space">It was the wrong flag !  </h2>
            <br><br>
            <div class="h-body text-center">
                    <img src="{{ asset('images/sad.webp') }}">
            </div>
            <br><br><br>
            <div class="container text-center">
                    {!! link_to(route('home'), 'Back home', ['class' => 'btn btn-action']) !!}

            </div>
        <br><br><br><br>
    </div>	<!-- /container -->

    @else
    {!! link_to(route('login'), 'Sign in', ['class' => 'btn btn-action']) !!}
    @endif

@endsection
