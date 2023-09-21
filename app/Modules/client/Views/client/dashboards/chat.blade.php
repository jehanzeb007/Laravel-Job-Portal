@if($message_sender == 1)
<li class="left clearfix" style="margin-right:10px; border-bottom: 1px solid #ccc;"><span class="chat-img pull-left">
    @if(isset($sender->image_path))
        <img src="/assets/images/profile/thumbnail/{{$sender->image_path}}" alt="User Avatar" class="img-responsive img-circle"  style="height:50px; width:50px">
    @else
        <img src="/assets/images/user.png" alt="" class="img-responsive  img-circle center-block "  style="height:50px; width:50px"></a>
    @endif
</span>
    <div class="chat-body clearfix">
        <div class="header">
            <strong class="primary-font reciever_name">{{$reciever->first_name}} {{$reciever->last_name}}</strong> 
            <small class="pull-right text-muted">
                <span class="">{{$date}}</span>
            </small>
        </div>
        <p>
            {{$chatText}}
        </p>
    </div>
</li>
</hr>
@endif

@if($message_sender == 0)
<li class="right clearfix" style="margin-left:10px; border-bottom: 1px solid #ccc;"><span class="chat-img pull-right">
    @if(isset($sender->image_path))
        <img src="/assets/images/profile/thumbnail/{{$sender->image_path}}" alt="User Avatar" class="img-responsive img-circle"  style="height:50px; width:50px">
    @else
        <img src="/assets/images/user.png" alt="" class="img-responsive  img-circle center-block "  style="height:50px; width:50px"></a>
    @endif
</span>
    <div class="chat-body clearfix">
        <div class="header">
            <small class=" text-muted"><span class="glyphicon"></span>{{$date}}</small>
            <strong class="pull-right primary-font">{{$sender->first_name}} {{$sender->last_name}}</strong>
        </div>
        <p>
            {{$chatText}}
        </p>
    </div>
</li>
</hr>
@endif

