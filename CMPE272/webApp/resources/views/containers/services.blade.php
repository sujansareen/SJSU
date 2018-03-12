@extends('layouts.app')
@section('content')
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Digital Transfer Service</h1>
        <p class="lead">Transfer your memories to the cloud</p>
    </div>
    <div class="container">
        <div class="card-deck mb-3 text-center">
            @foreach ($cards as $card)
                <div class="card mb-4 box-shadow">
                    <div class="card-header">
                        <h4 class="my-0 font-weight-normal">{{ $card["header"] }}</h4>
                    </div>
                    <img class="card-img-top" style="max-height: 250px;" src="{{$card['img']}}" alt="Card image cap">
                    <div class="card-body">
                        <h3 class="card-title pricing-card-title">Starting at {{ $card["price"] }}</h3>
                        <ul class="list-unstyled mt-3 mb-4">
                            @foreach ($card['list'] as $item)
                                <li>{{$item}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('header')
    @component('components.header')
    @endcomponent
@endsection
