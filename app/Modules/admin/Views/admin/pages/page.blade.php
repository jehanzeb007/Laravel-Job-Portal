@extends('layouts.2columns-right')

@section('title')
    @if($page->slug == 'elearning')
    HBI's Training Courses, E-Learning Programs & Modules
    @elseif($page->slug == 'communities')
         @if(!empty($communitySlug) && $communitySlug == "revenue-cycle")
         HBI - Revenue Cycle Benchmarks & Best Practices, Benchmarking Tools
         @elseif(!empty($communitySlug) && $communitySlug == "supply-chain")
         HBI - Supply Chain Best Practices on Operations Management & Value Analysis
         @elseif(!empty($communitySlug) && $communitySlug == "cost-quality")
         HBI - Best Practice Research on Achieving Quality Outcomes, Population & Disease Management
         @elseif(!empty($communitySlug) && $communitySlug == "information-technology")
         HBI - IT Best Practices on Informatics, Applications & Infrastructure
         @else
         Healthcare Business Insights (HBI) - Research Academy Memberships
         @endif
    @elseif($page->slug == 'services')
        HBI's Products and Services to Assist Hospitals and Health Systems
    @elseif($page->slug == 'about-us')
        HBI's Research, E-Learning, Analytics, and Consulting
    @else
    @parent - {{ $page->title }}
    @endif
@stop
@section('footer_assets')
    @parent
    <script>
    $(document).ready(function(){
        $('.community-tab').removeClass('selected');
        @if(!empty($communitySlug)) 
            $('.content-{{$communitySlug}}').show();
            $('.{{$communitySlug}}').addClass("selected");
        @else
            $('#community1').show();
            $('#tab1').addClass("selected");
        @endif
    });
    </script>
@stop

@section($page->slug) 
    active
@endsection

@section('left_section')

<div class="editerStyle @if($page->slug == 'about-us')about-us-editor@endif" >    
    {{ $page->short_description }}
    <br/>
    {{ $page->long_description }}

    @if($page->slug == 'communities' || $page->slug == 'services' || $page->slug == 'elearning')
        {{$child}}
    @else
    
    
    @endif</div>

@stop

    @section('right_section')
    @if( !empty($announcement_count))
        <div class="cmsNewsBanner">
            <a href="{{route('page',array('slug' => 'announcement'))}}">
                <div class="cmsNewsBannerOverlay"></div>
                {{HTML::image('assets/images/newsBanner.jpg', '' )}}
            </a>
        </div>
    @endif
        @include('guest.pages.widget.1')
        <div class="clr"></div>
        @include('guest.pages.widget.2')
        <div class="clr"></div>
        @include('guest.pages.widget.3')
        <div class="clr"></div>
    @stop

