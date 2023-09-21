@foreach($user as $item)
    <tr>
        <td>{{$item->last_name.", ".$item->first_name}}</td>
        <td>{{$item->email_address}}</td>
        <td>
            @if ($item->active === 1)
                active
            @elseif ($item->active === 0)
                inactive
            @else
                I don't have any records!
            @endif
        </td>
        <td>
            <span>
            {!! link_to_route('edit_user', '', array($item->id), array('class' => 'glyphicon glyphicon-edit')) !!}
            </span>
            <span class="col-xs-offset-2">
                {!! link_to_route('delete_user', '', array($item->id), array('class' => 'glyphicon glyphicon-trash', "onclick"=>"return confirm('Are you sure?')")) !!}
            </span>
        </td>
    </tr>
@endforeach