@extends('default.main_layout')
@section('title')    
{{Config::get('constants.site.name')}} | User Detail
@stop
@section('home')
<style type="text/css">
   .dashboard {
      background: rgba(60, 146, 202, 0.7) url(/assets/images/cover/thumbnail/{{$user->cover_image_path}}) no-repeat fixed center center / cover;
   }
</style>
<section class="job-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-7 co-xs-12 text-left">
                <h3>User Detail</h3>
            </div>
        </div>
    </div>
</section>
<section class="dashboard-body">
<div class="container">
   <div class="row">
      <div class="col-md-3 col-sm-3 col-xs-12">
         @include('client::client.left_side_image_bar',['$user'=>$user,'distnace' => $distance])
      </div>
      <div class="col-md-9 col-sm-9 col-xs-12">

         <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="job-short-detail">
               <div class="heading-inner">
                  <p class="title">User detail</p>
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
   @section('footer')
      @parent
      <script>
         $(document).ready(function(){
            if (navigator.geolocation){
               navigator.geolocation.getCurrentPosition(showPosition);
            }
         })
         function showPosition(position){
            console.log(position.coords.latitude)
            
         }
      </script>
   @show
@stop
