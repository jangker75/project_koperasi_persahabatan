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
            url: "{{ route('admin.ex-employee.index.datatables') }}",
        },
        columns: [
            { data: "id", name: "id", visible: false},
            { data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false},
            { data: "first_name", name: "first_name" },
            { data: "last_name", name: "last_name" },
            { data: "nik", code: "nik" },
            { data: "nip", name: "nip" },
            { data: "salary_number", name: "salary_number" },
            { data: "position.name", name: "position.name" },
            { data: "actions", name: "actions" },
        ],
        language: {
            searchPlaceholder: 'Search...',
            scrollX: "100%",
            sSearch: '',
        }
    });

    // Filter event handler
    $(table.table().container() ).on( 'keyup', 'thead input', function () {
        table
            .column($(this).data('index') )
            .search( this.value )
            .draw();
    });
    $('#datatable').on('click', '.btn-cairkan-simpanan', function(e) {
        let employeeId = $(this).data('employeeid')
        let url = $(this).val()
        $('#btnCairkan').attr('disabled', false)
        $('#formCairkanSimpanan').attr('action', url)
        console.log($(this).data('employeeid'));
        $.ajax({
            type: "get",
            url: "{{ url('admin/employee-balance-information') }}/"+employeeId,
            dataType: "json",
            success: function (response) {
                $('#modalTitle').text(response['name'])
                $("#activity_savings").text(response['activity_savings_balance'])
                $("#mandatory_savings").text(response['mandatory_savings_balance'])
                $("#principal_savings").text(response['principal_savings_balance'])
                $("#voluntary_savings").text(response['voluntary_savings_balance'])
                $("#total_savings").text(response['total_savings_balance'])
                if(response['total_savings_value'] <= 0){
                    $('#btnCairkan').attr('disabled', true)
                }
            }
        }); 
    })
    
</script>