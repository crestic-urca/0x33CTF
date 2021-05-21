@extends('template')

@section('contenu')

    <!-- Header -->
    <div class="parallax-container valign-wrapper" style="height: 150px">
        <div class="parallax">
            <img src="{{ asset('images/bg_header.jpg') }}">
        </div>
        <div class="container center-align">
            <h2 style="margin: 0">Challenge {{$sujet->titre}} </h2>
        </div>
    </div>
    <!-- /Header -->

    @php
        if (Session::get('inform') != NULL ) {
            $inform = Session::get('inform');
        }
    @endphp

    @if (isset($inform))
        <script>M.toast({html: "{{$inform}}", classes:"green darken-3"})</script>
    @endif

    @if (isset($info))
        <div class="row alert alert-info"> {{ $info }} </div>
    @endif

        <!-- container -->
        <div class="container">

            <nav class="clean">
                <div class="nav-wrapper">
                    <div class="col s12">
                    <a href="{{ route('home') }}" class="breadcrumb">Home</a>
                    <a href="{{ route('admin.show_categorie') }}" class="breadcrumb">Categories</a>
                    <span class="active breadcrumb">Subject {{$sujet->titre}}</span>
                    </div>
                </div>
            </nav>

            <h4 class="center">{{$sujet->categorie->nom_categorie}}</h4>
  
            <div class="card blue-grey  darken-3 col s7 offset-s3 hoverable">
                <div class="card-content align-warper">
                    <span class="card-title center" >
                        <h3>{{$sujet->titre}}</h3>
                        <div>({{$sujet->nb_points}} points)</div>
                        <div> Author: <em><b>{{$sujet->author->name}}</b></em></div>
                    </span>
                    <div> Email : <a href="mailto:{{$sujet->author->email}}">{{$sujet->author->email}}</a></div>
                    <hr/>
                    <div class="card-content">{!! $sujet->enonce !!}</div>
                    <hr/>
                    @if ($sujet->file_name != null)
                        <div>File attached : <a class="btn" href="{{ url('storage/'.$sujet->file_name) }}" download>Download {{$sujet->file_name}}</a></div>
                    @else
                        <div>No file attached</div>
                    @endif
                    <hr/>
                    @if ($sujet->hide)
                        <div>State: Private</div>
                    @else
                        <div>State: Public</div>
                    @endif
                </div>
                <div class="card-action center">
                    <div class="row">
                        <div class="col s4" style="padding: 0">{!! link_to(route('subjects.edit', $sujet->id), 'Modify this challenge', ['class' => 'btn']) !!}</div>

                        @if ($sujet->hide)
                            <div class="col s4">
                                <form action="{{ route('admin.show', $sujet->id) }}" method="POST">
                                    @csrf
                                    <button class ='btn'> make public </button>
                                </form>
                            </div>
                        @else
                            <div class="col s4">
                                <form action="{{ route('admin.hide', $sujet->id) }}" method="POST">
                                    @csrf
                                    <button class ='btn'> make private </button>
                                </form>
                            </div>
                        @endif
                        
                        
                        
                        
                        <div class="col s4">
                            <form action="{{ route('subjects.destroy', $sujet->id) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class ='btn'> Delete this challenge </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- /container  -->

@endsection
