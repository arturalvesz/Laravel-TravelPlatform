@extends('layouts.app')

@section('content')

<style>
    .row {
        margin-top: 5rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    input {
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
        border: 1px solid #ced4da;
    }

    .btn-success {
        font-size: 0.875rem;
    }
</style>

<div class="container mt-5">
    <div class="row mb-5">
        <div class="col-6 offset-3">
            <h1 class="text-center mb-5 text-secondary">Edit Day</h1>

            <form method="post" action="{{ route('days.update', compact('day','experience')) }}">
                @csrf

                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" class="form-control" name="date" value="{{ old('date', $day->date) }}">
                </div>

                <div class="form-group">
                    <label for="timeframe">Timeframe(hh:mm:ss):</label>
                    <input type="text" class="form-control" name="timeframe" value="{{ old('timeframe', $day->timeframe) }}">
                </div>

                <div class="form-group">
                    <label for="max_people">Max People:</label>
                    <input type="number" class="form-control" name="max_people" value="{{ old('max_people', $day->max_people) }}">
                </div>

                <div class="form-group mt-5">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection