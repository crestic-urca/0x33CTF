@extends('template')

@section('contenu')

<header id="head" class="secondary"></header>

    <!-- Header -->
    <div class="parallax-container valign-wrapper" style="height: 150px">
        <div class="parallax">
            <img src="{{ asset('images/bg_header.jpg') }}">
        </div>
        <div class="container center-align">
            <h2 style="margin: 0">Reset your password</h2>
        </div>
    </div>
    <!-- /Header -->

<div class="container">

                <!-- Article main content -->
                <article class="col-xs-12 maincontent">
                        <header class="page-header"></header>

                        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h3 class="thin text-center">Get back my password</h3>
                                    <hr>

                                    @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                    @endif

                                    <form  method="POST" action="{{ route('password.email') }}">
                                            @csrf
                                        <div class="top-margin">
                                            <label>Email Address<span class="text-danger">*</span></label>
                                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                            @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                            @endif

                                        </div>

                                        <hr>

                                        <div class="row">
                                                <button type="submit" class="btn btn-primary">
                                                        {{ __('Send Password Reset Link') }}
                                                </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>

                    </article>
                    <!-- /Article -->

</div>
@endsection
