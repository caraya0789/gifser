@extends('layouts.app')

@section('content')
<div id="search" class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="text-center">Search gifs</h3>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="row no-gutters">
                        <div class="col-sm-9">
                            <input :disabled="searching" v-model="query" placeholder="Search..." class="form-control form-control-lg border-0" :class="{ 'error' : formError, 'disabled' : searching }"/>
                        </div>
                        <button :disabled="searching" v-on:click="search" class="col btn btn-primary">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5 justify-content-center" v-if="searching" v-cloak>
        <img src="images/loading.gif" />
    </div>
    <div class="row mt-5" v-if="results.length && !searching" v-cloak>
        <div v-for="result in results" class="col-sm-4 col mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="gif-holder" :style="'background-image:url('+result.url+')'"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
