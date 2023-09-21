@extends('default.main_layout')
@section('title')    
{{Config::get('constants.site.name')}} | Job Detail
@stop
@section('home')
<style type="text/css">
    #posted_date{
        margin-right: 10px;
        color: #29aafe;
    }
    .form-horizontal .form-group {
        margin-left: 0px;
    }

</style>
<section class="job-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-7 co-xs-12 text-left">
                <h3>Job Detail</h3>
            </div>
        </div>
    </div>
</section>
<section class="single-job-section single-job-section-2">
    <div class="container">
        <div class="row">
        	<div class="col-md-12 col-sm-12 col-xs-12">
            	<div class="single-job-detail-box">
            		<div class="col-md-2 col-sm-6 col-xs-6">
                        @if(isset($job->category))
                        <div class="company-img"  style="text-align:center; height:100px; width:150px; border: 1px solid #F1F1F1 !important;  box-sizing: border-box;" >
                            <!-- <img src="images/company/logo2.png" alt=""> -->
                            <i style="font-size: 95px; color:#29aafe;" class="{{$job->category}}"></i>
                        </div>
                        @else
                        <div class="company-img"  style="text-align:center; height:100px; width:150px; border: 1px solid #F1F1F1 !important;  box-sizing: border-box;" >
                            <i style="font-size: 95px; color:#29aafe;" class="fa fa-plane"></i>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <div class="job-detail-2">
                            @if($errors->has('job_already_applied'))
                              <ul class="alert alert-danger" >
                                 @foreach ($errors->all() as $error)
                                     <li >{{ $error }}</li>
                                 @endforeach
                              </ul>
                            @endif
                            @if (session('status'))
                              <div class="alert alert-success">
                                  {{ session('status') }}
                              </div>
                            @endif
                            <h2>{{$job->name}}</h2>
                        </div>
                        <div class="job-detail-meta">
                        <ul>
                            <li><i class="fa fa-location-arrow"></i> {{$job->sub_city}} {{$job->city}} {{$job->state}} {{$job->country}}</li>
                            @if(!empty($job->attribute['Expected Salary']))
                                <li><i class="fa fa-dollar"></i> ${{$job->attribute['Expected Salary']}}/Month</li>
                            @endif
                            @if(!empty($job->attribute['Job Timing']))
                                <li><i class="fa fa-clock-o"></i> {{$job->attribute['Job Timing']}} </li>
                            @endif
                            <li><i class="fa fa-calendar-o"></i> Deadline: 20 January 2017</li>
                        </ul>
                    </div>
                    </div>

                    <div class="col-md-2 col-sm-12 col-xs-12">
                    	<div class="apply-job">

                            @if(Auth::check())                        
                                @if(Auth::user()->id != $job->user_id)
                                    @if(empty($job->awarded_user))
                                    <a id='apply_btn' class="btn btn-default" data-toggle="modal" data-target="#myModal"><i class="fa fa-upload"></i>Apply Now</a>
                                    @else
                                        @if ($job->awarded_user != Auth::user()->id)
                                            <a style="float:right; color: red;"><i class="fa fa-times"></i>Job closed</a>
                                        @else
                                            <a style="float:right; color: dodgerblue;"><i class="fa fa-check"></i>You have been awarded this job</a>
                                        @endif
                                    @endif
                                @endif
                            @else
                            <a class="btn btn-default" href="{{route('login_client')}}"><i class="fa fa-upload"></i>Apply Now</a>
                            @endif
                            <!-- <a class="btn btn-default bookmark"><i class="fa fa-star"></i> Bookmark</a> -->
                        </div>
                    </div>
                    <div id="myModal" class="modal add-resume-modal in" tabindex="-1" role="dialog" aria-labelledby="" style="display: none; padding-right: 17px;">
                        <div class="modal-dialog modal-md" role="document">
                            <div class="modal-content">
                                {!! Form::open(['url' => route('job_apply'), 'class' => 'form-horizontal','method' => 'post', 'files'=>'true']) !!}
                                
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Apply job</h4>
                                </div>
                                <?php 
                                    $value=0;
                                    if(\Session::get('validate_fails')){
                                        $value=\Session::get('validate_fails');
                                    } 
                                ?>
                                @if ($errors->any())
                                  <ul class="alert alert-danger" >
                                     @foreach ($errors->all() as $error)
                                         <li >{{ $error }}</li>
                                     @endforeach
                                  </ul>
                                @endif
                                <div class="modal-body">
                                    {!! Form::hidden('job_slug',$job->slug)!!}
                                    {!! Form::hidden('job_id',$job->id)!!}
                                    <div class="input-group image-preview form-group {{ $errors->has('cover_letter') ? 'has-error' : ''}}"  style="width:100%">
                                        <label>Cover Letter</label>
                                        <textarea name="cover_letter" type="text" class="form-group" style="width:100%">{{old('cover_letter')}}</textarea>
                                    </div>
                                    <label>Resume</label>
                                    <input type="file" name="resume"  class="form-group {{ $errors->has('resume') ? 'has-error' : ''}}"> 
                                    <p>Only pdf and doc files are accepted</p>
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-default">Apply</button>
                                </div>
                                {!! Form::close()!!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-8 col-sm-12 col-xs-12">
                    <div class="single-job-page-2 job-short-detail">
                        <div class="heading-inner">
                            <p class="title">Job Description</p>
                        </div>
                        <div class="job-desc job-detail-boxes">
                            <p>
                                {{$job->description}}
                            </p>
                        </div>

                    </div>
                    <div class="single-job-map">
                        <div id="map-contact" style="position: relative; overflow: hidden;"></div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="widget">
                        <div class="widget-heading"><span class="title">Job Attributes</span></div>
                        <ul class="short-decs-sidebar">
                            @foreach($form_attributes as $key => $item)
                                @if($key!="Expected Salary")
                                <li>
                                    <div>
                                        <h4>{{$key}}:</h4></div>
                                    <div>{{$item}}</div>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <aside>
                        <div class="company-detail widget">
                            <div class="widget-heading"><span class="title">{{{isset($user->company_name) ? 'Company Detail' : 'Job Posted Details' }}}</span></div>
                            <div class="company-contact-detail">
                                <table>
                                    <tbody><tr>
                                        <th>Name:</th>
                                        @if(isset($user->company_name))
                                        <td> {{$user->company_name}}</td>
                                        @else
                                        <td> {{$user->first_name}} {{$user->last_name}}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td> {{$user->email_address}}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone:</th>
                                        <td> {{$user->phone}}</td>
                                    </tr>
                                    <tr>
                                        <th>Address:</th>
                                        <td> {{$user->address}}</td>
                                    </tr>
                                    <tr>
                                        <th>Posted On:</th>
                                        <td><i id="posted_date" class="fa fa-calendar"></i>{{date('D, M d Y',strtotime($job->created_at))}}</td>
                                    </tr>
                                </tbody></table>
                            </div>
                        </div>
                    </aside>

                </div>
            </div>
        </div>
    </div>
</section>

@section('footer')
	@parent
	<script type="text/javascript">
		$(document).ready(function(){

            if ({{$value}}==1) {
                $('#apply_btn').click();
            };

			var latitude =  {{$job->latitude}};
			var longitude = {{$job->longitude}};
			var zoom = {{$job->zoom}}
			console.log(latitude, longitude);
			var location = {lat: latitude, lng: longitude};
		      var map = new google.maps.Map(document.getElementById('map-contact'), {
		        zoom: zoom,
		        center: location
		      });
		      var marker = new google.maps.Marker({
		          position: new google.maps.LatLng(location),
		          title: 'Marker',
		          map: map,
		          draggable: false
		      });
		});



	</script>
	<script async defer
  		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAi7FJBxb4YuT_S7_YOSQbkx_k15pG29KI">
	</script>

@show
@stop