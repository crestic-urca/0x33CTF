@extends('template')

@section('contenu')

<div class="container"  style="margin: 5% auto">
    <div class="row">
        <div class="card col s6 offset-s3 hoverable">
            <div class="card-content">
                <div class="center-align">
                    <div class=""><h4><i class="fas fa-user-check fa-5"></i></h4></div>
                    <span class="card-title center">Verify Your Email Address</span>
                    <hr>
                    @if (session('resent'))
                        <script> M.toast({html:'A fresh verification link has been sent to your email address.', displayLength: 7000, classes: 'red darken-3'}) </script>
                    @endif
                    <p>Before proceeding, please check your email for a verification link.</p>
                    <br/>
                    <p>If you did not receive the email :</p>
                    @if (session('resent'))
                        {!! link_to(route('verification.resend'), 'Send another request', ['class' => 'btn disabled']) !!}
                    @else
                         {!! link_to(route('verification.resend'), 'Send another request', ['class' => 'btn waves-effect waves-red']) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection