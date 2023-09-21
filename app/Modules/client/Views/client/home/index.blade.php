@extends('default.main_layout')
@section('title')    
{{Config::get('constants.site.name')}} | Home
@stop
@section('home')

<style type="text/css">

  .index5-main-section .employer-main-section {
      background: rgba(60, 146, 202, 0.7) url(/assets/client/images/team_image.jpg) no-repeat scroll center center / cover;
   }
   .index5-main-section .employee-main-section {
    background: rgba(60, 146, 202, 0.7) url(/assets/client/images/company_image.jpg) no-repeat scroll center center / cover;
  }
</style>
        <!-- @if(!Auth::check())
         <section class="index5-main-section">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-12 nopadding">
                     <div class="employer-main-section parallex-employer">
                        <h1>Hundreds of users searching for their Dream Job.</h1>
                        <a href="{{route('register')}}" class="btn-default">Sign up <i class="fa fa-angle-right"></i> </a>
                     </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12 nopadding">
                     <div class="employee-main-section parallex-employee">
                        <h1>The Easiest way to get your New Dream job.</h1>
                        <a href="{{route('login_client')}}" class="btn-default">Sign In <i class="fa fa-angle-right"></i></a>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         @endif -->
         <section class="light-grey">
            <div class="container">
               <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                     <div class="Heading-title black">
                        <h1>Latest Jobs</h1>
                     </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12">
                     <div class="all-jobs-list-box2">
                        @foreach($job as $item)
                       <div class="job-box job-box-2">
                          <div class="col-md-2 col-sm-2 col-xs-12 hidden-sm">
                             <div class="comp-logo">
                                <!-- <a href=""><img src="/assets/client/images/company/5.png" class="img-responsive" alt="scriptsbundle"> </a> -->
                                <div class="col-md-2 col-sm-6 col-xs-6">
                                   @if(isset($item->category))
                                   <div class="company-img"  style="text-align:center; height:100px; width:150px; border: 1px solid #F1F1F1 !important;  box-sizing: border-box;" >
                                       <!-- <img src="images/company/logo2.png" alt=""> -->
                                       <i style="font-size: 95px; color:#29aafe;" class="{{$item->category}}"></i>
                                   </div>
                                   @else
                                      <div class="company-img"  style="text-align:center; height:100px; width:150px; border: 1px solid #F1F1F1 !important;  box-sizing: border-box;" >
                                       <i style="font-size: 95px; color:#29aafe;" class="fa fa-graduation-cap"></i>
                                   </div>
                                   @endif
                               </div>
                             </div>
                          </div>
                          <div class="col-md-10 col-sm-10 col-xs-12">
                             <div class="job-title-box">
                                <a href="{{route('job_detail',$item->slug)}}">
                                   <div class="job-title"> {{$item->name}}</div>
                                </a>
                                @if(isset($item->company_name))
                                <a ><span class="comp-name">{{$item->company_name}}</span></a>
                                @else
                                <a ><span class="comp-name">{{$item->first_name}} {{$item->last_name}}</span></a>
                                @endif
                                @if(!empty($item->attribute['Job Timing']))
                                  <a  class="job-type jt-full-time-color"> <i class="fa fa-clock-o"></i> {{$item->attribute['Job Timing']}} </a>
                                @endif
                                
                             </div>
                             <p>{{substr($item->description,0,100)}} {{{ strlen($item->description) > 100 ? '...............' : '' }}}<!-- .......<a href="">Read More</a> --> </p>
                          </div>
                          <div class="job-salary"> <i class="fa fa-money"></i> ${{!empty($item->attribute['Price Range']) ? $item->attribute['Price Range'] : '0'}} </div>
                       </div>
                        @endforeach
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <div style="text-align:center">
                              <a class="btn-default" href="{{route('all_jobs')}}" > View All <i class="fa fa-angle-right"></i> </a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <section class="light-grey" style="padding-top: 0px;">
            <div class="container">
               <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                     <div class="Heading-title black">
                        <h1>Latest Job Seekers</h1>
                     </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12">
                     <div class="all-jobs-list-box2">
                        @foreach($users as $item)
                       <div class="job-box job-box-2">
                          <div class="col-md-2 col-sm-2 col-xs-12 hidden-sm">
                           @if(!empty($item->image_path))
                            <img src="/assets/images/profile/thumbnail/{{$item->image_path}}" alt="user-img" class="img-circle" width="140">
                           @else
                              <img src="/assets/images/user.png" class="img-responsive img-circle" alt="" >
                           @endif
                          </div>
                          <div class="col-md-10 col-sm-10 col-xs-12">
                             <div class="job-title-box">
                                <a href="{{route('user_detail',$item->id)}}">
                                  <div class="job-title"> {{$item->first_name.' '.$item->last_name}}</div>
                                   @if(!empty($item->distance))
                                    <h4>Distance: <b>{{$item->distance}} km.</b> from you.</h4>
                                  @endif
                                </a>
                                @if(isset($item->company_name))
                                <span class="comp-name">{{$item->company_name}}</span>
                                @else
                                <span class="comp-name">{{$item->last_education}}</span>
                                @endif
                             </div>
                             <p>{{substr($item->description,0,100)}} {{{ strlen($item->description) > 100 ? '...............' : '' }}}<!-- .......<a href="">Read More</a> --> </p>
                          </div>
                       </div>
                        @endforeach
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <div style="text-align:center">
                              <a class="btn-default" href="{{route('all_users')}}" > View All <i class="fa fa-angle-right"></i> </a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <section class="facts">
            <div class="container">
               <div class="row">
                  <div class="col-sm-6 col-md-3 col-xs-6">
                     <div class="fact-box">
                        <div class="single-facts-area">
                           <div class="facts-icon"> <i class="icon-megaphone"></i> </div>
                           <span class="counter">{{$total_jobs}}</span>
                           <h3>Jobs</h3>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-6 col-md-3 col-xs-6">
                     <div class="fact-box">
                        <div class="single-facts-area">
                           <div class="facts-icon"> <i class="icon-document"></i> </div>
                           <span class="counter">{{$total_resumes}}</span>
                           <h3> Resume </h3>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-6 col-md-3 col-xs-6">
                     <div class="fact-box">
                        <div class="single-facts-area">
                           <div class="facts-icon"> <i class="icon-profile-male"></i> </div>
                           <span class="counter">{{$total_users}}</span>
                           <h3>Members</h3>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-6 col-md-3 col-xs-6">
                     <div class="fact-box">
                        <div class="single-facts-area">
                           <div class="facts-icon"> <i class="icon-toolbox"></i> </div>
                           <span class="counter">{{$total_companies}}</span>
                           <h3>Company</h3>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <section id="categories-section-2">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                     <div class="categories-section-2">
                        <ul id="popular-categories">
                          @foreach($category_array as $item)
                           <li><a  href="{{route('search_jobs_by_categorie',$item->slug)}}"><i  class="{{$item->icon}}"></i> {{$item->name}} <span> ({{$item->categorie_count}})</span></a></li>
                          @endforeach
                          @foreach($sub_category_array as $item)
                           <li><a  href="{{route('search_jobs_by_categorie',$item->slug)}}"><i  class="{{$item->icon}}"></i> {{$item->name}} <span> ({{$item->sub_categorie_count}})</span></a></li>
                          @endforeach
                        </ul>
                        <div class="clearfix"></div>
                     </div>
                  </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div style="text-align:center; margin-bottom: 50px; margin-top: 50px;">
                    <a class="btn-default" href="{{route('all_categories')}}" > View All <i class="fa fa-angle-right"></i> </a>
                  </div>
                </div>
            </div>
         </section>
         <section class="featured-jobs">
            <div class="container">
               <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                     <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="Heading-title black">
                           <h1>Featured Jobs</h1>
                        </div>
                     </div>
                     @foreach($featured_job as $item)
                     <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="featured-image-box">
                          @if(isset($item->category))
                           <div class="img-box" style="text-align: center; background: gainsboro; color:#29aafe;"><i style="font-size: 75px;" class="{{$item->category}} center-block"></i><!-- <img src="/assets/client/images/company/1.png" class="img-responsive center-block" alt=""> --></div>
                          @else
                            <div class="img-box" style="text-align: center; background: gainsboro; color:#29aafe;"><i style="font-size: 75px;" class="fa fa-building-o center-block"></i></div>
                          @endif
                           <!-- <div class="col-md-4 col-sm-6 col-xs-6">
                               <div class="company-img"  style="height:100px; width:150px; border: 1px solid #F1F1F1 !important;  box-sizing: border-box;" >
                                   <i style="font-size: 75px;" class="{{$item->category}}"></i>
                               </div>
                           </div> -->
                           <div class="content-area">
                              <div class="">
                                 <h4><a href="{{route('job_detail',$item->slug)}}"> {{$item->name}} </a></h4>
                                 @if(isset($item->company_name))
                                      <span class="comp-name">{{$item->company_name}}</span>
                                  @else
                                      <span class="comp-name">{{$item->first_name}} {{$item->last_name}}</span>
                                  @endif
                              </div>
                              <div class="feature-post-meta">
                                 
                                 <a > <i class="fa fa-clock-o"></i> {{$item->timespan}}</a> 
                                 @if(!empty($item->attribute['Job Timing']))
                                 <a class="mata-detail part">{{$item->attribute['Job Timing']}}</a> 
                                 @endif
                              </div>
                              <div class="feature-post-meta-bottom"> <span>${{!empty($item->attribute['Expected Salary']) ? $item->attribute['Expected Salary'] : '0'}}<small>/ month</small></span> <a class="apply pull-right"  href="{{route('job_detail',$item->slug)}}"> Apply Now</a> </div>
                           </div>
                        </div>
                     </div>
                     @endforeach
                     <div class="col-md-12 col-sm-12 col-xs-12">
                        <div style="text-align:center">
                          <a class="btn-default" href="{{route('all_jobs')}}" > View All <i class="fa fa-angle-right"></i> </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </body>
</html>

@stop