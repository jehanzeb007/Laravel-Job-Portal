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
    <link rel="shortcut icon" href="assets/ico/favicon.png">
    
    <title>
        @section('title')
          {{Config::get('constants.site.name')}}            
        @show
    </title>
    <!-- Sub View to Include Assets -->
    @section('header_assets')
      @include('layouts.header_assets')
    @show
</head>
    <body>
        <div id="layout">
          <div class="container headerOffset">
            @yield('modal')
            @yield('cropper_popup')
          </div>
          <!-- Footer section -->
           <!-- End of footer section -->
        </div>
        <div class="userSuccMSG">
       ...
       </div>
    </body>
</html>