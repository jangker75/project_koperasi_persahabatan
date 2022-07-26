@props(['value' => 0, 'text' => 'No Name', 'type_balance' => ''])
<div class="card">
    <div class="row">
        <div class="col-4 align-items-center">
            <div
                class="card-img-absolute  circle-icon bg-success align-items-center text-center box-success-shadow bradius">
                <img src="{{ asset('assets/images/svgs/circle.svg') }}" alt="img" class="card-img-absolute">
                <i class="pe-7s-cash fs-30 text-white mt-4"></i>
            </div>
        </div>
        <div class="col-8">
            <div class="card-body p-4">
                <p class="mb-2 fw-normal mt-2 fs-5">{{ format_uang($value) }}</p>
                <p class="fw-normal mb-0">{{ $text }}</p>
                <button data-type-balance="{{ $type_balance }}" data-bs-toggle="modal"
                    data-bs-target="#history-balance-modal" class="btn btn-primary btn-sm balance-card">Riwayat Saldo</button>
            </div>
        </div>
    </div>
</div>
