<!DOCTYPE html>
<html>
<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}" type="">
    <title>Famms - Fashion HTML Template</title>
    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{asset('home/css/bootstrap.css')}}" />
    <!-- font awesome style -->
    <link href="{{asset('home/css/font-awesome.min.css')}}" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="{{asset('home/css/style.css')}}" rel="stylesheet" />
    <!-- responsive style -->
    <link href="{{asset('home/css/responsive.css')}}" rel="stylesheet" />
</head>
<body>
@include('sweetalert::alert')
<div class="hero_area">
    <!-- header section strats -->
    @include('home.header')
    <!-- end header section -->

    <div class="container pb-4 pt-4">
        <div class="row justify-content-center">
            <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="text-center">
                    <div class="img-box">
                        <img src="/products/{{$product->image}}" alt="" style="max-width: 100%; height: auto;">
                    </div>
                    <div class="detail-box mt-3">
                        <h5>{{$product->title}}</h5>
                        <h6 class="d-inline">price:</h6>
                        @if($product->discount_price)
                            <h6 class="mb-0 d-inline">
                            <span class="text-primary font-weight-bold">
                                ${{$product->discount_price}}
                            </span>
                                <span class="text-muted" style="text-decoration: line-through;">
                                ${{$product->price}}
                            </span>
                            </h6>
                        @else
                            <h6 class="mb-0 d-inline">
                            <span class="text-primary font-weight-bold">
                                ${{$product->price}}
                            </span>
                            </h6>
                        @endif

                        <h6 class="pt-2">Category : {{$product->category->name}}</h6>
                        <h6>Description : {{$product->description}}</h6>
                        <h6 class="pb-4">Quantity : {{$product->quantity}}</h6>

                        <form action="{{route('add.to.cart',$product->id)}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="number" name="quantity" value="1" min="1" style="width: 100px" class="rounded">
                                </div>

                                <div class="col-md-4">
                                    <input type="submit" value="Add To Card" class="rounded">
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- footer start -->
@include('home.footer')
<!-- footer end -->
<div class="cpy_">
    <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>

        Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>

    </p>
</div>
<!-- jQery -->
<script src="home/js/jquery-3.4.1.min.js"></script>
<!-- popper js -->
<script src="home/js/popper.min.js"></script>
<!-- bootstrap js -->
<script src="home/js/bootstrap.js"></script>
<!-- custom js -->
<script src="home/js/custom.js"></script>
</body>
</html>

