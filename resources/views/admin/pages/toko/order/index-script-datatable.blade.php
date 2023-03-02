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

      $.ajax({
        type: "post",
        url: '{{ route("api-get-data-order") }}?page='+page,
        dataType: 'json',
        data: {
          params: param
        },
        beforeSend: function() {
            // unlock_browser();
        }
      }).done(function(res){
        console.log(res)
      });
    }
</script>