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
    html, body, #app {
            height: 100%;
            margin: 0;
            padding: 0;
        }

    /* Add a unique class or ID for the availability page styles */
    #availability-page {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-top: 50px;
    }

    #availability-page .card-container {
        width: 450px; /* Adjusted width */
        margin-left: auto;
        margin-right: auto;
    }

    #availability-page .card {
        margin-top: 20px;
        width: 100%; /* Full width within the container */
        height: 250px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(0, 0, 0, 0.1); /* Grey border */
        border-radius: 24px;
        position: relative;
    }

    #availability-page .input-container {
        margin-bottom: 15px;
    }

    #availability-page input {
        width: 100%; /* Full width within the container */
        padding: 5px;
        box-sizing: border-box;
        border: 1px solid #ccc; /* Grey border */
        outline: none; /* Remove default outline */
    }

    #availability-page .check-availability {
        width: 130px;
        padding: 8px;
        border: none;
        border-radius: 20px;
        background-color: #198754;
        color: #fff;
        cursor: pointer;
        font-size: 14px;
        align-self: center; /* Center the button */
        margin-top: 10px; /* Add margin to separate the button from the inputs */
    }

    #availability-page .timeframes-card {
        width: 100%; /* Full width within the container */
        height: auto;
    }

    #availability-page #timeframes-container {
        display: flex;
        flex-wrap: wrap; /* Allow buttons to wrap to the next line */
        gap: 5px; /* Add gap between buttons */
    }

    /* Added a class for timeframe buttons to ensure color stays on click */
    #availability-page .btn-outline-success {
        width: 100px; /* Adjust the width as needed */
        font-size: 12px;
        margin-top: 5px; /* Add margin to separate the buttons */
        padding: 8px;
        cursor: pointer;
        border-radius: 20px;
    }

    /* New styles for the result card */
    #availability-page .result-card {
        margin-top: 20px;
        width: 100%;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(0, 0, 0, 0.1); /* Grey border */
        border-radius: 24px;
        padding: 20px;
        text-align: center;
    }

    /* Center the Add to Cart button */
    #availability-page .add-to-cart-container {
        text-align: center;
        margin-top: 20px;
        margin-bottom: 150px;
    }

    /* Hide the Add to Cart button initially */
    #availability-page #add-to-cart-button {
        display: none;
    }   

</style>

<div class = container>
<div id="availability-page">
    <h1>Show Availability for {{ $experience->name }}</h1>

    <div class="card-container">
        <div class="card">
            <div class="card-body">
                <div class="input-container">
                    <label for="selected_date">Select Date:</label>
                    <input type="date" id="selected_date" required>
                </div>

                <div class="input-container">
                    <label for="num_tickets">Number of Tickets:</label>
                    <input type="number" id="num_tickets" required min="1">
                </div>

                <button class="check-availability" onclick="updateAvailability()">Check Availability</button>
            </div>
        </div>

        <div class="card timeframes-card" id="availability-container">
            <div class="card-body">
                <h2>Available Timeframes:</h2>
                <div id="timeframes-container"></div>
            </div>
        </div>

        <!-- New card for displaying the result -->
        <div class="card result-card" id="result-container" style="display: none;">
            <h2>Booking Details</h2>
            <p><strong>{{ $experience->name }}</strong> <span id="result-experience"></span></p>
            <p><strong>Number of Tickets:</strong> <span id="result-num-tickets"></span></p>
            <p><strong>Selected Date:</strong> <span id="result-selected-date"></span></p>
            <p><strong>Selected Timeframe:</strong> <span id="result-selected-timeframe"></span></p>
        </div>

        <!-- Container for Add to Cart button -->
        <div class="add-to-cart-container">
            <form action="{{ route('cart.addToCart') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="numTickets" value="" id="numTicketsInput">
                <input type="hidden" name="selectedDate" value="" id="selectedDateInput">
                <input type="hidden" name="selectedTimeframe" value="" id="selectedTimeframeInput">
                <input type="hidden" name="experience_id" value="{{ $experience->id }}">
                <input type="hidden" name="experience_price" value="{{ $experience->price }}">
                <button type="submit" class="btn btn-outline-success" id="add-to-cart-button">Add to Cart</button>
            </form>
        </div>
    </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>

function updateAvailability() {
    var selectedDate = $('#selected_date').val();
    var numTickets = $('#num_tickets').val();

    $.ajax({
        url: "{{ route('experience.checkAvailability', ['experience' => $experience->id]) }}",
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            selected_date: selectedDate,
            num_tickets: numTickets
        },
        success: function (data) {
            // Update the content of the availability container
            var timeframesContainer = $('#timeframes-container');
            timeframesContainer.empty(); // Clear existing content

            if (data.available_timeframes.length > 0) {
                // Display timeframes
                $.each(data.available_timeframes, function (index, timeframe) {
                    var button = $('<button>', {
                        type: 'button',
                        class: 'btn btn-outline-success',
                        text: timeframe,
                        click: function () {
                            showResult(data.experience_name, numTickets, selectedDate, timeframe);
                            // Show the Add to Cart button after displaying booking details
                            $('#add-to-cart-button').show();
                        }
                    });
                    timeframesContainer.append(button);
                });
            } else {
                // Display "No timeframes available" message
                timeframesContainer.append('<p>No timeframes available</p>');
            }
        },
        error: function () {
            console.log('Error fetching availability');
        }
    });
}

    function showResult(experience, numTickets, selectedDate, selectedTimeframe) {
        // Update the result card with the selected details
        $('#result-experience').text(experience);
        $('#result-num-tickets').text(numTickets);
        $('#result-selected-date').text(selectedDate);
        $('#result-selected-timeframe').text(selectedTimeframe);

        // Set the value of the hidden inputs
        $('#numTicketsInput').val(numTickets);
        $('#selectedDateInput').val(selectedDate);
        $('#selectedTimeframeInput').val(selectedTimeframe);

        // Display the result card
        $('#result-container').show();
    }

</script>

@endsection
