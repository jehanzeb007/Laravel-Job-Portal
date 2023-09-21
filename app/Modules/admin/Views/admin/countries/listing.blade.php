@foreach($country as $item)

    <tr>
        <td>{{$item->name}}</td>
        <td>{{$item->latitude}}</td>
        <td>{{$item->longitude}}</td>
        <td>
            <span class="col-xs-offset-1">
                {!! link_to_route('edit_country', '', array($item->id), array('class' => 'glyphicon glyphicon-edit grouped_elements')) !!}
            </span>
            <span class="col-xs-offset-1">
                {!! link_to_route('delete_country', '', array($item->id), array('class' => 'glyphicon glyphicon-trash', "onclick"=>"return confirm('Are you sure?')")) !!}
            </span>
        </td>
    </tr>

@endforeach