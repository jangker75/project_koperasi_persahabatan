<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
<script>
    
    $('#datatable thead tr').clone(true).appendTo( '#datatable thead' );
    // Setup - add a text input to each header cell
    $('#datatable thead tr:eq(1) th').each( function (i) {
        if (i == 0 || i == 6) {
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
            url: "{{ route('admin.product.index.datatables.label') }}",
        },
        columnDefs: [
            {
                targets: 0,
                checkboxes: {
                    selectRow: true
                }
            }
        ],
        select: {
            style: 'multi'
        },
        columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
            {data: 'DT_RowIndex', orderable: false, searchable: false, visible:false},
            { data: "name", name: "name" },
            { data: "sku", name: "sku" },
            { data: "brand", code: "brand" },
            { data: "category", code: "category" },
            { data: "price", code: "price" }
        ],
        orderFixed: [0, 'asc'],
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

    $("#checkAllCheckbox").on('change',function(){
      var checked = $(this).prop('checked');

      table.cells(null, 0).every( function () {
        var cell = this.node();
        $(cell).find('input[type="checkbox"][name="chkbx"]').prop('checked', checked); 
      });
    })

    $("#submit").click(function(){
      let ids = [];

      var rows_selected = table.column(0).checkboxes.selected();
      $.each(rows_selected, function(index, rowId){
          // Create a hidden element
          ids.push($(rowId).val())
      });

      console.log(ids)
    })

    
    // $(document)
</script>