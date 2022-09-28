<div class="modal-body">
    <div class="form-group">
        {{ Form::label('Category name: *', null, ['class' => 'label text-black']) }}
        {!! Form::text('name', $category->name ?? '', ['class' => 'form-control', 'name' => 'name', 'id' => 'name', 'placeholder' => 'Category name']) !!}
        <span class="md-line" id="name_error"></span>
    </div>
    <div class="form-group">
        {{ Form::label('Category code: *', null, ['class' => 'label text-black']) }}
        {!! Form::text('short_code', $category->short_code ?? '', ['class' => 'form-control', 'name' => 'short_code', 'id' => 'short_code', 'placeholder' => 'Category code']) !!}
        <span class="md-line" id="short_code_error"></span>
    </div>

    <div class="form-group">
        {{ Form::label('Description: ', null, ['class' => 'label text-black']) }}

        {!! Form::text('description', $category->description ?? '', ['class' => 'form-control', 'name' => 'description', 'id' => 'description', 'placeholder' => 'Description']) !!}
        <span class="md-line" id="description_error"></span>
    </div>
        <div class="form-group">
            {!! Form::label('Industry:*') !!}
            <div class="controls category">
                {!! Form::select('industry_id', $industries, $category->industry_id ?? '', ['placeholder' => __('please_select'), 'class' => 'form-control select2 ', 'data-validation-required-message' => 'The industry field is required']) !!}
                <span class="md-line" id="business_id_error"></span>
            </div>
        </div>

    <div class="form-group">
        {{ Form::label('Icon: ', null, ['class' => 'label text-black']) }}
        {!! Form::file('icon', ['class' => 'form-control', 'id' => 'icon']) !!}
        <span class="md-line" id="icon_error"></span>
    </div>
    <div class="form-group banner">
        {{ Form::label('Image: ', null, ['class' => 'label text-black']) }}
        {!! Form::file('banner', ['class' => 'form-control', 'id' => 'banner']) !!}
        <span class="md-line" id="banner_error"></span>
    </div>
    <div class="form-group thumb">
        {{ Form::label('Thumb: ', null, ['class' => 'label text-black']) }}
        {!! Form::file('thumb', ['class' => 'form-control', 'id' => 'thumb']) !!}
        <span class="md-line" id="thumb_error"></span>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default waves-effect " data-bs-dismiss="modal">Close</button>
    {!! Form::submit('Save', ['class' => 'btn btn-info waves-effect', 'id' => 'on_submit_category']) !!}
</div>
