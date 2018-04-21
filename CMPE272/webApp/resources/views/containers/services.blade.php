@extends('layouts.app')
@section('content')
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Digital Transfer Service</h1>
        <p class="lead">Your memories to the cloud</p>
    </div>
    <div class="container">
        <div id="card-deck" class="card-deck text-center"> </div>
    </div>


    {{--   Product Template --}}
    <div id="ProductTemplateCard" class="card box-shadow" style="display: none;min-width: 18rem;" >
        <div class="card-header">
            <h4 class="product-name font-weight-normal"></h4>
        </div>
        <img class="card-img-top" style="max-height: 250px;" src="" alt="Card image cap">
        <div class="card-body">
            <h3 class="card-title pricing-card-title"></h3>
            <p class="card-text"></p>

        </div>
    </div>

    <script>

        function renderCard(data){
            if(data && data.name){
                var $card = $('#ProductTemplateCard').clone();
                $card.attr('id', '');
                $card.attr('data-id', data.id||'');
                $card.find('.card-img-top').attr('src', data.url||'');
                $card.find('.product-name').text(data.name||'');
                $card.find('.card-img-top').attr('src', 'images/products/'+ data.img||'');
                $card.find('.card-body .card-title').text(data.name||'');
                $card.find('.card-body .card-text').text(data.description||'');
                $card.show();
            }
            return $card;
        }
        axios.get('/api/products')
        .then(function (response) {
            window.products = response.data || [];
            var $cards = products.map(renderCard);
            $('#card-deck').html($cards);
            $('.card').unbind('click').on('click',
                function(e) {
                    var id = e.currentTarget.dataset.id;
                    window.location = '/products/' + id;
                });
        })
        .catch(function (error) {
            console.log(error);
        });

    </script>
@endsection
@section('header')
    @component('components.header')
    @endcomponent
@endsection


{{--

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



--}}
