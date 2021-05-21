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
                    <a href="{{ route('teams.index') }}" class="breadcrumb">Teams</a>
                    <span class="active breadcrumb">Team {{$team->team_name}}</span>
                    </div>
                </div>
            </nav>

            <div class="row">
                <div class="col s6 offset-s3">
                    <div class="card blue-grey darken-3 hoverable">
                        <div class="card-content center-align">
                            <i class="fas fa-users fa-5x"></i>

                            @switch($team->rank())
                                @case(1)
                                    <h3>{{ $team->team_name }} <i class="material-icons yellow-text" style="font-size: 1em; vertical-align: -5px;">emoji_events</i> </h3>
                                @break
                                
                                @case(2)
                                    <h3>{{ $team->team_name }} <i class="material-icons grey-text" style="font-size: 1em; vertical-align: -5px;">emoji_events</i> </h3>
                                @break
                                
                                @case(3)
                                    <h3>{{ $team->team_name }} <i class="material-icons brown-text" style="font-size: 1em; vertical-align: -5px;">emoji_events</i> </h3>
                                @break

                                @case(-1)
                                    <h3>{{ $team->team_name }} </h3>
                                @break
                                    
                            @endswitch

                            <p>Points : {{ $team->points() }}</p>
                            <p>Rank : {{ $team->rank() == -1 ? 'Not ranked' : $team->rank() }}</p>

                        </div>
                    </div>
                </div>
            </div> <!-- /row  -->

            <ul class="collapsible blue-grey darken-3">
                <li class="active">
                    <div class="collapsible-header blue-grey darken-3">
                        <h4>Member{{$team->number_members() > 1 ? 's' : ''}}</h4>
                    </div>
                    <div class="collapsible-body blue-grey darken-3">
                        <ul>
                        <span class="col s2">{{ $team->leader()->first()->name }} (leader)</span>
                        @foreach ($team->members()->get() as $member)
                        <a class="row collection-item waves-effect blue-grey darken-3 white-text" href="{{route('teams.showing_one_team', $team->id )}}" >
                            <!-- si image de team https://materializecss.com/collections.html-->
                            <span class="col s2">{{ $member->name }}</span>
                        </a>
                        @endforeach
                        </ul>
                    </div>
                </li>
                <li class="active">
                    <div class="collapsible-header blue-grey darken-3">
                        <h4>Challenge validated</h4>
                    </div>
                    <div class="collapsible-body blue-grey darken-3">
                        <table class="centered">
                            <thead><tr><th>Subject title</th><th>Category</th><th>Points</th><th>Date validated</th></tr></thead>
                            <tbody>
                            @foreach($team->challs_validated as $chall)
                                <tr class="" >
                                    @if (Auth::user() && Auth::user()->admin)
                                        <td><a href="{{route('sujets.showing_one_subject_admin', $chall->sujet->id )}}">{{ $chall->sujet->titre }}<a/></td>
                                    @else
                                        <td><a href="{{route('sujets.showing_one_subject', $chall->sujet->id )}}">{{ $chall->sujet->titre }}<a/></td>
                                    @endif
                                    <td>{{ $chall->sujet->categorie->nom_categorie }}</td>
                                    <td>{{ $chall->sujet->nb_points}}</td>
                                    <td>{{$chall->date_validated}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </li>
            </ul>

            <ul class="collection with-header">
                <li class="collection-header blue-grey darken-3"><h4>Statistics</h4></li>
                <li class="blue-grey darken-3 row" style="margin: 0; padding: 10px">
                    <canvas style="padding: 10px" id="radar"></canvas>
                    <canvas style="padding: 10px" id="line"></canvas>

                </li>
            </ul>
            

        </div><!-- /container  -->

        <script>
            M.Collapsible.init(document.querySelectorAll('.collapsible')[0], {accordion: false});

            new Chart(document.getElementById('line').getContext('2d'),
            {
                "type":"line",
                "data":{
                    "labels"  : @json($tab_label_line),
                    "datasets":[
                        {
                            "label": "Evolution of points",
                            "data": @json($tab_points_line),
                            "fill": false,
                            "borderColor":"rgb(75, 192, 192)",
                            "lineTension": 0.1
                        }
                    ]
                },
                "options":{
                    scales: {
                        xAxes: [{
                            display: true,
                            ticks: {
                                padding: 10,
                                stepSize : 5,
                                precision: 0
                            },
                            gridLines: {
                                color: '#fff',
                            }
                            
                        }],
                        yAxes: [{
                            display: true,
                            gridLines: {
                                color: '#fff',
                            }
                            
                        }],
                            
                    }
                }
            });
            

            new Chart(document.getElementById('radar').getContext('2d'),
                    {
                        "type":"radar",
                        "data": {
                            "labels": @json($tab_categories),
                            "datasets":[
                                            { 
                                                "label" : '{{ $team->team_name }}',
                                                "data": @json($tab_data),
                                                "strokeColor" : '#fff',
                                                "backgroundColor" : 'rgba(0, 154, 169, 0.2)',
                                                "borderColor":"#009aa9",
                                                "pointBackgroundColor":"#009aa9",
                                                "pointBorderColor":"#fff",
                                                "pointHoverBackgroundColor":"#fff",
                                                "borderJoinStyle": "round",
                                            }
                                        ]   
                        },
                        "options":{
                            legend: {
                                labels: {
                                    fontColor: "white",
                                    fontSize: 18
                                }
                            },
                            "elements":{ "line":{"tension":0,"borderWidth":3}},
                            scale: {
                                gridLines:{
                                    color : '#fff'
                                },
                                pointLabels: {
                                    fontSize: 15,
                                    fontColor: '#fff'
                                },
                                angleLines: {
                                    display: true,
                                },
                                ticks: {
                                    display: false,
                                    suggestedMin: 0,
                                    suggestedMax: 100,
                                    stepSize: 10,
                                }
                            }                                    
                        }
                    });
        </script>
@endsection
