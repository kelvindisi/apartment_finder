@extends('layouts.template')
@section('navbar')
    @include('layouts.navbar')
@endsection
@section('content')
<div id="housePictureList" class="carousel slide" data-bs-ride="carousel" style="margin-top: -10px;">
    <div class="carousel-inner">
        @foreach($room->pictures as $picture)
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
                        <span>{{ $room->apartment->name }}</span>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="fw-bold">Location:</span>
                        <span>{{ $room->apartment->location }}</span>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="fw-bold">Contact Email:</span>
                        <span>{{ $room->apartment->email }}</span>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="fw-bold">Contact Phone:</span>
                        <span>{{ $room->apartment->phone }}</span>
                    </div>
                    <div class="col-12">
                        <span class="fw-bold">Apartment Description:</span>
                        <span>{{ $room->apartment->description }}</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12 col-md-6">
                        <span class="fw-bold">House No:</span>
                        <span>{{ $room->room_no }}</span>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="fw-bold">No of Bathrooms:</span>
                        <span>{{ $room->bathrooms }}</span>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="fw-bold">No of Bedrooms:</span>
                        <span>{{ $room->bedrooms }}</span>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="fw-bold">House(Room) Description:</span>
                        <span>{{ $room->description }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <form action="{{route('appointment.book', $room->id)}}" method="post" style="max-width: 400px">
                @csrf
                <div class="input-group">
                    <button class="btn btn-primary">Request physical viewing</button>
                </div>
            </form>
        </div>
    </div>
    <div class="mt-3">
        @include("users.posts.comments")
    </div>
</div>
<div class="footer-image">
    <img src="{{asset('images/home/bottom.svg')}}" alt="houses svg">
</div>
@endsection
@section("scripts")
<script src="{{ asset('/js/datatable.js') }}"></script>
@endsection