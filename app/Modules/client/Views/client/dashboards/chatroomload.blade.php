@foreach($chats as $chat)
	@if($chat['sender_id'] == Auth::user()->id)
    	<li class="sender">
            <div class="messagearea">
                <div class="senderimg">
                    @php
                        $image_pathsender = asset('assets/images/profile/thumbnail/'.Auth::user()->image_path);
                        if(!empty(Auth::user()->image_path)){
                            //Do Nothing
                        }else{
                            $image_pathsender = asset('assets/images/user.png');
                        }
                    @endphp
                    <img src="{{$image_pathsender}}" alt="">
                </div>
                <p class="sendermsg">{{$chat['chat']}}</p>
                <p class="sendertime">{{date('D, d-m-Y H:i:s a',strtotime($chat['created_at']))}}<i class="fa fa-clock-o" aria-hidden="true"></i></p>
            </div>
        </li>
    @else
    	<li class="receiver">
            <div class="messagearea">
                <div class="receiverimg">
                	@php
                        $image_path = asset('assets/images/profile/thumbnail/'.$receiverImage);
                        if(!empty($receiverImage)){
                            //Do Nothing
                        }else{
                            $image_path = asset('assets/images/user.png');
                        }
                    @endphp
                    <img src="{{$image_path}}" alt="">
                </div>
                <p class="receivermsg">{{$chat['chat']}}</p>
                <p class="receivertime">{{date('D, d-m-Y H:i:s a',strtotime($chat['created_at']))}} <i class="fa fa-clock-o" aria-hidden="true"></i></p>
            </div>
        </li>
    @endif
    
@endforeach

