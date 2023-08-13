@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="margin-bottom: 1%">
            <div class="col-md-4"></div>
            <div class="col-md-6"></div>
            <div class="col-md-2">
                <a href="{{ route('commodities.upload') }}" class="btn btn-info" type="submit">Upload CSV</a>
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
@endsection
