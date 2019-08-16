@extends('layouts.app')

@section('content')
<div class="container">
    
    <h3 class="text-center">Favorites</h3>
    
    <div class="row mt-4 gifs">

        @foreach($favorites as $favorite)
        
        <div class="col-md-6 col-lg-4 col-12 mb-4">
            <div class="card">
                <div class="gif-holder card-img-top" style="background-image:url('{{ $favorite['url'] }}');"></div>
                <div class="card-body">
                    <h4 class="card-title text-center">{{ $favorite['title'] }}</h4>
                </div>
                <a href="{{ url('remove_favorite?id='.$favorite['id']) }}" class="favorite added"><i class="fa fa-heart"></i></a>
            </div>
        </div>
        
        @endforeach

    </div>
</div>
@endsection
