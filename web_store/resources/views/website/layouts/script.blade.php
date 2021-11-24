<script>

    //delete Field
    function deleteField(id,path){
        swal({
            title: "{{ __('website.text_sure') }}",
            text: "{{ __('website.text_not_recoverable') }}",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "{{ __('website.text_delete') }}",
            cancelButtonText: "{{ __('website.text_cancel') }}",
            closeOnConfirm: false,
            closeOnCancel: false
            }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                url: path,
                type: 'post',
                data: { 
                    id: id,
                    _token: "{{csrf_token()}}"
                },
                dataType: 'html',
                success: function (data) {
                    if(data.length > 0){
                        $('#work-table').html(data);
                    }else{
                        $('#work-table').html("<span style='font-size: 13px;'>{{ __('website.text_no_table_data') }}</span>");
                    }
                    swal({
                        title: "{{ __('website.info_success') }}",
                        text: "{{ __('website.text_deleted_success') }}",
                        type: "success",
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
            } else {
                swal("{{ __('website.text_done_canceled') }}", "{{ __('website.text_no_cancle') }}", "error");
            }
        });
    }

    //dataTables  configs
    $('.js-exportable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            {
                extend: 'copy',
                text: 'Copy',
                className: 'btn btn-outline-primary text-center',
                exportOptions: {
                columns: ':visible :not(:last-child)'
                }
            },
            {
                extend: 'csv',
                className: 'btn btn-outline-primary text-center',
                exportOptions: {
                columns: ':visible :not(:last-child)'
                }
            },
            {
                extend: 'excel',
                className: 'btn btn-outline-primary text-center',
                exportOptions: {
                columns: ':visible :not(:last-child)'
                }
            },
            {
                extend: 'print',
                className: 'btn btn-outline-primary text-center',
                exportOptions: {
                columns: ':visible :not(:last-child)'
                }
            },
            
        ],
        columnDefs: [
            { className: 'text-center', targets: "_all" },
        ],
    });
</script>