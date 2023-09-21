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

    var totalPages = {{$announcements->count()}};
    var currentPage = {{$announcements->getCurrentPage()}};
    $('.clsGetRecrods').click(function(){
        if(currentPage < totalPages){
            currentPage++;
        }else{
/* Disable Button on pages completed */
            $(this).addClass('grayBtn')
            .removeClass('siteButtonSmall')
            .addClass('clsGetRecrods');
            return;
        }

        $.ajax({
        dataType: "json",
        url:"{{route('getannouncements')}}"+'?page='+currentPage,
        success:function(responseData){
            totalPages = responseData.last_page;
            currentPage = responseData.current_page;

            $.each(responseData.data, function(key, value){
            var vHtml = '<li>\n\
<img src="http://hbi.loc/data/announcement/mobile/images/'+value.mobile_image_path+'">\n\
<h2>'+value.title+'</h2>\n\
<h4>'+value.sub_title+'</h4>\n\
<div class="featuredPost">';
    if(value.featured == 1){
        vHtml=vHtml+'Featured &nbsp; | &nbsp;';
    }
    vHtml = vHtml + 'Posted on ' + convertDate(value.date) + '</div>'+value.long_description
        +'</li>';

$( "newsIMG" ).append(vHtml);
                });
            }
        });
/* Disable Button on pages completed */
        if(currentPage >= totalPages){
            $(this).addClass('grayBtn')
            .removeClass('siteButtonSmall')
            .addClass('clsGetRecrods');
        }
    })

var m_names = new Array("Jan", "Feb", "Ma", 
"Apr", "May", "Jun", "Jul", "Aug", "Sep", 
"Oct", "Nov", "Dec");
    function convertDate(dt){
        a_dt = dt.split('-');
        dat = m_names[a_dt[1]-1] + ' ' + a_dt[2] + ', '+ a_dt[0];
        return dat;
    }
  </script>
@stop

@section('about-us')
    active
@endsection

@section('left_section')
<div class="newSeprator"></div>
@if ($announcements->count())
<ul class="newsIMG">
   @foreach ($announcements as $announcement)
    <li>
        @if(is_file("data/announcement/images/".$announcement->image_path))
            {{ HTML::image("data/announcement/images/".$announcement->image_path) }}
        @endif
        <h2>{{$announcement->title}}</h2>
        <h4>{{$announcement->sub_title}}</h4>
        <div class="featuredPost">
            @if($announcement->featured == 1)Featured &nbsp; | &nbsp; @endif 
            Posted on {{date('M d, Y', strtotime($announcement->date))}}</div>
        {{$announcement->long_description}}
    </li>
   @endforeach
</ul>
@endif

<div class="clr"></div>

<div class=" @if ( (int)$announcements->getCurrentPage() == (int)$announcements->getLastPage() ) grayBtn @else siteButtonSmall @endif clsGetRecrods" style="float: right;">
    <span><a href="javascript:void(0)">Next Article</a></span>
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