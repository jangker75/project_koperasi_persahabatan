<script>
    
    $('#datatable thead tr').clone(true).appendTo( '#datatable thead' );
    // Setup - add a text input to each header cell
    $('#datatable thead tr:eq(1) th').each( function (i, e) {
        if (i == 0 || i == 1) {
            return $(this).html( '' );
        }
        var title = $(this).text();

        if(title == "Produk Terjual"){
          $(this).attr("colspan", "3");
          $(this).html('<div class="btn btn-secondary w-100 border border-1 border-white" id="buttonSearch">Cari</div>');
        }else if(title == "Status" || title == "Action"){
          $(this).remove();
        }else if(title == "Total"){
          let newId = $(this).data("id")
          $(this).html( '<input class="form-control format-uang" type="text" placeholder="' + title + '" id="' + newId + '" data-index="' + i + '" />' );
        }else{
          let newId = $(this).data("id")
          $(this).html( '<input class="form-control" type="text" placeholder="'+title+'" id="'+newId+'" data-index="'+i+'" />' );
        }
    });

    function getData(){
      let orderCode = $("#orderCode").val();
      let total = $("#total").val();
      let nasabah = $("#nasabah").val();
      let paylater = $("#paylater").val();
      let delivery = $("#delivery").val();
      let lunas = $("#lunas").val();

      var param = [];

      if(orderCode !== ""){
        param.push({
          "key": "order_code",
          "value": orderCode
        })
      }
      if(total !== ""){
        let newTotal = total.split(".").join("");
        param.push({
          "key": "total",
          "value": newTotal
        })
      }
      if(nasabah !== ""){
        param.push({
          "key": "employee",
          "value": nasabah
        })
      }
      if(paylater !== ""){
        if(paylater == "ya"){
          param.push({
            "key": "isPaylater",
            "value": 1
          })
        }else if(paylater == "tidak"){
          param.push({
            "key": "isPaylater",
            "value": 0
          })
        }
      }
      if(delivery !== ""){
        if(delivery == "ya"){
          param.push({
            "key": "isDelivery",
            "value": 1
          })
        }else if(delivery == "tidak"){
          param.push({
            "key": "isDelivery",
            "value": 0
          })
        }
      }
      if(lunas !== ""){
        if(lunas == "lunas"){
          param.push({
            "key": "isPaid",
            "value": 1
          })
        }else if(lunas == "belum lunas"){
          param.push({
            "key": "isPaid",
            "value": 0
          })
        }
      } 

      let date = $("input[name='daterange']").val();
      date = date.split('to')
      startDate = date[0].replace(" ", "");
      endDate = date[1].replace(" ", "");

      param.push({
        "key": "date",
        "value": {
          "startDate": startDate,
          "endDate": endDate
        }
      })

      let page = $("[name=page]").val();

      console.log(param)

      $.ajax({
        type: "post",
        url: '{{ route("api-get-data-order") }}?page='+page,
        dataType: 'json',
        data: {
          params: param
        },
        beforeSend: function() {
            $("#loaderResult").show();
        }
      }).done(function(res){
        $("#loaderResult").hide();
        console.log(res)
        processDisplay(res.data)
        processPagination(res.pagination.links)
        $("#totalPaylater").text(formatRupiah(res.total.totalPaylater))
        $("#totalPrice").text(formatRupiah(res.total.grandTotal))
      });
    }

    function processDisplay(Data){
        let page = parseInt($("[name=page]").val());
        let html = "";
        if(Data.length == 0){
          html = `<tr><td colspan='11' align='center' >Data Kosong</td></tr>`;
        }else{
          Data.forEach(function(value, index) {
            html = html + 
              `<tr>
                  <td>` + (((page-1)*10)+(index+1)) + `</td>
                  <td data-id="date">` + value.orderDate + `</td>
                  <td data-id="orderCode">` + value.orderCode + `</td>
                  <td data-id="total">` + formatRupiah(value.total) + `</td>
                  <td data-id="nasabah">` + value.requesterName + `</td>
                  <td data-id="paylater">` + (value.isPaylater == 1 ? "ya" : "tidak") + `</td>
                  <td data-id="delivery">` + (value.isDelivery == 1 ? "ya" : "tidak") + `</td>
                  <td data-id="lunas">` + (value.isPaid == 1 ? "lunas" : "belum lunas") + `</td>
                  <td>` + value.totalQtyProduct + `</td>
                  <td><span class="btn btn-sm `+ value.statusOrderColorButton +`">` + value.statusOrderName + `</span></td>
                  <td>
                    <a href="{{ url('admin/pos/history-order') }}/` + value.orderCode + `"
                    class="btn btn-primary btn-sm me-1" data-toggle="tooltip" data-placement="top"
                    target="_blank" title="Lihat Detail Produk">Lihat Detail</a>
                  </td>
              </tr>`;
          });
        }
        $("#bodyTable").html(html)
    }

    function formatRupiah(angka) {
        var rupiah = '';    
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) {
            if(i%3 == 0) {
            rupiah += angkarev.substr(i,3)+'.';
            }
        }    
        return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    }

    function processPagination(page){
      let pageHtml = '<div class="pagination">';
      
      if(page.length > 0){
        page.forEach(pag => {
          link = pag.url == null ? "" : pag.label;
          pageHtml = pageHtml + `<span class="btn btn-sm ` + (pag.active == true ? "btn-primary" : "btn-outline-primary") + ` btn-page m-1" data-link="` + link + `">` + pag.label + `</span>`
        });
      }

      pageHtml = pageHtml + '</div>';

      $("#pagination").html(pageHtml);
    }
</script>