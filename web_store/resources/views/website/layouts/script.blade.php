<script>
    //Delete user 
    function deleteUser(user_id){
        
        $.ajax({
            url: "{{ url('user/delete') }}",
            type: 'post',
            data: { 
                user_id: user_id,
                _token: "{{csrf_token()}}"
            },
            dataType: 'html',
            
            success: function (data) {
                if(data.length > 0){
                    $('#user-table').html(data);
                }else{
                    $('#user-table').html("<span style='font-size: 13px;'>{{ __('website.text_no_table_data') }}</span>");
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
</script>