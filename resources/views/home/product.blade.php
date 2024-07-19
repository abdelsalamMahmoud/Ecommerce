<section class="product_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>
                Our <span>products</span>
            </h2>

            <div>
                <form action="{{route('product.search')}}" method="GET">
                    @csrf
                    <input type="text" name="search" placeholder="Search For Product" class="rounded" style="width: 300px ; height: 40px;">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
        <div class="row">

            @foreach($products as $product)
                <div class="col-sm-6 col-md-4 col-lg-4">
                    <div class="box">
                        <div class="option_container">
                            <div class="options">
                                <a href="{{ route('product.details', $product->id) }}" class="option1">
                                    Product Details
                                </a>
                                @if($product->quantity > 0)
                                    <form action="{{ route('add.to.cart', $product->id) }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="number" name="quantity" value="1" min="1" style="width: 100px" class="rounded">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="submit" value="Add To Cart" class="rounded">
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <div class="row">
                                        <div class="col-md-12 text-center" style="opacity: 0.5;">
                                            Not Available
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="img-box">
                            <img src="products/{{ $product->image }}" alt="">
                        </div>
                        <div class="detail-box">
                            <h5>{{ $product->title }}</h5>
                            @if($product->discount_price)
                                <h6>${{ $product->discount_price }}</h6>
                                <h6 style="text-decoration: line-through;">${{ $product->price }}</h6>
                            @else
                                <h6>${{ $product->price }}</h6>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row pt-4">
            <div class="col d-flex justify-content-center">
                {{$products->links('pagination::bootstrap-5')}}
            </div>
        </div>
    </div>
</section>
