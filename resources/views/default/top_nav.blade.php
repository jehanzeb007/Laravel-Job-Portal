<style type="text/css">
  #container{
    padding: 0px;
  }
  #menu-links{
    padding-top: 20px;
    padding-bottom: 20px;
  }
</style>
<div class="page category-page">
 <div id="spinner">
    <div class="spinner-img">
       <img alt="Opportunities Preloader" src="/assets/client/images/loader.gif" />
       <h2>Please Wait.....</h2>
    </div>
 </div>
 <nav id="menu-1" class="mega-menu fa-change-black" data-color="">
        
    <section id="container" class="menu-list-items container">
      <ul class="menu-logo">
          <li > <a href="{{route('home')}}"> <img style="height: 80px; width: 90px; margin-left: 26px;" src="/assets/images/logo.png" alt="logo" class="img-responsive"> </a> </li>
       </ul>
       <ul id="menu-links" class="menu-links pull-right">
          @if (Auth::user()->user_type != 'JobSeeker' )
          <li class="no-bg"><a href="{{route('add_job_post')}}" class="p-job"><i class="fa fa-plus-square"></i> Post a Job</a></li>
          @endif
          @if (Auth::user()->user_type == 'Both' )
            <li class="no-bg"><a href="/chat-room-seeker" class="p-job" style="margin-left: 10px;"><i class="fa fa-comments-o"></i>Messages</a></li>
          @elseif (Auth::user()->user_type == 'JobSeeker')
            <li class="no-bg"><a href="/chat-room-seeker" class="p-job" style="margin-left: 10px;"><i class="fa fa-comments-o"></i>Messages</a></li>
          @elseif (Auth::user()->user_type == 'Employer')
            <li class="no-bg"><a href="/chat-room-employer" class="p-job" style="margin-left: 10px;"><i class="fa fa-comments-o"></i>Messages</a></li>
          @endif
          <li class="profile-pic">
            @if(!empty($user->image_path))
              <a href="javascript:void(0)"> <img src="/assets/images/profile/thumbnail/{{$user->image_path}}" alt="user-img" class="img-circle" width="36"><span class="hidden-xs hidden-sm">{{$user->first_name}} </span><i class="fa fa-angle-down fa-indicator"></i> </a>
            @else
              <a href="javascript:void(0)"> <img src="/assets/images/user.png" alt="user-img" class="img-circle" width="36"><span class="hidden-xs hidden-sm">{{$user->first_name}} </span><i class="fa fa-angle-down fa-indicator"></i> </a>
            @endif
             
             <ul class="drop-down-multilevel left-side">
                <li><a href="{{route('client_user_profile')}}"><i class="fa fa-user"></i> My Profile</a></li>
                <!-- <li><a href="#"><i class="fa fa-mail-forward"></i> Inbox</a></li>
                <li><a href="#"><i class="fa fa-gear"></i> Account Setting</a></li> -->
                <li><a href="{{route('logout')}}"><i class="fa fa-power-off"></i> Logout</a></li>
             </ul>
          </li>
       </ul>
    </section>
 </nav>

</div>