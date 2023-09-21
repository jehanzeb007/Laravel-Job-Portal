@foreach($form as $item)

    <tr>

        <td>{{$item->name}}</td>
        <td>
            
            <span style="padding-left:20px;">
                {!! link_to_route('edit_form', '', array($item->id), array('class' => 'glyphicon glyphicon-edit grouped_elements')) !!}
            </span>
            <span style="padding-left:20px;">
                {!! link_to_route('delete_form', '', array($item->id), array('class' => 'glyphicon glyphicon-trash', "onclick"=>"return confirm('Are you sure?')")) !!}
            </span>
            <span  style="padding-left:20px;">
                <a class="grouped_elements" href="{{route('add_edit_attribute',$item->id)}}">Add/Edit Attributes</a>
            </span>
            <span style="padding-left:20px;">
                <a class="grouped_elements" href="{{route('show_attribute',$item->id)}}">Show Attributes</a>
            </span>
        </td>

    </tr>

@endforeach