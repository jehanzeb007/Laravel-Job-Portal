<!DOCTYPE html>
<html lang="en">
<head>
    @section('meta')
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      @if(!empty($page->meta_description))
      <meta http-equiv="Content-Type" name="description" content="{{$page->meta_description}}">
      @endif
      @if(!empty($page->meta_keyword))
      <meta name="keywords" content="{{$page->meta_keyword}}">
      @endif
    @show
    
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/logo.png')}}"/>
    
    <title>
      @section('title')
        {{Config::get('constants.site.name')}}            
      @show
    </title>

    @section('header_assets')
      @include('layouts.header_assets')
    @show
</head>
    <body>
        <div id="layout">
          <div>@include('layouts.top_nav')</div>
          <div class="container main-container headerOffset">@yield('main')</div>
          <!-- Footer section -->
          <div>
            @section('footer_assets')
              @include('layouts.footer')
            @show
          </div>
           <!-- End of footer section -->

        </div>
    </body>
</html>