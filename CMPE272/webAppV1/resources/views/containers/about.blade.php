@extends('layouts.app')
@section('content')
    <br />
    <div class="container">
        <div class="masthead-followup row m-0 border border-white">
            @foreach ($info as $item)
                <div class="col-12 col-md-4 p-3 p-md-5 bg-light border border-white">
                    <h3><?= $item["title"] ?></h3>
                    <p><?= $item["msg"] ?></p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('header')
    @component('components.header')
    @endcomponent
@endsection



