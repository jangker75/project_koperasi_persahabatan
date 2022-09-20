<script>
    let cart = [];
    let count = 0;
    let total = 0;
    
    if (Cookies.get('cart') !== null) {
        cart = JSON.parse(Cookies.get("cart"))
        cart.forEach(element => {
            count += element.qty
        });
        $("#totalItem").html(count)

        total = Cookies.get('total')
    } else {
        cart = [];
    }

    // -------------------------------------------------------------------------------------------------------------------

    refreshCart(cart)

    function refreshCart() {

      // console.log(cart)
      setTimeout(function(){
        // set count again
        let recount = 0;
        cart.forEach(element => {
            recount += element.qty
        });
        count = recount;
        $("#totalItem").html(recount)

        // set total price
        total = countSubtotal(cart)

        // rerender element
        refreshElementCart(cart)
      }, 500)

        setTimeout(function () {
            Cookies.remove('cart');
            Cookies.set('cart', JSON.stringify(cart))
        }, 500);
        setTimeout(function () {
            Cookies.remove('total');
            Cookies.set('total', total)
        }, 500);

        
    }

    function countSubtotal(item) {
        let sum = 0;

        for (let index = 0; index < item.length; index++) {
            sum += parseInt(item[index].subtotal);
        }

        return sum;
    }

    function refreshElementCart(items) {
        $("#ulCartList").html("")

        items.forEach(element => {
            $("#ulCartList").append(`
              <li class="border-bottom py-3 w-100">
                  <div class="w-100 d-flex align-items-center justify-content-between">
                      <div class="p-4">
                        <img src="` + element.cover + `" alt="" height="48">
                      </div>
                      <div class="text ms-3 h-100 flex-grow-1">
                          <span>` + element.title + `</span><br>
                          <div class="text-danger">` + formatRupiah(String(element.price), "Rp") + `</div>
                          <div class="handle-counter justify-content-start mt-2" id="sku` + element.sku + `">
                              <button type="button" class="counter-minus counter-navbar btn btn-white lh-2 shadow-none">
                                  <i class="fa fa-minus text-muted"></i>
                              </button>
                              <input type="text" value="` + element.qty + `" class="qtyInNavbar">
                              <button type="button" class="counter-plus counter-navbar btn btn-white lh-2 shadow-none">
                                  <i class="fa fa-plus text-muted"></i>
                              </button>
                          </div>
                      </div>
                      <div class="text ms-3 delete-from-cart" id="` + element.sku + `">
                          <i class="fe fe-x"></i>
                      </div>
                  </div>
              </li>
            `);
        });

        $("#totalPriceCart").html("Checkout " + formatRupiah(String(total), "Rp"))
    }

    // -------------------------------------------------------------------------------------------------------------------

    $('body').on('click', '.counter-navbar', function () {

        let skuNumber = $(this).closest('.handle-counter').attr('id');
        skuNumber = skuNumber.replace("sku", "");

        const checker = cart.find(element => {
            if (element.sku === skuNumber) {
                if ($(this).hasClass('counter-minus')) {
                    if (element.qty > 1) {
                        element.qty -= 1;
                        $(this).siblings(".qtyInNavbar").val(element.qty);
                    }
                } else if ($(this).hasClass('counter-plus')) {
                    element.qty += 1;
                    $(this).siblings(".qtyInNavbar").val(element.qty);
                }
                element.subtotal = element.price * element.qty

                return true;
            }

            return false;
        });

        refreshCart(cart)
    })

    $('body').on('click', '.delete-from-cart', function () {
        let skuNumber = $(this).attr('id');
        skuNumber = skuNumber.replace("dlt", "");
        

        // get index of object with id:37
        var removeIndex = cart.map(function (item) {
            return item.sku;
        }).indexOf(skuNumber);

        // remove object
        cart.splice(removeIndex, 1);

        refreshCart(cart)
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    function truncateString(str, num) {
        if (str.length > num) {
            return str.slice(0, num) + "...";
        } else {
            return str;
        }
    }

    // -------------------------------------------------------------------------------------------------------------------



</script>
