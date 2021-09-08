@extends('layouts.template')
@section('navbar')
    @include('layouts.navbar')
@endsection
@section('content')
<div class="container mt-3">
    @include('layouts.messages')
    <div class="table-responsive mt-3">
        <table class="table table-striped dt-table">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Client Email</th>
                    <th>Status</th>
                    <th>Scheduled On</th>
                    <th>Manage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->name }}</td>
                    <td>{{ $booking->email }}</td>
                    <td class="uppercase">{{ $booking->confirmed }}</td>
                    <td>{{ $booking->scheduled_date ? $booking->scheduled_date: 'NOT SCHEDULED' }}</td>
                    <td>
                        <a href="{{ route('appointment.show', $booking->id) }}" class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('/js/datatable.js') }}"></script>
@endsection