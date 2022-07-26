<script>
    $(document).ready(function() {
        $('#datatable').on('click', '.delete-button', function(e) {
            let form = $(this).siblings("form");
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                },
                function(isConfirm) {
                    if (isConfirm) {
                        swal("Deleted!", "Your data has been deleted.", "success")
                        form.submit()
                    }
            });
            // swal({
            //     title: 'Are you sure?',
            //     text: "You won't be able to revert this!",
            //     icon: 'warning',
            //     showCancelButton: true,
            //     confirmButtonText: 'Yes, delete it!',
            //     cancelButtonText: 'Cancel',
            //     buttons: {
            //         confirm: {
            //             text: 'Yes, delete it!',
            //             className: 'btn btn-success'
            //         },
            //         cancel: {
            //             visible: true,
            //             className: 'btn btn-danger'
            //         }
            //     }
            // }).then((Delete) => {
            //     if (Delete) {
            //         form.submit();
            //         swal({
            //             title: 'Deleted!',
            //             text: 'Your data has been deleted.',
            //             icon: 'success',
            //             buttons: {
            //                 confirm: {
            //                     className: 'btn btn-success'
            //                 }
            //             }
            //         });
            //     } else {
            //         swal.close();
            //     }
            // });
        });
    });
</script>
