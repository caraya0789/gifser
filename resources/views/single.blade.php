@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="text-center">{{ $image['title'] }}</h3>
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ $image['url'] }}" />
                    <p class="mt-4">Share</p>
                    <p><input class="form-control text-center" readonly value="{{ url($image['id']) }}" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
