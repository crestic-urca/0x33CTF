@extends('template')

@section('contenu')

    <!-- Header -->
    <div class="parallax-container valign-wrapper" style="height: 150px">
        <div class="parallax">
            <img src="{{ asset('images/bg_header.jpg') }}">
        </div>
        <div class="container center-align">
            <h2 style="margin: 0">Invite Player</h2>
        </div>
    </div>
    <!-- /Header -->

    @if (Auth::user()->ctf_player)
    
        @if (isset($info))
            <div class="row"> {{ $info }} </div>
        @endif

        @php
            if(Session::get('user_invited')){
                $user_invited = Session::get('user_invited');
            }
        @endphp

        @if(isset($user_invited))
            <script>M.toast({html: "You successfully invited {{$user_invited}}", classes:"green"})</script>
        @endif

        <!-- container -->
        <div class="container">

            <nav class="clean">
                <div class="nav-wrapper">
                <div class="col s12">
                    <a href="{{ route('home') }}" class="breadcrumb">Home</a>
                    <a href="{{ route('team.index') }}" class="breadcrumb">Team</a>
                    <span class="active breadcrumb">Invite Player</span>
                </div>
                </div>
            </nav>

            <div style="margin: 5% auto">
                <div class="row">
                    <div class="card blue-grey darken-3 col s12 hoverable">
                        <div class="card-content">
                            <span class="card-title center">
                                <i class="material-icons prefix" style="display: inline-block; vertical-align: middle">search</i> Search for a player
                            </span>
                            <div class="input-field">
                                <label for="user_name">Search a user</label>
                                <input id="user_name" type="text" onload="search(this.value)" oninput="search(this.value)"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div id="output">
                    
                </div>
            </div>


            <script>

                const base_url = document.head.querySelector("[name=base][content]").content

                
                const search = (name)=>{
                    fetch(base_url+"/team/__ajax_invite_player", {
                        headers: { "Content-Type": "application/json", "X-Requested-With": "XMLHttpRequest", "X-CSRF-Token": document.head.querySelector("[name=csrf-token][content]").content },
                        method: "POST",
                        body: JSON.stringify({ user_name : name })
                    })
                    .then( async (res)=>{
                        res = await res.json()
                        let output = document.querySelector("#output")
                        console.log(res)
                        if(!Array.isArray(res)){ output.innerHTML = ""; return; }
                        output.innerHTML = res.map( (user) =>{
                            return `
                            <div class="col s12 m6 xl4">
                                <div class="card blue-grey darken-2 hoverable">
                                    <div class="card-content">
                                        <span class="card-title center">${user.name}</span>
                                            ${ (user.state == 0) ?  `<b class="center-align center light-blue-text text-lighten-3">Waiting</b>` : ""}

                                            ${ (user.state == 2) ?  `
                                                <b class="center-align center red-text text-darken-3">This player have refuse your last invitation</b>
                                                <form action="${base_url}/team/invite/${user.id}" method="POST">
                                                    <div class="input-field center">
                                                        @csrf
                                                        <button type="submit" class='btn'>Invite again</button>
                                                    </div>
                                                </form>
                                                ` : ""}
                                            
                                            ${ (user.state == -1) ? `
                                                <form action="${base_url}/team/invite/${user.id}" method="POST">
                                                    <div class="input-field center">
                                                        @csrf
                                                        <button type="submit" class='btn'>Send a request</button>
                                                    </div>
                                                </form>
                                                ` : ``}

                                            ${ (user.state == 4) ? `
                                                <form action="${base_url}/team/invite/${user.id}" method="POST">
                                                    <p>This player has already been in your team, but he left.</p>
                                                    <div class="input-field center">
                                                        @csrf
                                                        <button type="submit" class='btn'>Send a request</button>
                                                    </div>
                                                </form>
                                            ` : `` }

                                            ${ (user.state == 5) ? `
                                                <form action="${base_url}/team/invite/${user.id}" method="POST">
                                                    <p>This player is in your team</p>
                                                </form>
                                            ` : `` }
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `
                        }).join('')
                        
                    })
                    .catch( err=>console.error(err) )
                }
            </script>

        
        
    </div>	<!-- /container -->

    @else
    {!! link_to(route('login'), 'Sign in', ['class' => 'btn btn-action']) !!}
    @endif

@endsection
