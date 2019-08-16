@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="text-center">Search History</h3>
            <table class="table table-striped white mt-4">
                <thead class="thead-dark">
                    <tr>
                        <th>Query</th>
                        <th class="text-center" width="200">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($searches as $search)
                    <tr>
                        <th>{{ $search->query }}</th>
                        <th class="text-center">{{ $search->created_at->diffForHumans() }}</th>
                    </tr>
                    @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
