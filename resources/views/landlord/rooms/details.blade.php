@extends('layouts.template')
@section('navbar')
    @include('layouts.navbar')
@endsection
@section('content')
<div class="container">
    @include('landlord.rooms.image_modal')
    <div class="shadow mt-2 p-4">
        @include('layouts.messages')  
        <div class="form-title">
            <h2>ROOM DETAILS</h2>
            <hr>
            <div class="row">
                <div class="col-12">Apartment Name: <span class="fw-bold">{{$room->apartment->name}}</span></div>
                <div class="col-12">Location: <span class="fw-bold">{{$room->apartment->location}}</span></div>
                <div class="col-6">Phone: <span class="fw-bold">{{$room->apartment->phone}}</span></div>
                <div class="col-6">Email: <span class="fw-bold">{{$room->apartment->email}}</span></div>
                <hr>
                <div class="col-6">
                    <span class="fw-bold">Rooms No:</span>
                    <span class="">{{$room->room_no}}</span></div>
                <div class="col-6">
                    <span class="fw-bold">Bedrooms: 
                    <span class="">{{$room->bedrooms}}</span></div>
                <div class="col-6">
                    <span class="fw-bold">Bathrooms:</span>
                    <span class="">{{$room->bathrooms}}</span></div>
                <div class="col-6">
                    <span class="fw-bold">Status:</span> 
                    <span>{{$room->status}}</span></div>
                <div class="col-12">
                    <span class="fw-bold">Description:</span>
                </div>
                <div class="col-12 mb-2">
                    <span>{{$room->description}}</span>
                </div>
                <hr>
                <div class="col-12 mb-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addImage">
                    Add Image
                    </button>
                </div>
                <div class="col-12 mt-2">
                    <div class="table-responsive">
                        <table class="table table-striped dt-table">
                            <thead class="table-dark">
                                <tr>
                                    <th>Image</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($room->pictures as $image)
                                <tr>
                                    <td>
                                        <img src="{{asset('storage/thumbs/'.$image->picture_file)}}"
                                         alt="{{$room->apartment->name}}">
                                    </td>
                                    <td>
                                        <form action="{{route('room.pic.delete', [$room->id, $image->id])}}" method="post">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section("scripts")
<script src="{{ asset('/js/datatable.js') }}"></script>
@endsection