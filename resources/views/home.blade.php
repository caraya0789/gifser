@extends('layouts.app')

@section('content')
<div id="search" class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="text-center">Search gifs</h3>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="row no-gutters">
                        <div class="col-9">
                            <input :disabled="searching" v-model="query" placeholder="Search..." class="form-control form-control-lg border-0" :class="{ 'error' : formError, 'disabled' : searching }"/>
                        </div>
                        <button :disabled="searching" v-on:click="search" class="col btn btn-primary">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5" v-if="results.length && !searching" v-cloak>
        <div v-for="(result, index) in results" class="col-md-6 col-lg-4 col-12 mb-4">
            <div class="card">
                <div class="gif-holder card-img-top" :style="'background-image:url('+result.url+')'"></div>
                <div class="card-body">
                    <h4 class="card-title text-center">@{{ result.title }}</h4>
                </div>
                <a href="javascript://" v-on:click="add_favorite(index)" :class="{ 'added': result.favorite }" class="favorite"><i class="fa fa-heart"></i></a>
            </div>
        </div>
    </div>
    <div class="row mt-5 justify-content-center" v-if="results.length && !searching && !loading && more"  v-cloak>
        <a href="#" v-on:click="loadmore" class="btn btn-link">Load More</a>
    </div>
    <div class="row mt-5 justify-content-center" v-if="searching || loading" v-cloak>
        <img src="images/loading.gif" />
    </div>
</div>
@endsection
