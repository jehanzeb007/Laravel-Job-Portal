@foreach($jobs['data'] as $item)
    <?php 
        $name = $item['name']; 
        $count = $item['count'];
        $job_id = $item['job_id'];
    ?>
    <tr>

        <td>{{$item['name']}}</td>
        @if ($item['is_active']==1)
            <td>Active</td>
        @else
            <td>Inactive</td>
        @endif
        @if ($item['is_featured']==1)
            <td>Featured</td>
        @else
            <td>Unfeatured</td>
        @endif
        <td>{{$item['email_address']}}</td>
        <td>{{$item['job_created_at']}}</td>
        <td>
            <span class="col-xs-offset-1">
            @if($item['is_active']==1)
                {!! link_to_route('block_job', '', array($job_id), array('class' => 'fa fa-check','title'=>"InActive $name", "onclick"=>"return confirm('Are you sure?')")) !!} 
            @else
                {!! link_to_route('block_job', '', array($job_id), array('class' => 'glyphicon glyphicon-ban-circle','title'=>"Active $name", "onclick"=>"return confirm('Are you sure?')")) !!} 
            @endif
            </span>
            <span class="col-xs-offset-1">
            @if($item['is_featured']==1)
                {!! link_to_route('feature_job', '', array($job_id), array('class' => 'glyphicon fa fa-star','title'=>"Unfeatured $name", "onclick"=>"return confirm('Are you sure?')")) !!} 
            @else
                {!! link_to_route('feature_job', '', array($job_id), array('class' => 'glyphicon fa fa-star-o','title'=>"Featured $name", "onclick"=>"return confirm('Are you sure?')")) !!} 
            @endif
            </span>
            <span class="col-xs-offset-1">
                {!! link_to_route('delete_job', '', array($job_id), array('class' => 'glyphicon glyphicon-trash','title'=>"Delete $name", "onclick"=>"return confirm('Are you sure?')")) !!}
            </span>
            <span style="padding-left:20px;">
                <a class="grouped_elements" href="{{route('show_user_applied',$job_id)}}">{{$count}} Users Applied</a>
            </span>
        </td>
    </tr>
@endforeach
