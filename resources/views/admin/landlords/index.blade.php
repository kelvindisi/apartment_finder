@extends('layouts.template')
@section('navbar')
    @include('layouts.navbar')
@endsection
@section('content')
<div class="container">
    @include('layouts.messages')
    <div class="creator mt-1">
        <a href="{{ route('landlords.create') }}" class="btn btn-primary btn-sm">Create account</a>
    </div>
    <div class="table-responsive mt-3">
        <table class="table table-striped dt-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registered On</th>
                    <th>Manage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($landlords as $landlord)
                <tr>
                    <td>{{ $landlord->name }}</td>
                    <td>{{ $landlord->email}}</td>
                    <td>{{ $landlord->created_at }}</td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('landlords.show', $landlord->id) }}" class="btn btn-sm btn-warning mr-1">View</a>
                        <a href="{{ route('landlords.edit', $landlord->id) }}" class="btn btn-sm btn-primary ml-1">Edit</a>
                        <form action="{{ route('landlords.destroy', $landlord->id)}}" class=" ml-1" method="post">
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
<script src="{{ asset('/js/dataTable.js') }}"></script>
@endsection