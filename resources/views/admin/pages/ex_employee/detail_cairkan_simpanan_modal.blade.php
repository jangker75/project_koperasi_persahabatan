<div class="modal fade" id="modalCairkanSimpanan" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold" id="modalTitle"></h4>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
            </div>
            <div class="modal-body">
                <table id="tableSimpananModal" class="table table-borderless">
                    <tr>
                        <td>{{ __('savings_employee.mandatory_savings_balance') }}</td>
                        <td>:</td>
                        <td id="mandatory_savings">Rp.___</td>
                    </tr>
                    <tr>
                        <td>{{ __('savings_employee.principal_savings_balance') }}</td>
                        <td>:</td>
                        <td id="principal_savings">Rp.___</td>
                    </tr>
                    <tr>
                        <td>{{ __('savings_employee.activity_savings_balance') }}</td>
                        <td>:</td>
                        <td id="activity_savings">Rp.___</td>
                    </tr>
                    <tr style="border-bottom: 1px solid black;">
                        <td>{{ __('savings_employee.voluntary_savings_balance') }}</td>
                        <td>:</td>
                        <td id="voluntary_savings">Rp.___</td>
                    </tr>
                    <tr style="border-bottom: 1px solid black; font-weight: 800;">
                        <td style="font-weight: 800;">Total Saldo Simpanan</td>
                        <td style="font-weight: 800;">:</td>
                        <td style="font-weight: 800;" id="total_savings">Rp.___</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <form action="" id="formCairkanSimpanan" method="post">
                    @csrf
                <button type="submit" class="btn btn-success">Cairkan</button>
                </form>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
            </div>
        </div>
    
    </div>
  </div>