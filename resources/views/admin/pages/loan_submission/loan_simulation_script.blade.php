<script>
    $(document).ready(function(){
        $("[name='profit_company_ratio']").val(50)
        $("[name='profit_employee_ratio']").val(50)
    })
    $("[name='profit_company_ratio']").on('keyup',function(){
        if ($(this).val() > 100) {
            $(this).val(100)
        }
        if ($(this).val() < 0) {
            $(this).val(0)
        }

        $("[name='profit_employee_ratio']").val(100 - $(this).val())
    })

    $('#btn-simulate-loan').click(function() {
        addToTable()
    })

    function addMonths(numOfMonths, date = new Date()) {
        date.setMonth(date.getMonth() + numOfMonths)
        let a = moment(date).locale('id').format('LL')
        return a
    }
    function addToTable() {
        //delete table content
        $('#table-simulation tbody').empty()
        //get data for initial value
        let firstPaymentDate = $('#first_payment_date').val()
        let totalLoanAmount = parseInt($('#total_loan_amount').val().replace('.',''))
        let interestType = $('#interest_amount_type').find(':selected').val()
        let interestScheme = $('#interest_scheme').find(':selected').text()
        let totalPayMonth = $('#total_pay_month').find(':selected').text()
        let payPerXMonth = $('#pay_per_x_month').val()
        let totalPrincipalAmount = Math.round(totalLoanAmount / totalPayMonth)
        let totalInterestAmount = parseInt($('#interest_amount').val())

        let currentTotalLoanAmount = totalLoanAmount
        let totalInterest = 0
        let totalIncome = 0
        let currentInterest = 0
        
        //iteration for input data simulation to table
        for (let index = 0; index <= totalPayMonth; index++) {
            if (index != 0) {
                currentTotalLoanAmount -= totalPrincipalAmount
            }
            //if last month still have pay under 50 rupiah, then payment will be deducted in last month
            if((currentTotalLoanAmount - totalPrincipalAmount) <= 50){
                totalPrincipalAmount = currentTotalLoanAmount
            }
            console.log('currentTotalLoanAmount',currentTotalLoanAmount);
            console.log('totalPrincipalAmount',totalPrincipalAmount);
            //calculate current interest based on percentage/value and scheme menurun/flat
            if (interestType == 'percentage') {
                if (interestScheme == 'Menurun') {
                    currentInterest = Math.round(currentTotalLoanAmount * totalInterestAmount / 100)
                } else {
                    currentInterest = Math.round(totalLoanAmount * totalInterestAmount / 100)
                }
            } else {
                currentInterest = totalInterestAmount
            }
            
            if (index == totalPayMonth) {
               currentInterest = totalPrincipalAmount = 0
            }
            
            //calculate for row total
            totalInterest += currentInterest
            totalIncome = (totalIncome + currentInterest + totalPrincipalAmount)
            
            //Insert tr to table simulation
            var trRow = '<tr>'
            trRow += "<td>" + (index + 1) + "</td>"
            trRow += "<td>" + addMonths(index * payPerXMonth, new Date(firstPaymentDate)) + "</td>"
            trRow += "<td>" + formatMoney(currentTotalLoanAmount) + "</td>"
            // console.log('totalPrincipalAmount',totalPrincipalAmount);
            trRow += "<td>" + formatMoney(totalPrincipalAmount) + "</td>"
            trRow += "<td>" + formatMoney(currentInterest) + "</td>"
            trRow += "<td>" + formatMoney(currentInterest + totalPrincipalAmount) + "</td>"
            trRow += '</tr>'
            $('#table-simulation tbody').append(trRow)
        }

            //Insert last row for total
            var trRow = '<tr>'
                trRow += "<td class='fw-600' colspan='4'>Total</td>"
                trRow += "<td class='fw-600'>"+ formatMoney(totalInterest) +"</td>"
                trRow += "<td class='fw-600'>"+ formatMoney(totalIncome) +"</td>"
                trRow += '</tr>'
            $('#table-simulation tbody').append(trRow)
    }
</script>
