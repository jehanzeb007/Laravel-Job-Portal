@foreach($categorie as $item)

    <tr>

        <td>{{$item->name}}</td>
        <td><i class="{{$item->icon}}"></i></td>
        <td>
            
            <span style="padding-left:20px;">
                {!! link_to_route('edit_categorie', '', array($item->id), array('class' => 'glyphicon glyphicon-edit grouped_elements')) !!}
            </span>
            <span style="padding-left:20px;">
                {!! link_to_route('delete_categorie', '', array($item->id), array('class' => 'glyphicon glyphicon-trash', "onclick"=>"return confirm('Are you sure?')")) !!}
            </span>
            <span style="padding-left:20px;">
                <a id="showbtn_{{$item->id}}" onclick="click_showbtn({{$item->id}})">show subcategories</a>
            </span>
        </td>

    </tr>
        @if( !empty( $item['children'] ))
        @foreach($item['children'] as $child)
        <tr style="display:none" class="child_{{$item->id}}">
            <td style="padding-left:50px;">{{$child->name}}</td>
            <td><i class="{{$child->icon}}"></i></td>
            <td>
                <span style="padding-left:20px;">
                    {!! link_to_route('edit_categorie', '', array($child->id), array('class' => 'glyphicon glyphicon-edit grouped_elements')) !!}
                </span>
                <span style="padding-left:20px;">
                    {!! link_to_route('delete_categorie', '', array($child->id), array('class' => 'glyphicon glyphicon-trash', "onclick"=>"return confirm('Are you sure?')")) !!}
                </span>
            </td>
        </tr>
        @endforeach
    @endif
@endforeach