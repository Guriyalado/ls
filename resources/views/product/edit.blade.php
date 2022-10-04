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
                            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Product</a></li>
                            <li class="breadcrumb-item active">Edit Product</li>
                        </ol>



                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-header bg-white modal-header d-block">
                            <h1 class="h3 mb-0 text-gray-800 float-left">Edit Product</h1>
                            <a type="button" href="javascript:void(0);" class="btn float-right btn-primary btn-modal waves-effect waves-light"
                                href="{{ route('product.index') }}"
                                data-container="#ajax_modal" style="color:#fff!important;">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>                           
                                                          
                        </div>
                        {!! Form::open(['url' => action('App\Http\Controllers\Product\ProductController@update', [$corporate->id]), 'method' => 'PUT', 'id' => 'ajax_form',  'enctype' => 'multipart/form-data' ]) !!}
                            
                            <div class="card-body">
                                @php
                                    $form = 'edit';
                                @endphp
                                @csrf
                                <div class="form-group">
                                    {{ Form::label('Product Category: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('product_category', $product->product_category ?? '', ['class' => 'form-control',  'id' => 'product_category', 'placeholder' => 'Product Category']) !!}
                                    <span class="md-line text-danger" id="name_error"></span>
                                </div>
                               <div class="form-group">
                                    {{ Form::label('Product Industry: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('product_industry', $product->product_industry ?? '', ['class' => 'form-control',  'id' => 'product_industry', 'placeholder' => 'Product Industry']) !!}
                                    <span class="md-line text-danger" id="name_error"></span>
                                
                                </div>
                                <div class="form-group">
                                    {{ Form::label('Product Name: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('product_name', $product->product_name ?? '', ['class' => 'form-control',  'id' => 'product_name', 'placeholder' => 'Product Name']) !!}
                                    <span class="md-line text-danger" id="name_error"></span>
                                
                                </div>
                                <div class="form-group ">
                                     {{ Form::label('Product Price: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('product_price', $product->product_price ?? '', ['class' => 'form-control',  'id' => 'product_price', 'placeholder' => 'Product Price']) !!}
                                    <span class="md-line text-danger" id="thumb_error"></span>
                                </div>
                                <div class="form-group ">
                                     {{ Form::label('Product size: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('product_size', $product->product_size ?? '', ['class' => 'form-control',  'id' => 'product_size', 'placeholder' => 'Product Size']) !!}
                                    <span class="md-line text-danger" id="thumb_error"></span>
                                </div>
                                 <div class="form-group ">
                                     {{ Form::label('Product Descreption: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('product_descreption', $product->product_descreption ?? '', ['class' => 'form-control',  'id' => 'product_descreption', 'placeholder' => 'Product Descreption']) !!}
                                    <span class="md-line text-danger" id="thumb_error"></span>
                                </div>
                                <div class="form-group ">
                                     {{ Form::label('Color: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('color', $product->color ?? '', ['class' => 'form-control',  'id' => 'color', 'placeholder' => 'Color']) !!}
                                    <span class="md-line text-danger" id="thumb_error"></span>
                                </div>
                                <div class="form-group ">
                                     {{ Form::label('Use Case: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('use_case', $product->use_case ?? '', ['class' => 'form-control',  'id' => 'use_case', 'placeholder' => 'Use Case']) !!}
                                    <span class="md-line text-danger" id="thumb_error"></span>
                                </div>
                                 <div class="form-group col-md-4">
        {{ Form::label('Discount: *', null, ['class' => 'label text-black']) }}
        {!! Form::select('discount', ['10' => '10%', '20' => '20%','30' => '30%','40' => '40%','50' => '50%','60' => '60%','70' => '70%','80' => '80%'], $product->discount ?? '', ['placeholder' => __('Select'), 'class' => 'form-control']) !!}

    </div>
     <div class="form-group ">
                                     {{ Form::label('Total Price: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('total_price', $product->total_price ?? '', ['class' => 'form-control',  'id' => 'total_price', 'placeholder' => 'Total price']) !!}
                                   
                                </div>
                            
                            </div>
                            <div class="card-footer">
                                
                                {!! Form::submit('Save', ['class' => 'btn btn-info waves-effect', 'id' => 'on_submit_corporate']) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                   
                </div>
            </div>
        </div>
    </section>
</div>


@endsection

@section('scripts')

<script>
    $(document).ready(function(){
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
                        setTimeout(function(){window.location.href=baseUrl+"corporate"} , 5000);
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

