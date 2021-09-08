@extends('layouts.template')
@section('navbar')
    @include('layouts.navbar')
@endsection
@section('content')
<div class="container-fluid mt-2">
    <div class="card shadow">
        <div class="card-body">
            <h3 class="card-title">House Details</h3>
            <div class="card-text table-responsive">
                <table class="table table-striped dt-table">
                    <thead>
                        <tr>
                            <th>Apartment</th>
                            <th>Room No</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td> {{ $booking->house->apartment->name }} </td>
                            <td>{{$booking->house->room_no}}</td>
                            <td>{{$booking->house->apartment->location}}</td>
                            <td>{{$booking->confirmed}}</td>
                            <td>
                                <a href="{{route('booking.show', $booking->id)}}" 
                                    class="btn btn-sm btn-outline-primary">Show</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="footer-image">
    <img src="{{asset('images/home/bottom.svg')}}" alt="houses svg">
</div>
@endsection
@section("scripts")
<script src="{{ asset('/js/datatable.js') }}"></script>
@endsection