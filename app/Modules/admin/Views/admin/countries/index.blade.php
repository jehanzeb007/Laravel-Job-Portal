@extends('layouts.layout')
@section('title')    
    {{Config::get('constants.site.name')}} | Countries
@stop
@section('header_assets')
    @parent
    {!! HTML::style('assets/public/css/footable-0.1.css') !!}
    {!! HTML::style('assets/public/css/footable.sortable-0.1.css') !!}
    <style type="text/css">
        .date-icon { position: absolute; right:795px; top: 100px; pointer-events: none;}
        .calendar .form-group { position: relative;}
    </style>
@show
@section('main')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div>
            <div class="pull-left">
                <h1 class="section-title-inner">
                    <span>Countries</span>
                </h1>
            </div>
            <div class="pull-right"><a class="btn btn-primary btn-small primary_color grouped_elements" href="{{route('add_country')}}">+ Add Country</a></div>
            <div class="clearfix"></div>
        </div>
        <hr/>
        <div style="margin-bottom: 20px;">
            <div class="col-md-2" style="padding-left: 0px;">
                <input id="searchinput" name="name" placeholder="Search By Country Name" class="form-control input-md" type="search">
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="row userInfo">
            <div class="col-xs-12 col-sm-12">
                <table class="footable footable-loaded tablet breakpoint">
                    <thead>
                        <tr>
                            <th><span>Country</span></th>
                            <th><span>Latitude</span></th>
                            <th><span>Longitude</span></th>
                            <th><span>Action</span></th>
                        </tr>
                    </thead>
                    <tbody id="content">
                        @include('admin::admin.countries.listing', ['country' => $country])
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('footer_assets')
    @parent
    <script>
        $(document).ready(function() {

   
            $(".grouped_elements").fancybox({
                'padding'       :   0,
                'type'          :   'iframe',
                'transitionIn'  :   'none',
                'transitionOut' :   'none',
                'fitToView'     :   false,
                'autoSize'      :   false,
                'autoScale'     :   false,
                'autoDimensions':   false,
                'height'        :   480,
                'width'         :   530,
                'speedIn'       :   600, 
                'speedOut'      :   200, 
                'overlayShow'   :   false,
            });
    
        });

        function closeFancyBox() {
            $.fancybox.close();
            window.location.reload(true);
        }

        var page = 1;
        var last_page = "{{$count/$index}}";
        var last_page = Math.ceil( last_page ); 
        var loadingComplete = true;
        if(loadingComplete == true){
            $(window).scroll(function() {
                if( $(window).scrollTop() + $(window).height() > $(document).height() + 510 ) {
                    if (page < last_page) {
                        page++;
                        var url = "{{URL::route('listing_country')}}?" + formatUrlParams();
                        fetchData(url, '0');
                    }
                }
            });
        }
        function fetchData(url, search) {
            /*if(search == '0' && loadingComplete == true){
                return ;
            }else*/ if(search == '1'){
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
            var url = "{{URL::route('listing_country')}}?" + formatUrlParams();
            fetchData(url, '1');
        }

        function formatUrlParams() {
            var param = "page=" + page;
            var searchTxt = $.trim($("input#searchinput").val());
            if (searchTxt != "") {
                param += "&search="+ searchTxt;
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