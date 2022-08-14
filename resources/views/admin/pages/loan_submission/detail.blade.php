<x-admin-layout>
    <div class="d-flex align-items-center mb-2">
            <a href="{{ $currentIndex }}" type="button" class="btn btn-danger">{{ __('general.button_cancel') }}</a>
            <div class="dropdown ms-2">
                <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown">
                        Action
                </button>
                <div class="dropdown-menu" style="">
                    <a class="dropdown-item action-button" href=" {{ route('admin.loan-submission.action.approval', ['status' => 51, 'loan' => $loan->id]) }}">Approve</a>
                    <a class="dropdown-item action-button" href=" {{ route('admin.loan-submission.action.approval', ['status' => 52, 'loan' => $loan->id]) }}">Reject</a>
                </div>
            </div>
    </div>
    @include('admin.pages.loan_list.detail_card_loan')
    <a href="{{ $currentIndex }}" type="button" class="btn btn-danger mb-3">{{ __('general.button_cancel') }}</a>
</x-admin-layout>