<script>
    
    $('#datatable thead tr').clone(true).appendTo( '#datatable thead' );
    // Setup - add a text input to each header cell
    $('#datatable thead tr:eq(1) th').each( function (i) {
        if (i == 1) {
            return $(this).html( '' );
        }
        var title = $(this).text();
        if(title == "Status" || title == "Action" || title == "Produk Terjual"){
          return $(this).html( '' );
        }
        $(this).html( '<input class="form-control" type="text" placeholder="'+title+'" data-index="'+i+'" />' );
    } );
    let table = $('#datatable').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
        order: [[0, "desc"]],
        processing: true,
        serverSide: true,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        // dom: 'lBfrtip',
        ajax: {
            url: "{{ route('admin.order.index.datatables') }}",
        },
        columns: [
            { data: "id", name: "id", visible: false},
            { data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false},
            { data: "order_code", name: "order_code" },
            { data: "totalPrice", name: "totalPrice" },
            { data: "order_date", name: "order_date" },
            { data: "employee", name: "employee" },
            { data: "isPaylater", name: "isPaylater" },
            { data: "isDelivery", name: "isDelivery" },
            { data: "isPaid", name: "isPaid" },
            { data: "totalQtyProduct", name: "totalQtyProduct" },
            { data: "statusOrder", name: "statusOrder" },
            { data: "actions", name: "actions" },
        ],
        language: {
            searchPlaceholder: 'Search...',
            scrollX: "100%",
            sSearch: '',
        }
    });

    // Filter event handler
    $( table.table().container() ).on( 'keyup', 'thead input', function () {
        table
            .column($(this).data('index') )
            .search( this.value )
            .draw();
    } );

    $('input[name="daterange"]').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD',
            separator: " to "
        }
    });

    // date
    $('input[name="daterange"]').change(function () {
        let value = $(this).val();
        value = value.split('to')
        value[0] = value[0].replace(" ", "");
        value[1] = value[1].replace(" ", "");
        value = value.join(',');

        table.ajax.url("{{ url('admin/datatables-order') }}?date="+value).draw();
        
    })
    $("#resetDate").click(function () {
        $('input[name="daterange"]').val("")

        table.ajax.url("{{ url('admin/datatables-order') }}").draw();
    })
</script>