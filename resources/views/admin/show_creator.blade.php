@extends('template')

@section('contenu')

    <!-- Header -->
    <div class="parallax-container valign-wrapper" style="height: 150px">
        <div class="parallax">
            <img src="{{ asset('images/bg_header.jpg') }}">
        </div>
        <div class="container center-align">
            <h2 style="margin: 0">Manage the Website</h2>
        </div>
    </div>
    <!-- /Header -->

    @if (Auth::user()->admin)
        @if (isset($info))
            <div class="row alert alert-info"> {{ $info }} </div>
        @endif

    <!-- container -->
	<div class="container">

            <nav class="clean">
                <div class="nav-wrapper">
                <div class="col s12">
                    <a href="{{ route('home') }}" class="breadcrumb">Home</a>
                    <span class="active breadcrumb">Users List</span>
                </div>
                </div>
            </nav>

            @php
                if (Session::get('inform') != NULL ) {
                    $inform = Session::get('inform');
                }
            @endphp

            @if (isset($inform))
                <script>M.toast({html: "{{$inform}}", classes:"green darken-3"})</script>
            @endif

            <div style="margin: 5% auto">
                <div class="row">
                    <div class="card blue-grey darken-3 col s12 hoverable">
                        <div class="card-content">
                            <span class="card-title center">
                                <i class="material-icons prefix" style="display: inline-block; vertical-align: middle">search</i> Search for a user
                            </span>
                            <div class="input-field">
                                <label for="user_name">Search a user</label>
                                <input id="user_name" class="text-color-white" type="text" onload="search(this.value)" oninput="search(this.value)"/>
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
                    fetch(base_url+"/admin/__ajax_player_list", {
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
                                <div class="card blue-grey darken-3 hoverable">
                                    <div class="card-content center">
                                        <span class="card-title center">${user.name}</span>

                                        <div class="">Email: ${user.email}</div>

                                           
                                        ${user.ctf_creator ? `
                                            <form action="${base_url}/admin/downgrade/${user.id}" method="POST">
                                                <input type="hidden" name="_token" value="${document.head.querySelector("[name=csrf-token][content]").content}"/>
                                                <button type="submit" class='btn'> Downgrade this user </button>
                                            </form>
                                            ` : `
                                            <form action="${base_url}/admin/upgrade/${user.id}" method="POST">
                                                <input type="hidden" name="_token" value="${document.head.querySelector("[name=csrf-token][content]").content}"/>
                                                <button type="submit" class='btn'> Upgrade this user </button>
                                            </form>
                                            `}
                                            
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
