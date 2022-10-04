
<div class="modal-body">
    @csrf
  <div class="form-row mb-4">
     <div class="form-group col-md-12">
         {!! Form::label('Size:') !!}
         {!! Form::text('size', $size->size ?? '', ['class' => 'form-control']) !!}
         
     </div>
      


    </div>
    </div>
 <div class="modal-footer">
    <button type="button" class="btn btn-default waves-effect " data-bs-dismiss="modal">Close</button>
    {!! Form::submit('Save', ['class' => 'btn btn-info waves-effect', 'id' => 'on_submit_size']) !!}
</div>

