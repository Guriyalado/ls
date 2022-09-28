@extends('layouts.app')
@section('title')
    {{ 'Subject - Categories' }}
@endsection
@section('content')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h4 class="text-themecolor">Categories</h4>
                </div> 
                <div class="col-md-7 align-self-end text-right">
                    <div class="d-flex mt-4 justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Categories</li>
                        </ol>



                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-header bg-white modal-header d-block">
                            <h1 class="h3 mb-0 text-gray-800 float-left">Categories</h1>
                            <a type="button" href="javascript:void(0);" class="btn float-right btn-primary btn-modal waves-effect waves-light"
                                data-href="{{ action('App\Http\Controllers\Categories\CategoryController@create') }}"
                                data-container="#category_modal" style="color:#fff!important;">
                                <i class="fa fa-plus"></i> Add
                            </a>                           
                                                          
                        </div>
                        <div class="card-body">
                            <div class="dt-responsive table-responsive">
                                <table id="data_table" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th id="name">Category Name</th>
                                            <th id="industry">Industry</th>
                                            <th id="thumb">Thumb</th>
                                            <th id="action">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Zero config.table end -->
                    <div class="modal fade" id="category_modal" tabindex="-1" role="dialog" style=""></div>
                </div>
            </div>
        </div>
    </section>
</div>


@endsection

@section('scripts')

<script>
    var columns= [
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'industry',
            name: 'industry'
        },
        {
            data: 'thumb',
            name: 'thumb'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        },
    ];

    
           
</script>
<script>
    $(function () {
      
      var data_table = $('#data_table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('categories.index') }}",
          columns: columns
      });
        
    });
    $( document ).ready(function() {
        $(document).on('click', '.delete_button', function(e) {
            e.preventDefault();
            var thePath = $(this).attr('href');
            const data = thePath.substring(thePath.lastIndexOf('/') + 1)
            swal({
                title: 'Delete',
                text: 'Are you sure!',
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        method: 'delete',
                        url: $(this).attr('href'),
                        dataType: 'json',
                        data: {
                            'id': data,
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(result) {
                            if (result.success === true) {
                                toastr.success(result.msg);
                                setTimeout(function(){window.location.href=baseUrl+"categories"} , 5000);
                            } else {
                                toastr.error(result.msg);
                            }
                        },
                    });
                }
            });
        });
        $(document).on('click', '.btn-modal', function(e) {
            e.preventDefault();
          alert($(this).data('href'));
            var container = '#category_modal';
            $.ajax({
                url: $(this).data('href'),
                dataType: 'html',
                success: function(result) {
                    $(container)
                        .html(result)
                        .modal('show');
                },
            });
        });
        $(document).on('submit', 'form#ajax_form', function(e) {
            e.preventDefault();
           
            var ref = $(this);
            ref.find('span.md-line').html('');
            ref.find('input[type="submit"]').attr('disabled', true);
            $.ajax({
                method: 'POST',
                url: ref.attr('action'),
                data: new FormData(this),
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.ajax_loader').removeClass('d-none');
                },
                success: function(result) {
                    $('.ajax_loader').addClass('d-none');
                    if (result.success === true) {
                        toastr.success(result.msg);
                        
                        $('form#ajax_modal').modal('hide');
                        setTimeout(function(){window.location.href=baseUrl+"categories"} , 5000);
                    } else {
                        toastr.error(result.msg);
                        console.log(result.msg);
                    }
                },
                error: function(data) {
                    $('.ajax_loader').addClass('d-none');
                    var response = JSON.parse(data.responseText);
                    $.each(response.errors, function(key, value) {
                        $('#' + key + '_error').html(value);
                    });
                    ref.find('input[type="submit"]').attr('disabled', false);
                },
            });
        });
    });

</script>
@endsection

