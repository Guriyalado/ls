<div class="modal-body">
    @csrf
    <div class="form-group">
        {{ Form::label('Industry name: *', null, ['class' => 'label text-black']) }}
        {!! Form::text('name', $industry->name ?? '', ['class' => 'form-control', 'name' => 'name', 'id' => 'name', 'placeholder' => 'Industry name']) !!}
        <span class="md-line text-danger" id="name_error"></span>
    </div>
    <div class="form-group">
        {{ Form::label('Icon: ', null, ['class' => 'label text-black']) }}
        {!! Form::file('icon', ['class' => 'form-control', 'id' => 'icon']) !!}
        <span class="md-line text-danger" id="icon_error"></span>
    </div>
    <div class="form-group banner">
        {{ Form::label('Image: ', null, ['class' => 'label text-black']) }}
        {!! Form::file('banner', ['class' => 'form-control', 'id' => 'banner']) !!}
        <span class="md-line text-danger" id="banner_error"></span>
    </div>
    <div class="form-group thumb">
        {{ Form::label('Thumb: ', null, ['class' => 'label text-black']) }}
        {!! Form::file('thumb', ['class' => 'form-control', 'id' => 'thumb']) !!}
        <span class="md-line text-danger" id="thumb_error"></span>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default waves-effect " data-bs-dismiss="modal">Close</button>
    {!! Form::submit('Save', ['class' => 'btn btn-info waves-effect', 'id' => 'on_submit_industry']) !!}
</div>
