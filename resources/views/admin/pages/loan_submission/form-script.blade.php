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

    
</script>
