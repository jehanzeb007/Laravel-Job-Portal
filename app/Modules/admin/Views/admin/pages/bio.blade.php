@extends('layouts.layout')

@section('title')
    HBI's Consulting & Advisory Services, Powered by Analytics
@stop
@section($page->slug) 
active
@endsection


@section('head_assets')
@parent
<style type="text/css">
    #content p {
        
        font-family: "Segoe UI Lgt";
        font-size: 20px;
        
    }
</style>
@stop

@section('content')
<div id="content">
    <div class="contentInner">
        <div class="bio-page">
            <div class="bio-header">
                @if(isset($page->title))
                <h1>{{$page->title}}</h1>
                @else
                <h1>Advisory Services Team</h1>
                @endif
                
                @if(isset($page->short_description))
                {{$page->short_description}}
                @else
                <p>HBI's Member-Driven Advisory Services team is experienced in utilizing a combination of data analytics, operational interviews, and patient survey information to provide a detailed picture of the current state of your operational workflows and patient experience.</p>
                <p>Together, HBI will craft a work plan with you to ensure the necessary processes, staffing resources, and technology utilization are in place to secure full and appropriate reimbursement, in addition to a high level of patient satisfaction.</p>
                @endif
            </div>
            <div class="bio-content">
                <div class="bio-widget">
                    <h2>Meet Our Team</h2>
                    <?php 
                    $path = 'data/bio';
                    $image_path = asset($path).'/';
                    ?>
                    @if(count($profiles) > 0)
                        @foreach($profiles as $profile)
                        <div class="bio-post">
                            <div class="alignleft">
                                <span class="img-frame"></span>
                                @if( !empty($profile->picture) && File::exists($path.'/'.$profile->picture) )
                                    <img src="{{$image_path.$profile->picture}}">
                                @else
                                    <img src="{{asset('assets/internal/images/dumyThumb.jpg')}}">
                                @endif
                            </div>
                            <div class="text-box">
                                <div class="head">
                                    <a class="btn btn-contact" href="mailto:{{$profile->email}}">Contact</a>
                                    <strong class="name">{{$profile->name}}</strong><span class="dot">&bull;</span><span class="designation">{{$profile->job_title}}</span>
                                </div>
                                {{$profile->description}}
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="bio-post">
                            <div class="text-box"><div class="head">No record found.</div></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('footer_assets')
@parent
@stop
