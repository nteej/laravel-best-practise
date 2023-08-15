<!-- resources/views/commodities/index.blade.php -->

@extends('layouts.app')
<style>
    #floating-display {
        position: fixed;
        top: 55px; /* Adjust the top distance as needed */
        right: 20px;
        white-space: nowrap;
        overflow: hidden;
        background-color: rgba(0, 0, 0, 0.8);
        padding: 10px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        animation: float 80000s linear infinite; /* Adjust the duration as needed */
    }

    .price {
        margin-right: 15px;
        white-space: nowrap;
        font-size: 14px;
    }

    @keyframes float {
        0% {
            transform: translateX(100%);
        }
        100% {
            transform: translateX(-100%);
        }
    }

    .item {
        font-weight: bold;
        margin-right: 5px;
        color: white;
    }

    .price-value {
        font-style: italic;
        color: #ccc;
    }

    .change {
        font-style: italic;
        margin-left: 5px;
    }

    .positive {
        color: red; /* Positive change color */
    }

    .negative {
        color: green; /* Negative change color */
    }

</style>
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">

                <div class="col-md-12">
                    <div id="floating-display">
                        <!-- Display the fetched commodity prices here -->
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12"><h2>Dambulla Economic Center Price Index</h2>
                    <table class="table" id="commoditiesTable" data-dynatable>
                        <thead>
                        <tr>
                            <th>Category</th>
                            <th>Item (EN)</th>
                            <th>Item (SI)</th>
                            <th>Item (TM)</th>
                            <th>Price From</th>
                            <th>Price To</th>
                            <th>Base Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($commodities as $commodity)
                            <tr>
                                <td>{{ $commodity->category->cat_name }}</td>
                                <td>{{ $commodity->item_en }}</td>
                                <td>{{ $commodity->item_si }}</td>
                                <td>{{ $commodity->item_tm }}</td>
                                <td>{{ $commodity->price_from }}</td>
                                <td>{{ $commodity->price_to }}</td>
                                <td>{{ $commodity->base_date }}</td>
                            </tr>

                        @endforeach
                        </tbody>

                    </table>
                    {{--{{ $commodities->render() }}--}}
                </div>

            </div>


        </div>
    </div>
    <script>
        $(document).ready(function () {
            // var currentIndex = 0; // Initial index for fetching
            function fetchCommodityPrices() {
                $.ajax({
                    url: '{{ route('api.commodity_prices') }}', // Passing the index as a parameter
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        // Sort the data based on percentage change
                        /*data.sort(function (a, b) {
                            // Sort negative changes first, then positive, then no changes
                            if (a.percentage_change < b.percentage_change) {
                                return 1;
                            } else if (a.percentage_change > b.percentage_change) {
                                return -1;
                            } else {
                                return 0;
                            }
                        });*/
                        updateFloatingDisplay(data);
                        //currentIndex++; // Move to the next index for the next call
                    },
                    error: function () {
                        console.log('Error fetching commodity prices.');
                    }
                });
            }

            function updateFloatingDisplay(prices) {
                var display = $('#floating-display');
                display.empty();

                $.each(prices, function (index, price) {
                    //if (price.price_from >= 1 && price.price_to >= 1) {
                        var price_change = (price.percentage_change >= 1) ? (price.percentage_change >= 0 ? '+' : '-') + Math.abs(price.percentage_change).toFixed(2) + '%' : '';
                        var priceHtml = '<div class="price">' +
                            '<span class="item">' + price.item_en +'</br>'+ price.item_si + '</span>' +
                            '<span class="price-value">' + price.price + '</span>' +
                            '<span class="change ' + (price.percentage_change >= 0 ? 'positive' : 'negative') + '">' +
                            price_change +
                            '</span>' +
                            '</div>';

                        display.append(priceHtml);
                   // }
                });

            }

            fetchCommodityPrices();
            //setInterval(fetchCommodityPrices, 5000);
        });
    </script>

@endsection
