@extends('nasabah.layout.base-nasabah')

@section('content')
<section class="py-4">
    <div class="d-flex align-items-center">
        <a href="{{ route('nasabah.product.index') }}" class="btn fw-bold h5 m-0">
            <i class="fa fa-angle-left text-muted"></i>
        </a>
        <h1 class="h3 fw-bold m-0">Checkout</h1>
    </div>
</section>
<section>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Detail Barang</div>
            </div>
            <div class="card-body p-2">

                <div class="table-responsive">
                    <table class="table border table-bordered mb-0">
                        <thead>
                            <th>produk</th>
                            <th>qty</th>
                            <th>price</th>
                            <th>subtotal</th>
                        </thead>
                        <tbody id="bodyTableCart">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-4">
                    Toko : <span id="storeName" class="fw-bold"></span>
                </div>
                <div class="mb-4">
                    Tax : <span class="fw-bold">{{ format_uang($tax->content) }}</span>
                </div>
                <div class="h5">
                    Total Harga : <span id="" class="fw-bold totalPriceCheckout"></span>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="pb-4">Metode Pembayaran : </div>
                <div class="d-flex flex-wrap">
                    <div class="btn btn-primary text-uppercase me-2 button-paylater" data-paylater="false">Bayar di
                        kasir</div>
                    <div class="btn btn-primary-light text-uppercase button-paylater" data-paylater="true">Paylater
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="pb-4">Metode Pengambilan : </div>
                <div class="d-flex">
                    <div class="btn btn-primary text-uppercase me-2 button-pickup" data-delivery="false">Ambil di Kasir
                    </div>
                    <div class="btn btn-primary-light text-uppercase button-pickup" data-delivery="true">Antar ke Lokasi
                    </div>
                </div>
                <div class="form-group pt-4" id="deliveryFee">
                    <label for="">Biaya Pengantaran</label><br>
                    <input type="text" class="form-control" value="{{ format_uang($delivery_fee->content) }}" readonly>
                </div>
                <div class="form-group pt-4" id="location">
                    <label for="">Catatan dan lokasi anda</label><br>
                    <textarea class="form-control" placeholder="Ketik catatan dan lokasi anda" rows="2" name="note"
                        id="locationText"></textarea>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="col-12 py-5">
        <div class="btn btn-primary btn-lg w-100 h4 fw-bold py-4" id="submit">Lanjutkan <span class="totalPriceCheckout"></span></div>
    </div>
</section>
<section class="py-5 mt-2"></section>



@endsection

@section('footer')
{{-- @include('nasabah.layout.bottombar-product') --}}
@endsection

@section('script')
<script>
    let listCart = JSON.parse(Cookies.get('cart'));
    let totalCheckout = JSON.parse(Cookies.get('total'));
    let paylater = false;
    let delivery = false;
    let note = "";
    let storeId = Cookies.get('storeId')
    $("#paymentCode").hide();
    $("#location").hide();
    $('#deliveryFee').hide()


    $('.totalPriceCheckout').html(formatRupiah(String(totalCheckout), "Rp"))
    $.get("{{ url('api/store') }}/" + storeId, function (response) {
        // console.log(response.data.name)
        $("#storeName").html(response.data.name)
    })
    // render
    renderCheckout();

    function renderCheckout() {
        let html = "";

        $("#bodyTableCart").html("")
        listCart.forEach(element => {
            html += `
        <tr>
          <td>` + element.title + `</td>
          <td>` + element.qty + `</td>
          <td>` + formatRupiah(String(element.price), "Rp") + `</td>
          <td>` + formatRupiah(String(element.subtotal), "Rp") + `</td>
        </tr>
      `;
        });
        $("#bodyTableCart").html(html)
    }


    // ui
    $(".button-pickup").click(function () {
        $(".button-pickup").removeClass("btn-primary")
        $(".button-pickup").addClass("btn-primary-light")

        $(this).removeClass("btn-primary-light")
        $(this).addClass("btn-primary")

        delivery = $(this).data('delivery')

        if ($(this).data('delivery')) {
            $("#location").show();
            $("#deliveryFee").show();
            totalCheckout += parseInt("{{ $delivery_fee->content }}")
            $('.totalPriceCheckout').html(formatRupiah(String(totalCheckout), "Rp"))
          } else {
            $("#deliveryFee").hide();
            $("#location").hide();
            totalCheckout -= parseInt("{{ $delivery_fee->content }}")
            $('.totalPriceCheckout').html(formatRupiah(String(totalCheckout), "Rp"))
        }
    })

    $(".button-paylater").click(function () {

        $(".button-paylater").removeClass("btn-primary")
        $(".button-paylater").addClass("btn-primary-light")

        $(this).removeClass("btn-primary-light")
        $(this).addClass("btn-primary")

        paylater = $(this).data("paylater")
        console.log(paylater)
    })

    $("#locationText").keyup(function () {
        note = $(this).val()
        console.log($(this).val())
        console.log(note)
    })



    $("#submit").click(function () {
        let prepareData = {
            requesterId: "{{ Auth::user()->employee->id }}",
            paylater: paylater,
            delivery: delivery,
            note: note,
            item: listCart,
            storeId: storeId
        };


        if (listCart.length < 1) {
            swal({
                title: "Gagal",
                text: "Belum ada produk yang ditambahkan",
                type: "error"
            });
        }

        if(paylater){
          swal({
            title: "Anda yakin?",
            text: "Order anda akan dimasukan ke dalam paylater",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Ya, lanjutkan order',
            cancelButtonText: "Tidak, batalkan order",
            closeOnConfirm: false,
            closeOnCancel: false
          }, function(isConfirm) {
            if (isConfirm) {
              $.ajax({
                  type: "POST",
                  processData: false,
                  contentType: 'application/json',
                  cache: false,
                  url: "{{ url('api/order-nasabah') }}",
                  data: JSON.stringify(prepareData),
                  dataType: "json",
                  enctype: 'multipart/form-data',
                  success: function (response) {
                      swal({
                          title: "Sukses",
                          text: response.message,
                          type: "success"
                      });
                      
                      Cookies.remove('cart')
                      Cookies.remove('total')
                      setTimeout(function () {
                          window.location.replace("{{ url('/') }}")
                      }, 2500)
                  },
                  error: function (response) {
                    console.log(response)
                      swal({
                          title: "Gagal",
                          text: response.responseJSON.message,
                          type: "error"
                      });
                  }
              });
            } else {
              swal("Cancelled", "Order dibatalkan", "error");
              return false;
            }
          })
        }else{
          $.ajax({
              type: "POST",
              processData: false,
              contentType: 'application/json',
              cache: false,
              url: "{{ url('api/order-nasabah') }}",
              data: JSON.stringify(prepareData),
              dataType: "json",
              enctype: 'multipart/form-data',
              success: function (response) {
                  swal({
                      title: "Sukses",
                      text: response.message,
                      type: "success"
                  });
                  
                  Cookies.remove('cart')
                  Cookies.remove('total')
                  setTimeout(function () {
                      window.location.replace("{{ url('/') }}")
                  }, 2500)
              },
              error: function (response) {
                console.log(response)
                  swal({
                      title: "Gagal",
                      text: response.responseJSON.message,
                      type: "error"
                  });
              }
          });
        }


        


    })


</script>
@endsection
