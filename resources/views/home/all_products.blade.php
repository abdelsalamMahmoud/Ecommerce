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

<!-- product section -->
@include('home.product')
<!-- end product section -->

{{--    comment and reply system starts here--}}

<div class="row justify-content-center pb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h1 class="text-center" style="font-size: 30px; font-family: 'Poppins', sans-serif; ">Comments</h1>
            </div>
            <div class="card-body">
                <form id="commentForm" action="{{route('comment.add')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <textarea class="form-control" rows="5" placeholder="Write your comment here" name="comment"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Post Comment</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div style="padding-left: 18%" class="pb-4">
    <h1 style="font-size: 20px;font-family: 'Poppins', sans-serif;" class="pb-4">All Comments</h1>

    @foreach($comments as $comment)
        <div class="pb-4">
            <b>{{$comment->user->name}}</b>
            <p class="pb-2">{{$comment->comment}}</p>
            <a href="javascript::void(0);" class="btn btn-secondary" onclick="reply(this)" data-commentId="{{$comment->id}}">Reply</a>
            <div class="pl-3 pt-4 pb-3">
                @foreach($comment->replies as $reply)
                    <b>{{$reply->user->name}}</b>
                    <p>{{$reply->reply}}</p>
                @endforeach
            </div>
        </div>
    @endforeach

    <div style="display: none" class="replyDiv pt-2">
        <form action="{{route('reply.add')}}" method="POST">
            @csrf
            <input type="text" name="commentId" id="commentId" hidden>
            <textarea style="height: 100px ; width: 500px;" placeholder="Write The Reply" name="reply"></textarea>
            <br>
            <button type="submit" class="btn btn-primary">Reply</button>
            <a href="javascript::void(0);" class="btn" onclick="reply_close(this)">Close</a>
        </form>
    </div>

</div>

{{--    comment and reply system ends here--}}

<div class="cpy_">
    <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>

        Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>

    </p>
</div>
<script type="text/javascript">
    function reply(caller)
    {
        document.getElementById('commentId').value = $(caller).attr('data-commentId')
        $('.replyDiv').insertAfter($(caller)).show();
    }

    function reply_close(caller) {
        $('.replyDiv').hide();
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        var scrollpos = localStorage.getItem('scrollpos');
        if (scrollpos) window.scrollTo(0, scrollpos);
    });

    window.onbeforeunload = function(e) {
        localStorage.setItem('scrollpos', window.scrollY);
    };
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
