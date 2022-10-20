<script>
    let admin_fee_percentage = 0.5
    let total_loan_amount = 0
    $('#admin_fee_percentage').val(admin_fee_percentage)
    $('#total_loan_amount').val(total_loan_amount)
    //Datepicker
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
        let a = $('#total_loan_amount').val()
        a = parseInt(a.replace('.',''))
        let totalAmount = a
        let amount = totalAmount * percent / 100
        $('#admin_fee').val(amount)
    }

    function calculateReceivedAmount() {
        let totalAmount = parseInt($('#total_loan_amount').val().replace('.',''))
        let amount = totalAmount - $('#admin_fee').val()
        $('#received_amount').val(formatMoney(amount))
    }
    //Notification for status age employee and loan ongoing
    $('#status-loan-employee, #status-age-employee').hide();
    
    //Ajax for checking status employee
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
    
    //Checking if scheme interest = value then perhitungan bunga only can menurun
    $('#interest_amount_type').change(function(){
        if ($(this).val() == 'value') {
            
            $('#interest_scheme').val(1).change().attr('disabled', true)
        }else{
            $('#interest_scheme').attr('disabled', false)
        }
    })
</script>
