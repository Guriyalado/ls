
<div class="modal-body">
    @csrf
  
    <div class="form-group">
                                    {{ Form::label('Product Category: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('product_category', $product->product_category ?? '', ['class' => 'form-control',  'id' => 'product_category', 'placeholder' => 'Product Category']) !!}
                                   
                                </div>
                               <div class="form-group">
                                    {{ Form::label('Product Industry: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('product_industry', $product->product_industry ?? '', ['class' => 'form-control',  'id' => 'product_industry', 'placeholder' => 'Product Industry']) !!}
                                    
                                </div>
                                <div class="form-group">
                                    {{ Form::label('Product Name: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('product_name', $product->product_name ?? '', ['class' => 'form-control',  'id' => 'product_name', 'placeholder' => 'Product Name']) !!}
                                   
                                
                                </div>
                                <div class="form-group ">
                                     {{ Form::label('Product Price: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('product_price', $product->product_price ?? '', ['class' => 'form-control',  'id' => 'product_price', 'placeholder' => 'Product Price']) !!}
                                   
                                </div>
                                <div class="form-group ">
                                     {{ Form::label('Product size: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('product_size', $product->product_size ?? '', ['class' => 'form-control',  'id' => 'product_size', 'placeholder' => 'Product Size']) !!}
                                   
                                </div>
                                 <div class="form-group ">
                                     {{ Form::label('Product Descreption: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('product_descreption', $product->product_descreption ?? '', ['class' => 'form-control',  'id' => 'product_descreption', 'placeholder' => 'Product Descreption']) !!}
                                   
                                </div>
                                <div class="form-group ">
                                     {{ Form::label('Color: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('color', $product->color ?? '', ['class' => 'form-control',  'id' => 'color', 'placeholder' => 'Color']) !!}
                                  
                                </div>
                                <div class="form-group ">
                                     {{ Form::label('Use Case: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('use_case', $product->use_case ?? '', ['class' => 'form-control',  'id' => 'use_case', 'placeholder' => 'Use Case']) !!}
                                   
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
    </div>

 <div class="modal-footer">
    <button type="button" class="btn btn-default waves-effect " data-bs-dismiss="modal">Close</button>
    {!! Form::submit('Save', ['class' => 'btn btn-info waves-effect', 'id' => 'on_submit_product']) !!}
</div>

