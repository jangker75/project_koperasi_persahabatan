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
            url: "{{ route('admin.loan-submission.index.datatables') }}",
        },
        columns: [
            { data: "id", name: "id", visible: false},
            { data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false},
            { data: "transaction_number", name: "transaction_number" },
            { data: "full_name", name: "full_name" },
            { data: "total_loan_amount", name: "total_loan_amount" },
            { data: "status", name: "approvalstatus.name" },
            { data: "user.employee.first_name", name: "user.employee.first_name" },
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

    //Confirmation dialog action approval
    $('#datatable').on('click', '.action-button', function(e) {
            let linkbutton = $(this).prop("href");
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                },
                function(isConfirm) {
                    if (isConfirm) {
                        // swal("Success!", "Your data has been edited.", "success")
                        window.location = linkbutton
                    }
            });
        })
</script>