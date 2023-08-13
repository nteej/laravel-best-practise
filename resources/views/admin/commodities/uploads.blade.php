@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row mb-3" style="margin-bottom: 1%">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <form action="{{ route('commodities.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <input type="file" class="form-control" name="csv_file" accept=".csv">
                            <button class="btn btn-info" type="submit">Upload CSV</button>
                        </div>
                    </form>

                </div>
            </div>

            <div class="row" style="margin-bottom: 1%">

                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>File Name</th>
                            <th>Rows Imported</th>
                            <th>Uploaded At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($history as $record)
                            <tr>
                                <td>{{ $record->file_name }}</td>
                                <td>{{ $record->rows_imported }}</td>
                                <td>{{ $record->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
