@extends('template')

@section('contenu')

    <!-- Header -->
    <div class="parallax-container valign-wrapper" style="height: 150px">
        <div class="parallax">
            <img src="{{ asset('images/bg_header.jpg') }}">
        </div>
        <div class="container center-align">
            <h2 style="margin: 0">Every Teams</h2>
        </div>
    </div>
    <!-- /Header -->

    @if (isset($info))
        <div class="row alert alert-info"> {{ $info }} </div>
    @endif

        <!-- container -->
        <div class="container">

            <nav class="clean">
                <div class="nav-wrapper">
                    <div class="col s12">
                    <a href="{{ route('home') }}" class="breadcrumb">Home</a>
                    <span class="active breadcrumb">Teams</span>
                    </div>
                </div>
            </nav>

            {!! Form::open(['route' => 'teams.index', 'method' => 'GET']) !!}
                <div class="input-field {!! $errors->has('name') ? 'red' : '' !!}">
                        {!! Form::text('name', (request()->name ?? ''), [ 'id' => 'name', 'class' => 'validate' ]) !!}
                        {!! Form::label('name', "Name of the team") !!}
                        {!! $errors->first('name', '<small class="help-block">:message</small>') !!}
                </div>
                {!! Form::submit('Send !', ['class' => 'btn']) !!}
            {!! Form::close() !!}
            
            @if(isset($teams) && $teams->items())
                <div class="center">
                    {{ $teams->appends(request()->except('page'))->links() }}
                </div>
                <table class="blue-grey darken-3">
                    <thead><tr><th>Team name</th><th class="center">Members</th><th class="center">Points</th><th class="center">Rank</th></tr></thead>
                    <tbody>
                        @foreach ($teams as $team)
                        <tr>
                            <td><a href="{{route('teams.showing_one_team', $team->id )}}">{!! preg_replace('/(' . (request()->name ?? '') . ')/i', "<b>$1</b>", $team->team_name) !!}</a></td>
                            <td class="center">{{$team->members()->count()}}</td>
                            <td class="center">{{$team->points()}}</td>
                            <td class="center">{{ ($team->rank() == -1 ? 'Not ranked' : $team->rank() )}}</td>
                        </tr>
                    @endforeach
                    <tbody>
                </table>
                <div class="center">
                    {{ $teams->appends(request()->except('page'))->links() }}
                </div>
            @else
                <div class="center">No team found for "<b>{{(request()->name ?? '')}}</b>"</div>
            @endif
        </div>	<!-- /container -->

@endsection
