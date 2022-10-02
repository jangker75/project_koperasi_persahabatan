<div class="table-responsive">
    <table class="table table-bordered border text-nowrap mb-0" id="editable">
        <thead class="table-info">
            <tr id="headerTable">
                
            </tr>
        </thead>
        <tbody id="bodyTable">
            
        </tbody>
    </table>
</div>


<!-- INTERNAL Edit-Table JS -->
<script src="{{ asset('/assets/plugins/edit-table/bst-edittable.js') }}"></script>
<script src="{{ asset('/assets/plugins/edit-table/edit-table.js') }}"></script>
<script src="{{ asset('/assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>



<script>
    $(document).ready(function () {
        let columnEditable;
        let heads;
        let bodies;
        $.ajax({
            type: "GET",
            url: "{{ $link }}",
            cache: "false",
            datatype: "html",
            beforeSend: function () {
                //something before send
            },
            success: function (data) {
                // console.log(data)
                heads = data.data.table.head;
                bodies = data.data.table.body;
                columnEditable = data.data.table.editable;
                heads.forEach(he => {
                    $("#headerTable").append("<th>" + he + "</th>")
                });
                bodies.forEach(body => {
                    let htm = "<tr>";
                    htm = htm + "<td class='d-none'>"+body.id+"</td>"
                    heads.forEach(hea => {
                        htm = htm + ("<td>"+body[hea]+"</td>")
                    });
                    htm = htm + "</tr>";
                    $("#bodyTable").append(htm)
                })
            }
        });

        setTimeout(() => {
            let editable = new BSTable('editable', {
                editableColumns: String(columnEditable),
                onEdit: function (data) {
                    let value = [];
                    var trs = data.getElementsByTagName("td");
                    var tds = [];

                    for (var i = 0; i < trs.length; i++) {
                        tds.push(trs[i].innerHTML);

                    }
                    tds.pop()
                    console.log(data);
                    data = {
                        'id': tds[0],
                        '_method': 'put',
                        'name': tds[1],
                        'credentials': tds[2],
                        'description': tds[3]
                    }
                    // console.log(data);
                    $.ajax({
                        type: "POST",
                        url: "{{ $link }}/" + data.id,
                        data: data,
                        dataType: "json",
                        success: function (response) {
                            swal({
                                title: "Success!",
                                text: response.message,
                                type: "success"
                            });
                        },
                        error: function (response) {
                            swal({
                                title: "Failed!",
                                text: response.message,
                                type: "failed"
                            });
                        }
                    });
                },
                onBeforeDelete: function (data) {
                    if (!confirm('Are you sure?')) editable._rowCandel(data);
                    let value = [];
                    var trs = data[0].getElementsByTagName("td");
                    var tds = [];

                    for (var i = 0; i < trs.length; i++) {
                        tds.push(trs[i].innerHTML);

                    }
                    tds.pop()
                    data = {
                        'id': tds[0],
                        '_method': 'delete',
                        'name': tds[1],
                        'guard_name': tds[2]
                    }
                    console.log(data);
                    $.ajax({
                        type: "POST",
                        url: "{{ $link }}/" + data.id,
                        data: data,
                        dataType: "json",
                        success: function (response) {
                            swal({
                                title: "Success!",
                                text: response.message,
                                type: "success"
                            });
                        },
                        error: function (response) {
                            swal({
                                title: "Failed!",
                                text: response.message,
                                type: "failed"
                            });
                        }
                    });
                }
            });
            editable.init()
            // editable
        }, 1000);
    })

</script>
