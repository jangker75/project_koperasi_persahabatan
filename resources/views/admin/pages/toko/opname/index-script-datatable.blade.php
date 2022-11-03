<script>
    
    $('#datatable thead tr').clone(true).appendTo( '#datatable thead' );
    // Setup - add a text input to each header cell
    $('#datatable thead tr:eq(1) th').each( function (i) {
        if (i == 1) {
            return $(this).html( '' );
        }
        var title = $(this).text();
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
            url: "{{ route('admin.opname.index.datatables') }}",
        },
        columns: [
            { data: "id", name: "id", visible: false},
            { data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false},
            { data: "opname_code", name: "opname_code" },
            { data: "created_at", name: "created_at" },
            { data: "employee", name: "employee" },
            { data: "storeName", name: "storeName" },
            { data: "countDetail", name: "countDetail" },
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
    $( table.table().container() ).on( 'keyup', 'thead input', function () {
        table
            .column($(this).data('index') )
            .search( this.value )
            .draw();
    } );
</script>