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

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Day ID</th>
                <th>Date</th>
                <th>Timeframe</th>
                <th>Max People</th>
                <th>People Registered</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($days as $day)
            <tr>
                <td>{{ $day->id }}</td>
                <td>{{ $day->date }}</td>
                <td>{{ $day->timeframe }}</td>
                <td>{{ $day->max_people }}</td>
                <td>{{ $day->people_registered }}</td>
                <td>
                <form action=" {{ route('days.destroy', ['day' => $day, 'experience' => $experience]) }} " method="POST">
                        @csrf
                        @method('DELETE')
                        <a class="btn btn-outline-success" href="{{ route('days.edit', compact('day','experience')) }}">Edit</a>
                        <button type="submit" class="btn btn-outline-success">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $days->links('pagination::bootstrap-5') }}

</div>
@endsection