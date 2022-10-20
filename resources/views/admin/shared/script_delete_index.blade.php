<script>
    $(document).ready(function () {
        $('#datatable').on('click', '.delete-button', function (e) {
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
                function (isConfirm) {
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

        $("body").on('keyup', '.format-uang', function(){
          $(this).val(formatRupiah($(this).val()))
        })
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
        
        function truncateString(str, num) {
            if (str.length > num) {
                return str.slice(0, num) + "...";
            } else {
                return str;
            }
        }
    });

</script>
