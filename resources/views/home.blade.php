@extends('template')

@section('contenu')

@if (Auth::check())

    <!-- Header -->
    
    <div class="parallax-container valign-wrapper" style="height: 150px">
        <div class="parallax">
            <img src="{{ asset('images/bg_header.jpg') }}">
        </div>
        <div class="container center-align">
            <h2 style="margin: 0">What you want to do ?</h2>
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

    <div class="row">
        <div class="container"  style="margin: 3% auto">
                
        <div class="col s6 offset-s3">
            <div class="card blue-grey darken-3 hoverable" style="height: 100%; width: 100%; padding: 0">
                <div class="card-content center-align">
                    <div class="center"><i class="fas fa-info-circle fa-5x"></i></div>
                    <h6 class="center">CTF Informations</h6>
                        <?php   //vérification de la création de la config
                            if( $config != NULL){}
                            else{
                                header("Location: /admin/config");
                                exit(0);
                            }
                        ?>
                        <div><span>CTF start at : <b>{{ $config->date_start }}</b> </span></div>
                        <div><span>CTF end at : <b>{{ $config->date_end }}</b> </span></div>

                        @if (Auth::user()->admin)
                            <div><span><b>{{ $nb_creator }}</b> Creator(s)</span></div>
                            <div><span><b>{{ $nb_admin }}</b> Admin(s)</span></div>
                            <div><span><b>{{ $nb_resolve_chall }}</b> Resolved challenge(s)</span></div>
                        @endif
                        
                        <div><span><b>{{ $nb_player }}</b> Player(s) </span></div>
                        <div><span><b>{{ $nb_subject }}</b> Subject(s)</span></div>
                        <div><span><b>{{ $nb_categories }}</b> Categorie(s)</span></div>
                        <div><span><b>{{ $nb_teams }}</b> Team(s)</span></div>
                    

                </div>
            </div>
        </div>
    </div>

    </div>

    @if (Auth::user()->admin)

        <div class="container">

            <div class="row flex">

                <div class="col s12 m6 l4">
                    <div class="card blue-grey darken-3 hoverable waves-effect waves-light" onclick="window.location = '{{ route('admin.show_categorie') }} '" style="height: 100%; width: 100%; padding: 0">
                        <div class="card-content center-align">
                            <i class="fas fa-book-open fa-5x"></i>
                            <h4>Challenges & Categories</h4>
                        </div>
                    </div>
                </div>

                <div class="col s12 m6 l4">
                    <div class="card blue-grey darken-3 hoverable waves-effect waves-light" onclick="window.location = '{{ route('admin.show_creator') }} '" style="height: 100%; width: 100%; padding: 0">
                        <div class="card-content center-align">
                            <i class="fas fa-user-cog fa-5x"></i>
                            <h4>Creators</h4>
                        </div>
                    </div>
                </div>

                <div class="col s12 m6 l4">
                    <div class="card blue-grey darken-3 hoverable waves-effect waves-light" onclick="window.location = '{{ route('admin.config') }} '" style="height: 100%; width: 100%; padding: 0">
                        <div class="card-content center-align">
                            <i class="fas fa-cogs fa-5x"></i>
                            <h4>Control pannel</h4>
                        </div>
                    </div>
                </div>

                <div class="col s12 m12 l6">
                    <div class="card blue-grey darken-3 hoverable waves-effect waves-light" onclick="window.location = '{{ route('subjects.index') }} '"  style="height: 100%; width: 100%; padding: 0">
                        <div class="card-content center-align">
                            <i class="fas fa-user-edit fa-5x"></i>
                            <h4>My challenges</h4>
                        </div>
                    </div>
                </div>
    
                <div class="col s12 m12 l6">
                    <div class="card blue-grey darken-3 hoverable waves-effect waves-light" onclick="window.location = '{{ route('subjects.create') }}'"  style="height: 100%; width: 100%; padding: 0">
                        <div class="card-content center-align">
                            <i class="fas fa-plus-square fa-5x"></i>
                            <h4>Create a new challenge</h4>
                        </div>
                    </div>
                </div>

            </div> <!-- /row  -->
        </div> <!-- /container  -->

    @elseif (Auth::user()->ctf_creator)

    <div class="container" >
        <div class="row flex">
            
            <div class="col s12 m12 l6">
                <div class="card blue-grey darken-3 hoverable waves-effect waves-light" onclick="window.location = '{{ route('subjects.index') }} '"  style="height: 100%; width: 100%; padding: 0">
                    <div class="card-content center-align">
                        <i class="fa fa-cogs fa-5x"></i>
                        <h4>Manage your challenges</h4>
                    </div>
                </div>
            </div>

            <div class="col s12 m12 l6">
                <div class="card blue-grey darken-3 hoverable waves-effect waves-light" onclick="window.location = '{{ route('subjects.create') }}'"  style="height: 100%; width: 100%; padding: 0">
                    <div class="card-content center-align">
                        <i class="fas fa-plus-square fa-5x"></i>
                        <h4>Create a new challenge</h4>
                    </div>
                </div>
            </div>

        </div> <!-- /row  -->
    </div><!-- /container  -->

    @else
       
        <div class="container" >
            <div class="row flex">
                
                <div class="col s12 m6 ">
                    <div class="card blue-grey darken-3 hoverable waves-effect waves-light" onclick="window.location = '{{ route('challenges.index') }} '" style="height: 100%; width: 100%; padding: 0">
                        <div class="card-content center-align">
                            <i class="fas fa-scroll fa-5x"></i>
                            <h4>Check the challenges</h4>
                        </div>
                    </div>
                </div>

                <div class="col s12 m6">
                    <div class="card blue-grey darken-3 hoverable waves-effect waves-light" onclick="window.location = '{{ route('team.index') }}'" style="height: 100%; width: 100%; padding: 0">
                        <div class="card-content center-align">
                            <i class="fas fa-users-cog fa-5x"></i>
                            <h4>My team</h4>
                        </div>
                    </div>
                </div>

            </div> <!-- /row  -->
        </div><!-- /container  -->

    @endif

@else
  <div class="alert alert-danger" role="alert">
    <p> Vous n'êtes pas connecté.</p>
      {!! link_to(route('login'), 'Se connecter', ['class' => 'btn btn-info pull-right']) !!}
  </div>
@endif
@endsection
