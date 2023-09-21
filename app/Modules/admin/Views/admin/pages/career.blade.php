@extends('layouts.layout')

@section('title')
    @parent - {{ $page->title }}
@stop
@section($page->slug) 
    active
@endsection

@section('head_assets')
@parent
<style>
    
    #content p{
        font-size: 19px;
        /*margin-bottom: 15px;*/
        margin-left: 0;
        line-height: 23px;
        font-family: 'Segoe UI Reg';
    }
</style>   
@stop

@section('content')

<div id="content">
    <div class="contentInner">
        <h1>{{$page->title}}</h1>
        {{$page->long_description}}
        <div class="career-content">
                <div class="career-open">
                    <h2>Current Openings</h2>
                <?php $k = 0; ?>
                    @if(!empty($resumatorData[0]) && count($resumatorData))
                        @foreach($resumatorData as $key => $value)
                            <?php $k++; ?>
                    <div class="career-post">
                        <div class="text-box">
                            <div class="head">
                                <div class="btn btn-apply"><span><a id="{{$value['id']}}" href="{{route('applyjob', array('job_id' => $value['id'])) }}" class="applyJob fancybox fancybox.iframe" title="Apply to {{{$value['title']}}} position" caption="Job Application" value="{{{$value['title']}}}">Apply Now</a></span></div>
                                <div class="btn btn-detail"><span><a href="{{route('jobDetail', array('id' => $key+1 )) }}" class="" caption="View Detail">View Details</a></span></div>
                                <strong class="title">{{$value['title']}}</strong> {{-- | <strong class="duration">{{$value['type']}}</strong> --}}
                            </div>
                            {{ $value['summary'] }}
                        </div>
                    </div>
                    @endforeach
                    @else
                        <li class="borBotNone mb0">
                            <h4>There are no current job openings.</h4>
                        </li>
                    @endif
                </div>
            </div>
    </div>
</div>
@stop

@section('footer_assets')
@parent
@stop