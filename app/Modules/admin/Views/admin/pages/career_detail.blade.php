@extends('layouts.layout')

@section('careers')
active
@endsection

@section('content')
<div id="content">
    <div class="career-page">
        <div class="career-header">
            <a class="link-back-page" href="/pages/careers"><i class=""></i>Back to List</a>
            <h1>Careers</h1>
        </div>
        <div class="career-content-holder">
            <div class="career-content">
                <div class='heading'>
                    <strong class="title">{{$data['title']}} {{-- <span class='separator'>|</span><span class="duration">{{$data['type']}}</span> --}}</strong>
                </div>
                <div class="resumator">{{$data['description']}}</div>
            </div>
            <div class="btn-area">
                <a id="{{$data['id']}}" href="{{route('applyjob', array('job_id' => $data['id'])) }}" class="btn btn-apply fancybox fancybox.iframe" title="Apply to {{{$data['title']}}} position" caption="Job Application" value="{{{$data['title']}}}">Apply Now</a>
                <a class="link-back" href="/pages/careers">Back to List</a>
            </div>
        </div>
    </div>
</div>
@stop

@section('footer_assets')
@parent
<script>
$(function(){
    $('ul').each(function() {
        var $this = $(this);
        $this.attr("style","margin-bottom:15px");
    });
    $('p').each(function() {
        var $this = $(this);
        if($this.html().replace(/\s|&nbsp;/g, '').length == 0)
            $this.attr("style","margin-bottom:5px");
    });
    $('.resumator strong').attr('style','font-size: 24px');
});
</script>
@stop