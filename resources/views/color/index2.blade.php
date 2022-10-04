<table class="table table-bordered table-striped datatable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Color</th>
            <th> </th>
        </tr>
    </thead>
    
    <tbody>
        @if(!empty($color))
            @foreach ($colors as $color)
                <tr data-entry-id="{{ $color->id }}">
                    <td field-key='name'>{{ $color->name }}</td>
                    <td field-key='color'>{{ $color->color }}</td>
                    <td>
                        <a href="{{ route('color.edit',[$color->id]) }}" class="btn btn-xs btn-info">Edit</a>
                        {!! Form::open(array(
                            'style' => 'display: inline-block;',
                            'method' => 'DELETE',
                            'onsubmit' => "return confirm('Are you sure?');",
                            'route' => ['color.destroy', $tag->id])) !!}
                        {!! Form::submit('Delete', array('class' => 'btn btn-xs btn-danger')) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            @endif
       
    </tbody>
</table>
