<!-- PRODUCT-->
<div class="col-lg-4 col-sm-6">
    <div class="product text-center">
        <div class="mb-3 position-relative">
            <div class="row justify-content-center">
                <p class="small text-muted">
                    @foreach ($product->categories as $category)
                    {{ $category->name }}
                    @endforeach
                </p>
            </div>
            <div class="badge text-white badge-"></div><a class="d-block" href="/products/{{ $product->slug }}"><img class="img-fluid w-100" src="{{ asset('storage/'.$product->image) }}" alt="..."></a>
            <div class="product-overlay">
                <ul class="mb-0 list-inline">
                    <li class="list-inline-item m-0 p-0">
                        <form action="{{ route('wishlist.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-sm btn-outline-dark"><i class="far fa-heart"></i></button>
                        </form>
                    </li>
                    <li class="list-inline-item m-0 p-0">
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="qty" value="1">
                            <button type="submit" class="btn btn-sm btn-dark">Add to cart</button>
                        </form>
                    </li>
                    <li class="list-inline-item mr-0"><a class="btn btn-sm btn-outline-dark" onclick="" href="#productView" data-toggle="modal"><i class="fas fa-expand"></i></a></li>
                </ul>
            </div>
        </div>
        <h6> <a class="reset-anchor" href="/products/{{ $product->slug }}">{{ $product->title }}</a></h6>
        <p class="medium text-muted">{{ $product->subtitle}}</p>
        <p class="small text-muted">{{ $product->getPrice() }}</p>
    </div>
</div>