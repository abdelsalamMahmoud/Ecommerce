<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    @include('admin.css')
    <style>
        .center{
            text-align: center;
            padding-top: 40px;
        }
        .center h1 {
            font-size: 40px;
            padding-bottom: 40px;
        }
        .color{
            color: black;
        }
        .color_image{
            color: white;
        }
        label{
            display: inline-block;
            width: 200px;
        }
        input{
            width: 400px;
        }
        select{
            width: 400px;
        }
        .submit_button{
            width: 200px;
            font-weight: bold;
            height: 40px;
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
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

                <div class="center">
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

                    <h1>Edit Product</h1>

                    <form action="{{route('product.update',$product->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="pb-3">
                            <label for="title">Product Name</label>
                            <input type="text" class="color rounded" id="title" placeholder="Enter Product Name" name="title" value="{{$product->title}}" required>
                        </div>

                        <div class="pb-3">
                            <label for="description">Product Description</label>
                            <input type="text" class="color rounded" id="description" placeholder="Enter Product Description" name="description" value="{{$product->description}}" required>
                        </div>

                        <div class="pb-3">
                            <label for="price">Product Price</label>
                            <input type="number" class="color rounded" id="price" placeholder="Enter Product Price" name="price" value="{{$product->price}}" required>
                        </div>

                        <div class="pb-3">
                            <label for="discount_price">Discount Price</label>
                            <input type="number"  min="0" class="color rounded" id="discount_price" placeholder="Enter Discount Price" value="{{$product->discount_price}}" name="discount_price">
                        </div>

                        <div class="pb-3">
                            <label for="quantity">Product Quantity</label>
                            <input type="number"  min="0" class="color rounded" id="quantity" placeholder="Enter Product Quantity" value="{{$product->quantity}}" name="quantity" required>
                        </div>

                        <div class="pb-3">
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <label for="image">Current Product Image</label>
                                    <img src="/products/{{$product->image}}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>

                        <div class="pb-3">
                            <label for="image">Change Product Image</label>
                            <input type="file"  class="color_image rounded" id="image" name="image"  value="{{$product->image}}">
                        </div>

                        <div class="pb-3">
                            <label for="category">Product Category</label>
                            <select class="color rounded" id="category" name="category" required>
                                <option value="{{$product->category->id}}" selected>{{$product->category->name}}</option>
                                @foreach($categories as $category)
                                    <option value="{{$category['id']}}">{{$category['name']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <input type="submit"  class="btn btn-primary submit_button rounded" value="Edit Product">

                    </form>
                </div>
            </div>
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
@include('admin.script')
<!-- End custom js for this page -->
</body>
</html>


