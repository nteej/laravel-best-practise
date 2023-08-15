@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="row">
                <div class="col-md-2">
                <ul class="list-group">
                    <a href="{{route('home')}}" class="list-group-item active" aria-current="true">Dashboard</a>
                    <a href="{{route('commodities.list')}}" class="list-group-item">Commodities</a>
                    <a href="{{route('commodities.upload')}}" class="list-group-item">Upload CSV</a>
                    <a href="#" class="list-group-item">Settings</a>

                </ul>
                </div>
                <div class="col-md-2">
                    <div class="card">
                        <div class="card-header">{{ __('Uploads') }}</div>

                        <div class="card-body">
                           <i class="fas fa-home fa-2x"> {{$uploads}}</i>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="card">
                        <div class="card-header">{{ __('Dashboard') }}</div>

                        <div class="card-body">

                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card">
                        <div class="card-header">{{ __('Dashboard') }}</div>

                        <div class="card-body">

                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card">
                        <div class="card-header">{{ __('Dashboard') }}</div>

                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom: 1%">
                <div class="col-md-2"></div>
                <div class="col-md-2">
                    <div class="card">
                        <div class="card-header">{{ __('Dashboard') }}</div>

                        <div class="card-body">

                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card">
                        <div class="card-header">{{ __('Dashboard') }}</div>

                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
