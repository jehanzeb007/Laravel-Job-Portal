<div class="navbar primary_color navbar-fixed-top megamenu" role="navigation">
    <div class="navbar-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6">

                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 no-margin no-padding">
                    <div class="pull-right">
                        <ul class="userMenu">
                            @if(Auth::check())
                            <li>
                                <a href="{{route('admin_logout')}}">
                                    <span class="hidden-xs">Sign Out</span>
                                    <i class="glyphicon glyphicon-log-in hide visible-xs "></i>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/.navbar-top-->

    <div class="container">
        <div class="navbar-header">
            <div > <a href="{{route('users')}}"> <img style="height: 50px; width: 60px; margin-right: 26px;" src="{{asset('/assets/images/logo.png')}}" alt="logo" class="img-responsive"> </a> </div>
        </div>
        @if(Auth::check())
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">

                <li @yield('Dashboard')><a href="{{route('dashboards')}}">Dashboard</a></li>
                <li class="dropdown" @yield('admin')>
                        <a class="dropbtn"> Admin Panel <b class="caret"></b></a>
                    <div class="dropdown-content">
                        <a href="{{route('users')}}"> Admin </a>
                        <a href="{{route('roles')}}"> Roles </a>
                    </div>
                </li>
                <li @yield('User')><a href="{{route('site_users')}}">Users</a></li>
                <li @yield('Job')><a href="{{route('jobs')}}"> Jobs </a></li>
                <li class="dropdown" @yield('cms')>
                        <a class="dropbtn"> CMS <b class="caret"></b></a>
                    <div class="dropdown-content">
                        <a href="{{route('pages.index')}}"> Pages </a>
                        <a href="{{route('announcements.index')}}"> Anouncements </a>
                        <a href="{{route('testimonials.index')}}"> Testimonials </a>
                        <a href="{{route('ads.index')}}"> Ads </a>
                        <a href="{{route('banners.index')}}"> Banners </a>
                    </div>
                </li>
                <li class="dropdown" @yield('settings')>
                        <a class="dropbtn"> Job Settings <b class="caret"></b></a>
                    <div class="dropdown-content">
                        <a href="{{route('categories')}}"> Categories </a>
                        <a href="{{route('forms')}}"> Job Form Attributes </a>
                        <a href="{{route('countries')}}"> Countries </a>
                        <a href="{{route('states')}}"> States </a>
                        <a href="{{route('cities')}}"> Cities </a>
                        <a href="{{route('sub_cities')}}"> Sub Cities </a>
                    </div>
                </li>   
            </ul>
        </div>
        @endif
    </div>
</div>

<style type="text/css">

.navbar{
    background-color: #9b59b6;
}
.navbar-nav > li > a {
    background-color: #9b59b6;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #8e44ad;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
}

.dropdown-content a {
    color: #fff;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.dropdown-content a:hover {background-color: #9b59b6}

.dropdown:hover .dropdown-content {
    display: block;
}
.img{
    height: 35px;
    padding-bottom: 2px;
}
.glyphicon {
    top: 8px;
}
</style>