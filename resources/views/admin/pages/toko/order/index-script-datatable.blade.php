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
        }else{
          let newId = $(this).data("id")
          $(this).html( '<input class="form-control" type="text" placeholder="'+title+'" id="'+newId+'" data-index="'+i+'" />' );
        }
    });

    




    // let table = $('#datatable').DataTable({
    //     orderCellsTop: true,
    //     fixedHeader: true,
    //     order: [[0, "desc"]],
    //     processing: true,
    //     serverSide: true,
    //     lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    //     // dom: 'lBfrtip',
    //     ajax: {
    //         url: "{{ route('admin.order.index.datatables') }}",
    //     },
    //     columns: [
    //         { data: "id", name: "id", visible: false},
    //         { data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false},
    //         { data: "order_code", name: "order_code" },
    //         { data: "totalPrice", name: "totalPrice" },
    //         { data: "order_date", name: "order_date" },
    //         { data: "employee", name: "employee" },
    //         { data: "isPaylater", name: "isPaylater" },
    //         { data: "isDelivery", name: "isDelivery" },
    //         { data: "isPaid", name: "isPaid" },
    //         { data: "totalQtyProduct", name: "totalQtyProduct" },
    //         { data: "statusOrder", name: "statusOrder" },
    //         { data: "actions", name: "actions" },
    //     ],
    //     language: {
    //         searchPlaceholder: 'Search...',
    //         scrollX: "100%",
    //         sSearch: '',
    //     }
    // });

    // // Filter event handler
    // $( table.table().container() ).on( 'keyup', 'thead input', function () {
    //     table
    //         .column($(this).data('index') )
    //         .search( this.value )
    //         .draw();
    // } );

    $('input[name="daterange"]').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD',
            separator: " to "
        }
    });

    // // date
    // $('input[name="daterange"]').change(function () {
    //     let value = $(this).val();
    //     value = value.split('to')
    //     value[0] = value[0].replace(" ", "");
    //     value[1] = value[1].replace(" ", "");
    //     value = value.join(',');

    //     table.ajax.url("{{ url('admin/datatables-order') }}?date="+value).draw();
        
    // })
    $("#resetDate").click(function () {
        $('input[name="daterange"]').val("")
    })

    $("body").on("click", "#buttonSearch", function(){
      let orderCode = $("#orderCode").val();
      let total = $("#total").val();
      let date = $("#date").val();
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
        param.push({
          "key": "total",
          "value": total
        })
      }
      if(nasabah !== ""){
        param.push({
          "key": "nasabah",
          "value": nasabah
        })
      }
      if(paylater !== ""){
        if(paylater == "ya"){
          param.push({
            "key": "paylater",
            "value": 1
          })
        }else if(paylater == "tidak"){
          param.push({
            "key": "paylater",
            "value": 0
          })
        }
      }
      if(delivery !== ""){
        if(delivery == "ya"){
          param.push({
            "key": "delivery",
            "value": 1
          })
        }else if(delivery == "tidak"){
          param.push({
            "key": "delivery",
            "value": 0
          })
        }
      }
      if(lunas !== ""){
        if(lunas == "ya"){
          param.push({
            "key": "lunas",
            "value": 1
          })
        }else if(lunas == "tidak"){
          param.push({
            "key": "lunas",
            "value": 0
          })
        }
      }
      console.log(param)
    })


    function processDisplay(Data){
        Data.forEach(function(value, index) {
            let html = 
            `<tr>
                <td>` + index + `</td>
                <td data-id="date">` + value.date + `</td>
                <td data-id="orderCode">` + value.orderCode + `</td>
                <td data-id="total">` + formatRupiah(value.total) + `</td>
                <td data-id="nasabah">` + value.employeeName + `</td>
                <td data-id="paylater">` + value.paylater == 1 ? "ya" : "tidak" + `</td>
                <td data-id="delivery">` + value.paylater == 1 ? "ya" : "tidak" + `</td>
                <td data-id="lunas">` + value.paylater == 1 ? "lunas" : "belum lunas" + `</td>
                <td>` + value.qtyProduct + `</td>
                <td>` + value.status + `</td>
                <td>` + value.action + `</td>
            </tr>`;
        });
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

</script>