<div class="profile-nav">
   <div class="panel">
      <ul class="nav nav-pills nav-stacked">
         <li @yield('profile')>
            <a href="{{route('client_user_profile')}}"> <i class="fa fa-user"></i> Profile</a>
         </li>
         <li @yield('edit_profile')>
            <a href="{{route('edit_profile')}}"> <i class="fa fa-edit"></i> Edit Profile</a>
         </li>
         <li @yield('resume_list')>
            <a href="{{route('resume_list')}}"> <i class="fa fa-file-o"></i>Resume List</a>
         </li>
         @if ( $user->user_type == "JobSeeker" || $user->user_type == "Both" )
         <li @yield('user_job_applied')>
            <a href="{{route('user_job_applied')}}"> <i class="fa  fa-list-ul"></i> Jobs Applied</a>
         </li>
         @endif
         @if ( $user->user_type == "Employer" || $user->user_type == "Both" )
         <li @yield('user_job_posted')>
            <a href="{{route('user_job_posted')}}"> <i class="fa  fa-bookmark-o"></i> Jobs Posted </a>
         </li>
         @endif
      </ul>
   </div>
</div>