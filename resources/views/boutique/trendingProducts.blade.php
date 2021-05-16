<section class="py-5">
    <header>
    <p class="small text-muted small text-uppercase mb-1">Made the hard way</p>
    <h2 class="h5 text-uppercase mb-4">Top trending products</h2>
    </header>
    <div class="row">
        @for ($i=1; $i<=8; $i++)
        @include('boutique.product')
        @endfor
</section>