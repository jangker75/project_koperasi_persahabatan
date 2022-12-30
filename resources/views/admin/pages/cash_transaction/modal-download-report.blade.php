<div class="modal fade" id="modalDownloadReport" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Download report transaction</h5>
        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
      </div>
      <form target="_blank" action="{{ route('admin.download.report-cash-transaction', ['type' => 'pdf']) }}" id="formDownloadReport" method="post">
        @csrf
      <div class="modal-body">
        <div class="row mb-4">
            {!! Form::label('date_from', 'Dari Tanggal', ['class' => 'col-md-3 form-label required']) !!}
            <div class="col-md-9">
                <div class="input-group" >
                    <div class="input-group-text">
                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                    </div>
                    {!! Form::text('date_from', null, [
                        'id' => 'date_from',
                        "required" => "required",
                        'class' => 'form-control fc-datepicker'.
                            ($errors->has('date_from') ? ' is-invalid' : '') .
                            (!$errors->has('date_from') && old('date_from') ? ' is-valid' : ''),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="row mb-4">
            {!! Form::label('date_to', 'Sampai Tanggal', ['class' => 'col-md-3 form-label required']) !!}
            <div class="col-md-9">
                <div class="input-group" >
                    <div class="input-group-text">
                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                    </div>
                    {!! Form::text('date_to', null, [
                        'id' => 'date_to',
                        "required" => "required",
                        'class' => 'form-control fc-datepicker'.
                            ($errors->has('date_to') ? ' is-invalid' : '') .
                            (!$errors->has('date_to') && old('date_to') ? ' is-valid' : ''),
                    ]) !!}
                </div>
            </div>
        </div>
      </div>
       <div class="modal-footer">
            <button type="submit" id="btnDownloadReport" class="btn btn-success">Download</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
       </div>
    </form>
    </div>
  </div>
</div>
