<x-admin-layout titlePage="{{ $titlePage }}">
    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Notifikasi Request Peminjaman</h5>
                </div>
                <div class="card-body scroll">
                    <div class="content vscroll h-300">
                    @foreach ($loanNew as $loan)
                    <div class="media mb-5 mt-0">
                        <div class="media-body">
                            <a target="_blank" href="{{ route('admin.loan-submission.show', $loan->id) }}" class="text-dark fw-bold fs-6">{{ $loan->transaction_number }}</a>
                            <div class="small fs-6">{{ $loan->employee->full_name ?? '' }}</div>
                            <div class="small mt-3">Di request oleh : {{ $loan->user->employee->full_name ?? '' }} ({{ getUserRole($loan->created_by) == 'nasabah' ? 'Nasabah' : 'Admin' }})</div>
                            <div class="text-muted small">{{ \Carbon\Carbon::parse($loan->created_at)->diffForHumans() }}</div>
                        </div>
                        <a target="_blank" href="{{ route('admin.loan-submission.show', $loan->id) }}" class="btn btn-primary btn-sm d-block">View</a>
                    </div>
                    @endforeach
                </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>