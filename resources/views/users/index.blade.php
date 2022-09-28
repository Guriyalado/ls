@extends('layouts.app')

@section('title', 'Users List')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 mt-4 text-gray-800">Users</h1>
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route('users.create') }}" class="mt-4 btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Add New
                        </a>
                    </div>
                    <!--<div class="col-md-6">
                        <a href="{{ route('users.export') }}" class="mt-4 btn btn-sm btn-success">
                            <i class="fas fa-check"></i> Export To Excel
                        </a>
                    </div>-->
                    
                </div>

            </div>

            {{-- Alert Messages --}}
            @include('common.alert')

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">All Users</h6>

                </div>
                <div class="card-body">
                    <div class="table-responsive" style="overflow-x:hidden;">
                        <table class="table table-striped table-bordered nowrap" id="users_table" width="100%" cellspacing="0" >
                            <thead>
                                <tr>
                                    <th width="20%">Name</th>
                                    <th width="25%">Email</th>
                                    <th width="15%">Company Name</th>
                                    <th width="15%">Status</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>

                       
                    </div>
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
            data: 'email',
            name: 'email'
        },
        {
            data: 'company_name',
            name: 'company_name'
        },
        {
            data: 'status',
            name: 'status'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        },
    ];
        $(function () {
      
            var data_table = $('#users_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
                columns: columns
            });
            
        });
        $( document ).ready(function() {
            $(document).on('click', '.delete_button', function(e) {
                e.preventDefault();
                var thePath = $(this).attr('href');
                alert(thePath);
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
                            type: 'get',
                            url: $(this).data('href'),
                            dataType: 'json',
                            data: {
                                'id': data,
                                '_token': '{{ csrf_token() }}'
                            },
                            success: function(result) {
                                if (result.success === true) {
                                    toastr.success(result.msg);
                                    data_table.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            },
                        });
                    }
                });
            });
        });
    </script>
@endsection
