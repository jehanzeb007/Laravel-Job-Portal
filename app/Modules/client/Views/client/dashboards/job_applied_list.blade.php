@extends('default.layout')
@section('title')    
{{Config::get('constants.site.name')}} | Job Applied
@stop
@section('user_job_applied')    
    class="active"
@stop
@section('top_nav')

@stop<div>@include('default.top_nav',['user'=>$user])</div>
@section('header_bar')
<style>
.title
{
    text-align: center;
}
.banner
{
    width: 100%;
    padding: 20px 0px;
}
.banner h4, .banner p
{
    display: inline-block;
}
.block-sec
{
    display: block;
}
.other-sec
{
    padding-top: 40px;
}
.middle-sec
{
    display: block;
    padding-top: 40px;
}
</style>
<section class="job-breadcrumb">
   <div class="container">
      <div class="row">
         <div class="col-md-6 col-sm-7 co-xs-12 text-left">
            <h3>Job Applied</h3>
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
                        <p class="title">Job applied</p>
                    </div>
                    <div class="all-jobs-list-box2">
                        @foreach($entries as $item)
                        <div class="job-box job-box-2">
                            <div class="col-md-2 col-sm-2 col-xs-12 hidden-xs hidden-sm">
                                @if(isset($item['category']))
                                <div class="comp-logo" style="text-align:center;">
                                    <a><i style="font-size: 45px; color:#29aafe;" class="{{$item['category']}}"></i></a>
                                </div>
                                @else
                                <div class="comp-logo" style="text-align:center;">
                                    <a><i style="font-size: 45px; color:#29aafe;" class="fa fa-home"></i></a>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-10 col-sm-12 col-xs-12">
                                <div class="job-title-box">
                                    @if ($item['invited']!=null  &&$item['invited']->is_accepted ==null )
                                        <a class="btn btn-primary"  href="{{route('invitation_accepted',$item['job_applied_id'])}}" style="margin-top:5px; margin-left:5px; float:right; background-color: #8bc24a; border-color: #8bc24a; width:135px;" onclick="return confirm('Are you sure you want to accept invitation')">
                                            Accept Invitation <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                    @if(!empty($item['awarded_user']))    
                                        @if($item['awarded_user'] == Auth::user()->id)    
                                            @if ($item['is_contracted']!=null && $item['is_accepted']!=1 )
                                            <a class="btn btn-primary"  href="javascript:void(0)"   data-toggle="modal" data-target=".add-contract-modal" style="margin-top:5px; margin-left:5px; float:right; background-color: cornflowerblue; border-color: cornflowerblue; width:125px;" onclick="openContract('{{$item['id']}}')">
                                                show Contract <i class="fa fa-sticky-note-o" aria-hidden="true"></i>
                                            </a>
                                            @endif
                                        @endif
                                    @endif
                                    <a href="{{route('job_detail',$item['slug'])}}">
                                        <div class="job-title"> {{$item['name']}}</div>
                                    </a>
                                        <!-- @if(isset($user->company_name))
                                            <span class="comp-name">{{$user->company_name}}</span>
                                        @else
                                            <span class="comp-name">{{$user->first_name}} {{$user->last_name}}</span>
                                        @endif -->
                                    @if(!empty($item->attribute['Job Timing']))
                                        <a class="mata-detail part" >{{$item->attribute['Job Timing']}}</a> 
                                    @endif
                                    <a class="price-range" style="margin-left:10px;">                                        
                                        <i class="fa fa-money"></i>  ${{!empty($item->attribute['Price Range']) ? $item->attribute['Price Range'] : '0'}} 
                                    </a>

                                    @if ($item['is_active']==1)
                                        <a style="margin-left:10px; color: dodgerblue;"><i class="fa fa-check"></i>Active</a>
                                    @else
                                        <a style="margin-left:10px; color: orangered;"><i class="glyphicon glyphicon-ban-circle"></i>Inactive</a>
                                    @endif
                                    @if ($item['is_featured']==1)
                                        <a style="margin-left:10px; color: #ff9700;"><i class="glyphicon fa fa-star-o"></i>Featured</a>
                                    @endif       
                                    <!-- <a style="solid darkgrey; padding: 6px;">
                                        @php $name = $item['name']; @endphp
                                        {!! link_to_route('edit_form', '', array($item['id']), array('class' => 'glyphicon glyphicon-edit grouped_elements', 'style'=>'color: darkgrey')) !!}
                                        {!! link_to_route('delete_job', '', array($item['id']), array('class' => 'glyphicon glyphicon-trash','title'=>"Delete $name", "onclick"=>"return confirm('Are you sure?')", 'style'=>'color: red; padding-left:5px;')) !!}
                                    </a> -->
                                    </div>
                                <p>{{substr($item['description'],0,100)}} {{{ strlen($item['description']) > 100 ? '...............' : '' }}}</p>
                                
                                    @if($jobStatus[$item['id']] == null)
                                    
                                        @if(!empty($item['awarded_user']))    
                                            @if($item['awarded_user'] == Auth::user()->id)
                                                @if ($item['invited']!=null && $item['invited']->is_accepted ==null)
                                                    <a style="float:right; color: #8bc24a;"><i class="fa fa-envelope-o"></i>You have been invited for this job</a>
                                                @elseif ($item['invited']!=null && $item['invited']->is_accepted !=null)
                                                    <a style="float:right; color: #8bc24a;"><i class="fa fa-envelope-o"></i>Invitation Accepted</a>
                                                @elseif ($item['is_awarded']!=null)
                                                    <a style="float:right; color: #ff9700;"><i class="glyphicon fa fa-trophy"></i>You have been awarded this job</a>
                                                @elseif ($item['is_contracted']!=null && $item['is_accepted'] ==null)
                                                    <a style="float:right; color: cornflowerblue;"><i class="fa fa-sticky-note-o"></i>You have recieved a job contract</a>
                                                @elseif ($item['is_contracted']!=null && $item['is_accepted'] !=null)
                                                    <a style="float:right; color: cornflowerblue;"><i class="fa fa-sticky-note-o"></i>You have accepted this job</a>
                                                @elseif ($item['is_canceled']!=null)
                                                    <a style="float:right; color: #d9534f;"><i class="fa fa-ban"></i>Job Canceled</a>
                                                @endif
    
                                            @else
                                                @if ($item['invited']!=null && $item['invited']->is_accepted ==null)
                                                    <a style="float:right; color: #8bc24a;"><i class="fa fa-envelope-o"></i>You have been invited for this job</a>
                                                @elseif ($item['invited']!=null && $item['invited']->is_accepted !=null)
                                                    <a style="float:right; color: #8bc24a;"><i class="fa fa-envelope-o"></i>Invitation Accept</a>
                                                @else
                                                    <a style="float:right; color: red;"><i class="fa fa-times"></i>Job closed</a>
                                                @endif
                                            @endif
                                        @endif
                                    @else
                                    	<a style="float:right; color: green;"><i class="fa fa-check"></i>Job Completed</a>
                                    @endif
                            </div>
                        </div>
                        @endforeach
                        @if($count==0)
                            No Job Applied
                        @endif
                    </div>
                    {!! $entries->setPath(route('user_job_applied'))!!}
                </div>
            </div>
        </div>
    </div>
    <div id="model" class="container modal add-resume-modal in" tabindex="-1" role="dialog" aria-labelledby="" style="display: none;">
    <div class="row">
        <div class="col-md-4 box" style=" position:fixed; bottom:0px; right:0px;  height: 350px; width: 310px;">
            <div class="panel panel-primary" style="width:280px;">
                <div class="panel-heading">
                    <!-- <span class="glyphicon glyphicon-comment"></span> Chat -->
                    <i class="glyphicon glyphicon-comment" style="padding-right:5px;"></i><span id="sender_name"></span>
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
                            onKeyDown="if(event.keyCode==13){sendMessage($('#job_id').val(),$('#sender_id').val())};" >
                        <input id="sender_id" type="hidden">
                        <input id="job_id" type="hidden">
                        <span class="input-group-btn">
                            <button class="btn btn-warning btn-sm" id="btn-chat" onclick="sendMessage($('#job_id').val(),$('#sender_id').val())">
                                Send</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="contract_model" class="modal add-contract-modal in" tabindex="-1" role="dialog" aria-labelledby="" style="display: none; padding-right: 17px;">
    <div class="modal-dialog modal-md" role="document" style="width:90%">
        <div class="modal-content" style="border:30px solid #000">
            {!! Form::open(['url' => route('accept_job'), 'class' => 'form-horizontal','method' => 'post', 'files'=>'true']) !!}
            <div style="display:none;">
                {!! Form::text('jobs_id', null, array('class' => 'form-control' ,'id'=>'jobs_id')) !!}
                {!! Form::text('accepted', null, array('class' => 'form-control' ,'id'=>'accepted')) !!}       
            </div>
            <div class="modal-header" style="text-align:center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h1>TOIL Online Contract Form</h1>
                <p>"Here it should have the name of job need to be done" automatically</p>
            </div>
            <header>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="title">
                            <p></p>
                            <div class="herader-img">
                                <img src="{{asset('logo-2.png')}}" alt="No-img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
            <div class="container" id="contract_inner" style="padding-left: 30px;padding-right: 40px;">
            
        	</div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default" onclick="$('#accepted').val(1);">I Agree</button>
                <button id="cancel" type="sumbit" class="btn btn-default" style="background:#c9302c; border:#c9302c;" onclick="$('#accepted').val(0);">I don't agree</button>
            </div>
            {!! Form::close()!!}
        </div>
    </div>
</div>
</section>

@section('footer')
    @parent

    <script type="text/javascript">

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
            message_sender = 1;
            reciever_id = {{$user->id}};
            console.log(job_id,sender_id,reciever_id)
            callChat(job_id,sender_id,reciever_id,message_sender);

        };            
        $('#btn-input').val('');
    };


    function userChatBox(first_name,last_name,job_id,sender_id,reciever_id) {
        $('#sender_name').text(first_name+" "+last_name);
        $('#sender_id').val(sender_id);
        $('#job_id').val(job_id);
        allMessages(job_id,sender_id,reciever_id);
    };

    //function openContract(employer_first_name,employer_last_name,payment,description,jobs_id) {
	function openContract(jobs_id) {
		/*@php $employee_first_name = \Auth::user()->first_name; $employee_last_name = \Auth::user()->last_name; @endphp
        var employee_first_name = '{{$employee_first_name}}';
        var employee_last_name = '{{$employee_last_name}}';
        $('#employer_name').text(employer_first_name+" "+employer_last_name);
        $('#employee_name').text(employee_first_name+" "+employee_last_name);
        $('#payment').text(payment);
        $('#description').text(description);
        $('#jobs_id').val(jobs_id);*/
		$('#jobs_id').val(jobs_id);
		$('#contract_inner').html('<div style="text-align:center">Loading... <i class="fa fa-spinner" aria-hidden="true"></i></div>');
		var dataString = [];
		$.ajax({
			type: "get",
			url: "{{url('')}}/show_contract/"+jobs_id,
			data: dataString,
			cache: false,
			success: function(result){
				$('#contract_inner').html(result);
			}
		});
	};

    $(document).ready(function() {
        if (typeof timer === 'undefined') {
            // do nothing
        } else {
            window.clearTimeout(timer);
        }
        timer = window.setInterval(function() {
            var reciever_id= {{$user->id}};
            var sender_id= $('#sender_id').val();
            var job_id = $('#job_id').val();
            allMessages(job_id, sender_id, reciever_id)
        }, 30000);
    });
    </script>
@show
@stop