@foreach($role as $item)
    <tr>
        <td>{{$item->name}}</td>
        <td>{{$item->display_name}}</td>
        <td>{{$item->description}}</td>
        <td>
            <span>
                {!! link_to_route('edit_role', '', array($item->id), array('class' => 'glyphicon glyphicon-edit')) !!}
            </span>
            <span class="col-xs-offset-2">
                {!! link_to_route('delete_role', '', array($item->id), array('class' => 'glyphicon glyphicon-trash ', "onclick"=>"return confirm('Are you sure?')")) !!}
            </span>
        </td>
    </tr>
@endforeach