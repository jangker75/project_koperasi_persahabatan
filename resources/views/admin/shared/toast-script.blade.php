<script>
    let msg = ''
    // $('#alertToast').on('show.bs.toast', function() {
    //     $('.toast-body').html(msg)
    // })
    $(document).ready(function() {
        @if (session('success'))
            msg = "{{ session('success') }}"
            // $('#alertToast').toast('show')
            swal({
                title: "Success",
                text: msg,
                type: 'success',
            });
        @endif
    })
</script>