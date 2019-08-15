@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Search History</div>

                
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Query</th>
                                <th width="200">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($searches as $search)
                            <tr>
                                <th>{{ $search->query }}</th>
                                <th>{{ $search->created_at }}</th>
                            </tr>
                            @endforeach
                    </table>
            </div>
        </div>
    </div>
</div>
@endsection
