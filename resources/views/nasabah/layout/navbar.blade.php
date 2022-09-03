<!-- Navbar -->
<nav class="navbar navbar-nasabah p-2">
    <div class="w-100 d-flex justify-content-between align-items-center mb-3">
        <div class="logo">
            <a href="" class="d-flex align-items-center">
                <img src="{{ asset('assets/images/logo/logo3.png') }}" alt="" height="48">
            </a>
        </div>
        <div class="col-6 d-flex justify-content-end">
            <button type="button" class="btn btn-sm text-white border border-white position-relative"
                data-bs-toggle="offcanvas" data-bs-target="#offcanvasAccount" aria-controls="offcanvasAccount">
                <i class="fa fa-shopping-basket"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                    id="totalItem">0
                    <span class="visually-hidden">Total Item</span>
                </span>
            </button>
            <div class="offcanvas offcanvas-end text-dark" tabindex="-1" id="offcanvasAccount"
                aria-labelledby="offcanvasAccountLabel">
                <div class="offcanvas-header">
                    <h5 id="offcanvasAccountLabel" class="text-dark">Koperasi Karya Husada</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close">&times;</button>
                </div>
                <div class="offcanvas-body">
                    <div class="fw-bold pb-4">Detail Keranjang</div>
                    <ul class="nav border border-primary" id="ulCartList" style="height: 70vh; overflow-y: scroll;">
                    </ul>
                </div>
                <div class="offcanvas-footer p-4">
                    <a href="{{ route('nasabah.product.checkout') }}" class="w-100 btn btn-warning fw-bold h5 py-3" id="totalPriceCart"></a>
                </div>
            </div>

        </div>
    </div>
    @if (Request::segment(1) == null || Request::segment(1) == 'product')

    <div class="p-2 w-100 mt-2">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Cari Produk.." aria-label="Cari Produk.."
                aria-describedby="basic-addon2">
            <span class="input-group-text" id="basic-addon2"><i class="fe fe-search"></i></span>
        </div>
        <div class="position-relative py-3 d-none">
            <div class="card position-absolute border border-primary" style="min-height: 50vh; z-index:99;"></div>
        </div>
    </div>
    @endif
</nav>


<!-- Navbar -->
