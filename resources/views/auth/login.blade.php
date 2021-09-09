@extends('layouts.template')
@section('content')
<div class="container">
    <div class="auth-form shadow mt-5 p-4">
        <div class="form-title">
            <h2>Login</h2>
        </div>
        @include('layouts.messages')
        <form action="{{ url('login') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" 
                    class="form-control @error('email') is-invalid @enderror" name="email"
                    id="email" placeholder="johndoe@gmail.com">
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" 
                    id="password" placeholder="Johndoe@&123"
                    class="form-control @error('password') is-invalid @enderror">
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group d-grid mt-4">
                <button class="btn btn-primary">Sign-In</button>
            </div>
            <div class="form-group opposite-action text-end mt-2">
                <span class="text-muted">Dont have an account?</span>
                <a href="{{ route('register.show') }}" class="btn btn-sm text-right btn-link">Create</a>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<style>
    body {
        background: url('/images/bg1.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    .auth-form {
        background: black;
        opacity: .8;
        border-radius: 10px;
    }
    .auth-form label {
        color: white;
    }
</style>
@endsection