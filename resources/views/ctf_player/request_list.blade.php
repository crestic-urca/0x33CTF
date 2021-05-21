@extends('template')

@section('contenu')

    <!-- Header -->
    <div class="parallax-container valign-wrapper" style="height: 150px">
        <div class="parallax">
            <img src="{{ asset('images/bg_header.jpg') }}">
        </div>
        <div class="container center-align">
            <h2 style="margin: 0">Request</h2>
        </div>
    </div>
    <!-- /Header -->

    @if (Auth::user()->ctf_player)
    
        @if (isset($info))
            <div class="row alert alert-info"> {{ $info }} </div>
        @endif

        @php
            if (Session::get('team') != NULL && Session::get('joindemand') != NULL ) {
                $joindemand = Session::get('joindemand');
            }
        @endphp

        <!-- container -->
        <div class="container">

            <nav class="clean">
                <div class="nav-wrapper">
                    <div class="col s12">
                        <a href="{{ route('home') }}" class="breadcrumb">Home</a>
                        <a href="{{ route('team.index') }}" class="breadcrumb">Team</a>
                        <span class="active breadcrumb">Request</span>
                    </div>
                </div>
            </nav>

            @forelse ($joindemand as $demand)
                    
                <div class="row" style="margin:1px">
                    <div class="blue-grey darken-3 hoverable" style="display: flex; justify-content:space-between; align-items:center; padding:10px; height:56px">
                        <b>{{ $demand["user"]["name"] }}</b>
                        <em>{{ $demand["user"]["email"] }}</em>
                        <span >{{ $demand["date_join_demand"] }}</span>
                            @switch($demand["state"])
                                @case(0) <b class="blue-text">Waiting</b> @break
                                @case(1) <b class="green-text">Accepted</b> @break
                                @case(2) <b class="red-text">Refused</b> @break
                                @case(3) <b class="grey-text">Suspended</b> @break
                                @case(4) <b class="green-text">Accepted (Has leaved the team)</b> @break
                                @case(5) <b class="green-text">The player already accepted to join your team</b> @break
                                @default 
                            @endswitch
                        @if ($demand["state"] == 0)
                            <div class="btn-group" role="group">
                                <form action="{{ route('team.team_accept', $demand['user']['id'] ) }}" method="POST" style="display: inline"> @csrf <button class='btn green darken-4'>Accept</button></form>
                                <form action="{{ route('team.team_refuse', $demand['user']['id'] ) }}" method="POST" style="display: inline"> @csrf <button class='btn red darken-4'>Decline</button></form>
                            </div>
                        @else
                            <div style="width: 180px">
                            
                            </div>
                        @endif
                    </div>
                </div>

            @empty

                <div style="margin: 5% auto">
                    <div class="row">
                        <div class="card blue-grey darken-3 col s6 offset-s3 hoverable">
                            <div class="card-content">
                                <div class="center-align">
                                    <div class=""><h4><i class="fas fa-frown fa-5"></i></h4></div>
                                    <span class="card-title center">There is no request for your team</span>
                                    {!! link_to('team', 'Back', ['class' => 'btn']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            @endforelse

        </div>	<!-- /container -->

    @else
        {!! link_to(route('login'), 'Sign in', ['class' => 'btn btn-action']) !!}
    @endif

@endsection
