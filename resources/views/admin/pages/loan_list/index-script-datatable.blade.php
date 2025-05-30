<script>
    let status = 'Approved'
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
            url: "{{ route('admin.loan-list.index.datatables') }}",
            data: function(d){
                    d.status = status
                    d.keyword = $('.dataTables_filter input').val()
                }
        },
        columns: [
            { data: "id", name: "id", visible: false},
            { data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false},
            { data: "transaction_number", name: "transaction_number" },
            { data: "loan_date", name: "loan_date" },
            { data: "full_name", name: "full_name" },
            { data: "contracttype.name", name: "contracttype.name" },
            { data: "total_loan_amount", name: "total_loan_amount" },
            { data: "remaining_amount", name: "remaining_amount" },
            { data: "approvalstatus.name", name: "approvalstatus.name" },
            { data: "status_lunas", name: "is_lunas" },
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
        table
            .column($(this).data('index') )
            .search( this.value )
            .draw();
    });

    //Handle filter clicked
    $('.filter-btn').click(function(e){
        status = $(this).data('status')
        table.draw()
    })

</script>