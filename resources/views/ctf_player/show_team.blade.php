@extends('template')

<?php
    $user = auth()->user();
    $team = $user->team();
?>

@section('contenu')

    <!-- Header -->
    <div class="parallax-container valign-wrapper" style="height: 150px">
        <div class="parallax">
            <img src="{{ asset('images/bg_header.jpg') }}">
        </div>
        <div class="container center-align">
            <h2 style="margin: 0">Manage your team</h2>
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

    @if ($user->ctf_player)
        @if (isset($info))
            <div class="row alert alert-info"> {{ $info }} </div>
        @endif


    <!-- container -->
	<div class="container">

        <nav class="clean">
            <div class="nav-wrapper">
              <div class="col s12">
                <a href="{{ url('/home') }}" class="breadcrumb">Home</a>
                <span class="active breadcrumb">Team</span>
              </div>
            </div>
        </nav>

        @if ($user->hasTeam() === false)
            <div class="container" >
                <div class="row flex">
                    
                    <div class="col s12">
                        <div class="card blue-grey darken-3 hoverable" style="height: 100%; width: 100%; padding: 0">
                            <div class="card-content center-align">
                                <i class="fas fa-users fa-5x"></i>
                                <h6>Your actual team</h6>
                                <h3> You are not in a team </h3>
                            </div>
                        </div>
                    </div>

                </div> <!-- /row  -->
            </div><!-- /container  -->
        @else

            <div class="container" >
                <div class="row flex">
                    <div class="col s12">
                        <div class="card blue-grey darken-3 hoverable" style="height: 100%; width: 100%; padding: 0">
                            <div class="card-content center-align">
                                <i class="fas fa-users fa-5x"></i>
                                <h6>Your actual team ({{ $user->team()->number_members() }} / {{ ($nb_max_player ?? '') != -1 ? $nb_max_player ?? '' : "∞" }})</h6>
                                <h3> {{ $team->team_name }} </h3>
                                <p> {{  $user->team()->leader->name }} (Leader) </p>
                                @foreach ($team->members()->get() as $member)
                                    <p> {{ $member->name }} </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div> <!-- /row  -->
            </div><!-- /container  -->

        @endif


        <!-- row -->
        <div class="row flex">
             <!-- create team -->
            <div class="col s12 m6 l4">
                <div class="card blue-grey darken-3 hoverable" style="height: 100%; width: 100%; padding: 0">
                    <div class="card-content center-align">
                        <i class="fas fa-plus-square fa-4x"></i>
                        <h5>Create a new team</h5>
                        <br>
                        @if ($user->hasTeam() === false)
                            {!! link_to(route('team.create'), 'Create a team', ['class' => 'btn']) !!}
                        @elseif ($user->isLeader())
                            <button type="button" class="btn" disabled="disabled">Create a team</button>
                            <br/><br/>
                            <i>You already are in a team</i>
                        @else
                            <button type="button" class="btn " disabled="disabled">Create a team</button>
                            <br/><br/>
                            <i>You already are in a team</i>
                        @endif
                    </div>
                </div>
            </div>

            <!-- edit team -->
            <div class="col s12 m6 l4">
                <div class="card blue-grey darken-3 hoverable" style="height: 100%; width: 100%; padding: 0">
                    <div class="card-content center-align">
                        <i class="fas fa-edit fa-4x"></i>
                        <h5>Change your team name</h5>
                        <br>
                        @if ($user->hasTeam() === false)
                            <button type="button" class="btn " disabled="disabled">Edit your team</button>
                            <br/><br/>
                            <i>You haven't created a team</i>
                        @elseif ($user->isLeader())
                            {!! link_to(route('team.edit', $team), 'Edit your team', ['class' => 'btn ']) !!}
                        @else
                            <button type="button" class="btn " disabled="disabled">Edit your team</button>
                            <br/><br/>
                            <i>You haven't created a team</i>
                        @endif
                    </div>
                </div>
            </div>


            <!-- delete team -->
            <div class="col s12 m6 l4">
                <div class="card blue-grey darken-3 hoverable" style="height: 100%; width: 100%; padding: 0">
                    <div class="card-content center-align">
                        <i class="fas fa-trash-alt fa-4x"></i>
                        <h5>Delete your team</h5>
                        <br>
                        @if ($user->hasTeam() === false)
                            <button type="button" class="btn " disabled="disabled">You haven't created a team</button>
                        @elseif ($user->isLeader())
                            <form action="{{ route('team.destroy', $team) }}" method="POST" onclick="return confirm('Are you sure to delete your team ?')"> 
                                @method('DELETE')
                                @csrf 
                                <button class='btn'>Delete your team</button>
                            </form>
                        @else
                            <button type="button" class="btn" disabled="disabled">Delete your team</button>
                            <br/><br/>
                            <i>You can't delete your team</i>
                        @endif
                    </div>
                </div>
            </div>

            <!-- leave team -->
            <div class="col s12 m6 l4">
                <div class="card blue-grey darken-3 hoverable" style="height: 100%; width: 100%; padding: 0">
                    <div class="card-content center-align">
                        <i class="fas fa-minus-square fa-4x"></i>
                        <h5>Leave your team</h5>
                        <br>
                        @if ($user->hasTeam() === false)
                            <button type="button" class="btn " disabled="disabled">Leave</button>
                            <br/><br/>
                            <i>You are not in a team</i>
                        @elseif ($user->isLeader())
                            <button type="button" class="btn " disabled="disabled">Leave</button>
                            <br/><br/>
                            <i>You can't leave the team you created</i>
                        @else
                            {!! link_to(route('team.leave'), 'Leave', ['class' => 'btn ', 'onclick'=>"return confirm('Are you sure to leave your team ?')"]) !!}
                        @endif
                    </div>
                </div>
            </div>

            <!-- join team -->
            <div class="col s12 m6 l4">
                <div class="card blue-grey darken-3 hoverable" style="height: 100%; width: 100%; padding: 0">
                    <div class="card-content center-align">
                        <i class="fas fa-sitemap fa-4x"></i>
                        <h5>Join a team</h5>
                        <br>
                        @if ($user->hasTeam() === false)
                            {!! link_to(route('team.choose_team'), 'Join', ['class' => 'btn ']) !!}
                        @elseif ($user->isLeader())
                            <button type="button" class="btn" disabled="disabled">Join</button>
                            <br/><br/>
                            <i>You can't join a team if you already have one</i>
                        @else
                            <button type="button" class="btn" disabled="disabled">Join</button>
                            <br/><br/>
                            <i>Leave your team</i>
                        @endif
                    </div>
                </div>
            </div>

            <!-- member request list -->
            <div class="col s12 m6 l4">
                <div class="card blue-grey darken-3 hoverable" style="height: 100%; width: 100%; padding: 0">
                    <div class="card-content center-align">
                        <i class="fas fa-list fa-4x"></i>
                        <h5>Check if someone wants to join</h5>
                        <br>
                        @if ($user->hasTeam() === false)
                            <button type="button" class="btn" disabled="disabled">Check</button>
                            <br/><br/>
                            <i>You haven't created a team</i>
                        @elseif ($user->isLeader())
                            @if ($nb_demand > 0)
                                {!! link_to('team/requests', 'Check ('.$nb_demand.')', ['class' => 'btn pulse red waves-effect waves-light']) !!}
                            @else
                                {!! link_to('team/requests', 'Check (0)', ['class' => 'btn']) !!}
                            @endif
                        @else
                            <button type="button" class="btn" disabled="disabled">Check</button>
                            <br/><br/>
                            <i>You can't accept members for your team</i>
                        @endif
                    </div>
                </div>
            </div>

            <!-- player list -->
            <div class="col s12 m6 l4">
                <div class="card blue-grey darken-3 hoverable" style="height: 100%; width: 100%; padding: 0">
                    <div class="card-content center-align">
                        <i class="fas fa-user-plus fa-4x"></i>
                        <h5>Invite a player to your team</h5>
                        <br>
                        @if ($user->hasTeam() === false)
                            <button type="button" class="btn " disabled="disabled">Invite</button>
                            <br/><br/>
                            <i>You can't accept members for your team</i>
                        @elseif ($user->isLeader())
                            {!! link_to('team/invite', 'Invite', ['class' => 'btn ']) !!}
                        @else
                            <button type="button" class="btn " disabled="disabled">Invite</button>
                            <br/><br/>
                            <i>You can't accept members for your team</i>
                        @endif
                    </div>
                </div>
            </div>

            <!-- invitation list -->
            <div class="col s12 m6 l4">
                <div class="card blue-grey darken-3 hoverable" style="height: 100%; width: 100%; padding: 0">
                    <div class="card-content center-align">
                        <i class="fas fa-list-alt fa-4x"></i>
                        <h5>Check invitation from other team</h5>
                        <br>
                        @if ($nb_invitation > 0)
                            {!! link_to('team/invitations', 'Check ('.$nb_invitation.')', ['class' => 'btn pulse red waves-effect waves-light']) !!}
                        @else
                            {!! link_to('team/invitations', 'Check (0)', ['class' => 'btn']) !!}
                        @endif
                    </div>
                </div>
            </div>

        </div><!-- /row -->

    </div>	<!-- /container -->

    @else
    {!! link_to('login', 'Sign in', ['class' => 'btn ']) !!}
    @endif

@endsection
