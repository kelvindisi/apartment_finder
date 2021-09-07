@extends('layouts.template')
@section('navbar')
    @include('layouts.navbar')
@endsection
@section('content')
<div class="container">
    <div class="shadow mt-2 p-4">
        <div class="form-title">
            <h2>New Room</h2>
            <hr>
        </div>
        @include('layouts.messages')
        <div class="row mb-4">
            <div class="col-12">
                <h3>Apartment:</h3>
            </div>
            <div class="col-6">Apartment Name: {{$room->apartment->name}}</div>
            <div class="col-6">Location: {{$room->apartment->location}}</div>
            <div class="col-6">Current No of Rooms: {{$room->apartment->houses()->count()}}</div>
        </div>
        <form action="{{ route('rooms.update', [$room->apartment->id, $room->id]) }}" enctype="multipart/form-data" method="post">
            @csrf
            <input type="hidden" name="_method" value="PATCH">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-floating mb-3">
                        <input type="number" 
                            class="form-control @error('room_no') is-invalid @enderror" 
                            min="0" name="room_no"
                            id="room_no" placeholder="No of Rooms"
                            value="@if(old('room_no')){{old('room_no')}}@else{{$room->room_no}}@endif">
                        <label for="room_no">No of Room </label>
                        @error('room_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 mb-3">
                    <div class="form-floating">
                        <input type="number" 
                            class="form-control @error('bedrooms') is-invalid @enderror" 
                            name="bedrooms" id="bedrooms"
                            min="0" placeholder="Bedrooms"
                            value="@if(old('bedrooms')){{old('bedrooms')}}@else{{$room->bedrooms}}@endif">
                        <label for="bedrooms">No of Bedrooms</label>
                        @error('bedrooms')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 mb-3">
                    <div class="form-floating">
                        <input type="number" 
                            class="form-control 
                            @error('bathrooms') is-invalid @enderror"  
                            min="0" placeholder="Bathrooms" 
                            id="bathrooms" name="bathrooms"
                            value="@if(old('bathrooms')){{ old('bathrooms')}}@else{{$room->bathrooms}}@endif">
                        <label for="bathrooms">Bathrooms:</label>
                        @error('bathrooms')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="form-floating">
                        <textarea name="description" id="description"
                            class="form-control @error('description') is-invalid @enderror"  
                            placeholder="Description"
                            style="height: 100px;"
                            >@if(old('description')){{old('description')}}@else{{$room->description}}@endif</textarea>
                        <label for="description">Description:</label>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary">Update Room</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection