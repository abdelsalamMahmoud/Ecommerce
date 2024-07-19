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

                <h1 style="font-size: 25px ; text-align: center">Send Email To {{$user->email}}</h1>

                <div class="center">

                    <form action="{{route('send.user.email',$user->id)}}" method="POST">
                        @csrf
                        <div class="pb-3">
                            <label for="greeting">Email Greeting</label>
                            <input type="text" class="color rounded" id="greeting" placeholder="Enter Email Greeting" name="greeting" required>
                        </div>

                        <div class="pb-3">
                            <label for="firstline">Email First Line</label>
                            <input type="text" class="color rounded" id="firstline" placeholder="Enter Email First Line" name="firstline" required>
                        </div>

                        <div class="pb-3">
                            <label for="body">Email Body</label>
                            <input type="text" class="color rounded" id="body" placeholder="Enter Email Body" name="body" required>
                        </div>

                        <div class="pb-3">
                            <label for="button">Email Button Name</label>
                            <input type="text" class="color rounded" id="button" placeholder="Enter Button Name" name="button" required>
                        </div>

                        <div class="pb-3">
                            <label for="url">Email Url</label>
                            <input type="text" class="color rounded" id="url" placeholder="Enter Email Url" name="url" required>
                        </div>

                        <div class="pb-3">
                            <label for="lastline">Email Last Line</label>
                            <input type="text" class="color rounded" id="lastline" placeholder="Enter Email Last Line" name="lastline" required>
                        </div>

                        <input type="submit"  class="btn btn-primary submit_button rounded" value="Send">

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

