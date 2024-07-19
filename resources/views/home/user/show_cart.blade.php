<!DOCTYPE html>
<html>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="images/favicon.png" type="">
    <title>Famms - Fashion HTML Template</title>
    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="home/css/bootstrap.css" />
    <!-- font awesome style -->
    <link href="home/css/font-awesome.min.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="home/css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="home/css/responsive.css" rel="stylesheet" />
    <style>
        .total_price {
           font-size: 40px;
            font-family: 'Poppins', sans-serif;
        }
        .pro{
            font-size: 25px;
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>
@include('sweetalert::alert')
<div class="hero_area">
    <!-- header section starts -->
    @include('home.header')
    <!-- end header section -->

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            @if (is_array(session('error')))
                <ul>
                    @foreach (session('error') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @else
                {{ session('error') }}
            @endif
        </div>
    @endif

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

<div class="pt-4 pb-4">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Product Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Price</th>
            <th scope="col">Image</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $totalprice = 0 ?>

        @foreach($user->carts as $cart)
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$cart->title}}</td>
                <td>{{ $cart->pivot->quantity }}</td>
                <td>${{ $cart->pivot->price }}</td>
                <td>
                    <img src="/products/{{$cart->image}}" alt="" style="max-width: 60px; border-radius: 50%">
                </td>
                <td><a onclick="cofirmation(event)" href="{{route('remove.from.cart',$cart->pivot->id)}}" class="btn btn-danger">Remove</a></td>
            </tr>

             <?php $totalprice = $totalprice + $cart->pivot->price ?>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center pb-4">
        <h1 class="total_price">
            Total Price Of Your Cart Is : ${{$totalprice}}
        </h1>
    </div>

    <div class="d-flex justify-content-center flex-column align-items-center pb-4">
        <h1 class="mb-4 pro">Proceed To Order</h1>
        <a href="{{route('order.cash')}}" class="btn btn-primary mb-2">Cash On Delivery</a>
        <a href="{{route('stripe',$totalprice)}}" class="btn btn-primary">Pay Using Card</a>
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

    <script>
        function cofirmation(ev)
        {
            ev.preventDefault();
            var urlToRedirect = ev.currentTarget.getAttribute('href');
            console.log(urlToRedirect);
            swal({
                title : "Are You Sure That You Want To Remove This Product From The Cart",
                text : "You Will Not Be Able To Revert This !",
                icon : "warning",
                buttons : true,
                dangerMode: true,
            }).then((willCancel)=>{
                if (willCancel){
                    window.location.href = urlToRedirect;
                }
            });
        }
    </script>
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

