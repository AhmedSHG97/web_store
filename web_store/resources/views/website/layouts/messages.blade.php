@if($errors->any())
    {{-- <div class="alert bg-red alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ $errors->first() }}
    </div> --}}
    <script>
        swal({
        title: "{{ __('website.info_warning') }}",
        text: "{{ $errors->first() }}",
        type: "warning",
        // showCancelButton: true,
        // confirmButtonColor: "#DD6B55",
        // confirmButtonText: "Yes, delete it!",
        // closeOnConfirm: false
        });
    </script>
@endif
@if(session()->has('success'))
    {{-- <div class="alert bg-green alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ session('success') }}
    </div>  --}}
    <script>
        swal({
        title: "{{ __('website.info_success') }}",
        text: "{{ session('success') }}",
        type: "success",
        // showCancelButton: true,
        // confirmButtonColor: "#DD6B55",
        // confirmButtonText: "Yes, delete it!",
        // closeOnConfirm: false
        });
    </script> 
@endif