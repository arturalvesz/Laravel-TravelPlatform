@extends('layouts.app')
@section('content')
<style>
    body {
        margin: 0;
        padding: 0;
        overflow-y: scroll;
        scrollbar-width: thin;
        scrollbar-color: transparent transparent;
        -ms-overflow-style: none;
    }

    body::-webkit-scrollbar {
        width: 0px;
    }

    body::-webkit-scrollbar-thumb {
        background-color: transparent;
    }

    body::-webkit-scrollbar-track {
        background-color: transparent;
    }

    .table-container {
        max-width: 800px;
        /* Set the maximum width as needed */
        margin: auto;
        /* Center the table */
    }

    .table {
        border-radius: 15px;
        overflow: hidden;
    }

    .table th,
    .table td {
        text-align: center;
        padding: 6px;
    }

    .table th {
        background-color: #198754;
        color: #fff;
    }

    .table a.btn-sm {
        font-size: 12px;
    }

</style>
<div class="container">
    <h1 class="text-center mb-5 text-secondary">Experiences Index</h1>
    @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
    <a class="btn btn-secondary float-right" href="{{ route('experience.create')}}">Add</a>
    <h2 class="text-secondary">Experience</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>UserID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Location</th>
                <th>Duration</th>
                <th>Price</th>
                <th style="width: 20%";>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($experiences as $experience)
            <tr>
                <td>{{ $experience->id }}</td>
                @if($experience->user)
                <td>{{ $experience->user->id }}</td>
                @else
                <td></td>
                @endif
                <td>{{ $experience->name }}</td>
                <td>{{ $experience->description }}</td>
                <td>{{ $experience->category->name }}</td>
                <td>{{ $experience->location }}</td>
                <td>{{ $experience->duration }}</td>
                <td>{{ $experience->price }}</td>
                <td>
                    <form action=" {{ route('experience.destroy', compact('experience')) }} " method="POST">
                        @csrf
                        <a class="btn btn-outline-success" href="{{ route('experience.show', compact('experience')) }}">Show</a>
                        <a class="btn btn-outline-success" href="{{ route('experience.edit', compact('experience')) }}">Edit</a>
                        <a class="btn btn-outline-success" href="{{ route('days.index', compact('experience')) }}">View Schedule</a>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $experiences->links('pagination::bootstrap-5') }}
</div>
@endsection