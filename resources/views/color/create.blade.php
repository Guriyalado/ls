<h3 class="page-title">Color</h3>
{!! Form::open(['method' => 'POST', 'route' => ['color.store']]) !!}

<div class="panel panel-default">
    <div class="panel-heading">
        Create
    </div>
    
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 form-group">
                {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('name'))
                    <p class="help-block">
                        {{ $errors->first('name') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 form-group">
                {!! Form::label('color', 'Color', ['class' => 'control-label']) !!}
                {!! Form::text('color', old('color'), ['class' => 'form-control', 'placeholder' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('color'))
                    <p class="help-block">
                        {{ $errors->first('color') }}
                    </p>
                @endif
            </div>
        </div>
        
    </div>
</div>

{!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}
{!! Form::close() !!}

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.min.js"></script>
    <script>
        $('.colorpicker').colorpicker();
    </script>
@stop