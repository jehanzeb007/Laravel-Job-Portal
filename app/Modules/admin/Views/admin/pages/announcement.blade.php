@extends('layouts.2columns-right')

@section('title')
    @parent - {{ $page->title }}
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

@section('about-us')
    active
@endsection

@section('left_section')

@if ($announcements->count())
<ul class="newsIMG">
   @foreach ($announcements as $announcement)
   <div class="newSeprator"></div>
    <li>
        @if(is_file("data/announcement/images/".$announcement->image_path))
            {{ HTML::image("data/announcement/images/".$announcement->image_path) }}
        @endif
        <h2>{{$announcement->title}}</h2>
        <h4>{{$announcement->sub_title}}</h4>
        <div class="featuredPost">
            @if($announcement->featured == 1)Featured &nbsp; <span>|</span> &nbsp; @endif 
            Posted on {{date('M d, Y', strtotime($announcement->date))}}</div>
        {{$announcement->long_description}}
    </li>
   @endforeach
</ul>
@endif

<div class="clr"></div>
<div class=" @if ($announcements->getCurrentPage() == 1) grayBtn @else siteButtonSmall @endif fl">
    <span><a href=" @if ($announcements->getCurrentPage() == 1) javascript:void(0) @else {{$announcements->getUrl($announcements->getCurrentPage()-1)}} @endif">Prev Article</a></span>
</div>

<div class=" @if ( (int)$announcements->getCurrentPage() == (int)$announcements->getLastPage() ) grayBtn @else siteButtonSmall @endif " style="float: right;">
    <span><a href=" @if ((int)$announcements->getCurrentPage() == (int)$announcements->getLastPage() ) javascript:void(0) @else {{ $announcements->getUrl($announcements->getCurrentPage()+1) }} @endif">Next Article</a></span>
</div>
<div class="clr"></div>
@stop


    @section('right_section')
    @stop
    
    @section('headingClass')
    newsTitle
    @stop

    @section('headingButton')
    <div class="siteButton newsBackBtn">
        <span><a href="{{route('page', array('slug' => 'about-us'))}}"> <i class="icons buttonArrowBack"></i>Back to About Us</a></span>
    </div>
    <div class="clr"></div>
    @stop