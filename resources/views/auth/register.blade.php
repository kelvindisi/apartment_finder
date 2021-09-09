@extends('layouts.template')

@section('content')
<div class="container">
    <div class="auth-form shadow mt-5 p-4">
        <div class="form-title">
            <h2>Create Account</h2>
        </div>
        @include('layouts.messages')
        <form action="{{ url('register') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text"
                    class="form-control @error('name') is-invalid @enderror" 
                    name="name" placeholder="John Doe" id="name"
                    value="@if(old('name')){{old('name')}}@endif">
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    placeholder="johndoe@gmail.com"
                    value="@if(old('email')){{old('email')}}@endif">
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" name="phone" id="phone" 
                    class="form-control @error('phone') is-invalid @enderror"
                    placeholder="0712345678"
                    value="@if(old('phone')){{old('phone')}}@endif">
                @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    placeholder="P4ass@*^23">
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Password Confirmation:</label>
                <input type="password" name="password_confirmation" 
                    id="password_confirmation" 
                    class="form-control @error('password_confirmation') is-invalid @enderror" 
                    placeholder="P4ass@*^23">
                @error('password_confirmation')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group mt-2 d-grid">
                <button class="btn btn-lg btn-block btn-primary">Sign-In</button>
            </div>
            <div class="form-group opposite-action text-end mt-2">
                <span class="text-muted">Already have an account?</span>
                <a href="{{ route('login.show') }}" class="btn btn-sm text-right btn-link">Login</a>
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