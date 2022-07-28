<x-admin-layout titlePage="{{ $titlePage }}">
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <x-employee.employee-balance-card-component :text="__('balance_company.loan_balance')" :value="$company->balance->loan_balance" type_balance="loan_balance"/>
        </div>
        <div class="col-md-6 col-lg-3">
            <x-employee.employee-balance-card-component :text="__('balance_company.store_balance')" :value="$company->balance->store_balance" type_balance="store_balance"/>
        </div>
        <div class="col-md-6 col-lg-3">
            <x-employee.employee-balance-card-component :text="__('balance_company.other_balance')" :value="$company->balance->other_balance" type_balance="other_balance"/>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <x-employee.employee-balance-card-component :text="__('balance_company.total_balance')" :value="$company->balance->total_balance" type_balance="total_balance"/>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4>Informasi Koperasi</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>{{ __('company.name') }}</td>
                            <td>{{ $company->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('company.address') }}</td>
                            <td>{{ $company->address }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('company.phone') }}</td>
                            <td>{{ $company->phone }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('company.description') }}</td>
                            <td>{{ $company->description }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('admin.pages.company_balance.history_balance_modal')
    @slot('script')
        <script>
            $(document).ready(function(){
                //Show modal table history
                $('.balance-card').on('click', function(e){
                    let type = $(this).data('type-balance')
                    $('#table-history-balance-modal tbody tr').remove()
                    let tRow = ''
                    $.ajax({
                        type: "get",
                        url: "{{ url('admin/company-balance-history').'/' }}"+ type,
                        dataType: "json",
                        success: function (response) {
                            $('#history-modal-title').text(response.type)
                            response.data.forEach(item => {
                                tRow += "<tr><td>" +
                                    item.transaction_date + "</td><td>" +
                                    (item.transaction_type == 'credit' ? item.amount : "") + "</td><td>" +
                                    (item.transaction_type == 'debit' ? item.amount : "") + "</td><td>" +
                                    item.balance_after + "</td><td>" +
                                    item.description + "</td></tr>"
                            })
                        }
                    }).then(() => {
                        $('#table-history-balance-modal tbody').append(tRow)
                    });
                })
            })
        </script>
    @endslot
</x-admin-layout>
