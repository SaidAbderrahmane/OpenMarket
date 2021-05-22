<!-- PRODUCT-->
<div class="col-xl-3 col-lg-4 col-sm-6">
    <div class="product text-center">
        <div class="position-relative mb-3 p-5">
            <div class="badge text-white badge-"></div><a class="d-block" href="/products/{{ $product->slug }}"><img class="img-fluid w-100" src="https://via.placeholder.com/500x750" alt="..."></a>
            <div class="product-overlay">
                <ul class="mb-0 list-inline">
                    <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-outline-dark" href="#"><i class="far fa-heart"></i></a></li>
                    <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-dark" href=" {{ route('cart') }} ">Add to cart</a></li>
                    <li class="list-inline-item mr-0"><a class="btn btn-sm btn-outline-dark" onclick="" href="#productView" data-toggle="modal"><i class="fas fa-expand"></i></a></li>
                </ul>
            </div>
        </div>
        <h6> <a class="reset-anchor" href="/products/{{ $product->slug }}">{{ $product->title }}</a></h6>
        <p class="medium text-muted">{{ $product->subtitle}}</p>
        <p class="small text-muted">{{ $product->getPrice() }}</p>
    </div>
</div>