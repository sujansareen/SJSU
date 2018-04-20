@extends('layouts.app')
@section('content')
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4"></h1>
        <p class="lead"></p>
    </div>
    <div id="card-deck" class="container">
    </div>


    {{--   Product Template --}}
    <div id="ProductTemplateCard" class="card box-shadow" style="display: none;min-width: 18rem;" >

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
                $card.find('.card-img-top').attr('src', '/images/products/'+ data.img||'');
                $card.find('.card-body .card-title').text(data.name||'');
                $card.find('.card-body .card-text').text(data.description||'');
                $card.show();
            }
            return $card;
        }
        axios.get('/api/products/{{$product_id}}')
                .then(function (response) {
                    var card = response.data || {};
                    var $card = renderCard(card);
                    $('.pricing-header .display-4').text(card.name||'');
                    $('.pricing-header .lead').text('Create a video from your memories at ' + card.name||'');
                    $('#card-deck').html($card);
                })
                .catch(function (error) {

                    window.location = '/services';
                });

    </script>
@endsection
@section('header')
    @component('components.header')
    @endcomponent
@endsection
