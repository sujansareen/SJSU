@extends('layouts.app')
@section('content')
    <br />
    <div class="container">
        <div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
            <div class="col-md-6 px-0">
                <h1 class="display-4 font-italic">Restoring Memories</h1>
                <p class="lead my-3">Multiple ways how we help others restore there memories.</p>
                <p class="lead mb-0"><a href="#" class="text-white font-weight-bold">Continue reading...</a></p>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-6">
                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <div class="card-body d-flex flex-column align-items-start">
                        <strong class="d-inline-block mb-2 text-primary">Family Albums</strong>
                        <h3 class="mb-0">
                            <a class="text-dark" href="#">Family Albums</a>
                        </h3>
                        <div class="mb-1 text-muted">Nov 12</div>
                        <p class="card-text mb-auto">100 Family Albums to date</p>
                        <a href="#">Continue reading</a>
                    </div>
                    <img class="card-img-right flex-auto d-none d-md-block" alt="Thumbnail [200x250]" style="width: 200px; height: 250px;" src="images/water.jpg" data-holder-rendered="true">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('header')
    @component('components.header')
    @endcomponent
@endsection



