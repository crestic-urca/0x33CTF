@extends('template')

@section('contenu')

    <!-- Header -->
    <div class="parallax-container valign-wrapper" style="height: 150px">
        <div class="parallax">
            <img src="{{ asset('images/bg_header.jpg') }}">
        </div>
        <div class="container center-align">
            <h2 style="margin: 0">Scoreboard</h2>
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
                <span class="active breadcrumb">Scoreboard</span>
                </div>
            </div>
        </nav>
    </div>
       
        <div id="chart" class="blue-grey darken-3" style=""></div>

        <script>
            var i,j;
            let data = [];
            let listTeam = [];
            let listDataID = [];
            const json = @json($teams)

            for(i in json.teams){
                json.teams[i].points.unshift(json.teams[i].name);
                data.push(json.teams[i].points);
                
                listTeam.push(json.teams[i].name);
                listDataID.push(i);

                json.teams[i].date.unshift(i);
                data.push(json.teams[i].date);
            }

            var chart = c3.generate({
                bindto: '#chart',
                size : {
                    height : 600,
                },
                data: {
                    xs: (function() {
                        var xs = {};
                        for(i in listTeam){ xs[listTeam[i]] = listDataID[i]; }
                        return xs;
                    }()),
                    xFormat: '%Y-%m-%d %H:%M:%S',
                    columns: data
                },
                axis : {
                    x : {
                        type : 'timeseries',
                        tick: {
                            count: 12,
                            format: '%Y-%m-%d %H:%M:%S'
                        }
                    },

                    y : {
                        label: {
                            text: "Points",
                            position: 'outer-middle'
                        }
                    }
                }
            });
        </script>


@endsection
