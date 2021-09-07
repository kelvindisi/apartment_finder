@extends('layouts.template')
@section('navbar')
    @include('layouts.navbar')
@endsection
@section('content')
<div class="container mt-3">
    @include('layouts.messages')
    <div class="creator mt-1">
        <a href="{{ route('apartments.create') }}" class="btn btn-primary btn-sm">Create Apartment</a>
    </div>
    <div class="table-responsive mt-3">
        <table class="table table-striped dt-table">
            <thead>
                <tr>
                    <th>Apartment Name</th>
                    <th>Location</th>
                    <th>Added On</th>
                    <th>Manage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($apartments as $apartment)
                <tr>
                    <td>{{ $apartment->name }}</td>
                    <td>{{ $apartment->location}}</td>
                    <td>{{ $apartment->created_at }}</td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('apartments.show', $apartment->id) }}" class="btn btn-sm btn-warning mr-1">View</a>
                        <a href="{{ route('apartments.edit', $apartment->id) }}" class="btn btn-sm btn-primary ml-1">Edit</a>
                        <form action="{{ route('apartments.destroy', $apartment->id)}}" class=" ml-1" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
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