@extends('layouts.template')
@section('navbar')
    @include('layouts.navbar')
@endsection
@section('content')
<div class="container">
    <div class="shadow mt-2 p-4">
        <div class="form-title">
            <h2>APARTMENT DETAILS</h2>
            <hr>
            <div class="row">
                <div class="col-12">Apartment Name: <span class="fw-bold">{{$apartment->name}}</span></div>
                <div class="col-12">Location: <span class="fw-bold">{{$apartment->location}}</span></div>
                <div class="col-6">Phone: <span class="fw-bold">{{$apartment->phone}}</span></div>
                <div class="col-6">Email: <span class="fw-bold">{{$apartment->email}}</span></div>
                
                <div class="col-6">Rooms: <span class="fw-bold">{{$apartment->houses()->count()}}</span></div>
                <hr>
                <div class="col-12 mb-2">
                    <div class="col text-center mb-2 fw-bold">Apartment Rooms</div>
                    <div class="col">
                        <a href="{{ route('rooms.create', $apartment->id) }}" class="btn btn-outline-primary btn-sm">Add Room</a>
                    </div>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped dt-table">
                            <thead class="table-dark">
                                <tr>
                                    <th>Room No</th>
                                    <th>Status</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($apartment->houses as $house)
                                <tr>
                                    <td>{{ $house->room_no }}</td>
                                    <td class="title">{{ $house->status }}</td>
                                    <td class="d-flex gap-2">
                                        <?php
                                            $params = ['id'=>$apartment->id, 'room'=>$house->id];
                                        ?>
                                        <a href="{{route('rooms.show', $params) }}" 
                                            class="btn btn-warning btn-sm">View</a>
                                        <a href="{{route('rooms.edit', $params) }}" 
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <form action="{{route('rooms.destroy', $params) }}" 
                                            method="post">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn-sm btn-danger">Delete</button>
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
        @include('layouts.messages')  
    </div>
</div>
@endsection
@section("scripts")
<script src="{{ asset('/js/datatable.js') }}"></script>
@endsection