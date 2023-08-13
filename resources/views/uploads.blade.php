@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-8">
                    <form action="{{ route('commodities.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="csv_file" accept=".csv">
                        <button class="btn btn-info" type="submit">Upload CSV</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
