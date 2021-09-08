@extends('layouts.template')
@section('navbar')
    @include('layouts.navbar')
@endsection
@section('content')
<div class="cover">
    <div class="search-form">
        <form action="{{route('room.search')}}" method="get">
            <div class="row height d-flex justify-content-center align-items-center">
                <div class="col-md-8">
                    <div class="search"> 
                        <i class="fa fa-search"></i>
                        <input type="text" name="q" class="form-control" placeholder="Search by location">
                        <button class="btn btn-primary">Search</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@include("layouts.messages")
<!-- House Listing -->
<div class="container mt-2">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @if($rooms->count() != 0)
        @foreach($rooms as $room)
        <div class="col">
            <div class="card">
                <img src="{{asset('storage/'.$room->pictures->first()->picture_file)}}" 
                    class="card-img-top" alt="{{$room->apartment->name}}">
                <div class="card-body">
                    <h5 class="card-title">Location: {{$room->apartment->location}}</h5>
                    <p class="card-text">
                        <p class="fw-bold">Description:</p>
                        <p>{{ \Illuminate\Support\Str::limit($room->description, 40, $end='...') }}</p>
                    </p>
                </div>
                <div class="card-footer d-flex">
                    <a href="{{ route('list.show', $room->id)}}" class="btn btn-outline-primary btn-sm">More</a>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <div class="container">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">No house available.</h5>
                </div>
            </div>
        </div>
        @endif
    </div>
    {{ $rooms->links() }}
</div>
<div class="footer-image">
    <img src="{{asset('images/home/bottom.svg')}}" alt="houses svg">
</div>
@endsection
@section("scripts")
<script src="{{ asset('/js/datatable.js') }}"></script>
@endsection