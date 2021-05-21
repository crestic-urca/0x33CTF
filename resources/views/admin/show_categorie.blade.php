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
                <span class="active breadcrumb">Categories</span>
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

        @if ($categories->isEmpty())
            <div class="row">
                <div class="card blue-grey darken-3 col s6 offset-s3 hoverable">
                    <div class="card-content center">
                        <div class="card-title">There is currently no categories</div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="card blue-grey darken-3 col s8 offset-s2 hoverable">
                <div class="card-content center">
                    <div class="card-title">Create a new category</div>
                    {!! Form::open(['route' => 'category.store']) !!}
                        <div class="input-field {!! $errors->has('nom_categorie') ? 'has-error' : '' !!}">
                                {!! Form::text('nom_categorie', null, [ 'id' => 'nom_categorie', 'class' => 'validate']) !!}
                                {!! Form::label('nom_categorie', "Name of the categorie", ['class' => 'text-color-white']) !!}
                                {!! $errors->first('nom_categorie', '<small class="help-block">:message</small>') !!}
                        </div>
                        <br>
                        {!! Form::submit('Send !', ['class' => 'btn btn-info pull-right']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
		</div>

		<div class="row center">
			<div class="col s6 offset-s3">
				<div class="col s6">
					<button class="btn" onClick="checkAll()">check all</button>
				</div>
				<div class="col s6">
					<button class="btn" onClick="unCheckAll()">uncheck all</button>
				</div>
			</div>
		</div>

        <div class="row">
            @foreach ($categories as $categorie)
				<div id="cate{{$categorie->id}}" class="card blue-grey darken-3 col s8 offset-s2 hoverable">
                    <div class="card-content">
                        <div class="card-title center">
                            {{ $categorie->nom_categorie }}
                        </div>
                        @forelse ($categorie->sujets as $sujet)
                            
							@if ($loop->first)
								<div class="row center">
										
									<div class="col s6">
										<button class="btn" onClick="checkAllInCate(document.querySelectorAll('#cate{{$categorie->id}}'))">check this categorie</button>
									</div>
									<div class="col s6">
										<button class="btn" onClick="UnCheckAllInCate(document.querySelectorAll('#cate{{$categorie->id}}'))">uncheck this categorie</button>
									</div>
									
								</div>
                                <table><thead><tr><th>Title</th><th class="center">state</th><th class="center">Action</th></tr></thead>
                            @endif

                            <tr>
                                <td><a href="{{route('sujets.showing_one_subject_admin', $sujet->id )}}">{{$sujet->titre}}</a></td>
                                <td class="center">@if ($sujet->hide) Hide @else Visible @endif</td>
                                <td class="center">
									<label>
										<input id="{{$sujet->id}}" type="checkbox" class="filled-in"><span></span>
									</label>
								</td>
								
                            </tr>

                            @if ($loop->last)
                                </table>
                            @endif
                        @empty
                                <form action="{{route("category.destroy", $categorie->id)}}" method="POST" class="center">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class='btn'> Delete this category </button>
                                </form>
                            </form>
                        @endforelse
                    </div>
                </div>
            @endforeach
            <div class="card blue-grey darken-3 col s8 offset-s2 hoverable">
                <div class="card-content center">
                    <div class="card-title center">Action :</div>
                    <button onClick="deleteCheck()" class='btn'>Delete</button>
                    <button onClick="hideCheck()" class='btn'>Make private</button>
                    <button onClick="showCheck()" class='btn'>Make public</button>
                </div>
            </div>
        </div>

        
    </div>	<!-- /container -->

    <script>
		
		const checkAll = () => {
			const checkboxs = document.querySelectorAll('input[type=checkbox]');
			checkboxs.forEach( element =>{ if(!element.checked) element.click() })
		}

		const unCheckAll = () => {
			const checkboxs = document.querySelectorAll('input[type=checkbox]');
			checkboxs.forEach( element =>{ if(element.checked) element.click() })
		}

		const checkAllInCate = (Cate) => {
			const checkboxs = Cate[0].querySelectorAll('input[type=checkbox]');
			checkboxs.forEach( element =>{ if(!element.checked) element.click() })
		}

		const UnCheckAllInCate = (Cate) => {
			const checkboxs = Cate[0].querySelectorAll('input[type=checkbox]');
			checkboxs.forEach( element =>{ if(element.checked) element.click() })
        }

        const base_url = document.head.querySelector("[name=base][content]").content

        const showCheck = () => {
            
            let checkboxs = document.querySelectorAll('input[type=checkbox]');
            checkboxs = [...checkboxs].filter(e => e.checked)
            
            if(confirm(`Vous allez public ${checkboxs.length}`) == false ){ return }
            
            
			let ids = checkboxs.map((e)=>{ return Number(e.id) })
            
            
            send(base_url+'/admin/show_multiple', ids)
            
		}

        const hideCheck = () => {
            
            let checkboxs = document.querySelectorAll('input[type=checkbox]');
            checkboxs = [...checkboxs].filter(e => e.checked)
            
            if(confirm(`Vous allez cacher ${checkboxs.length}`) == false ){ return }
			
			let ids = checkboxs.map((e)=>{ return Number(e.id) })

            send(base_url+'/admin/hide_multiple', ids)
            
		}
        
        const deleteCheck = () => {
            
            let checkboxs = document.querySelectorAll('input[type=checkbox]');
            checkboxs = [...checkboxs].filter(e => e.checked)
            
            if(confirm(`Vous allez supprimer ${checkboxs.length}`) == false ){ return }
			
			let ids = checkboxs.map((e)=>{ return Number(e.id) })

            send(base_url+'/admin/delete_multiple', ids)
            
        }
        

        const send = (url, ids) => {
            fetch(url, {
                headers: { "Content-Type": "application/json", "X-Requested-With": "XMLHttpRequest", "X-CSRF-Token": document.head.querySelector("[name=csrf-token][content]").content },
                method: "POST",
                contentType: "json",
                processData: false,
                body : JSON.stringify(ids)
            })
            .then(res => console.log(res))
            .catch(err => console.error(err))
            .finally(()=>{
                document.location.reload(true);
            })
        }
        
    </script>

    @else
        {!! link_to(route('login'), 'Sign in', ['class' => 'btn btn-action']) !!}
    @endif

@endsection
