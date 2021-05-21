@extends('template')

@section('contenu')

    <!-- Header -->
    <div class="parallax-container valign-wrapper" style="height: 150px">
        <div class="parallax">
            <img src="{{ asset('images/bg_header.jpg') }}">
        </div>
        <div class="container center-align">
            <h2 style="margin: 0">Challenges</h2>
        </div>
    </div>
    <!-- /Header -->

    @if (Auth::user()->ctf_player)
        @if (isset($info))
            <div class="row alert red"> {{ $info }} </div>
        @endif

        @if (!Auth::user()->hasTeam())
            <script> 
                const has_team = false
                M.toast({html: "You need to be in a team to validate a challenge", displayLength : 10000, classes  : "red"})
            </script>
        @else
            <script>     
                const has_team = true 
            </script>
        @endif

        @php
            if (Session::get('inform') != NULL ) {
                $inform = Session::get('inform');
                $success = Session::get('success');
            }
        @endphp

        @if (isset($inform))
            @if($success == true)
                <script>
                    M.toast({html: "{{$inform}}", classes: "green darken-3"})
                </script>
            @else
                <script>
                    M.toast({html: "{{$inform}}", classes: "red darken-3"})
                </script>
            @endif
        @endif

    <!-- container -->
	<div class="container">
         
        <nav class="clean">
            <div class="nav-wrapper">
              <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb">Home</a>
                <span class="active breadcrumb">Challenges</span>
              </div>
            </div>
        </nav>

            @if (!$sujets->isEmpty())
            
                <div class="row">
                    <div class="card blue-grey darken-3 col s6 offset-s3 hoverable"><div class="card-content center"><div class="card-title">You can choose below which category you want</div><button id="drop_cate" class='dropdown-trigger dropdown-button btn' data-target ='categories'>Choose a category</button></div></div>
                </div>
                <ul id='categories' class='dropdown-content'>
                    @foreach ($categories as $id => $category_name)
                        <li><a onclick="getCate({{$id}}, '{{$category_name}}')">{{$category_name}}</a></li>
                    @endforeach
                </ul>

                <div id="output_cate" class="row">
                </div>

                <ul id="output" class="row collapsible popout" style="border: 0; box-shadow: none; margin-bottom: 100px;">
                </ul>

            @else

                <div style="margin: 5% auto">
                    <div class="row">
                        <div class="card blue-grey darken-3 col s6 offset-s3 hoverable">
                            <div class="card-content">
                                <div class="center-align">
                                    <div class=""><h4><i class="fas fa-frown fa-5"></i></h4></div>
                                    <span class="card-title center">There is currently no challenges</span>
                                    {!! link_to('home', 'Back', ['class' => 'btn']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endif

    </div>	<!-- /container -->
    
    <script>

        const base_url = document.head.querySelector("[name=base][content]").content

        const getCate = (id, name) =>{

            fetch(base_url+"/categorie/__ajax_sujets", {
                headers: { "Content-Type": "application/json", "X-Requested-With": "XMLHttpRequest", "X-CSRF-Token": document.head.querySelector("[name=csrf-token][content]").content },
                method: "POST",
                body: JSON.stringify({ categorie_id : id })
            })
            .then( async (res)=>{
                res = await res.json()
                let output = document.querySelector("#output")
                if(!Array.isArray(res) || res.length == 0){ output.innerHTML = `<div class="card blue-grey darken-3 col s12 hoverable"><div class="card-content">There is currently no challenges in <b>${name}</b></div></div>`; return; }                
                document.querySelector("#output_cate").innerHTML = `<div class="card blue-grey darken-3 col s8 offset-s2 hoverable"><div class="card-content center"><div class="card-title"><h4 style="margin:0 auto">${name}</h4></div></div></div>`
                output.innerHTML = res.map( (sujet, i) =>{
                    return ` 
                        <li class="row" style="border: 1px solid white">
                            <div class="collapsible-header center waves-effect waves-light ${ (has_team == true && sujet.display_form == false) ? ` ${sujet.max_try_reach == true? `red` : `green darken-4`}` : `blue-grey darken-3` }" style="flex-direction: column;"><h2 style="margin:0 auto">${sujet.titre}</h2>${ sujet.nb_points && `<span class="">(${sujet.nb_points} points)</span>`}${ (sujet.nb_try || sujet.team_try) && `<span class="">${sujet.team_try ? sujet.team_try : 0 }/${sujet.nb_try} tries</span>`}</div>
                            <div class="collapsible-body card ${ (has_team == true && sujet.display_form == false) ? ` ${sujet.max_try_reach == true? `red` : `green darken-4`}` : `blue-grey darken-3` } col s12" style="margin: 0">
                                <div class="card-content">
                                    <div class="">
                                        
                                        ${ (sujet.hide) ? `<div class="card-content">Not avaible now.</div>`
                                        :`
                                            
                                            ${sujet.enonce && `<div class="card-content">${sujet.enonce}</div>`}

                                            ${ sujet.file_name ? `<div>File attached : <a class="btn" href="${base_url}/storage/${sujet.file_name}" download>Download ${sujet.file_name}</a></div>` : `<div class="center">No file attached</div>`}
                                        
                                            ${ has_team == false ? `
                                                <div class="row input-field inline">
                                                    <form action="${base_url}/player/${sujet.id}"  method="POST" >
                                                        <div class="row">
                                                            <div class="input-field col s6">
                                                                <input type="hidden" name="_token" value="${document.head.querySelector("[name=csrf-token][content]").content}">
                                                                <input class="inline" id="flag_${sujet.id}" type="text" name="flag" />
                                                                <label for="flag_${sujet.id}">Test the flag</label>
                                                            </div>
                                                            <div class="input-field col s6">
                                                                <button disabled onclick="return confirm('Are you sure to try this flag ?')" class="inline btn" type="submit">You need a team</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                ` : ` ${ sujet.display_form == true ? `
                                                    <div class="row input-field inline">
                                                        <form action="${base_url}/player/${sujet.id}"  method="POST" >
                                                            <div class="row">
                                                                <div class="input-field col s6">
                                                                    <input type="hidden" name="_token" value="${document.head.querySelector("[name=csrf-token][content]").content}">
                                                                    <input class="inline" id="flag_${sujet.id}" type="text" name="flag" />
                                                                    <label for="flag_${sujet.id}">Test the flag</label>
                                                                </div>
                                                                <div class="input-field col s6">
                                                                    <button  onclick="return confirm('Are you sure to try this flag ?')" class="inline btn" type="submit">Test</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>

                                            ` : ` ${sujet.max_try_reach == true? `You have reach the maximum attempt for this challenge` : `Your team already validate the challenge`}` } `  }
                                            <div class="row" style="margin: 0 25%; min-width: 300px">
                                                <a class="col s12 btn btn-large" href="${base_url}/subject/${sujet.id}">Show this subject only</a>
                                            </div>
                                            
                                        `}
                                        
                                    </div>
                                </div>
                            </div>
                        </li>
                    `                           
                }).join('')

                res.forEach( (sujet, i)=>{
                    console.log(i)
                    if( !(has_team == true && sujet.display_form == false) )
                        collapsible_instance[0].el.children[i].children[0].click()
                })

                

                
                
            })
            .catch( err=>console.error(err) )

           
            //collapsible_instance[0].el.children[i].children[0].click()
            
        }

        M.Dropdown.init(document.querySelectorAll('#drop_cate'), {coverTrigger: false});
        let collapsible_instance = M.Collapsible.init(document.querySelectorAll('.collapsible'), {accordion: false});
    </script>

    @else
        {!! link_to('login', 'Sign in', ['class' => 'btn btn-action']) !!}
    @endif

@endsection
