@extends('template')

@section('contenu')

    <!-- Header -->
    <div class="parallax-container valign-wrapper" style="height: 150px">
        <div class="parallax">
            <img src="{{ asset('images/bg_header.jpg') }}">
        </div>
        <div class="container center-align">
            <h2 style="margin: 0">Help</h2>
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
                <span class="active breadcrumb">Help</span>
                </div>
            </div>
        </nav>
    </div>
       
        <div id="chart" class="blue-grey darken-3" style=""></div>
        <li class="row" style="list-style:none; cursor: default">
            <div class="collapsible-header blue-grey darken-3 col s8 offset-s2" style="flex-direction: column;border-bottom-color: transparent; cursor: default">
                <div class="card-content" style="border-bottom-color: transparent; padding-top: 0.5em; padding-bottom: 0.5em; cursor: default">
                    Hello and welcome to 0x33-CTF!  <br>
                    This tool will allow you to organize your own CTFs easily. <br>
                    In this page you will find how to use the tool according to your rank.
                </div>
            </div>
        </li>

        <li class="row" style="list-style:none">
            <div class="collapsible-header center waves-effect waves-light blue-grey darken-4 col s8 offset-s2 hoverable" style="flex-direction: column;">
                <h2 style="margin:0 auto">
                    Project
                </h2>
            </div>

            <div class="collapsible-body card blue-grey darken-3 col s8 offset-s2" style="flex-direction: column; margin-top:0; border-bottom-color: transparent;">
                <div class="card-content">
                    You can find the project on <b><a class="text-color-white" href="https://github.com/crestic-urca/0x33CTF">github - 0x33CTF</a></b>. 
                    <br>
                </div>
            </div>
        </li>

        <li class="row" style="list-style:none">
            <div class="collapsible-header center waves-effect waves-light blue-grey darken-4 col s8 offset-s2 hoverable" style="flex-direction: column;">
                <h2 style="margin:0 auto">
                    Configuration
                </h2>
            </div>

            <div class="collapsible-body card blue-grey darken-3 col s8 offset-s2" style="flex-direction: column; margin-top:0; border-bottom-color: transparent;">
                <div class="card-content">
                    <p id="help-p">
                        For the configuration of the tool, and thus of your CTF, you will need to create an administrator account, to do this, 
                        you just have to create the first account, this first account has the administrator rights.
                        When you connect, you arrive on the configuration page: <br>

                        <div id="help-div-img"> 
                            <img id="help-img-60" src="{{ asset('images/help_page/config_page.jpg') }}" alt="configuration image">
                        </div>

                        After filling in each field, you need to save your settings, if you have put in the right settings, 
                        you will get this pop-up at the top of the page.<br>

                        <div id="help-div-img"> 
                            <img id="help-img-100" src="{{ asset('images/help_page/config_finish.png') }}" alt="configuration finished image">
                        </div>

                        To see the result of your configuration and the description of your CTF, click on the tool's logo on the top left.<br>
                        
                        <div id="help-div-img"> 
                            <img id="help-img-60" src="{{ asset('images/help_page/home_site_button.png') }}" alt="home button image">
                        </div>
                    </p>
                </div>
            </div>
        </li>

        <li class="row" style="list-style:none">
            <div class="collapsible-header center waves-effect waves-light blue-grey darken-4 col s8 offset-s2 hoverable" style="flex-direction: column;">
                <h2 style="margin:0 auto">
                    ADMIN
                </h2>
            </div>

            <div class="collapsible-body card blue-grey darken-3 col s8 offset-s2" style="flex-direction: column; margin-top:0; border-bottom-color: transparent;">
                <div class="card-content">
                    Once connected, you will land on your control interface, here is an overview: 
                    
                    <div id="help-div-img"> 
                        <img id="help-img-60" src="{{ asset('images/help_page/home_admin_page_1.png') }}" alt="home admin stats image">
                    </div>
                    
                    In this first part, you have a summary of the configuration of your CTF, as well as its components (players, 
                    administrator, creators, number of challenges, etc.).
                    
                    <div id="help-div-img"> 
                        <img id="help-img-60" src="{{ asset('images/help_page/home_admin_page_2.png') }}" alt="home admin control panel image">
                    </div>
                    
                    And here is your control interface, where you can perform different tasks, like controlling which challenges will be presented
                    or creating and managing your own challenges.
                    As an administrator, you have the power to control which challenges will be presented and which won't
                    To do this you go to your home page and go to "Challenges and categories", if no challenge has been entered yet, you can
                    If no challenge has been entered yet, you will get this: <br>
                    
                    <div id="help-div-img"> 
                        <img id="help-img-60" src="{{ asset('images/help_page/categorie_admin_page_clean.png') }}" alt="categorie admin clean image">
                    
                    </div>
                    
                    On the other hand, if challenges and categories have been entered, you will have a presentation like this : 
                    
                        <div id="help-div-img"> 
                        <img id="help-img-60" src="{{ asset('images/help_page/categorie_admin_page_not-clean.png') }}" alt="categorie admin image">
                    </div>
                    
                    On this page you can decide to show or hide challenges for your CTF, you also have the the possibility 
                    to delete challenges. To learn more about a challenge, just click on its name. Let's go to the second button 
                    of your interface. This button will take you to the creators page, the creators are the accounts you will allow 
                    to add to your accounts that you will allow to add challenges. To change a player into a creator, his account 
                    must be filled in, but you To change a player into a creator, his account must be filled in, but on your side, 
                    you have to search for his nickname on this page, via the search bar.

                    <div id="help-div-img"> 
                        <img id="help-img-60" src="{{ asset('images/help_page/addCreator_admin_page.png') }}" alt="add Creator page image">
                    </div>
                    
                    Once the right nickname is found, you will have a button to pass this person creator.<br>
                    The 3rd button is the one to modify the configuration of your CTF, for example change its description, its start and end dates, etc. 
                    start and end dates, etc. It is exactly the same form as when you created it, except that this time
                    the form is filled in and you can change whatever you want. Don't forget to save.
                    The 4th button is for managing your challenges.

                    <div id="help-div-img"> 
                        <img id="help-img-60" src="{{ asset('images/help_page/controlPanel_challenges_page.png') }}" alt="clean control panel of challenges image">
                    </div>
                    
                    This is where you will manage your challenges. If you haven't created a challenge yet, this page will look like this, but if you have 
                    will look like this, but if you have already created challenges, then you will have this: 
                    
                    <div id="help-div-img"> 
                        <img id="help-img-60" src="{{ asset('images/help_page/controlPanel_challenges_page_not-clean.png') }}" alt="control panel of challenges image">
                    </div>
                    
                    To create challenges, go to the 5th and last button of your interface.
                    From there you will have access to this form, allowing you to give various information about your
                    challenge, with a name, a description, but also a number of points, and a number of tries.
                    If your challenge is a docker backup, then you will have to put the line of code to launch the image.
                    As well as the image (.tar) in the file repository.
                    
                    <div id="help-div-img"> 
                        <img id="help-img-60" src="{{ asset('images/help_page/create_challenges_page.png') }}" alt="create challenge page image">
                    </div>
                    
                    And of course, save your challenge! 
                </div>
            </div>
        </li>

        <li class="row" style="list-style:none">
            <div class="collapsible-header center waves-effect waves-light blue-grey darken-4 col s8 offset-s2 hoverable" style="flex-direction: column;">
                <h2 style="margin:0 auto">
                    CREATOR
                </h2>
            </div>

            <div class="collapsible-body card blue-grey darken-3 col s8 offset-s2" style="flex-direction: column; margin-top:0; border-bottom-color: transparent;">
                <div class="card-content">
                    An account is decided creator, if the administrator decides so. It's an ordinary player who is given the right to create and manage
                    to create and manage these challenges, for the CTF. Here is his control interface.
                    
                    <div id="help-div-img"> 
                        <img id="help-img-60" src="{{ asset('images/help_page/home_creator.png') }}" alt="home creator image">
                    </div>
                    
                    Like the administrator, he can create and manage these challenges.
                    
                    <div id="help-div-img"> 
                        <img id="help-img-60" src="{{ asset('images/help_page/controlPanel_challenges_page.png') }}" alt="clean control panel challenges image">
                    </div>
                    
                    This is where you will manage your challenges. If you haven't created a challenge yet, this page will look like this, but if you have 
                    will look like this, but if you have already created challenges, then you will have this: 
                    
                    <div id="help-div-img"> 
                        <img id="help-img-60" src="{{ asset('images/help_page/controlPanel_challenges_page_not-clean.png') }}" alt="control panel of challenges image">
                    </div>
                    
                    To create challenges, go to the 2nd and last button of your interface.
                    From there you will have access to this form, allowing you to give various information about your
                    challenge, with a name, a description, but also a number of points, and a number of tries.
                    If your challenge is a docker backup, then you will have to put the line of code to launch the image.
                    As well as the image (.tar) in the file repository.
                    
                    <div id="help-div-img"> 
                        <img id="help-img-60" src="{{ asset('images/help_page/create_challenges_page.png') }}" alt="create challenge page image">
                    </div>
                    
                    And of course, save your challenge! 
                </div>
            </div>
        </li>

        <li class="row" style="list-style:none">
            <div class="collapsible-header center waves-effect waves-light blue-grey darken-4 col s8 offset-s2 hoverable" style="flex-direction: column;">
                <h2 style="margin:0 auto">
                    PLAYER
                </h2>
            </div>

            <div class="collapsible-body card blue-grey darken-3 col s8 offset-s2" style="flex-direction: column; margin-top:0; border-bottom-color: transparent;">
                <div class="card-content">
                    The player is the account that participates in the organized CTF, his interface is complete, but it allows him to manage several things, 
                    here it is: 
                    
                    <div id="help-div-img"> 
                        <img id="help-img-60" src="{{ asset('images/help_page/team_control_panel_player.png') }}" alt="team clean control player panel image">
                    </div>
                    
                    And here it is if the account is part of a team: 
                    
                    <div id="help-div-img"> 
                        <img id="help-img-60" src="{{ asset('images/help_page/team_control_panel_player_in-team.png') }}" alt="team control player panel image">
                    </div>
                    
                    As a player, you have the possibility to create your team, by giving it a name, or to join one
                    by searching for its name. If you are the leader of your team, you have the possibility to invite players, and 
                    to accept or refuse them.
                </div>
            </div>
        </li>

<script type="text/javascript">
    var coll = document.getElementsByClassName("collapsible-header");
    var i;

    for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.display === "block") {
        content.style.display = "none";
        } else {
        content.style.display = "block";
        }
    });
    }
</script>


@endsection
