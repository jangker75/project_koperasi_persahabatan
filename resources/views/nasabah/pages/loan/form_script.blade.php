<script>
    let admin_fee_percentage = 2
    let admin_fee = 0
    let received_amount = 0
    $(document).ready(function(){
        $('#admin_fee_percentage').val(admin_fee_percentage)
        $('#admin_fee').val(admin_fee)
        $('#total_loan_amount').val(0)
        $('#received_amount').val(received_amount)
    })

    $('#total_loan_amount').keyup(function(){
        let loanValue = $(this).val()
        admin_fee = loanValue * admin_fee_percentage / 100
        received_amount = loanValue - admin_fee
        $('#admin_fee').val(admin_fee)
        $('#received_amount').val(received_amount)
    })

</script>