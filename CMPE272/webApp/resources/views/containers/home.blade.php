@extends('layouts.app')
@section('content')
    <br />
    <div class="container">
        <div class="row align-items-center">
            <div class="col-6 mx-auto col-md-6 order-md-2">
                <img class="img-fluid mb-3 mb-md-0" src="images/couple.JPG" alt="" width="1024" height="860">
            </div>
            <div class="col-md-6 order-md-1 text-center text-md-left pr-md-5">
                <h1 class="mb-3 bd-text-purple-bright">Capture your memories</h1>
                <p class="lead">  </p>
                <p class="lead mb-4"> </p>
                <div class="d-flex flex-column flex-md-row lead mb-3">
                    <a href="/services" class="btn btn-lg btn-bd-primary mb-3 mb-md-0 mr-md-3" onclick="ga('send', 'event', 'Jumbotron actions', 'Get started', 'Get started');">Get started</a>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('header')
    @component('components.header')
    @endcomponent
@endsection



