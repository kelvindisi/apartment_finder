@extends('layouts.template')
@section('navbar')
    @include('layouts.navbar')
@endsection
@section('content')
<div class="container">
    <div class="shadow mt-2 p-4">
        <div class="form-title">
            <h2>Update Apartment Details</h2>
        </div>
        @include('layouts.messages')
        <form action="{{ route('apartments.update', $apartment->id) }}" method="post">
            @csrf
            <input type="hidden" name="_method" value="PATCH">
            <div class="form-group">
                <label for="name">Apartment Name:</label>
                <input type="text"
                    class="form-control @error('name') is-invalid @enderror" 
                    name="name" placeholder="WanG Plaza" id="name"
                    value="@if(old('name')){{old('name')}} @else {{ $apartment->name }} @endif">
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Contact Email:</label>
                <input type="email" name="email" id="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    placeholder="wangplaza@gmail.com"
                    value="@if(old('email')){{old('email')}} @else {{ $apartment->email }} @endif">
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone">Contact Phone:</label>
                <input type="tel" name="phone" id="phone" 
                    class="form-control @error('phone') is-invalid @enderror"
                    placeholder="0712345678"
                    value="@if(old('phone')){{old('phone')}} @else {{ $apartment->phone }} @endif">
                @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="location" name="location" id="location" 
                    class="form-control @error('location') is-invalid @enderror"
                    value="@if(old('location')){{old('location')}} @else {{ $apartment->location }} @endif"
                    placeholder="Juja">
                @error('location')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" 
                    cols="30" rows="10" 
                    class="form-control @error('description') is-invalid @enderror"
                    placeholder="More details"
                    >@if(old('location')){{old('location')}}@else{{ $apartment->description }}@endif</textarea>
                @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group mt-2">
                <button class="btn btn-lg btn-block btn-primary">Update Apartment</button>
            </div>
        </form>
    </div>
</div>
@endsection