<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Pdf</title>

    <style>
        body {
            padding: 20px;
            font-family: 'Poppins', sans-serif;s
        }
        h1, h3 {
            margin-bottom: 15px;
        }
        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="mt-4 mb-4">Order Details</h1>

    <div class="row">
        <div class="col-md-6">
            <h3>Customer Information</h3>
            <ul class="list-unstyled">
                <li><strong>Name:</strong> {{$order->user->name}}</li>
                <li><strong>Email:</strong> {{$order->user->email}}</li>
                <li><strong>Phone:</strong> {{$order->user->phone}}</li>
                <li><strong>Address:</strong> {{$order->user->address}}</li>
            </ul>
        </div>
        <div class="col-md-6">
            <h3>Product Information</h3>
            <ul class="list-unstyled">
                <li><strong>Name:</strong> {{$order->product->title}}</li>
                <li><strong>Quantity:</strong> {{$order->quantity}}</li>
                <li><strong>Price:</strong> {{$order->price}}</li>
                <li><strong>Payment Status:</strong> {{$order->payment_status}}</li>
            </ul>
            <div class="mt-4">
                <strong>Product Image:</strong><br>
                <img src="products/{{$order->product->image}}" alt="{{$order->product->title}}" class="img-fluid mt-2">
            </div>
        </div>
    </div>
</div>
</body>
</html>
