<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
            <title>
                @section('title')                
                @show
            </title>
            <!-- Sub View to Include Assets -->
            @section('admin_assets')
            @include('admin::layouts.admin_asset')
            @show
    </head>

    <body>
        <div id="layout">
           <!--  Top Navigation Secion Start -->
           @include('admin::layouts.top_nav')
           <!-- End of Top Navigation Section -->
           <!-- Title of Page Content -->
           <div class="ssi_heading">
                @section('section_title')
                @show
           </div>
           
           <!-- Main Content section -->
           <div id="content">

            <div class="right-panel">
              <div class="clr"></div>
              @if (Session::has('success'))
                <span id="success-message" class="adminSuccess">{{  Session::get('success') }}</span>    
                  <div class="clr"></div>
              @endif
                @yield('main') </div>
            <div class="clr"></div>
            </div>
           
           <!-- End of Main Content section -->
           
           <!-- Footer section -->
           @include('admin::layouts.footer')
           <!-- End of footer section -->
        </div>
    </body>
</html>