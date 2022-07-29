<x-admin-layout>
    <a href="{{ $currentIndex }}" type="button" class="btn btn-danger mb-3">{{ __('general.button_cancel') }}</a>
    @include('admin.pages.loan_list.detail_card_loan')
    <a href="{{ $currentIndex }}" type="button" class="btn btn-danger mb-3">{{ __('general.button_cancel') }}</a>
</x-admin-layout>