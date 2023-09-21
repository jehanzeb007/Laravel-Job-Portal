@foreach($state as $item)

    <tr>
        <td>{{$item->state_name}}</td>
        <td>{{$item->name}}</td>
        <td>{{$item->latitude}}</td>
        <td>{{$item->longitude}}</td>
        <td>
            
            <span style="padding-left:20px;">
                {!! link_to_route('edit_state', '', array($item->states_id), array('class' => 'glyphicon glyphicon-edit grouped_elements')) !!}
            </span>
            <span style="padding-left:20px;">
                {!! link_to_route('delete_state', '', array($item->states_id), array('class' => 'glyphicon glyphicon-trash', "onclick"=>"return confirm('Are you sure?')")) !!}
            </span>
        </td>

    </tr>
        
@endforeach