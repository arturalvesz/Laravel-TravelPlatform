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
        max-width: 800px; /* Set the maximum width as needed */
        margin: auto; /* Center the table */
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
        <h1 class="text-center mb-5 text-secondary">Reviews Index</h1>
        @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
        <h2 class="text-secondary">Reviews</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Experience</th>
                    <th>Reviwer</th>
                    <th>Rating</th>
                    <th>Comment</th>     
                    <th>Actions</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($reviews as $review)
                    <tr>
                        <td>{{ $review->id }}</td>
                        <td>{{ $review->orderExperience->experience->name }}</td>
                        <td>{{ $review->user->name }}</td>
                        <td>{{ $review->starRating }}</td>
                        <td>{{ $review->comment }}</td>
                        
                        <td>   
                        <form action="{{ route('review.destroy', $review->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    
    </div>
@endsection


