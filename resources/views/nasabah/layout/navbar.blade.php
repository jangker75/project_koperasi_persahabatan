<!-- Navbar -->
<nav class="navbar navbar-nasabah p-2">
    <div class="w-100 d-flex justify-content-between align-items-center">
        <div class="logo">
            <a href="" class="d-flex align-items-center">
                <img src="{{ asset('assets/images/logo/logo3.png') }}" alt="" height="48">
            </a>
        </div>
        <div class="col-6 d-flex justify-content-end">
            <form action="{{ route('admin.logout') }}" method="post">
            @csrf
            <button class="btn btn-outline-light text-light" type="submit">Logout</button>
            </form>
            <button class="btn btn-outline-light text-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAccount"
                aria-controls="offcanvasAccount"><i class="fa fa-shopping-basket"></i></button>

            <div class="offcanvas offcanvas-end text-dark" tabindex="-1" id="offcanvasAccount"
                aria-labelledby="offcanvasAccountLabel">
                <div class="offcanvas-header">
                    <h5 id="offcanvasAccountLabel" class="text-dark">Koperasi Karya Husada</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close">&times;</button>
                </div>
                <div class="offcanvas-body">
                    <ul class="nav flex-column">
                      <li>
                        <div class="w-100 h-100 d-flex align-items-center justify-content-between">
                                <div class="p-4 bg-secondary rounded"></div>
                                <div class="text ms-3 h-100">
                                    <span>Product 1</span><br>
                                    <small class="text-danger">Rp 9000</small>
                                </div>
                                <span class="input-group" style="max-width:120px;">
                                    <span class="input-group-text"><i class="fa fa-angle-left"></i></span>
                                    <input type="text" class="form-control br-0" value="4" style="max-width:48px;">
                                    <span class="input-group-text"><i class="fa fa-angle-right"></i></span>
                                </span>
                                <div class="text ms-3">
                                    <i class="fe fe-x"></i>
                                </div>
                            </div>
                      </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <div class="p-2 w-100 mt-2">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username"
                aria-describedby="basic-addon2">
            <span class="input-group-text" id="basic-addon2"><i class="fe fe-search"></i></span>
        </div>
    </div>
</nav>
<!-- Navbar -->
