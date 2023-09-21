@foreach($chats as $item)
	@if($item->message_sender == 1)
	<li class="left clearfix" style="margin-right:10px; border-bottom: 1px solid #ccc;"><span class="chat-img pull-left">
	    @if(isset($item->reciever_image_path))
	    	<img src="/assets/images/profile/thumbnail/{{$item->reciever_image_path}}" alt="User Avatar" class="img-responsive img-circle"  style="height:50px; width:50px">
	    @else
	        <img src="/assets/images/user.png" alt="" class="img-responsive  img-circle center-block "  style="height:50px; width:50px"></a>
	    @endif
	</span>
	    <div class="chat-body clearfix">
	        <div class="header">
	            <strong class="primary-font reciever_name">{{$item->reciever_first_name}} {{$item->reciever_last_name}}</strong> 
	            <small class="pull-right text-muted">
	                <span class="">{{$item->date}}</span>
	            </small>
	        </div>
	        <p>
	            {{$item->chat}}
	        </p>
	    </div>
	</li>
	</hr>
	@endif

	@if($item->message_sender == 0)
	<li class="right clearfix" style="margin-left:10px; border-bottom: 1px solid #ccc;"><span class="chat-img pull-right">
	    @if(isset($item->sender_image_path))	
	    	<img src="/assets/images/profile/thumbnail/{{$item->sender_image_path}}" alt="User Avatar" class="img-circle img-responsive " style="height:50px; width:50px">
	    @else
	        <img src="/assets/images/user.png" alt="" class="img-responsive  img-circle center-block " style="height:50px; width:50px"></a>
	    @endif
	</span>
	    <div class="chat-body clearfix">
	        <div class="header">
	            <small class=" text-muted"><span class="glyphicon"></span>{{$item->date}}</small>
	            <strong class="pull-right primary-font">{{$item->sender_first_name}} {{$item->sender_last_name}}</strong>
	        </div>
	        <p>
	            {{$item->chat}}
	        </p>
	    </div>
	</li>
	</hr>
	@endif
@endforeach