@extends('template')
@section('contenu')
<!--
    bug : 
        * lorsque la description est vide, produit un bug mais que la config est remplie
-->


	<!-- Header -->
    <div class="parallax-container" style="height: 350px">
        <div class="parallax"> <img src="{{ asset('images/bg_header.jpg') }}"></div>
            <div class="container center-align">
                <br/>
                <h1>Welcome in {{$config->name ?? ''}} CTF !</h1>
                <p>We are using 0x33CTF, it is the best and easiest way for creating challenge in controlled area ! </p>
                <p><a class="btn btn-large waves-effect waves-light transparent" role="button" href="https://0x33ctf.com"><b>0x33</b></a> <b>{!! link_to('/home', 'HOME', ['class' => 'btn btn-large waves-effect waves-light ','role' => 'button']) !!}</b></p>
            </div>
        </div>
    </div>
    <!-- /Header -->
    <div class="container">
        {!! $config->description ?? '' !!}
    </div>

@endsection