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


<div class="container mt-5">
    <h1 class="text-center mb-5">Experience Days</h1>
    @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                @if(auth()->user()->usertype === 'admin')
                <th>Day ID</th>
                @endif
                <th>Date</th>
                <th>Timeframe</th>
                @if(auth()->user()->usertype === 'admin' || Auth::check() && Auth::user()->id === $experience->user_id)
                <th>Max People</th>
                <th>People Registered</th>
                <th>Actions</th>
                @else
                <th>Available</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($days as $day)
            <tr>
                @if(auth()->user()->usertype === 'admin')
                <td>{{ $day->id }}</td>
                @endif
                <td>{{ $day->date }}</td>
                <td>{{ $day->timeframe }}</td>
                @if(auth()->user()->usertype === 'admin' || Auth::check() && Auth::user()->id === $experience->user_id)
                <td>{{ $day->max_people }}</td>
                <td>{{ $day->people_registered }}</td>
                <td>
                    <form action=" {{ route('days.destroy', ['day' => $day, 'experience' => $experience]) }} " method="POST">
                        @csrf
                        @method('DELETE')
                        <a class="btn btn-outline-success" href="{{ route('days.edit', compact('day','experience')) }}">Edit</a>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
                @else
                <td>{{$day->max_people - $day->people_registered}}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    <a class="btn btn-outline-success" href="/experience">Back</a>

    {{ $days->links('pagination::bootstrap-5') }}

</div>
@endsection