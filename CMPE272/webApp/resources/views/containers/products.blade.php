@extends('layouts.app')
@section('content')


<div class="container-fluid">

    

<div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link" href="/products?products=products"> View All </a>
                <a class="nav-link" href="/products?products=top_rated"> Top Rated </a>
                <a class="nav-link" href="/products?products=top_visited"> Top Visted </a>
              </li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Companies</span>
            </h6>
            <ul class="nav flex-column mb-2">
                @foreach ($companies as $company)
                    <li class="nav-item">
                        <a class="nav-link" href="/products?products=company_{{$company['company_id']}}">
                          <i class="far fa-building"></i>
                          {{$company['name']}}
                        </a>
                    </li>
                @endforeach
            </ul>
          </div>
        </nav>
        <div class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="card-group">
                @foreach ($products as $product)
                    <div class="card box-shadow" style="min-width: 18rem;max-width: 50rem;margin:5px;">
                        <img class="card-img-top" src="http://via.placeholder.com/3000x3000" alt="Card image cap">
                        <div class="card-body">
                          <a href="{{ $product["url"] }}" class="card-title">{{ $product["name"] }}</a>
                          <p class="card-text">{{ $product["description"] }}</p>
                        </div>
                        <div class="card-footer">
                          <small class="text-muted">Last updated 3 mins ago</small>
                        </div>
                    </div>
                @endforeach
            </div>
            
                
            
        </div>
      </div>




<!-- end of left sidebar -->

    <div class="card-deck mb-3 text-center">
        {{-- @foreach ($products as $product)
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">{{ $product["header"] }}</h4>
                </div>
                <img class="card-img-top" style="max-height: 250px;" src="{{$product['img']}}" alt="Card image cap">
                <div class="card-body">
                    <h3 class="card-title pricing-card-title">Starting at {{ $product["price"] }}</h3>
                    <ul class="list-unstyled mt-3 mb-4">

                    </ul>
                </div>
            </div>
        @endforeach --}}
    </div>
</div>

@endsection
@section('header')
    @component('components.header')
    @endcomponent
@endsection



