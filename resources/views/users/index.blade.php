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
    <h1 class="text-center mb-5 text-secondary">Users Index</h1>
    @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
    <a class="btn btn-secondary float-right" href="{{ route('users.create')}}">Add</a>
    <h2 class="text-secondary">Users</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
                <th>Change Usertype</th> <!-- Add a new column header for the button -->
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <form action="{{ route('users.destroy', compact('user')) }}" method="POST">
                        @csrf
                        <a class="btn btn-outline-success" href="{{ route('users.show', compact('user')) }}">Show</a>
                        <a class="btn btn-outline-success" href="{{ route('users.edit', compact('user')) }}">Edit</a>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
                <td>
                    <!-- Add a new form for the button -->
                    <form action="{{ route('users.changeUsertype', compact('user')) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="usertype">Select New Usertype:</label>
                            <select name="usertype" id="usertype" class="form-select" required>
                                <option value="admin" {{ $user->usertype === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="traveler" {{ $user->usertype === 'traveler' ? 'selected' : '' }}>Traveler</option>
                                <option value="local" {{ $user->usertype === 'local' ? 'selected' : '' }}>Local</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Change Usertype</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links('pagination::bootstrap-5') }}
</div>
@endsection