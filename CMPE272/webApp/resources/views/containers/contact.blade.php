@extends('layouts.app')
@section('header')
    @component('components.header')
    @endcomponent
@endsection
@section('content')
    <br />

    <div class="container">
        <div class="row">
            @foreach ($contacts as $line)
                <div class="col-md-6">
                    <div class="card" >
                        <img class="card-img-top" style="max-height: 400px;" src="{{ data_get($line, 'img','http://via.placeholder.com/1024x860') }}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{ data_get($line, 'full_name') }}</h5>
                            <p class="card-text">{{ data_get($line, 'title') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <br />
        <div class="row">
            <div class="col-md-6">
                <div class="well well-sm">
                    <form class="" method="post" onsubmit="return false">
                        <fieldset>
                            <legend class="text-center header">Contact us</legend>
                            <div class="form-group">
                                <div class="col-md-10 offset-md-1">
                                    <input id="fname" name="name" type="text" placeholder="First Name" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-10 offset-md-1">
                                    <input id="lname" name="name" type="text" placeholder="Last Name" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-10 offset-md-1">
                                    <input id="email" name="email" type="text" placeholder="Email Address" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-10 offset-md-1">
                                    <input id="phone" name="phone" type="text" placeholder="Phone" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-10 offset-md-1">
                                    <textarea class="form-control" id="message" name="message" placeholder="Enter your massage for us here. We will get back to you within 2 business days." rows="7"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <div class="card ">
                        <div class="text-center card-header">Our Office</div>
                        <div class="card-block text-center">
                            <h4>Address</h4>
                            <div>
                                @foreach ($contents as $line)
                                    {{$line}}<br />
                                @endforeach
                            </div>
                            <hr />
                            <div id="map1" class="map">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="http://maps.google.com/maps/api/js?sensor=false"></script>

    <script type="text/javascript">

        $(function() {
            function init_map1() {
                var myLocation = new google.maps.LatLng(37.335662, -121.880645);
                var mapOptions = {
                    center: myLocation,
                    zoom: 16
                };
                var marker = new google.maps.Marker({
                    position: myLocation,
                    title: "Property Location"
                });
                var map = new google.maps.Map(document.getElementById("map1"),
                        mapOptions);
                marker.setMap(map);
            }
            init_map1();
        });

    </script>

    <style>
        .map {
            min-width: 300px;
            min-height: 300px;
            width: 100%;
            height: 100%;
        }

    </style>

@endsection



