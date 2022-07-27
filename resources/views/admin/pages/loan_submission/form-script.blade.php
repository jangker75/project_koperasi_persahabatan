<script>
    let admin_fee_percentage = 0.5
    let total_loan_amount = 1000000
    $('#admin_fee_percentage').val(admin_fee_percentage)
    $('#total_loan_amount').val(total_loan_amount)
    $('.fc-datepicker').bootstrapdatepicker({
        todayHighlight: true,
        toggleActive: true,
        format: 'yyyy-mm-dd',
        autoclose: true,
    })
    $(document).ready(function() {
        calculateAdminFee()
        calculateReceivedAmount()
    })

    $('#total_loan_amount, #admin_fee_percentage').keyup(function() {
        calculateAdminFee()
        calculateReceivedAmount()
    })
    $('#admin_fee').keyup(function() {
        calculateReceivedAmount()
    })

    function calculateAdminFee() {
        let percent = $('#admin_fee_percentage').val()
        let totalAmount = $('#total_loan_amount').val()
        let amount = totalAmount * percent / 100
        $('#admin_fee').val(amount)
    }

    function calculateReceivedAmount() {
        let totalAmount = $('#total_loan_amount').val()
        let amount = totalAmount - $('#admin_fee').val()
        $('#received_amount').val(formatMoney(amount))
    }
    $('#status-loan-employee, #status-age-employee').hide();
    $('#employee_id').on('change', function(){
        $('#status-loan-employee, #status-age-employee').hide();
        $.ajax({
            type: "post",
            url: "{{ route('admin.check.status.loan.employee') }}",
            data: {
                employee_id: $(this).val(),
                _token: "{{ csrf_token() }}",
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (response.status_loan != undefined) {
                    let result = ''
                    result += response.status_loan + '<br><ul class="list-group">'
                    response.transaction_number.forEach((item)=> {
                        result += '<li class="listunorder bg-transparent border-0 fw-bold">' + item + '</li>'
                    })
                    result += '</ul>'
                    $('#status-loan-employee').html(result).show();
                }
                if(response.status_age != undefined){
                    $('#status-age-employee').text(response.status_age).show();
                }
            }
        });
    })
    
</script>
