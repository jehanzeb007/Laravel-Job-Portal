@extends('default.layout')
@section('title')    
{{Config::get('constants.site.name')}} | Chat Room
@stop
@section('user_job_posted')    
    class="active"
@stop
@section('top_nav')

@stop<div>@include('default.top_nav',['user'=>$user])</div>
@section('header_bar')

<section class="job-breadcrumb">
   <div class="container">
      <div class="row">
         <div class="col-md-6 col-sm-7 co-xs-12 text-left">
            <h3>Chat room</h3>
         </div>
      </div>
   </div>
</section>
@stop
@section('body')
<section class="dashboard-body">
    <div class="container">
        <div class="row">
        	<div class="row">
                <div class="col-md-4 col-sm-4">
                    <div class="munal-frnd-list">
                        @if (Auth::user()->user_type == 'Both' )
                            <label>Chat With</label>
                            {!! Form::select('type', array('employers' => "Employers",'jobseekers' => 'JobSeekers'), 'jobseekers', array('class' => 'form-control', 'onchange' => "update_chat(this)")) !!}
                        @endif
                        @if(!empty($relatedJobs->count()))
                        	@foreach($relatedJobs as $relatedJob)
                            	<a href="javascript:void(0)" onClick="loadChat('{{$relatedJob->job_id}}','{{$relatedJob->job_poster_id}}',false)">
                                    <div class="frnd-list">
                                        <div class="frnd-img-holder">
                                        	@php
                                            	$image_path = asset('assets/images/profile/thumbnail/'.$relatedJob->user_image);
                                            	if(!empty($relatedJob->user_image)){
                                                	//Do Nothing
                                                }else{
                                                	$image_path = asset('assets/images/user.png');
                                                }
                                            @endphp
                                            <img src="{{$image_path}}" alt="frnd-img">
                                        </div>
                                        <div class="frnd-content-holder">
                                            <h4>{{$relatedJob->job_poster_fname.' '.$relatedJob->job_poster_lname}}</h4>
                                            <p>{{$relatedJob->job_name}}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <label style="margin-top:12px; color: red; font-size:14px;">no record found.</label>
                        @endif
                    </div>
                </div>
                <div class="col-md-8 col-sm-8">
                    <div class="message-sec">
                        <div class="conversation">
                            <h2>Conversation</h2>
                            <div class="chatArea">
                                <ul class="myChat" id="chat_area">
                                    <li>
                                        <div class="messagearea" id="notification_msg">
                                            Please click to the left side and select user for load chat
                                        </div>
                                    </li>
                                </ul>
                                <div class="input-group" id="message_box" style="display:none">
                                    <input class="form-control form-style" id="msg_text" placeholder="Type here..." type="text">
                                    <span class="input-group-btn">
                                        <button class="btn btn-info btn-secondary btn-style" onClick="send_message()" type="button">Send</button>
                                    </span>
                                </div>
                            </div>
                        </div>	
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@section('footer')
    @parent
    <script type="text/javascript">

    function update_chat(elem){
     var chat_type = $(elem).val();
     if (chat_type == "employers"){
        window.location.href = "/chat-room-employer";
     }

    }

	var selectJobId;
	var receiver_id;
	
	var auto_load_job_id = '';
	var auto_load_poster_id = '';
	function loadChat(job_id,poster_id,reload_auto){
		auto_load_job_id = job_id;
		auto_load_poster_id = poster_id;
		
		selectJobId = job_id;
		receiver_id = poster_id ;
		var user_id = '{{Auth::user()->id}}';
		var dataString = [];
		$.ajax({
			type: "get",
			url: '{{url('')}}/get-chat-seeker/'+user_id+'/'+job_id+'/'+poster_id,
			data: dataString,
			cache: false,
			success: function(result){
				$('#message_box').show();
				if(reload_auto == false){
					$('#msg_text').val('');
				}
				
				if($.trim(result) == 'empty'){
					$('#chat_area').html('<div class="messagearea" id="notification_msg">No conversation found.</div>');
				}else{
					$('#chat_area').html(result);
				}
			}
		});
	}
	function send_message(){
		var message = $('#msg_text').val();
		//selectJobId    This is selected job
		//receiver_id    This is Receiver Id
		if($.trim(message) != ''){
			var dataString = 'job_id='+selectJobId+'&receiver_id='+receiver_id+'&message='+message+'&_token={{ csrf_token() }}';
			$.ajax({
				type: "post",
				url: '{{route('send_message')}}',
				data: dataString,
				cache: false,
				success: function(result){
					$('#msg_text').val('');
				}
			});	
		}
	}
	$(document).ready(function(e) {
		setInterval(function(){ 
			if(auto_load_job_id != '' && auto_load_poster_id != ''){
				loadChat(auto_load_job_id,auto_load_poster_id,true);
			}
		}, 3000);
    });
    </script>
@show
@stop