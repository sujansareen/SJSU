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

        <img class="card-img-top" src="" alt="Card image cap">
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
                    var card = response.data && response.data  || {};
                    var $card = renderCard(card);
                    $('.pricing-header .display-4').text(card.name||'');
                    $('.pricing-header .lead').text('Create a video from your memories at ' + card.name||'');
                    $('#card-deck').html($card);
                })
                .catch(function (error) {
                    window.location = '/services';
                });

    </script>



    <div class="container">
        <div class="row" style="margin-top:40px;">
            <div class="col-md-6">
            <div class="well well-sm">
                <div class="row" id="post-review-box" >
                    <div class="col-md-12">
                        <form accept-charset="UTF-8" action="" method="post">
                            <div class="form-group">
                                <input id="ratings-hidden" name="rating" type="hidden"> 
                            </div>
                            <div class="form-group">
                                <textarea class="form-control animated" cols="50" id="new-review" name="comment" placeholder="Enter your review here..." rows="5"></textarea>
                            </div>
                            <div class="text-right">
                                <div class="stars starrr" data-rating="0"></div>
                                <a class="btn btn-danger btn-sm" href="#" id="close-review-box" style="display:none; margin-right: 10px;">
                                <span class="glyphicon glyphicon-remove"></span>Cancel</a>
                                <button class="btn btn-success mb-4" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> 
             
            </div>
        </div>
    </div>












    <div class="container">
        <div class="row">
            <div class="col-sm-7">
                <div class="rating-block">
                    <h4>Average user rating</h4>
                    <h2 class="bold padding-bottom-7">4.3 <small>/ 5</small></h2>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                      <span class="far fa-star" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                      <span class="far fa-star" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                      <span class="far fa-star" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                      <span class="far fa-star" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                      <span class="far fa-star" aria-hidden="true"></span>
                    </button>
                </div>
            </div>         
        </div>          
        
        <div class="row">
            <div class="col-sm-7">
                <hr/>
                <div class="review-block">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="http://dummyimage.com/60x60/666/ffffff&text=No+Image" class="img-rounded">
                            <div class="review-block-name"><a href="#">nktailor</a></div>
                            <div class="review-block-date">January 29, 2016<br/>1 day ago</div>
                        </div>
                        <div class="col-sm-9">
                            <div class="review-block-rate">
                                <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                  <span class="far fa-star" aria-hidden="true"></span>
                                </button>
                                <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                  <span class="far fa-star" aria-hidden="true"></span>
                                </button>
                                <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                  <span class="far fa-star" aria-hidden="true"></span>
                                </button>
                                <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                                  <span class="far fa-star" aria-hidden="true"></span>
                                </button>
                                <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                                  <span class="far fa-star" aria-hidden="true"></span>
                                </button>
                            </div>
                            <div class="review-block-title">this was nice in buy</div>
                            <div class="review-block-description">this was nice in buy. this was nice in buy. this was nice in buy. this was nice in buy this was nice in buy this was nice in buy this was nice in buy this was nice in buy</div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="http://dummyimage.com/60x60/666/ffffff&text=No+Image" class="img-rounded">
                            <div class="review-block-name"><a href="#">nktailor</a></div>
                            <div class="review-block-date">January 29, 2016<br/>1 day ago</div>
                        </div>
                        <div class="col-sm-9">
                            <div class="review-block-rate">
                                <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                  <span class="far fa-star" aria-hidden="true"></span>
                                </button>
                                <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                  <span class="far fa-star" aria-hidden="true"></span>
                                </button>
                                <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                  <span class="far fa-star" aria-hidden="true"></span>
                                </button>
                                <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                                  <span class="far fa-star" aria-hidden="true"></span>
                                </button>
                                <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                                  <span class="far fa-star" aria-hidden="true"></span>
                                </button>
                            </div>
                            <div class="review-block-title">this was nice in buy</div>
                            <div class="review-block-description">this was nice in buy. this was nice in buy. this was nice in buy. this was nice in buy this was nice in buy this was nice in buy this was nice in buy this was nice in buy</div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="http://dummyimage.com/60x60/666/ffffff&text=No+Image" class="img-rounded">
                            <div class="review-block-name"><a href="#">nktailor</a></div>
                            <div class="review-block-date">January 29, 2016<br/>1 day ago</div>
                        </div>
                        <div class="col-sm-9">
                            <div class="review-block-rate">
                                <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                  <span class="far fa-star" aria-hidden="true"></span>
                                </button>
                                <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                  <span class="far fa-star" aria-hidden="true"></span>
                                </button>
                                <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                  <span class="far fa-star" aria-hidden="true"></span>
                                </button>
                                <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                                  <span class="far fa-star" aria-hidden="true"></span>
                                </button>
                                <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                                  <span class="far fa-star" aria-hidden="true"></span>
                                </button>
                            </div>
                            <div class="review-block-title">this was nice in buy</div>
                            <div class="review-block-description">this was nice in buy. this was nice in buy. this was nice in buy. this was nice in buy this was nice in buy this was nice in buy this was nice in buy this was nice in buy</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div> <!-- /container -->













@endsection
@section('header')
    @component('components.header')
    @endcomponent
@endsection
