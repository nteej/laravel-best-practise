<!-- resources/views/commodities/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-8"></div>
            </div>
            <div class="row">

                <div class="col-md-12">

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
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
                                <td>{{ $commodity->category }}</td>
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
@endsection
