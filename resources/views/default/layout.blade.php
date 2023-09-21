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
          <div >@yield('top_nav')</div>
          <div >@yield('header_bar')</div>
          <div >@yield('body')</div>
          <!-- Footer section -->
          <div>
            @section('footer_assets')
              @include('default.footer')
            @show
          </div>
           <!-- End of footer section -->

        </div>
    </body>
</html>