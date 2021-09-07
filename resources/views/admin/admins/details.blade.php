@extends('layouts.template')

@section('navbar')
@include('layouts.navbar')
@endsection
@section('content')
<div class="container">
    <div class="card ml-4 mr-4 mt-5 mb-5">
@include('layouts.messages')
        <div class="card-body">
            <div class="card-title">
                <h3>Account Details</h3>
            </div>
            <hr>
            <div class="card-text">
                <p>Full name: {{ $user->name }}</p>
                <p>Email: <span>{{ $user->email }}</span></p>
                <p>Phone: <span>{{ $user->phone }}</span></p>
                <p>Created: <span>{{ $user->created_at }}</span></p>
            </div>
        </div>
        <div class="card-footer d-flex gap-2">
            <a href="{{ route('admins.index') }}" class="btn btn-sm btn-warning mr-2">All Admins</a>
            <a href="{{ route('admins.edit', $user->id) }}" class="btn btn-sm btn-primary mr-2">Edit</a>
            <form action="{{ route('admins.destroy', $user->id) }}" method="post">
                @csrf
                <input type="hidden" name="_method" value="DELETE">
                <button class="btn btn-sm btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection