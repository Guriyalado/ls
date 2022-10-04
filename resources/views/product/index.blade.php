@extends('layouts.app')
@section('title')
    {{ 'Subject - Product' }}
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
                    <h4 class="text-themecolor">Product</h4>
                </div> 
                <div class="col-md-7 align-self-end text-right">
                    <div class="d-flex mt-4 justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Product</li>
                        </ol>



                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-header bg-white modal-header d-block">
                            <h1 class="h3 mb-0 text-gray-800 float-left">Product</h1>
                            <a type="button" href="javascript:void(0);" class="btn float-right btn-primary btn-modal waves-effect waves-light"
                                data-href="{{ action('App\Http\Controllers\Product\ProductController@create') }}"
                                data-container="#ajax_modal" style="color:#fff!important;">
                                <i class="fa fa-plus"></i> Add
                            </a>                           
                                                          
                        </div>
                        <div class="card-body">
                            <div class="dt-responsive table-responsive">
                                <table id="data_table" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th >Product Name</th>
                                            <th >Product Price</th>
                                            <th >Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Zero config.table end -->
                    <div class="modal fade" id="ajax_modal" tabindex="-1" role="dialog" style=""></div>
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
            data: 'product_name',
            name: 'product_name'
        },
        {
            data: 'product_price',
            name: 'product_price'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        },
    ];

    
           
</script>
@include('layouts.partials.common-js');
@endsection

