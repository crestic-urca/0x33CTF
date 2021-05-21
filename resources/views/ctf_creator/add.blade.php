@extends('template')

@section('contenu')

    <!-- Header -->
    <div class="parallax-container valign-wrapper" style="height: 150px">
        <div class="parallax">
            <img src="{{ asset('images/bg_header.jpg') }}">
        </div>
        <div class="container center-align">
            <h2 style="margin: 0">Manage my challenges</h2>
        </div>
    </div>
    <!-- /Header -->

    @if (Auth::user()->ctf_creator)
        @if (isset($info))
            <div class="row alert alert-info"> {{ $info }} </div>
        @endif

    <!-- container -->
	<div class="container">

        <nav class="clean">
            <div class="nav-wrapper">
              <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb">Home</a>
                <span class="active breadcrumb">Create a challenge</span>
              </div>
            </div>
        </nav>

        <div class="card blue-grey darken-3 hoverable">
            <div class="card-content">
                <div class="card-title center"><h1>Create a new challenge</h1></div>       
                    
                    {!! Form::open(['route' => 'subjects.store','files' => 'true']) !!}
                        @csrf
                        <div class="text-color-white input-field {!! $errors->has('titre') ? 'has-error' : '' !!}">
                                <i class="material-icons prefix">create</i>
                                {!! Form::text('titre', null, ['id'=>'titre','class' => 'validate']) !!}
                                {!! Form::label('titre', "Title") !!}
                                {!! $errors->first('titre', '<small class="help-block">:message</small>') !!}
                        </div>
                        <div class="text-color-white input-field {!! $errors->has('enonce') ? 'has-error' : '' !!}">
                                <i class="material-icons prefix">format_align_left</i>
                                {!! Form::textarea('enonce', null, ['id' => 'enonce','class' => '', 'data-length' => '60000', 'style' => 'border: 1px solid white; resize: vertical']) !!}
                                {!! Form::label('enonce', "Subject") !!}
                                {!! $errors->first('enonce', '<small class="help-block">:message</small>') !!}
                        </div>
                        <div class="text-color-white input-field {!! $errors->has('flag') ? 'has-error' : '' !!}">
                                <i class="material-icons prefix">flag</i>
                                {!! Form::text('flag', null, ['id' => 'flag','class' => 'validate']) !!}
                                {!! Form::label('flag', "Flag") !!}
                                {!! $errors->first('flag', '<small class="help-block">:message</small>') !!}
                        </div>
                        <div class="text-color-white input-field {!! $errors->has('nb_try') ? 'has-error' : '' !!}">
                            <i class="material-icons prefix">lock</i>
                            {!! Form::number('nb_try', null, ['id' => 'nb_try','class' => 'validate']) !!}
                            {!! Form::label('nb_try', "Number of try") !!}
                            {!! $errors->first('nb_try', '<small class="help-block">:message</small>') !!}
                        </div>
                        <div class="text-color-white input-field {!! $errors->has('categorie_id') ? 'has-error' : '' !!}">
                                <i class="material-icons prefix">reorder</i>
                                {!! Form::select('categorie_id', $categories, null, ['id'=>'categorie_id','class' => '']) !!}
                                {!! $errors->first('categorie_id', '<small class="help-block">:message</small>') !!}
                        </div>
                        <div class="text-color-white input-field {!! $errors->has('nb_points') ? 'has-error' : '' !!}">
                            <i class="material-icons prefix">emoji_events</i>
                            {!! Form::number('nb_points', null, ['id' => 'nb_points','class' => 'validate']) !!}
                            {!! Form::label('nb_points', "Number of points") !!}
                            {!! $errors->first('nb_points', '<small class="help-block">:message</small>') !!}
                        </div>

                        <div class="text-color-white file-field input-field {!! $errors->has('file_attachment') ? 'has-error' : '' !!}">
                            <div class="btn">
                                <span>File (optional)</span>
                                <input name="file_attachment" type="file">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                            {!! $errors->first('file_attachment', '<small class="help-block">:message</small>') !!}
                        </div>

                        <br><br>
                        {!! Form::submit('Send !', ['class' => 'btn btn-info pull-right']) !!}
                    {!! Form::close() !!}
            </div>
        </div>
    </div>	<!-- /container -->

    @else
    {!! link_to(route('login'), 'Sign in', ['class' => 'btn btn-action']) !!}
    @endif

    <script>
        M.FormSelect.init(document.querySelectorAll('select'), {});
        M.CharacterCounter.init(document.getElementById("enonce"));
    </script>

@endsection

