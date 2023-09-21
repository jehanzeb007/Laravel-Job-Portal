@foreach($users['data'] as $item)
    <?php 
        $first_name = $item['first_name'];
        $last_name = $item['last_name']; 
        $job_applied_count = $item['job_applied_count'];
        $job_posted_count = $item['job_posted_count'];
        $id = $item['id'];
    ?>
    <tr>
        <td>{{$last_name.", ".$first_name}}</td>
        <td>{{$item['email_address']}}</td>
        <td>
            @if ($item['active'] === 1)
                active
            @elseif ($item['active'] === 0)
                inactive
            @else
                I don't have any records!
            @endif
        </td>
        <td>
            <span class="col-xs-offset-1">
                @if($item['active']==1)
                    {!! link_to_route('block_user', '', array($id), array('class' => 'fa fa-check','title'=>"InActive $first_name $last_name", "onclick"=>"return confirm('Are you sure?')")) !!} 
                @else
                    {!! link_to_route('block_user', '', array($id), array('class' => 'glyphicon glyphicon-ban-circle','title'=>"Active $first_name $last_name", "onclick"=>"return confirm('Are you sure?')")) !!} 
                @endif
            </span>
            <span class="col-xs-offset-1">
                {!! link_to_route('delete_site_user', '', array($id), array('class' => 'glyphicon glyphicon-trash','title'=>"Delete $first_name $last_name", "onclick"=>"return confirm('Are you sure?')")) !!}
            </span>
            <span style="padding-left:20px;">
                <a class="grouped_elements" href="{{route('show_job_applied',$id)}}">{{$job_applied_count}} Jobs Applied</a>
            </span>
            <span style="padding-left:20px;">
                <a class="grouped_elements" href="{{route('show_job_posted',$id)}}">{{$job_posted_count}} Jobs Posted</a>
            </span>
            <span style="padding-left:20px;">
                <a  href="{{route('change_site_user_password',$id)}}">Change Password</a>
            </span>
                        

        </td>
    </tr>
@endforeach

