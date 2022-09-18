<script>
    $(document).ready(function() {
        //Show modal balance history
        $('.balance-card').on('click', function(e) {
            let type = $(this).data('type-balance')
            $('#table-history-balance-modal tbody tr').remove()
            let tRow = ''
            $.ajax({
                type: "get",
                url: "{{ url('employee-savings-history') . '/' . "$employee->id" . '/' }}" +
                    type,
                dataType: "json",
                success: function(response) {
                    $('#history-modal-title').text(response.type)
                    response.data.forEach(item => {
                        tRow += "<tr><td>" +
                            item.transaction_date + "</td><td>" +
                            (item.transaction_type == 'credit' ? item.amount : "") +
                            "</td><td>" +
                            (item.transaction_type == 'debit' ? item.amount : "") +
                            "</td><td>" +
                            item.balance_after + "</td><td>" +
                            item.description + "</td></tr>"
                    })
                }
            }).then(() => {
                $('#table-history-balance-modal tbody').append(tRow)
            });
        })

        //Show modal loan history
        $('.loan-history-modal').click(function() {
            $('#loanmodalcontent').load($(this).attr('value'))
            $('#modalTitle').text($(this).data('loan-number'))
        })

    })
</script>