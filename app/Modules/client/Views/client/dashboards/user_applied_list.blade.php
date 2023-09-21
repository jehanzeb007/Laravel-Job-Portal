@extends('default.layout')
@section('title')    
{{Config::get('constants.site.name')}} | User Applied
@stop
@section('user_job_posted')    
    class="active"
@stop
@section('top_nav')

@stop<div>@include('default.top_nav',['user'=>$user])</div>
@section('header_bar')
<style type="text/css">
    .form-horizontal .form-group {
        margin-left: 0px;
    }
</style>
<section class="job-breadcrumb">
   <div class="container">
      <div class="row">
         <div class="col-md-6 col-sm-7 co-xs-12 text-left">
            <h3>User Applied</h3>
         </div>
      </div>
   </div>
</section>
@stop
@section('body')
<section class="dashboard-body">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-4 col-sm-4 col-xs-12">
                   @include('client::client.left_side_image_bar',['$user'=>$user])
                   @include('client::client.left_side_bar',['$user'=>$user])
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="heading-inner first-heading">
                        @if(!empty($job))
                        <p class="title">User Applied for {{$job->name}}</p>
                        @endif
                    </div>
                    <div class="all-jobs-list-box2">
                        @if(!empty($job_applied))
                        @foreach($job_applied as $item)
                        <div class="job-box job-box-2">
                            <div class="col-md-2 col-sm-2 col-xs-12 hidden-xs hidden-sm">
                                @if(isset($item->image_name))
                                    <img src="/assets/images/profile/thumbnail/{{$item->image_path}}" alt="" class="img-responsive center-block "></a>
                                @else
                                    <img src="/assets/images/user.png" alt="" class="img-responsive center-block "></a>
                                @endif

                            </div>
                            <div class="col-md-10 col-sm-12 col-xs-12">
                                <div class="job-title-box">
									@if($job->is_completed == null)
                                    <div class="col-md-3"  style="float:right;">
                                    @if( $job->is_contracted == null && $job->is_awarded == null && $item->job_invite_id == null)
                                    <a class="btn btn-primary"   href="{{route('invite_job',$item->jobs_applied_id)}}"  style="margin-top:5px; float:right; background-color: #8bc24a; border-color: #8bc24a; width:125px;" onclick="return confirm('Are you sure you want to invite {{$item->first_name}} {{$item->last_name}}?')" >
                                        Send Invitation <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                    </a>
                                    @endif
                                    @if($job->is_contracted == null && $item->job_invite_id != null)
                                    <a id="contract_btn" class="btn btn-primary {{$item->is_accepted !=1 ?'disabled' :''}}"  href="javascript:void(0)"   data-toggle="modal" data-target=".add-contract-modal" style="margin-top:5px; float:right; background-color: cornflowerblue; border-color: cornflowerblue; width:125px;" onclick="sendContract('{{$item->jobs_applied_id}}')">
                                        Send Contract <i class="fa fa-sticky-note-o" aria-hidden="true"></i>
                                    </a>
                                    @endif
                                    @if($job->is_awarded == null && $job->is_contracted != null && $item->user_id == $job->awarded_user )
                                    <a class="btn btn-primary {{$job->is_accepted !=1 ?'disabled' :''}}"  href="{{route('award_job',$item->jobs_applied_id)}}" style="float:right; background-color: #ff9700; border-color: #ff9700; width:125px;" onclick="return confirm('Are you sure you want to award this job to {{$item->first_name}} {{$item->last_name}}?')"  {{$job->is_accepted !=1 ?'disabled' :''}}>
                                        Award Job <i class="fa fa-trophy" aria-hidden="true"></i>
                                    </a>
                                    @endif
                                    @if($job->is_contracted != null && $job->is_awarded!=null && $item->user_id == $job->awarded_user)
                                    <a class="btn btn-danger"  href="{{route('cancel_job',$item->jobs_applied_id)}}" style="margin-top:5px; float:right;width:125px;" onclick="return confirm('Are you sure you want to cancel this job for {{$item->first_name}} {{$item->last_name}}?')">
                                        Cancel Job <i class="fa fa-ban" aria-hidden="true"></i>
                                    </a>
                                    @endif
                                    <a class="btn btn-primary" style="margin-top:5px; float:right; background-color: #2ecc71; border-color: #2ecc71; width:125px;" href="{{route('download_resume',$item->path)}}" title="{{$item->path}}">
                                     Resume <i class="fa fa-download" style="padding-left:12px;" aria-hidden="true"></i> 
                                    </a>
                                    
                                    @if($job->is_contracted != null && $job->is_awarded!=null && $item->user_id == $job->awarded_user)
                                   <a class="btn btn-primary"  onClick="jobCompletedConfirm('{{$item->jobs_applied_id}}')" href="javascript:void(0)" style="margin-top:5px; float:right;width:125px;">
                                        Complete Job <i class="fa fa-check" aria-hidden="true"></i>
                                    </a>
                                    @endif
                                    
                                    
                                    </div>
                                    @endif
                                    <a>
                                        <div class="job-title"> {{$item->first_name}} {{$item->last_name}} </div>
                                    </a>
                                   	@if($job->is_completed == null)
                                    	@if($item->job_invite_id != null && $job->is_canceled!=null && $item->is_accepted==null)
                                            <a style="margin-left:10px; color: #8bc24a;"><i class="fa fa-envelope-o"></i>Invitation Send</a>
                                        @endif
                                        @if($item->job_invite_id != null && $job->is_canceled!=null && $item->is_accepted!=null)
                                            <a style="margin-left:10px; color: #8bc24a;"><i class="fa fa-envelope-o"></i>Invitation accepted</a>
                                        @endif
                                        @if($job->awarded_user == $item->user_id && $job->is_contracted !=null && $job->is_awarded==null && $item->is_accepted==null)
                                            <a style="margin-left:10px; color: cornflowerblue;"><i class="fa fa-sticky-note"></i>Contract send. Waiting for response</a>
                                        @endif
                                        @if($job->awarded_user == $item->user_id && $job->is_contracted !=null && $job->is_awarded==null && $item->is_accepted!=null)
                                            <a style="margin-left:10px; color: cornflowerblue;"><i class="fa fa-sticky-note"></i>Contract Accepted</a>
                                        @endif
                                        @if($job->awarded_user == $item->user_id && $job->is_awarded!=null)
                                            <a style="margin-left:10px; color: #ff9700;"><i class="glyphicon fa fa-trophy"></i>Job Awarded</a>
                                        @endif
                                        @if($job->awarded_user == $item->user_id && $item->job_invite_id == null && $job->is_canceled!=null)
                                            <a style="margin-left:10px; color: #d9534f;"><i class="fa fa-ban"></i>Contract Canceled</a>
                                        @endif
                                            
                                    @else
                                    	<a style="margin-left:10px; color: green;"><i class="fa fa-check"></i>Job Completed</a>
                                    @endif
                                </div>
                                <p>{{substr($item->cover_letter,0,100)}} {{{ strlen($item->cover_letter) > 100 ? '...............' : '' }}}</p>
                            </div>
                        </div>
                        @endforeach
                        @if($count==0)
                            No User Applied this Job
                        @endif
                    </div>
                    {{ $job_applied->links() }}
                    @else
                        No User Applied this Job
                    @endif

                </div>
            </div>
        </div>

    </div>
@if(!empty($job))
<div id="model" class="container modal add-resume-modal in" tabindex="-1" role="dialog" aria-labelledby="" style="display: none;">
    <div class="row">
        <div class="col-md-4 box" style=" position:fixed; bottom:0px; right:0px;  height: 350px; width: 310px;">
            <div class="panel panel-primary" style="width:280px;">
                <div class="panel-heading">
                    <!-- <span class="glyphicon glyphicon-comment"></span> Chat -->
                    <i class="glyphicon glyphicon-comment" style="padding-right:5px;"></i><span id="reciever_name"></span>
                    <div class="btn-group pull-right">
                    <i class="fa fa-times" aria-hidden="true" class="button" , data-dismiss="modal" aria-label="Close" style="cursor:pointer;"></i>
                    </div>
                </div>
                <div class="panel-body" >
                    <ul class="chat" id="content" style="padding: 0px; overflow-y: scroll; height: 230px; width: 260px;">

                    </ul>
                </div>
                <div class="panel-footer">
                    <div class="input-group">
                        <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here..."  onclick="this.select()" 
                            onKeyDown="if(event.keyCode==13){sendMessage({{$job->id}},{{$job->user_id}})};" >
                        <input id="reciever_id" type="hidden">
                        <span class="input-group-btn">
                            <button class="btn btn-warning btn-sm" id="btn-chat" onclick="sendMessage({{$job->id}},{{$job->user_id}})">
                                Send</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<div id="contract_model" class="modal add-contract-modal in" tabindex="-1" role="dialog" aria-labelledby="" style="display: none; padding-right: 17px;">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            {!! Form::open(['url' => route('send_contract'), 'class' => 'form-horizontal','method' => 'post', 'files'=>'true']) !!}
            <div style="display:none;">
                {!! Form::text('job_applied_id', null, array('class' => 'form-control' ,'id'=>'job_applied_id')) !!}     
            </div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Send Contract</h4>
            </div>
            <?php 
                $validate=0;
                $value=null;
                if(\Session::get('validate_fails')){
                    $value=\Session::get('validate_fails');
                    $validate = 1;
                } 
            ?>
           @if ($errors->any())
              <ul class="alert alert-danger" >
                 @foreach ($errors->all() as $error)
                 <li >{{ $error }}</li>
                 @endforeach
              </ul>
            @endif
            <div class="modal-body" style="height:440px;">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('start_date') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                            {!! Form::label('start_date', 'Start Date ') !!}
                            {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                            {!! Form::text('start_date', null, array('class' => 'form-control date start_date','placeholder' => 'Start Date','tabindex' => 1)) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('end_date') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                            {!! Form::label('end_date', 'End Date ') !!}
                            {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                            {!! Form::text('end_date', null, array('class' => 'form-control date end_date','placeholder' => 'End Date','tabindex' => 2)) !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="input-group image-preview form-group {{ $errors->has('payment') ? 'has-error' : ''}}"  style="width:100%">
                            {!! Form::label('payment', 'Payment ') !!}
                            {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                            {!! Form::text('payment', null, array('class' => 'form-control','placeholder' => 'Payment','tabindex' => 3)) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group image-preview form-group {{ $errors->has('payment_via') ? 'has-error' : ''}}"  style="width:100%">
                            {!! Form::label('payment_via', 'Payment Via ') !!}
                            {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                            {!! Form::text('payment_via', null, array('class' => 'form-control','placeholder' => 'Payment Via','tabindex' => 3)) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group image-preview form-group {{ $errors->has('description') ? 'has-error' : ''}}"  style="width:100%">
                            {!! Form::label('description', 'Description ') !!}
                            {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                            {!! Form::textarea('description', null, array('class' => 'form-control','placeholder' => 'Description','tabindex' => 4)) !!}
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="submit" class="btn btn-default">Send Contract</button>
                <button id="cancel" type="button" class="btn btn-default" data-dismiss="modal" style="background:#c9302c;">Cancel</button>
            </div>
            {!! Form::close()!!}
        </div>
    </div>
</div>


<div id="job_complete_model" class="modal in" tabindex="-1" role="dialog" aria-labelledby="" style="display: none; padding-right: 17px;">
    <div class="modal-dialog modal-md" role="document">
        {!! Form::open(['url' => route('complete_job'), 'class' => 'form-horizontal','method' => 'post', 'files'=>'true']) !!}
        <div class="modal-content">
            {!! Form::hidden('job_completed_id', null, array('id'=>'job_completed_id')) !!}
            {!! Form::hidden('rate_select', null, array('id'=>'rate_select')) !!}
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Complete Job</h4>
            </div>
            <div class="modal-body" style="height:440px;">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="input-group image-preview form-group"  style="width:100%">
                            {!! Form::label('rate', 'Rate') !!}
                            <div class="my-rating-5"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                    {!! Form::label('comment', 'Comment') !!}
                            {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                            {!! Form::textarea('description', null, array('class' => 'form-control','placeholder' => 'Description','required' => true)) !!}
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="submit" class="btn btn-default">Completed</button>
                <button id="cancel" type="button" class="btn btn-default" data-dismiss="modal" style="background:#c9302c;">Cancel</button>
            </div>
        </div>
        {!! Form::close()!!}
    </div>
</div>

</section>
@section('footer')
    @parent
<script src="{{asset('js/jquery.star-rating-svg.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/star-rating-svg.css')}}">
    <script type="text/javascript">
	$(".my-rating-5").starRating({
	  starSize: 80,
	  strokeWidth: 9,
	  strokeColor: 'black',
	  initialRating: 2,
	  starGradient: {
		  start: '#93BFE2',
		  end: '#105694'
	  },
	  callback: function(currentRating, $el){
		$('#rate_select').val(currentRating);
	  }
	});
	
     var loadingComplete = true;

     function fetchData(url, chat) {

         if(chat == '1'){
             loadingComplete = false;
         }
         $('div.loader').show();
         d = new Date();
         url += '&t='+d.valueOf();
         console.log('url', url);
         $.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
             options.async = true;
         }); 
         $.ajax({
             url: url
         }).done(function(response) {
             if (response.code == '401' || response.status == 'error') {
                 document.location.reload();
             } else {
                 if (chat == '1') {
                     if(response == ""){
                         response = '<tr><td colspan="10">no record found.</td></tr>'
                     }
                     console.log(response)
                     $('#content').append(response);
                 } else {

                     if(response == ''){
                        $('#content').html(response);
                         loadingComplete = true;
                     } else {

                         $('#content').html(response);
                         loadingComplete = false;
                     }
                 }
             }
             $('div.loader').hide(); 
         });
     }

     function callChat(job_id,sender_id,reciever_id,message_sender){
         page = 1;
         var url = "{{URL::route('user_chat')}}?" + formatUrlParams(job_id,sender_id,reciever_id,message_sender);
         fetchData(url, '1');
     }

    function allMessages(job_id,sender_id,reciever_id){

         page = 1;
         var param = "page=" + page;
         param += "&job_id="+ job_id+ "&sender_id="+ sender_id+ "&reciever_id="+ reciever_id;
         var url = "{{URL::route('all_messages')}}?" + param;
         fetchData(url, '0');
     }

     function formatUrlParams(job_id,sender_id,reciever_id) {
         var param = "page=" + page;
         var chatTxt = $.trim($("#btn-input").val());
         if (chatTxt != "") {
             param += "&chat="+ chatTxt+ "&job_id="+ job_id+ "&sender_id="+ sender_id+ "&reciever_id="+ reciever_id+ "&message_sender="+ message_sender;
         }
         
         
         return param;
     }

    function sendMessage(job_id,sender_id){

        if ($.trim($('#btn-input').val())!="") {
            message_sender = 0;
            reciever_id = $('#reciever_id').val();
            console.log(job_id,sender_id,reciever_id)
            callChat(job_id,sender_id,reciever_id,message_sender);

        };            
        $('#btn-input').val('');
    };


    function userChatBox(first_name,last_name,job_id,sender_id,reciever_id) {
        $('#reciever_name').text(first_name+" "+last_name);
        $('#reciever_id').val(reciever_id);
        allMessages(job_id,sender_id,reciever_id);
    };

    function sendContract(job_applied_id) {
        $('#job_applied_id').val(job_applied_id);
    };

    $(document).ready(function() {
        if({{$validate}}==1){
            $('#job_applied').val({{$value}});
            $('#contract_btn').click();
        }

        if (typeof timer === 'undefined') {
            // do nothing
        } else {
            window.clearTimeout(timer);
        }
        timer = window.setInterval(function() {
            var reciever_id= $('#reciever_id').val();
            allMessages({{$job->id}},{{$job->user_id}},reciever_id)
        }, 30000);

        $(".start_date" ).datepicker({
            dateFormat: "mm/dd/yy",
            onSelect: function(date) {
                $(".start_date").datepicker('option', 'minDate', date);
                $(".end_date").datepicker('option', 'minDate', date);
            }
        });
        $(".end_date" ).datepicker({
            dateFormat: "mm/dd/yy",
            onSelect: function(date) {
                $(".end_date").datepicker('option', 'maxDate', date);
                $(".start_date").datepicker('option', 'maxDate', date);
            }
        });
            @if($sucess = \Session::get('success_msg'))
                showTimerMsg("{{$sucess}}",3000);
            @endif
    });
	function jobCompletedConfirm(job_id){
		$('#job_completed_id').val(job_id);
		//alert(job_id);
		$('#job_complete_model').modal('show');
	}
    </script>
@show
@stop