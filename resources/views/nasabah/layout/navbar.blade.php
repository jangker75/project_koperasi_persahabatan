<!-- Navbar -->
<nav class="navbar navbar-nasabah p-2">
    <div class="w-100 d-flex justify-content-between align-items-center mb-3">
        <div class="logo">
            <a href="" class="d-flex align-items-center">
                <img src="{{ asset('assets/images/logo/logo3.png') }}" alt="" height="48">
            </a>
        </div>
        <div class="col-6 d-flex justify-content-end">
            {{-- <form action="{{ route('admin.logout') }}" method="post">
            @csrf
            <button class="btn btn-outline-light text-light" type="submit">Logout</button>
            </form> --}}
            {{-- <button class="btn btn-outline-light text-light" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasAccount" aria-controls="offcanvasAccount"><i
                    class="fa fa-shopping-basket"></i></button> --}}
            <button type="button" class="btn btn-sm text-white border border-white position-relative" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasAccount" aria-controls="offcanvasAccount">
                <i class="fa fa-shopping-basket"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="totalItem">0
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
                    <ul class="nav flex-column" id="ulCartList">
                        <li>
                            <div class="w-100 h-100 d-flex align-items-center">
                                <div class="p-4">
                                  <img src="{{ asset('storage/default-image.jpg') }}" alt="" height="48">
                                </div>
                                <div class="text ms-3 h-100 flex-grow-1">
                                    <span>Product 1</span><br>
                                    <small class="text-danger">Rp 9000</small><br>
                                    <span class="input-group" style="max-width:120px;">
                                        <span class="input-group-text"><i class="fa fa-angle-left"></i></span>
                                        <input type="text" class="form-control br-0" value="4" style="max-width:48px;">
                                        <span class="input-group-text"><i class="fa fa-angle-right"></i></span>
                                    </span>
                                </div>
                                <div class="text ms-3">
                                    <i class="fe fe-x"></i>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="offcanvas-footer p-4">
                  <div class="w-100 btn btn-warning fw-bold">Checkout</div>
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
    </div>
    @endif
</nav>

<script>
    function refreshCuantityCart() {
        let cart = JSON.parse(sessionStorage.getItem("cart"))
        let count = 0;

        cart.forEach(element => {
            count += element.qty
        });

        $("#totalItem").html(count)
        $("#ulCartList").html("")

        cart.forEach(element => {
            $("#ulCartList").append(`
              <li class="border-bottom py-3">
                  <div class="w-100 h-100 d-flex align-items-center justify-content-between">
                      <div class="p-4">
                        <img src="`+element.cover+`" alt="" height="48">
                      </div>
                      <div class="text ms-3 h-100 flex-grow-1">
                          <span>`+element.title+`</span><br>
                          <div class="text-danger">`+element.price+`</div>
                          <div class="handle-counter justify-content-start mt-2" id="sku` + element.sku + `">
                              <button type="button" class="counter-minus counter btn btn-white lh-2 shadow-none">
                                  <i class="fa fa-minus text-muted"></i>
                              </button>
                              <input type="text" value="` + element.qty + `" class="qty">
                              <button type="button" class="counter-plus counter btn btn-white lh-2 shadow-none">
                                  <i class="fa fa-plus text-muted"></i>
                              </button>
                          </div>
                      </div>
                      <div class="text ms-3">
                          <i class="fe fe-x"></i>
                      </div>
                  </div>
              </li>
            `);
        });

        console.log(count)
        console.log(cart)
    }

    

</script>
<!-- Navbar -->
