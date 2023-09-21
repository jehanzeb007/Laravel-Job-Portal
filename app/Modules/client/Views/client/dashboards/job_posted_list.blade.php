@extends('default.layout')
@section('title')    
{{Config::get('constants.site.name')}} | Job Posted
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
            <h3>Job Posted</h3>
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
                        <p class="title">Job Posted</p>
                    </div>
                    <div class="all-jobs-list-box2">
                        @foreach($job_posted as $item)
                        <div class="job-box job-box-2">
                            <div class="col-md-2 col-sm-2 col-xs-12 hidden-xs hidden-sm">
                                @if(isset($item->category))
                                <div class="comp-logo" style="text-align:center;">
                                    <a><i style="font-size: 45px; color:#29aafe;" class="{{$item->category}}"></i></a>
                                </div>
                                @else
                                <div class="comp-logo" style="text-align:center;">
                                    <a><i style="font-size: 45px; color:#29aafe;" class="fa fa-home"></i></a>
                                </div>
                                @endif

                            </div>
                            <div class="col-md-10 col-sm-12 col-xs-12">
                                <div class="job-title-box">
                                	@if($item->is_completed == '1')
                                    	<h4 style="float:right; color: green;"><i class="glyphicon fa fa-check"></i>Job Completed</h4>
                                    @endif
                                    @if($item->is_awarded != null && $item->is_completed == '0')
                                        <h4 style="float:right; color: #ff9700;"><i class="glyphicon fa fa-trophy"></i>Job Awarded</h4>
                                    @endif
                                    <a href="{{route('job_detail',$item->slug)}}">
                                        <div class="job-title"> {{$item->name}}</div>
                                    </a>
                                    
                                    <!-- <a href="#">
                                        @if(isset($user->company_name))
                                            <span class="comp-name">{{$user->company_name}}</span>
                                        @else
                                            <span class="comp-name">{{$user->first_name}} {{$user->last_name}}</span>
                                        @endif
                                    </a> -->
                                    @if(!empty($item->attribute['Job Timing']))
                                        <a class="mata-detail part">{{$item->attribute['Job Timing']}}</a> 
                                    @endif
                                    <a class="price-range ">
                                        <i class="fa fa-money" style="margin-left:10px;"></i> ${{!empty($item->attribute['Price Range']) ? $item->attribute['Price Range'] : '0'}} 
                                    </a>
                                    	@if($item->is_completed == '1')
                                        	<a style="margin-left:10px; color: dodgerblue;"><i class="fa fa-check"></i>Completed</a>
                                        @else
                                            @if ($item->is_active ==1)
                                                <a style="margin-left:10px; color: dodgerblue;"><i class="fa fa-check"></i>Active</a>
                                            @else
                                                <a style="margin-left:10px; color: orangered;"><i class="glyphicon glyphicon-ban-circle"></i>Inactive</a>
                                            @endif
                                            @if ($item->is_featured==1)
                                                <a style="margin-left:10px; color: #ff9700;"><i class="glyphicon fa fa-star-o"></i>Featured</a>
                                            @endif 
										@endif
                                        <a href="{{route('job_user_applied',$item->slug)}}"><span style="margin-left:5px; color: green;" ><i class="fa fa-user"></i> {{$item['count']}} Users Applied</span></a>
                                    <a style="margin-left: 7px;">
                                    {!! link_to_route('edit_job_post', '', array($item->slug), array('class' => 'glyphicon glyphicon-edit grouped_elements', 'style'=>'color: darkgrey')) !!}
                                    {!! link_to_route('delete_job', '', array($item->id), array('class' => 'glyphicon glyphicon-trash','title'=>"Delete $item->name", "onclick"=>"return confirm('Are you sure?')", 'style'=>'color: red;  padding-left:5px;')) !!}
                                    </a>  
                                </div>
                                <p>{{substr($item->description,0,100)}} {{{ strlen($item->description) > 100 ? '...............' : '' }}}</p>
                            </div>
                            <div class=" job-salary">
                                
                                
                                
                                   
                                
                            </div>
                        </div>
                        @endforeach
                        @if($count==0)
                            No Job Posted
                        @endif
                    </div>
                    {{ $job_posted->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@section('footer')
    @parent

    <script type="text/javascript">
    </script>
@show
@stop