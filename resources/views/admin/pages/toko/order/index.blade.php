<x-admin-layout titlePage="{{ $titlePage }}">
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header row">
                    <div class="mb-3">
                        <div>
                            <span>Download report</span>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary fw-bold text-wrap" id="btnDownload">
                                <i class="fa fa-print me-2"></i>Download Report
                            </button>
                            <a href="{{route('admin.daily-sales-report.index')}}" class="btn btn-primary fw-bold text-wrap">
                                Laporan Penjualan Harian
                            </a>
                        </div>
                    </div>
                    
                    <br>
                    
                    <div class="col-8">
                        <div>
                            <span>Filter Date</span>
                        </div>
                        <div class="btn-group" style="width: 100%">
                            <input type="text" style="width: 100%" name="daterange" class="form-control" placeholder="Masukan tanggal"
                                autocomplete="off">
                            <button type="button" class="btn btn-success" id="submitFilter">Filter</button>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold text-danger mb-2">Total Paylater : <span id="totalPaylater"></span>
                        </div>
                        <div class="fw-bold text-success m-0">Total Pendapatan : <span id="totalPrice"></span></div>
                    </div>
                    
                    {{-- <div>
                        <span>Filter status</span>
                    </div>
                    <div class="btn-group">
                        <a type="button" data-status="All" class="btn btn-primary fw-bold text-wrap filter-btn">Semua Pinjaman</a>
                        <a type="button" data-status="Approved" class="btn btn-success text-white fw-bold text-wrap filter-btn">Pinjaman Approved</a>
                        <a type="button" data-status="Rejected" class="btn btn-warning fw-bold text-wrap filter-btn">Pinjaman Rejected</a>
                        <a type="button" data-status="Lunas" class="btn btn-success text-white fw-bold text-wrap filter-btn">Pinjaman Lunas</a>
                    </div> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottom" id="datatable">
                            <thead>
                                <tr>
                                    {{-- <th></th> --}}
                                    <th>NO</th>
                                    <th>TANGGAL</th>
                                    <th>KODE ORDER</th>
                                    <th>TOTAL</th>
                                    
                                    <th>SUB TOTAL</th>
                                    <th>NASABAH</th>
                                    <th>PAYLATER</th>
                                    <th>DELIVERY</th>
                                    <th>LUNAS</th>

                                    <th>PRODUK TERJUAL</th>
                                    <th>STATUS</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div style="display: none">
            <form action="{{ route('download.history-order') }}" method="post" id="formdownload">
                @csrf
                <input type="hidden" name="startDate" value="{{ date('Y-m-d') }}" id="startDate">
                <input type="hidden" name="endDate" value="{{ date('Y-m-d') }}" id="endDate">
            </form>
        </div>
        
    </div>
    @slot('script')
        @include('admin.pages.toko.order.index-script-datatables')
    @endslot
</x-admin-layout>
