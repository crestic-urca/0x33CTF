@extends('template')

@section('contenu')

    <!-- Header -->
    <div class="parallax-container valign-wrapper" style="height: 150px">
        <div class="parallax">
            <img src="{{ asset('images/bg_header.jpg') }}">
        </div>
        <div class="container center-align">
            <h2 style="margin: 0">Help</h2>
        </div>
    </div>
    <!-- /Header -->

    @if (isset($info))
        <div class="row alert alert-info"> {{ $info }} </div>
    @endif

    <!-- container -->
	<div class="container" style="height: 100%">
        <nav class="clean">
            <div class="nav-wrapper">
                <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb">Home</a>
                <span class="active breadcrumb">Help</span>
                </div>
            </div>
        </nav>
    </div>
       
        <div id="chart" class="blue-grey darken-3" style=""></div>
        <div class="container">
            <p> Page en cours de construction... </p>
        </div>


@endsection
