<script>
    $(document).ready(function(){
        // $("#tenor_tahunan").hide();
        $("[name='profit_company_ratio']").val(50)
        $("[name='profit_employee_ratio']").val(50)

        $("#interest_scheme").change(function(){
            let interest = $(this).find(':selected').text()
            console.log(interest);
            if(interest == "Anuitas"){ //anuitas
                $("#admin_fee_percentage").val(0);
                $("#admin_fee_percentage").prop('readonly', true);
                $("#admin_fee").val(0);
                $("#admin_fee").trigger("keyup");
                $("#admin_fee").prop('readonly', true);
                
                $("#profit_company_ratio").val(100);
                $("#profit_company_ratio").trigger("keyup");
                $("#profit_company_ratio").prop('readonly', true);

                $("#interest_amount").prop('readonly', true);
                $("#interest_amount_yearly").prop('readonly', false);


                // $("#tenor_bulanan").hide();
                $("#total_pay_month").html(`
                <option value="12">12</option>
                <option value="24">24</option>
                <option value="36">36</option>
                `);
            }else{
                $("#admin_fee_percentage").prop('readonly', false);
                $("#admin_fee").prop('readonly', false);
                $("#admin_fee").trigger("keyup");
                $("#profit_company_ratio").val(50);
                $("#profit_company_ratio").trigger("keyup");
                $("#profit_company_ratio").prop('readonly', false);
                $("#interest_amount").prop('readonly', false);
                $("#interest_amount_yearly").prop('readonly', true);

                $("#total_pay_month").html(`
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                `);
                // $("#tenor_bulanan").show();
                // $("#tenor_tahunan").hide();
            }
        })
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

    $("#btnDownloadSimulation").click(function(){
        let firstPaymentDate = $('#first_payment_date').val()
        let totalLoanAmount = parseInt($('#total_loan_amount').val().replace('.',''))
        let interestType = $('#interest_amount_type').find(':selected').val()
        let interestScheme = $('#interest_scheme').find(':selected').text()
        let totalPayMonth = $('#total_pay_month').find(':selected').text()
        let payPerXMonth = $('#pay_per_x_month').val()
        let totalInterestAmount = (interestScheme == "Anuitas" ? (parseFloat($('#interest_amount_yearly').val())/12) : parseFloat($('#interest_amount').val()))
        let profitCompanyRatio = parseInt($("input[name='profit_company_ratio']").val())
        
        let input1 = $("<input>").attr("type", "hidden").attr("name", "firstPaymentDate").val(firstPaymentDate);
        let input2 = $("<input>").attr("type", "hidden").attr("name", "totalLoanAmount").val(totalLoanAmount);
        let input3 = $("<input>").attr("type", "hidden").attr("name", "interestType").val(interestType);
        let input4 = $("<input>").attr("type", "hidden").attr("name", "interestScheme").val(interestScheme);
        let input5 = $("<input>").attr("type", "hidden").attr("name", "totalPayMonth").val(totalPayMonth);
        let input6 = $("<input>").attr("type", "hidden").attr("name", "payPerXMonth").val(payPerXMonth);
        let input7 = $("<input>").attr("type", "hidden").attr("name", "totalInterestAmount").val(totalInterestAmount);
        let input8 = $("<input>").attr("type", "hidden").attr("name", "profitCompanyRatio").val(profitCompanyRatio);
        
        $("#formDownloadSimulasi").append($(input1))
        .append($(input2)).append($(input3)).append($(input4))
        .append($(input5)).append($(input6)).append($(input7))
        .append($(input8));
        $("#formDownloadSimulasi").submit()
    })
    // $("#formDownloadSimulasi").on("submit", function(e){
    //     e.preventDefault();
    // })
    $('#btn-simulate-loan').click(function() {
        // addToTable()
        getDataLoanSimulation()
    })

    function getDataLoanSimulation(){
        let firstPaymentDate = $('#first_payment_date').val()
        let totalLoanAmount = parseInt($('#total_loan_amount').val().replace('.',''))
        let interestType = $('#interest_amount_type').find(':selected').val()
        let interestScheme = $('#interest_scheme').find(':selected').text()
        let totalPayMonth = $('#total_pay_month').find(':selected').text()
        let payPerXMonth = $('#pay_per_x_month').val()
        // let totalInterestAmount = parseFloat($('#interest_amount').val())
        let totalInterestAmount = (interestScheme == "Anuitas" ? (parseFloat($('#interest_amount_yearly').val())/12) : parseFloat($('#interest_amount').val()))
        let profitCompanyRatio = parseInt($("input[name='profit_company_ratio']").val())

        $.ajax({
            type: "post",
            url: "{{ route('nasabah.loan-simulation') }}",
            data: {
                firstPaymentDate: firstPaymentDate,
                totalLoanAmount: totalLoanAmount,
                interestType: interestType,
                interestScheme: interestScheme,
                totalPayMonth: totalPayMonth,
                payPerXMonth: payPerXMonth,
                totalInterestAmount: totalInterestAmount,
                profitCompanyRatio: profitCompanyRatio,
                _token: "{{ csrf_token() }}",
            },
            dataType: "json",
            success: function (response) {
                addLoanSimulationToTable(response)
            },
            error: function(response){
                swal("Oops!", "Terjadi kesalahan saat memproses data, mohon koreksi lagi konfigurasi cicilan anda.", "error");
            }
        });
    }

    function addLoanSimulationToTable(data){
        //delete table content
        $('#table-simulation tbody').empty()
        //get data for initial value
        for (let index = 0; index < data["data"].length; index++) {
            //Insert tr to table simulation
            var trRow = '<tr>'
                trRow += "<td>" + data["data"][index]["cicilan_ke"] + "</td>"
                trRow += "<td>" + data["data"][index]["tgl_tagih"] + "</td>"
                trRow += "<td>" + data["data"][index]["saldo_hutang"] + "</td>"
                trRow += "<td>" + data["data"][index]["pokok"] + "</td>"
                // trRow += "<td>" + data["data"][index]["bunga"] + "</td>"
                trRow += "<td>" + data["data"][index]["margin_kop"] + "</td>"
                trRow += "<td>" + data["data"][index]["margin_employee"] + "</td>"
                trRow += "<td>" + data["data"][index]["total_cicilan"] + "</td>"
                trRow += '</tr>'
            $('#table-simulation tbody').append(trRow)
        }
        //Insert last row for total
        var trRow = '<tr>'
                trRow += "<td class='fw-600' colspan='5'>Total</td>"
                trRow += "<td class='fw-600'>"+ data["lastrow"]["total_bunga"] +"</td>"
                trRow += "<td class='fw-600'>"+ data["lastrow"]["total_cicilan"] +"</td>"
                trRow += '</tr>'
        $('#table-simulation tbody').append(trRow)
    }

</script>
