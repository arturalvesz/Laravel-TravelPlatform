<div class="card">
    <div class="card-body mx-4">
        <div class="container">
            <p class="my-5 mx-5" style="font-size: 30px;">Thank you for your purchase</p>
            @php
            $total = 0;
            @endphp

            <div class="row">
                <div class="list-unstyled">
                    <h4 class="text-black">Seller name: {{$order->user->name}}</h4>
                </div>
                @foreach($cart as $item)
                <hr>
                <div class="col-xl-10">
                    @php
                    $experience = \App\Models\Experience::find($item['experience_id']);
                    $experienceName = $experience ? $experience->name : 'Experience Not Found';
                    @endphp
                    <p>Experience: {{$experienceName}}</p>
                </div>
                <div class="col-xl-2">
                    <p class="float-end"> Number of Entries: {{ $item['num_tickets'] }}</p>
                    <p class="float-end">Date: {{ $item['selected_date'] }}</p>
                    <p class="float-end">Entry time: {{ $item['selected_timeframe'] }}</p>
                    <p class="float-end">Price: {{ $item['price'] }}€</p>
                </div>
                <hr>
            </div>
            @php
            $total += $item['price']; // Add the current item's price to total
            @endphp
            @endforeach
            <div class="row text-black">
                <div class="col-xl-12">
                    <p class="float-end fw-bold">Total: {{$total}}€</p>
                </div>
                <hr style="border: 2px solid black;">
            </div>
        </div>
    </div>
</div>