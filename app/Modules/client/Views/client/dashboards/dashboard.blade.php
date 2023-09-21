@extends('default.layout')
@section('title')    
{{Config::get('constants.site.name')}} | User Dashboard
@stop
@section('profile')    
    class="active"
@stop
@section('top_nav')

@show<div>@include('default.top_nav',['user'=>$user])</div>
@section('body')
<style type="text/css">
   .dashboard {
      background: rgba(60, 146, 202, 0.7) url(/assets/images/cover/thumbnail/{{$user->cover_image_path}}) no-repeat fixed center center / cover;
   }
</style>

<section class="dashboard parallex">
<div class="container-fluid">
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
         <div class="dashboard-header">
            <div class="col-md-5 col-sm-5 col-xs-12">
               <div class="user-avatar ">
                  @if(!empty($user->image_path))
                     <img src="/assets/images/profile/thumbnail/{{$user->image_path}}" alt="" class="img-responsive center-block "></a>
                  @else
                     <img src="/assets/images/user.png" alt="" class="img-responsive center-block "></a>
                  @endif
                  
                  <h3>{{$user->first_name}} {{$user->last_name}}</h3>
               </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
               <div class="rad-info-box rad-txt-success">
                  <i class="icon icon-presentation"></i>
                  <span class="title-dashboard">Job Posted</span>
                  <span class="value"><span>{{$job_posted}}</span></span>
               </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
               <div class="rad-info-box rad-txt-success">
                  <i class="icon icon-aperture"></i>
                  <span class="title-dashboard">Jobs Applied</span>
                  <span class="value"><span>{{$count}}</span></span>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</section>
<section class="dashboard-body">
<div class="container">
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="col-md-4 col-sm-4 col-xs-12">
            @include('client::client.left_side_bar',['$user'=>$user])
         </div>
         <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="job-short-detail">
               <div class="heading-inner">
                  <p class="title">Profile detail</p>
               </div>
               <dl>
                  @if(isset($user->company_name))
                  <dt>Company Name:</dt>
                  <dd>{{$user->company_name}}</dd>
                  @endif
                  <dt>Name:</dt>
                  <dd>{{$user->first_name}} {{$user->last_name}}</dd>
                  <dt>Father Name:</dt>
                  <dd>{{$user->father_name}}</dd>
                  <dt>Date Of Birth:</dt>
                  <dd>
                  @if($user->date_of_birth != Null)
                     <?php
                        list($y,$m,$d) = explode("-", $user->date_of_birth); 
                        $date_of_birth = $m.'/'.$d.'/'.$y;
                     ?>
                     {{$date_of_birth}}
                  @endif
                  </dd>
                  <dt>Phone:</dt>
                  <dd>{{$user->phone}}</dd>
                  <dt>Email:</dt>
                  <dd>{{$user->email_address}}</dd>
                  <dt>Address:</dt>
                  <dd>{{$user->address}}</dd>    
                  <dt>Last Education:</dt>
                  <dd>{{$user->last_education}}</dd>          
                  <dt>Country:</dt>
                  <dd>
                     @if(!empty($country))
                        {{$country->name}}
                     @endif
                  </dd>
                  <dt>State:</dt>
                  <dd>
                     @if(!empty($state))
                        {{$state->name}}
                     @endif
                  </dd>
                  <dt>City:</dt>
                  <dd>
                     @if(!empty($city))
                        {{$city->name}}
                     @endif
                  </dd>

                  <dt>Sub City:</dt>
                  <dd>
                     @if(!empty($sub_city))
                        {{$sub_city->name}}
                     @endif
                  </dd>
               </dl>
            </div>
            <div class="heading-inner">
               <p class="title">Some Line About Me</p>
            </div>
            <p>{{$user->description}}</p>
         </div>
      </div>
   </div>
</div>
</section>
@stop
