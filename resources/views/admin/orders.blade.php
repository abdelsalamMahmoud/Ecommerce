<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    @include('admin.css')
    <style>
        .title_h1{
            text-align: center;
            font-size: 25px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container-scroller">
    <div class="row p-0 m-0 proBanner" id="proBanner">
        <div class="col-md-12 p-0 m-0">
            <div class="card-body card-body-padding d-flex align-items-center justify-content-between">
                <div class="ps-lg-1">
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0 font-weight-medium me-3 buy-now-text">Free 24/7 customer support, updates, and more with this template!</p>
                        <a href="https://www.bootstrapdash.com/product/corona-free/?utm_source=organic&utm_medium=banner&utm_campaign=buynow_demo" target="_blank" class="btn me-2 buy-now-btn border-0">Get Pro</a>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <a href="https://www.bootstrapdash.com/product/corona-free/"><i class="mdi mdi-home me-3 text-white"></i></a>
                    <button id="bannerClose" class="btn border-0 p-0">
                        <i class="mdi mdi-close text-white me-0"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- partial:partials/_sidebar.html -->
    @include('admin.sidebar')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        @include('admin.header')

        <div class="main-panel">
            <div class="content-wrapper">
                <h1 class="title_h1 pb-4">All Orders</h1>
                <div class="pb-4 d-flex justify-content-center align-items-center">
                    <form action="{{route('search')}}" method="get">
                        @csrf
                        <input type="text" name="search" style="width: 250px; height: 40px; color: black" class="rounded" placeholder="Search For Something">
                        <input type="submit" value="Search" class="btn btn-outline-primary">
                    </form>
                </div>

                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Address</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Delivery Status</th>
                        <th scope="col">Image</th>
                        <th scope="col">Deliver</th>
                        <th scope="col">Print PDF</th>
                        <th scope="col">Send Email</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($orders as $order)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$order->user->name}}</td>
                                <td>{{$order->user->email}}</td>
                                <td>{{$order->user->address}}</td>
                                <td>{{$order->user->phone}}</td>
                                <td>{{$order->product->title}}</td>
                                <td>{{$order->quantity}}</td>
                                <td>{{$order->price}}</td>
                                <td>{{$order->payment_status}}</td>
                                <td>{{$order->delivery_status}}</td>
                                <td><img src="products/{{$order->product->image}}" alt=""></td>
                                <td>
                                @if($order->delivery_status == 'delivered')
                                    <p style="color:green;">delivered</p>
                                @else
                                    <a href="{{route('deliver',$order->id)}}" class="btn btn-primary" onclick="return confirm('Are You Sure That This Order Is Delivered ?')">Deliver</a>
                                @endif
                                </td>
                                <td><a href="{{route('print.pdf',$order->id)}}" class="btn btn-secondary">Download</a></td>
                                <td><a href="{{route('send.email',$order->user->id)}}" class="btn btn-info">Send Email</a></td>
                            </tr>

                            @empty
                                <tr>
                                    <td colspan="16">
                                        No Data Found
                                    </td>
                                </tr>
                    @endforelse

                    </tbody>
                </table>


            </div>
        </div>

    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
@include('admin.script')
<!-- End custom js for this page -->
</body>
</html>

