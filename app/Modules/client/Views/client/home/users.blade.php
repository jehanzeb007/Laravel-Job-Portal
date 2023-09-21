@extends('default.main_layout')
@section('title')    
{{Config::get('constants.site.name')}} | Job Listing
@stop
@section('header_assets')
   @parent  
   {!! HTML::style('/assets/client/css/select2.min.css') !!}
@stop
@section('home')
<div class="clearfix"></div>
 <div class="search">
    <div class="container-fluid">
       <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
             <div class="input-group">
                <div class="input-group-btn search-panel">
                   <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                   <span id="search_concept">Filter By</span>
                   </button>
                </div>
                <input type="hidden" name="search_param" value="all" id="search_param">
                <input id="filter_search" type="text" class="form-control search-field " name="x" placeholder="Search term...">
                <span class="input-group-btn">
                <button class="btn btn-default" type="button"><span class="fa fa-search" onclick="callTopSearch()"></span></button>
                </span>
             </div>
          </div>
       </div>
    </div>
 </div>
<section class="breadcrumb-search parallex">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                <div class="col-md-8 col-sm-12 col-md-offset-2 col-xs-12 nopadding">
                    <div class="search-form-contaner">
                        <div class="col-md-10 col-sm-7 col-xs-12 nopadding">
                            <div class="form-group">
                                <input id="searchinput" name="searchinput" class="form-control searchinput" type="search" placeholder="Search" value="">
                                <i class="icon-magnifying-glass"></i>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12 nopadding">
                            <div class="form-group form-action">
                                <button class="btn btn-default btn-search-submit" type="button" onclick="callSearch(1)">Search <i class="fa fa-angle-right"></i> </button>
                            </div>
                        </div>
                        <a href="{{route('radial_search')}}" style="color:#fff; float:right; margin-top:10px;"> Radial Search</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="categories-list-page light-grey">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    @php $country_id = 0; $categorie_id = 0; @endphp
                    <div class="all-jobs-list-box2" id="content">
                    	@include('client::client.home.user_listing', ['users' => $users])
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@section('footer_assets')
   @parent
   <script>

    function callTopSearch(){
        var searchMe = $("input#filter_search").val();
        $("input#searchinput").val(searchMe);
        callSearch(1)
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

     function callSearch(page){
         var url = "{{URL::route('user_listing')}}?" + formatUrlParams(page);
         fetchData(url, '1');
     }

     function formatUrlParams(page) {
         var param = "page=" + page;
         var country = {{$country_id}};
         var categorie = {{$categorie_id}};
         
         var searchTxt = $.trim($("input.searchinput").val());
         $("input#filter_search").val(searchTxt);
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
        $("#searchinput").keypress(function(event) {
            if (event.which == 13) {
                callSearch(1)
            }
        });
        $("#filter_search").keypress(function(event) {
            if (event.which == 13) {
                callTopSearch(1)
            }
        });
     });
</script>
@show
@stop