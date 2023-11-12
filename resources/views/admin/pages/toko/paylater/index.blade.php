<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fw-bold">{{ str("list User dengan total Paylater")->title() }}</h3>
                    <div class="card-options">
                      <a href="{{ route('admin.paylater.index') }}" class="btn btn-primary">Refresh <i class="fa fa-refresh    "></i></a>
                    </div>
                    
                </div>
                <div class="card-body">
                    <div class="row mb-5">
                        <div>
                            <span>Download report</span>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary fw-bold text-wrap" id="btnDownload">
                                <i class="fa fa-print me-2"></i>Download Report
                            </button>
                        </div>
                    </div>
                    <div class="row mb-5">
                      <div class="col-12 col-md-3">
                        <h5>Total Tagihan Belum Lunas : <strong class="fw-bold text-danger">{{ format_uang($totalNotPaid) }}</strong></h5>
                      </div>
                      <div class="col-12 col-md-3">
                        <h5>Total Tagihan Lunas : <strong class="fw-bold text-success">{{ format_uang($totalPaid) }}</strong></h5>
                      </div>
                    </div>
                    <div class="w-100">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatable">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>Department</th>
                                        <th>Position</th>
                                        <th>status</th>
                                        <th>Jumlah Permintaan</th>
                                        <th>total paylater</th>
                                        <th>total tagihan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paylaters as $i => $paylater)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td>{{ $paylater->employeeFullName }}</td>
                                        <td>{{ $paylater->nik }}</td>
                                        <td>{{ $paylater->departmentName }}</td>
                                        <td>{{ $paylater->positionName }}</td>
                                        <td>{{ $paylater->statusName }}</td>
                                        <td>{{ $paylater->countTransaction }}</td>
                                        <td>{{ format_uang($paylater->totalAmount) }}</td>
                                        <td><span class="text-danger">{{ format_uang($paylater->totalUnpaid) }}</span></td>
                                        <td>
                                          <a href="{{ route('admin.paylater.show', $paylater->id) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <form id="formDownload" action="{{ route('download.history-paylater') }}" method="POST">
            @csrf
        </form>
    </div>
    <x-slot name="scriptVendor">
        <script src="{{ asset('/assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    </x-slot>

    @slot('script')
    <script>
        $(document).ready(function () {
            $("#datatable").DataTable();
        })
        $("#btnDownload").on("click", function(){
            $("#formDownload").submit()
        })
    </script>
    @endslot
</x-admin-layout>
