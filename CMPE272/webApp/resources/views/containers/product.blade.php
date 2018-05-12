@extends('layouts.app')
@section('content')
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">{{ $product["name"] }}</h1>
<!--         <p class="lead">{{ $product["description"] }}</p>
 -->    </div>
    <div id="card-decks" class="container">
        <div class="card box-shadow" style="min-width: 18rem;" >
            <img class="card-img-top" src="{{ $product['baseurl'] }}/{{ $product['img'] }}" alt="Card image cap">
            <div class="card-body">
                <h3 class="card-title pricing-card-title">{{ $product["name"] }}</h3>
                <p class="card-text">{{ $product["description"] }}</p>

            </div>
        </div>
    </div>
@guest
<br />
@else
    <div class="container">
        <div class="row" style="margin-top:40px;">
            <div class="col-md-6">
            <div class="well well-sm">
                <div class="row" id="post-review-box" >
                    <div class="col-md-12">
                        <form id="reviewForm" onsubmit="return false">
                            <div class="form-group">
                                <input id="ratings-hidden" name="product_id" type="hidden" value="{{$product['id']}}">
                                <input id="ratings-hidden" name="user_id" type="hidden" value="{{Auth::id()}}">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control animated" cols="50" id="new-review" name="review" placeholder="Enter your review here..." rows="5"></textarea>
                            </div>
                            <div class="text-right">
                                <fieldset class="rating">
                                    <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="Rocks!">5 stars</label>
                                    <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="Pretty good">4 stars</label>
                                    <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="Meh">3 stars</label>
                                    <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="Kinda bad">2 stars</label>
                                    <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="Sucks big time">1 star</label>
                                </fieldset>
                                <a class="btn btn-danger btn-sm" href="#" id="close-review-box" style="display:none; margin-right: 10px;">
                                <span class="far fa-remove"></span>Cancel</a>
                                <button class="btn btn-success mb-4" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> 
             
            </div>
        </div>
    </div>
@endguest

    <div class="container">

        <div class="row">
            <div class="col-sm-7">
                <div class="rating-block">
                    <h4>Average user rating</h4>
                    <h2 class="bold padding-bottom-7">{{$product['average']}} <small>/ 5</small></h2>
                    <button type="button" class="btn btn-default btn-grey btn-sm {{ $product['average']>0?'btn-warning':'' }}" aria-label="Left Align">
                      <span class="far fa-star" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-default btn-grey btn-sm {{ $product['average']>1?'btn-warning':'' }}" aria-label="Left Align">
                      <span class="far fa-star" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-default btn-grey btn-sm {{ $product['average']>2?'btn-warning':'' }}" aria-label="Left Align">
                      <span class="far fa-star" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-default btn-grey btn-sm {{ $product['average']>3?'btn-warning':'' }}" aria-label="Left Align">
                      <span class="far fa-star" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-default btn-grey btn-sm {{ $product['average']>4?'btn-warning':'' }}" aria-label="Left Align">
                      <span class="far fa-star" aria-hidden="true"></span>
                    </button>
                </div>
            </div>         
        </div>   


        <div class="row">
            <div class="col-sm-10">
                <hr/>
                <div class="review-block">
                    @foreach ($product['reviews'] as $review)
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="http://via.placeholder.com/70x70" class="img-rounded">
                                <div class="review-block-name"><a href="#">{{ $review['user']['name'] }}</a></div>
                                <div class="review-block-date">{{ $review['created_at'] }}</div>
                            </div>
                            <div class="col-sm-9">
                                <div class="review-block-rate">
                                    <button type="button" class="btn btn-default btn-grey btn-xs {{ $review['rating']>0?'btn-warning':'' }}" aria-label="Left Align">
                                      <span class="far fa-star" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-default btn-grey btn-xs {{ $review['rating']>1?'btn-warning':'' }}" aria-label="Left Align">
                                      <span class="far fa-star" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-default btn-grey btn-xs {{ $review['rating']>2?'btn-warning':'' }}" aria-label="Left Align">
                                      <span class="far fa-star" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-default btn-grey btn-xs {{ $review['rating']>3?'btn-warning':'' }}" aria-label="Left Align">
                                      <span class="far fa-star" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-default btn-grey btn-xs {{ $review['rating']>4?'btn-warning':'' }}" aria-label="Left Align">
                                      <span class="far fa-star" aria-hidden="true"></span>
                                    </button>
                                </div>
                                <div class="review-block-description">{{ $review['review'] }}</div>
                            </div>
                        </div>
                        <hr/>
                    @endforeach 
                </div>
            </div>
        </div>
        
    </div> <!-- /container -->





        <script>
            var $form =  $("#reviewForm");
            //==========    Sign in
            $form.submit(function(e) {
                var data = $form.serializeArray().reduce(function(acc,curr){acc[curr.name] = curr.value; return acc;},{});
                console.log("sdfsdf: ",data)
                axios.post('/api/products/{{ $product["id"] }}/reviews', data)
                        .then(function (response) {
                            location.reload && location.reload();
                        })
                        .catch(function (error) {
                            console.log(error);
                        });

                e.preventDefault(); // avoid to execute the actual submit of the form.
            });
            
        </script>







@endsection
@section('header')
    @component('components.header')
    @endcomponent
@endsection
