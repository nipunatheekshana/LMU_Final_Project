@extends('layouts.auth1')
@section('head')
<script>
    var user = "{{Auth::user()}}";
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="{{ url('assets/js/custom/login.js') }}"></script>

@endsection
@section('content')

    <h5>{{__('Sign in')}}</h5>

    <!-- form -->
    <form id="loginForm">
        {{csrf_field()}}

        <div class="form-group">
            <input type="text" class="form-control" name="email"  placeholder="email" required autofocus>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
        </div>
        <div class="form-group d-flex justify-content-between">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" checked="" id="customCheck1">
                {{-- <label class="custom-control-label" for="customCheck1">Remember me</label> --}}
            </div>
            <a href="#">{{__('Reset password')}}</a>
        </div>
        <button class="btn btn-primary btn-block" id="btnLogIn">Sign in</button>
        {{-- <hr>
        <p class="text-muted">Login with your social media account.</p>
        <ul class="list-inline">
            <li class="list-inline-item">
                <a href="#" class="btn btn-floating btn-facebook">
                    <i class="fa fa-facebook"></i>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="#" class="btn btn-floating btn-twitter">
                    <i class="fa fa-twitter"></i>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="#" class="btn btn-floating btn-dribbble">
                    <i class="fa fa-dribbble"></i>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="#" class="btn btn-floating btn-linkedin">
                    <i class="fa fa-linkedin"></i>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="#" class="btn btn-floating btn-google">
                    <i class="fa fa-google"></i>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="#" class="btn btn-floating btn-behance">
                    <i class="fa fa-behance"></i>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="#" class="btn btn-floating btn-instagram">
                    <i class="fa fa-instagram"></i>
                </a>
            </li>
        </ul>
        <hr>
        <p class="text-muted">{{__("Don't have an account?")}}</p>
        <a href="#" class="btn btn-outline-light btn-sm">{{__('Register now!')}}</a> --}}
    </form>
    <!-- ./ form -->

@endsection
