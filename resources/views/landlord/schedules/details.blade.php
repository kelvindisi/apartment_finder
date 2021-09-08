@extends('layouts.template')
@section('navbar')
    @include('layouts.navbar')
@endsection
@section('content')
<div class="container">
    <div class="shadow mt-2 p-4">
        @include('layouts.messages')  
        <div class="form-title">
            <h2>ROOM DETAILS</h2>
            <hr>
            <div class="row">
                <div class="col-12">Apartment Name: <span class="fw-bold">{{$booking->house->apartment->name}}</span></div>
                <div class="col-12">Location: <span class="fw-bold">{{$booking->house->apartment->location}}</span></div>
                <div class="col-6">Phone: <span class="fw-bold">{{$booking->house->apartment->phone}}</span></div>
                <div class="col-6">Email: <span class="fw-bold">{{$booking->house->apartment->email}}</span></div>
                <hr>
                <div class="col-6">
                    <span class="fw-bold">Rooms No:</span>
                    <span class="">{{$booking->house->room_no}}</span></div>
                <div class="col-6">
                    <span class="fw-bold">Bedrooms: 
                    <span class="">{{$booking->house->bedrooms}}</span></div>
                <div class="col-6">
                    <span class="fw-bold">Bathrooms:</span>
                    <span class="">{{$booking->house->bathrooms}}</span></div>
                <div class="col-6">
                    <span class="fw-bold">Status:</span> 
                    <span>{{$booking->house->status}}</span></div>
                <div class="col-12">
                    <span class="fw-bold">Description:</span>
                </div>
                <div class="col-12 mb-2">
                    <span>{{$booking->house->description}}</span>
                </div>
                <hr>
                <div class="col-12 mt-2 mb-1">
                    <h3>Physical Viewing Booking Request</h3>
                </div>
                <div class="col-6">
                    <span class="fw-bold">Client Name:</span> 
                    <span>{{$booking->user->name}}</span>
                </div>
                <div class="col-6">
                    <span class="fw-bold">Client Email:</span> 
                    <span>{{$booking->user->email}}</span>
                </div>
                <div class="col-6">
                    <span class="fw-bold">Date Scheduled:</span> 
                    <span>{{$booking->scheduled_date?$booking->scheduled_date:'NOT SCHEDULED'}}</span>
                </div>
                <div class="col-6">
                    <span class="fw-bold">Request Status:</span> 
                    <span>{{$booking->confirmed}}</span>
                </div>
                <div class="mt-2 row">
                    @if($booking->confirmed=='pending')
                    <div class="flex col-7">
                        <form action="{{route('appointment.schedule', $booking->id)}}" method="post">
                            @csrf
                            <div class="input-group">
                                <label class="form-label" for="date">Date Scheduled</label>
                                <input type="date" name="date" id="date" 
                                class="form-control @error('date') is-invalid @enderror">
                                <button class="btn btn-primary">Schedule</button>
                                @error('date')
                                <small class="invalid-feedback">{{$message}}</small>
                                @enderror
                            </div>
                        </form>
                    </div>
                    <div class="col-4">
                        <a href="{{ route('appointment.deny', $booking->id) }}" class="btn btn-danger">Deny</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section("scripts")
<script src="{{ asset('/js/datatable.js') }}"></script>
@endsection