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
                <th scope="col">Payment_status</th>
                <th scope="col">Delivery Status</th>
                <th scope="col">Image</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>

            @foreach($user->orders as $order)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td>{{$order->title}}</td>
                    <td>{{ $order->pivot->quantity }}</td>
                    <td>${{ $order->pivot->price }}</td>
                    <td>{{ $order->pivot->payment_status }}</td>
                    <td>{{ $order->pivot->delivery_status }}</td>
                    <td>
                        <img src="/products/{{$order->image}}" alt="" style="max-width: 60px; border-radius: 50%">
                    </td>
                    <td>
                        @if($order->pivot->delivery_status == 'processing')
                            <a onclick="return confirm('Are You Sure That You Want To Cancel This Order ?')" href="{{route('cancel.order',$order->pivot->id)}}" class="btn btn-danger">Cancel</a>

                        @else
                            <p style="color: #0a58ca">Not Allowed</p>
                        @endif

                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>

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

