<x-admin-layout titlePage="{{ $titlePage }}">
    {{-- PROFIT SECTION --}}
    <div class="row my-4">
        <div class="div">
            <a href="{{ route('admin.company-balance.create') }}">
                <button class="btn btn-primary">Transfer Saldo Internal</button>
            </a>
            <a href="{{ route('admin.company-balance.transfer-saldo-employee') }}">
                <button class="btn btn-success">Tarik Saldo dari Nasabah</button>
            </a>
        </div>
    </div>
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
    {{-- END PROFIT SECTION --}}

<div class="row">

    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
        <div class="card overflow-hidden">
            <div class="card-body pb-5 bg-green">
                <h3 class="card-title text-white">Jumlah Pengajuan Pinjaman</h3>
            </div>
            <div id="flotback-chart" class="flot-background" style="padding: 0px;"><canvas class="flot-base" width="517" height="600" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 258.5px; height: 300px;"></canvas><canvas class="flot-overlay" width="517" height="600" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 258.5px; height: 300px;"></canvas></div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-4 mt-3 ">
                    <div class="avatar avatar-md bg-warning-transparent text-secondary bradius me-3">
                        <i class="fa fa-exclamation"></i>
                    </div>
                    <div class="">
                        <h6 class="fw-semibold">Waiting Approval</h6>
                    </div>
                    <div class="ms-auto">
                        <p class="fw-bold fs-20"> {{ $loanWaiting }} </p>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-4 mt-3">
                    <div class="avatar avatar-md bg-secondary-transparent text-secondary bradius me-3">
                        <i class="fe fe-check"></i>
                    </div>
                    <div class="">
                        <h6 class="mb-1 fw-semibold">Approved</h6>
                    </div>
                    <div class=" ms-auto my-auto">
                        <p class="fw-bold fs-20"> {{ $loanApproved }} </p>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-4 mt-3">
                    <div class="avatar  avatar-md bg-pink-transparent text-pink bradius me-3">
                        <i class="fe fe-x"></i>
                    </div>
                    <div class="">
                        <h6 class="mb-1 fw-semibold">Rejected</h6>
                    </div>
                    <div class=" ms-auto my-auto">
                        <p class="fw-bold fs-20 mb-0"> {{ $loanRejected }} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-12 col-lg-5 col-xl-5">
        <div class="card overflow-hidden">
            <div class="card-body pb-5 bg-primary">
                <h3 class="card-title text-white">Jumlah Uang yang dipinjam</h3>
            </div>
            <div id="flotback-chart" class="flot-background" style="padding: 0px;"><canvas class="flot-base" width="517" height="600" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 258.5px; height: 300px;"></canvas><canvas class="flot-overlay" width="517" height="600" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 258.5px; height: 300px;"></canvas></div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-4 mt-3">
                    <div class="avatar avatar-md bg-warning-transparent text-secondary bradius me-3">
                        <i class="fe fe-dollar-sign"></i>
                    </div>
                    <div class="">
                        <h6 class="mb-1 fw-semibold">Total Dipinjamkan</h6>
                    </div>
                    <div class=" ms-auto my-auto">
                        <p class="fw-bold fs-20"> {{ format_uang($loan->sum('total_loan_amount')) }} </p>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-4 mt-3">
                    <div class="avatar avatar-md bg-success-transparent text-secondary bradius me-3">
                        <i class="fe fe-dollar-sign"></i>
                    </div>
                    <div class="">
                        <h6 class="mb-1 fw-semibold">Total Terbayar</h6>
                    </div>
                    <div class=" ms-auto my-auto">
                        <p class="fw-bold fs-20"> {{ format_uang($loanPaid->sum('total_payment')) }} </p>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-4 mt-3">
                    <div class="avatar avatar-md bg-secondary-transparent text-secondary bradius me-3">
                        <i class="fe fe-dollar-sign"></i>
                    </div>
                    <div class="">
                        <h6 class="mb-1 fw-semibold">Total Sisa Terpinjam</h6>
                    </div>
                    <div class=" ms-auto my-auto">
                        <p class="fw-bold fs-20"> {{ format_uang($loan->sum('total_loan_amount') - $loanPaid->sum('total_payment')) }} </p>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-4 mt-3">
                    <div class="avatar avatar-md bg-secondary-transparent text-danger bradius me-3">
                        <i class="fe fe-dollar-sign"></i>
                    </div>
                    <div class="">
                        <h6 class="mb-1 fw-semibold">Profit Bunga</h6>
                    </div>
                    <div class=" ms-auto my-auto">
                        <p class="fw-bold fs-20"> {{ format_uang($loanPaid->sum('profit_company_amount')) }} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    {{-- INFORMASI KOPERASI SECTION --}}
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
    {{-- END INFORMASI KOPERASI SECTION --}}

    {{-- MODAL --}}
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
                        // add data requested to modal body
                        $('#table-history-balance-modal tbody').append(tRow)
                    });
                })
            })
        </script>
    @endslot
    @slot('style')
        <style>
            table#table-history-balance-modal tr th{
                font-weight: 800;
            }
        </style>
    @endslot
</x-admin-layout>
