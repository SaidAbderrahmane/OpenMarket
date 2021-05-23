<section class="py-5">
    <header>
    <p class="small text-muted small text-uppercase mb-1">Made the hard way</p>
    <h2 class="h5 text-uppercase mb-4">Top trending products</h2>
    </header>
    <div class="row">
        @for ($i=1; $i<=8; $i++)
       <!-- PRODUCT-->
<div class="col-xl-3 col-lg-4 col-sm-6">
    <div class="product text-center">
        <div class="position-relative mb-3 p-5">
            <div class="badge text-white badge-"></div><a class="d-block" href="#!"><img class="img-fluid w-100" src="https://via.placeholder.com/500x750" alt="..."></a>
            <div class="product-overlay">
                <ul class="mb-0 list-inline">
                    <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-outline-dark" href="#"><i class="far fa-heart"></i></a></li>
                    <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-dark" href=" {{ route('cart') }} ">Add to cart</a></li>
                    <li class="list-inline-item mr-0"><a class="btn btn-sm btn-outline-dark" href="#productView" data-toggle="modal"><i class="fas fa-expand"></i></a></li>
                </ul>
            </div>
        </div>
        <h6> <a class="reset-anchor" href="#">title</a></h6>
        <p class="medium text-muted">apsum-larauij onwoqmd</p>
        <p class="small text-muted"> 250$</p>
    </div>
</div>
        @endfor
</section>