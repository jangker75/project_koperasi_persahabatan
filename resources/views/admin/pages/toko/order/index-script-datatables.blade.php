<script>
    $(document).on("ready", function(){
        // getTotalHeader()
    })

    let table = $('#datatable').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
        order: [[0, "asc"]],
        processing: true,
        serverSide: false,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        // dom: 'lBfrtip',
        ajax: {
            url: "{{ route('get-data-order.datatables') }}",
            data: function(d){
                d.startDate = $("#startDate").val()
                d.endDate = $("#endDate").val()
            }
        },
        columns: [
            // { data: "order_id", name: "order_id", visible: false},
            { data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false},
            { data: "order_date_txt", name: "order_date" },
            { data: "order_code", name: "order_code" },
            { data: "store_name", name: "store_name" },
            { data: "total", render: function(data, type, row){
                return formatRupiah(data)
            }},

            { data: "subtotal_txt", name: "subtotal" },
            { data: "requester_name", name: "requester_name" },
            // { data: "is_paylater", name: "is_paylater" },
            { data: "is_paylater", render: function(data, type, row){
                return (data != null && data == 1) ?
                        "ya" : 'tidak';
            } },
            { data: "is_delivery", render: function(data, type, row){
                return (data != null && data == 1) ?
                        "ya" : 'tidak';
            } },
            { data: "is_paid", render: function(data, type, row){
                return (data != null && data == 1) ?
                        "ya" : 'tidak';
            } },
            // { data: "is_delivery", name: 'is_delivery' },
            // { data: "is_paid", name: "is_paid"},

            // { data: "qty_item", name: "qty_item" },
            { data: "status", name: "status" },
            { data: "actions", name: "actions" },
        ],
        language: {
            searchPlaceholder: 'Search...',
            scrollX: "100%",
            sSearch: '',
        }
    });
    // Filter event handler
    $( table.table().container() ).on('keyup', 'thead input', function () {
        console.log(this.value);
        table
        .column($(this).data('index') )
        .search( this.value )
        .draw();
    });
    $('#datatable thead tr').clone(true).appendTo( '#datatable thead' );
    // Setup - add a text input to each header cell
    $('#datatable thead tr:eq(1) th').each( function (i) {
        if (i == 0) {
            return $(this).html( '' );
        }
        var title = $(this).text();
        $(this).html( '<input class="form-control" type="text" placeholder="'+title+'" data-index="'+i+'" />' );
    } );

    $('input[name="daterange"]').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD',
            separator: " to "
        },
        dateLimit: {
            "days": 15
        },
    });

    //Download
    $("#submitFilter").on("click", function(){
        // initData()
        // table.draw()
        getTotalHeader()
        table.ajax.reload()
    })

    $("input[name='daterange']").on("change", function(){
        let date = $(this).val();
        date = date.split('to')
        startDate = date[0].replace(" ", "");
        endDate = date[1].replace(" ", "");
        $("#startDate").val(startDate)
        $("#endDate").val(endDate)
    })

    $("#btnDownload").on("click", function(){
        $("#formdownload").submit()
    })

    function getTotalHeader(){
        $.ajax({
            type: "GET",
            url: "{{ route('get-data-total-header-order') }}",
            data: {
                startDate : $("#startDate").val(),
                endDate : $("#endDate").val(),
            },
            dataType: "jSON",
            success: function (data) {
                console.log(data);
                if(data != null){
                    $("#totalPaylater").html(formatRupiah(data.totalpaylater))
                    $("#totalPrice").html(formatRupiah(data.grandtotal))
                }
            }
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