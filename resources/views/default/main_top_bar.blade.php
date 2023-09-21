<style type="text/css">
  #container{
    padding: 0px;
  }
  #menu-links{
    padding-top: 20px;
    padding-bottom: 20px;
  }
</style>
<div class="header-top clear">
   <div class="container">
      <div class="row">
         <div class="col-md-7 hidden-sm hidden-xs">
            <div class="header-top-left header-top-info">
               <p><a href="tel:+966 560 9686 16"><i class="fa fa-phone"></i>+966 560 9686 16</a></p>
               <p><a href="mailto:toilscompany@gmail.com"><i class="fa fa-envelope"></i>toilscompany@gmail.com</a></p>
            </div>
         </div>
         <div class="col-md-5">
            <div class="header-top-right pull-right header-top-info">
               @if(Auth::check())
                  <p><a href="{{route('logout')}}"><i class="fa fa-power-off"></i>Logout</a></p>
               @else
                  <p><a href="{{route('login_client')}}"><i class="fa fa-lock"></i>Login</a>
                  <a href="{{route('register')}}"></i>/ Register</a></p>
               @endif
               
            </div>
         </div>
      </div>
   </div>
</div>
<nav id="menu-1" class="mega-menu fa-change-black" data-color="">
   <section id="container" class="menu-list-items container">
      <div class="container">
         <ul class="menu-logo">
            <li > <a href="{{route('home')}}"> <img style="height: 80px; width: 90px; margin-left: 26px;" src="/assets/images/logo.png" alt="logo" class="img-responsive"> </a> </li>
         </ul>
         <nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
     <a href="{{route('home')}}" class="navbar-brand"> <img style="height: 80px; width: 90px; margin-left: 26px;" src="/assets/images/logo.png" alt="logo" class="img-responsive"> </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="{{route('home')}}">Home<span class="sr-only">(current)</span></a></li>
        <li><a href="{{route('all_jobs')}}">Jobs</a></li>
        <li><a href="{{route('all_users')}}">Professionals</a></li>
        <li><a href="#">Companies</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Contact Us</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Language <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">English</a></li>
            <li><a href="#">عربى</a></li>
            <li><a href="#">中国语文</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Français</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">اردو</a></li>
            <li><a href="#">русский</a></li>


          </ul>
        </li>
      </ul>
     
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

         <ul id="menu-links"  class="menu-links pull-right">

            @if(Auth::check())
              @if (Auth::user()->user_type != 'JobSeeker' )
                <li class="no-bg"><a href="{{route('add_job_post')}}" class="p-job" ><i class="fa fa-plus-square"></i> Post a Job</a></li>
              @endif
              @if (Auth::user()->user_type == 'Both' )
                <li class="no-bg"><a href="/chat-room-seeker" class="p-job" style="margin-left: 10px;"><i class="fa fa-comments-o"></i>Messages</a></li>
              @elseif (Auth::user()->user_type == 'JobSeeker')
                <li class="no-bg"><a href="/chat-room-seeker" class="p-job" style="margin-left: 10px;"><i class="fa fa-comments-o"></i>Messages</a></li>
              @elseif (Auth::user()->user_type == 'Employer')
                <li class="no-bg"><a href="/chat-room-employer" class="p-job" style="margin-left: 10px;"><i class="fa fa-comments-o"></i>Messages</a></li>
              @endif
              <li class="profile-pic">
                @if(!empty(Auth::user()->image_path))
                <a href="{{route('client_user_profile')}}"> <img src="/assets/images/profile/thumbnail/{{Auth::user()->image_path}}" alt="user-img" class="img-circle" width="36"><span class="hidden-xs hidden-sm">{{Auth::user()->first_name}}</a>
                @else
                <a href="{{route('client_user_profile')}}"> <img src="/assets/images/user.png" alt="user-img" class="img-circle" width="36"><span class="hidden-xs hidden-sm">{{Auth::user()->first_name}}</a>
                @endif
              </li>
            
            @endif
         </ul>
      </div>
   </section>
</nav>