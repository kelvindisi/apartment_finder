@extends('layouts.template')
@section('navbar')
    @include('layouts.navbar')
@endsection
@section('content')
<div id="housePictureList" class="carousel slide" data-bs-ride="carousel" style="margin-top: -10px;">
    <div class="carousel-inner">
        @foreach($booking->house->pictures as $picture)
        <div class="carousel-item @if($loop->index == 0){{_('active')}}@endif">
            <img src="{{asset('storage/'.$picture->picture_file) }}" class="d-block w-100" alt="...">
        </div>
        @endforeach
        <button class="carousel-control-prev" type="button" data-bs-target="#housePictureList" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#housePictureList" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
<div class="container-fluid mt-2">
    <div class="card shadow">
        <div class="card-body">
            <h3 class="card-title">House Details</h3>
            <div class="card-text">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <span class="fw-bold">Apartment Name:</span>
                        <span>{{ $booking->house->apartment->name }}</span>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="fw-bold">Location:</span>
                        <span>{{ $booking->house->apartment->location }}</span>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="fw-bold">Contact Email:</span>
                        <span>{{ $booking->house->apartment->email }}</span>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="fw-bold">Contact Phone:</span>
                        <span>{{ $booking->house->apartment->phone }}</span>
                    </div>
                    <div class="col-12">
                        <span class="fw-bold">Apartment Description:</span>
                        <span>{{ $booking->house->apartment->description }}</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12 col-md-6">
                        <span class="fw-bold">House No:</span>
                        <span>{{ $booking->house->room_no }}</span>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="fw-bold">No of Bathrooms:</span>
                        <span>{{ $booking->house->bathrooms }}</span>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="fw-bold">No of Bedrooms:</span>
                        <span>{{ $booking->house->bedrooms }}</span>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="fw-bold">House(Room) Description:</span>
                        <span>{{ $booking->house->description }}</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <hr>
                    <div class="col-sm-12 col-md-6">
                        <span class="fw-bold">Confirmed Date:</span>
                        <span>{{ $booking->confirmed_date }}</span>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="fw-bold">Status:</span>
                        <span>{{ $booking->confirmed }}</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <form action="{{route('comment.create', $booking->id)}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="rating" class="form-label">Rating</label>
                            <input type="number" name="rating" id="rating" 
                            class="form-control @error('rating') is-invalid @enderror" min="0" max="10">
                            @error('rating')
                            <small class="invalid-feedback">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="review" class="form-label">Review</label>
                            <textarea name="review" id="review" cols="30" rows="10" 
                            class="form-control @error('review') is-invalid @enderror"></textarea>
                            @error('review')
                            <small class="invalid-feedback">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('users.posts.mycomments')
</div>
<div class="footer-image">
    <img src="{{asset('images/home/bottom.svg')}}" alt="houses svg">
</div>
@endsection
@section("scripts")
<script src="{{ asset('/js/datatable.js') }}"></script>
@endsection