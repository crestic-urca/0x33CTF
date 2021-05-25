<!--
    TODO list : 
        * ajouter un effet au déploiment de la page help
        * remplir la page help
-->

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
        <!--
        <div class="container">
            <p> Page en cours de construction... </p>
        </div>
        -->
        <!--
        <button type="button" class="collapsible-header center">Open Collapsible</button>
        <div class="collapsible-body" style="margin: 5% auto">
            <div class="row">
                <div class="card blue-grey darken-3 col s6 offset-s3 hoverable">
                    <div class="card-content">
                        <div class="center-align">
                            <p>Lorem ipsum...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        -->
        <!--
        <div class="row">
            <div class="card blue-grey darken-3 col s6 offset-s3 hoverable">
                <div class="card-content center">
                    <div class="card-title">
                        You can choose below which category you want
                    </div>
                    <button id="drop_cate" class='dropdown-trigger dropdown-button btn' data-target ='categories'>
                        Choose a category
                    </button>
                </div>
            </div>
        </div>
        -->
        <li class="row" style="list-style:none">
            <div class="collapsible-header center waves-effect waves-light blue-grey darken-4 col s8 offset-s2 hoverable" style="flex-direction: column;">
                <h2 style="margin:0 auto">
                    titre
                </h2>
                <!--
                <span class="">
                    nb points
                </span>
                <span class="">
                    nombre d'essais
                </span>
                -->
            </div>
            <div class="collapsible-body card blue-grey darken-3 col s8 offset-s2" style="flex-direction: column; margin-top:0; border-bottom-color: transparent;">
                <div class="card-content">
                    contenu
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
