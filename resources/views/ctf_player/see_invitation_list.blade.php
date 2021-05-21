@extends('template')

@section('contenu')

    <!-- Header -->
    <div class="parallax-container valign-wrapper" style="height: 150px">
        <div class="parallax">
            <img src="{{ asset('images/bg_header.jpg') }}">
        </div>
        <div class="container center-align">
            <h2 style="margin: 0">Invitations List</h2>
        </div>
    </div>
    <!-- /Header -->

    @if (Auth::user()->ctf_player)
        @if (isset($info))
            <div class="row alert alert-info"> {{ $info }} </div>
        @endif

        @php
            if(Session::get('invitePlayer')){
                $invitePlayer = Session::get('invitePlayer');
            }
        @endphp

        <!-- container -->
        <div class="container">

            <nav class="clean">
                <div class="nav-wrapper">
                    <div class="col s12">
                        <a href="{{ route('home') }}" class="breadcrumb">Home</a>
                        <a href="{{ route('team.index') }}" class="breadcrumb">Team</a>
                        <span class="active breadcrumb">Invite list</span>
                    </div>
                </div>
            </nav>


            @forelse ($invitePlayer as $invite)
                <div class="row" style="margin:1px">
                    <div class="blue-grey darken-3 hoverable" style="display: flex; justify-content:space-between; align-items:center; padding:10px; height:56px">
                        <b>{{ $invite["team"]["team_name"] }}</b>
                        <span >{{ $invite["date_invitation"] }}</span>
                            @switch($invite["state"])
                                @case(0) <span class="blue-text">Waiting</span> @break
                                @case(1) <span class="green-text">Accepted</span> @break
                                @case(2) <span class="red-text">Refuse</span> @break
                                @case(3) <span class="grey-text">Suspended</span> @break
                                @default 
                            @endswitch
                        @if ($invite["state"] == 0)
                            <div class="btn-group" role="group">
                                <form action="{{ route('team.invite_accept', $invite['team']['id'] ) }}" method="POST" style="display: inline"> @csrf <button class='btn green darken-4'>Accept</button></form>
                                <form action="{{ route('team.invite_refuse', $invite['team']['id'] ) }}" method="POST" style="display: inline"> @csrf <button class='btn red darken-4'>Decline</button></form>
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
                                    <span class="card-title center">There is no request to join a team</span>
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
