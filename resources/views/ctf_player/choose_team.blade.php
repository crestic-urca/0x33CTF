@extends('template')

@section('contenu')

    <!-- Header -->
    <div class="parallax-container valign-wrapper" style="height: 150px">
        <div class="parallax">
            <img src="{{ asset('images/bg_header.jpg') }}">
        </div>
        <div class="container center-align">
            <h2 style="margin: 0">Choose a team</h2>
        </div>
    </div>
    <!-- /Header -->

    @if (Auth::user()->ctf_player && Auth::user()->hasTeam() === false)
        @if (isset($info))
            <div class="row alert alert-info"> {{ $info }} </div>
        @endif

    <!-- container -->
	<div class="container">

        <nav class="clean">
            <div class="nav-wrapper">
              <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb">Home</a>
                <a href="{{ route('team.index') }}" class="breadcrumb">Team</a>
                <span class="active breadcrumb">Choose a team</span>
              </div>
            </div>
        </nav>
        
        @php
            $team = Session::get('team');
        @endphp

        @if($team)
            <div class="row">
                <div class="card col s12 hoverable">
                    <div class="card-content">
                        <div class="center-align">
                            <div class=""><h4><i class="fas fa-user-check fa-5"></i></h4></div>
                            <span class="card-title center">Your request to the team {{$team->team_name}} is sent !</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div style="margin: 5% auto">
            <div class="row">
                <div class="card blue-grey darken-3 col s12 hoverable">
                    <div class="card-content">
                        <span class="card-title center">
                            <i class="material-icons prefix" style="display: inline-block; vertical-align: middle">search</i> Search for a team
                        </span>
                        <div class="input-field">
                            <label for="team_name">Search a team name</label>
                            <input id="team_name" type="text" oninput="search(this.value)"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="output">
                
            </div>
        </div>



    </div>	<!-- /container -->

    <script>
        const base_url = document.head.querySelector("[name=base][content]").content

        const search = (name)=>{
            fetch(base_url+"/team/__ajax_team", {
                headers: { "Content-Type": "application/json", "X-Requested-With": "XMLHttpRequest", "X-CSRF-Token": document.head.querySelector("[name=csrf-token][content]").content },
                method: "POST",
                body: JSON.stringify({ team_name : name })
            })
            .then( async (res)=>{
                res = await res.json()
                let output = document.querySelector("#output")

                if(!Array.isArray(res)){ output.innerHTML = ""; return; }
                output.innerHTML = res.map( (team) =>{
                    return `
                    <div class="col s12 m6 xl4">
                        <div class="card blue-grey darken-2  hoverable">
                            <div class="card-content">
                                <span class="card-title center">${team.team_name}</span>
                                    <form action="${base_url}/team/join/${team.id}" method="POST">
                                        <div class="input-field center">
                                            @csrf
                                            <button type="submit" class='btn'>Send a request</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    `
                }).join('')
                
            })
            .catch( async (err)=>{ M.toast( {html: await err.json(), classes: "red"} )})
        }
    </script>

    @else
        <div class="container">

            <nav class="clean">
                <div class="nav-wrapper">
                  <div class="col s12">
                    <a href="{{ route('home') }}" class="breadcrumb">Home</a>
                    <a href="{{ route('team.index') }}" class="breadcrumb">Team</a>
                    <span class="active breadcrumb">Choose a team</span>
                  </div>
                </div>
            </nav>

            <div class="center-align">
                <h4 class="">Leave your team before trying to join one</h4>
                {!! link_to(route('team.index'), 'Back', ['class' => 'btn']) !!}
            </div>

        </div>
    @endif

@endsection
