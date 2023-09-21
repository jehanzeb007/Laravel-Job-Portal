<!DOCTYPE html>
<html lang="en">
<head>
    @section('meta')
       <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
      <!--[if IE]>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <![endif]-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="ScriptsBundle">
      <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/logo.png')}}"/>
    @show
    <title>
      @section('title')
        {{Config::get('constants.site.name')}}            
      @show
    </title>
    @section('header_assets')
      @include('default.header_assets')
    @show
</head>
    <body>
        <div id="layout">
          <div>@include('default.main_top_bar')</div>
          <div>@yield('home')</div>
          <div>@include('default.footer')</div>
        </div>
    </body>
</html>