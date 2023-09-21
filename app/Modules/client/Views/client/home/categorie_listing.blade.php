@extends('default.main_layout')
@section('title')    
{{Config::get('constants.site.name')}} | Job Listing
@stop
@section('header_assets')
   @parent  
   {!! HTML::style('/assets/client/css/select2.min.css') !!}
@stop
@section('home')

<section class="breadcrumb-search parallex">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                <div class="col-md-8 col-sm-12 col-md-offset-2 col-xs-12 nopadding">
                    <div class="search-form-contaner">
                        <form class="form-inline">
                            <div class="col-md-10 col-sm-7 col-xs-12 nopadding">
                                <div class="form-group">
                                    <input id="searchinput" name="searchinput" class="form-control" type="search" placeholder="Search" value="">
                                    <i class="icon-magnifying-glass"></i>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12 nopadding">
                                <div class="form-group form-action">
                                    <button class="btn btn-default btn-search-submit" type="button">Search <i class="fa fa-angle-right"></i> </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="categories">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="Heading-title black">
                        <h1>Job categories</h1>
                    </div>
                </div>
                @php $country_id = 0; $categorie_id = 0; @endphp
                <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                    <div id="cats-masonry" style="height: 1603.77px; position: relative;">
                        @foreach($category_array as $key => $item)
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="category-box">
                                <div class="category-heading"> <a href="{{route('search_jobs_by_categorie',$item->slug)}}"> {{$item->name}} <span>({{$item->categorie_count}})</span></a></div>
                                @foreach($sub_category_array[$item->id] as $value)
                                <ul>
                                    <li><a href="{{route('search_jobs_by_categorie',$item->slug)}}"> {{$value->name}} <span>({{$value->sub_categorie_count}})</span> </a></li>
                                </ul>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                        <div class="col-md-12 col-sm-12 col-xs-12" style="left: 0px; top: 1531px; position: absolute;">
                            <div class="load-more-btn">
                                <button class="btn-default"> Load More <i class="fa fa-refresh"></i> </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('footer_assets')
   @parent
   <script>

     var page = 1;
     var last_page = "{{$count/$index}}";
     var last_page = Math.ceil( last_page ); 
     var loadingComplete = true;
     if(loadingComplete == true){
        $(window).scroll(function() {
            console.log($(document).height() )
            if( $(window).scrollTop() + $(window).height() > $(document).height() -300 ) {
                
                console.log($(window).scrollTop())
                if (page < last_page) {
                    page++;
                    var url = "{{URL::route('categorie_listing')}}?" + formatUrlParams();
                    console.log('url',url)
                    fetchData(url, '0');
                }
            }
        });
     }
     function fetchData(url, search) {
         if(search == '1'){
             loadingComplete = false;
         }
         $('div.loader').show();
         d = new Date();
         url += '&t='+d.valueOf();
         console.log('url', url);
         $.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
             options.async = true;
         }); 
         $.ajax({
             url: url
         }).done(function(response) {
             if (response.code == '401' || response.status == 'error') {
                 document.location.reload();
             } else {
                 if (search == '1') {
                     if(response == ""){
                         response = '<tr><td colspan="10">no record found.</td></tr>'
                     }
                     $('#content').html(response);
                 } else {

                     if(response == ''){
                         loadingComplete = true;
                     } else {

                         $('#content tr:last').after(response);
                         loadingComplete = false;
                     }
                 }
             }
             $('div.loader').hide(); 
         });
     }

     function callSearch(){
         page = 1;
         var url = "{{URL::route('categorie_listing')}}?" + formatUrlParams();
         fetchData(url, '1');
     }

     function formatUrlParams() {
         var param = "page=" + page;
         var country = {{$country_id}};
         var categorie = {{$categorie_id}};
         
         var searchTxt = $.trim($("input#searchinput").val());
         if (searchTxt != "") {
             param += "&search="+ searchTxt;
             $('.pagination-box').hide();
         }else{
            $('.pagination-box').show();
         }
         if (country != 0) {
            param += "&country="+ country;
         }
         if (categorie != 0) {
            param += "&categorie="+ categorie;
         }
         
         
         return param;
     }

     $(document).ready(function() {
         $("input#searchinput").keyup(function(){
             if(typeof timer === 'undefined'){
                 // do nothing
             } else {
                 window.clearTimeout(timer);
             }
             timer = window.setTimeout(function(){
                 console.log("search");
                 callSearch();
             },1000); 
         })
     });
</script>
@show
@stop