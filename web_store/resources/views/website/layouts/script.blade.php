<script type="text/javascript">
    $('#invoiceExampleModal').modal({
        backdrop: 'static',
        keyboard: false
    })
    $('#closeModal').click();
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
        dom: 'Blfrtip',
        responsive: true,
        pageLength: 20,
        lengthMenu: [[20, 30, 50, -1], [20, 30, 50, "All"]],        
        autoWidth: true,
        "processing": true,
        "serverSide": false,
        "deferRender": true,
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

    
    //permissions and roles
    //datatable api instance
    var table = new $.fn.dataTable.Api( '.js-exportable' );
    table.rows().nodes().to$().find('input[name="allowed[]"]').click(function(){
            status = $(this).prop('checked');
        $.ajax({
            url: "{{ route('updateUserPermissions') }}",
            type: 'post',
            data: { 
                status: status,
                permission: this.value,
                id: this.attributes.user_id.value,
                _token: "{{csrf_token()}}"
            },
            dataType: 'html',
            success: function (data) {
                console.log(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    //adding products to invoice
    var invoiceTable = new $.fn.dataTable.Api( '.js-exportable' );
    invoiceTable.rows().nodes().to$().find('input[name="invoice_products[]"]').click(function(){
            status = $(this).prop('checked');
            productId = this.attributes.value.value;
            salesPrice = this.attributes.sales_price.value;
            quantity = this.attributes.quantity.value;
            $('#product_inventories').html('<label class="card-inside-title">{{ __("website.select_inventory") }}</label>');
            if(status == "true"){
                $("#productId").val(productId);
                $("#sales_price").val(salesPrice);
                $("#total_quantity").val(quantity);
                $('#product_inventories').append('<select onchange="getOptionValue(event)" name="inventory_id"  class="form-control show-tick">');
                $("#inventory_"+productId+" option").each(function(){
                    console.log(this.value);
                    $("#product_inventories select").append('<option value="'+this.value+'">'+this.text+'</option>');
                    
                    // $('#product_inventories select').append(new Option(this.text, this.value));
                });
                $('#product_inventories').append('</select>');
                $('#invoicePriceModel').click();
            }else{
                updateInvoiceProducts("{{route('storeInvoiceProducts')}}",productId,salesPrice,false)
            }
       
    });

    //function to clear invoice price modal inputs
    function clearInputs(){
        productId = $("#productId").val();
        $('#basic_checkbox_'+productId).prop('checked', false);
        $("#productId").val("");
    }
    function updateInvoiceProducts(path,product_id=null,price=null,status="true",quantity=null){
        if(product_id == null && price == null){
            product_id = $("#productId").val();
            price = $("#sales_price").val();
            quantity = $("#quantity").val();
            total_quantity = $("#total_quantity").val();
            inventory_id = $('#product_inventories select').find(":selected").val();
            status = "true";
        }
        if(quantity == ''){
            swal("{{ __('website.quantity_required') }}", "", "error");
        }else if(parseInt(total_quantity) < parseInt(quantity)){
            swal("{{ __('website.quantity_not_validated') }}", "", "error");
        }else{
            $.ajax({
                url: path,
                type: 'post',
                data: { 
                    status: status,
                product_id: product_id,
                price: price,
                quantity: quantity,
                inventory_id: inventory_id,
                _token: "{{csrf_token()}}"
                },
                dataType: 'html',
                success: function (data) {
                    $("#productId").val("");
                    $("#quantity").val("");
                    $("#closeModal").click();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    }
    
    var id_array = [
        @if(isset($inventories))
        @foreach ($inventories as $inventory)
            "{{ $inventory->id }}", 
        @endforeach
        @endif
        @if(isset($product->inventories))
        @foreach ($product->inventories as $inventory)
            "{{ $inventory->id }}", 
        @endforeach
        @endif
        
    ];
    
    function addToQuantity(){
        var total = 0;
        document.getElementById("input-quantity").value = total;
        var inventories = document.getElementById("inventories").children;
        console.log(inventories);
        id_array.forEach(function(item){
            var inventory = document.getElementById("input-quantity_in_inventory" + (item));
            if (inventory.value == null || inventory.value == '') {
                inventory.value = 0;
            }
            total += parseInt(inventory.value);
            document.getElementById("input-quantity").value = total;
        });
    }
    
    function getOptionValue(evt){
        
    }
</script>