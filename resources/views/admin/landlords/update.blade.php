@extends('layouts.template')
@section('navbar')
    @include('layouts.navbar')
@endsection
@section('content')
<div class="container">
    <div class="auth-form shadow mt-2 p-4">
        <div class="form-title">
            <h2>Update Landlord Account</h2>
        </div>
        @include('layouts.messages')
        <form action="{{ route('landlords.update', $landlord->id) }}" method="post">
            @csrf
            <input type="hidden" name="_method" value="PATCH">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text"
                    class="form-control @error('name') is-invalid @enderror" 
                    name="name" placeholder="John Doe" id="name"
                    value="@if(old('name')){{old('name')}}@else {{ $landlord->name }} @endif">
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
                    value="@if(old('email')){{old('email')}} @else {{ $landlord->email}} @endif">
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
                    value="@if(old('phone')){{old('phone')}}@else {{$landlord->phone}} @endif">
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
                <button class="btn btn-lg btn-block btn-primary">Update Account</button>
            </div>
        </form>
    </div>
</div>
@endsection