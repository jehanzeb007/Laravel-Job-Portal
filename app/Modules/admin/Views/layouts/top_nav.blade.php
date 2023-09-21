<div class="hbiAdmin_topContainer">
  <div id="top">
    <div id="headerlogo">
      <a href="#">Logo</a>
    </div>
    <div id="topContent"> 
    
    <!--<ul class="hbiAdmin_topSearch">
    <li><input name="" type="text" class="hbiAdmin_topSearchFld" value="Search" /></li>
    </ul>-->
    
    <ul class="hbiAdmin_topLinks">
    <li><a href="javascript:{}" onclick="popupMenu(this)"><i>{!! HTML::image("assets/admin/images/hbiAdmin_userIcon.png") !!}</i><span>Welcome, @if(!empty(Auth::user()->name)){!!Auth::user()->name!!}@endif</span></a>
        <ul class="pull-down">
            <li>{!!link_to('admin/change_password', 'Change Password')!!}</li>
        </ul>
    </li>
    <li>{!!link_to('logout', 'Logout')!!}</li>
    
    </ul>
    
     </div>
    
    
  </div>
  </div>
  

    <!--****** Start Top Navigation ******-->
    <div id="nav" style="display:none">
           <ul>
            <li class="ssi_menuCostStudy ssi_itemMenu @yield('ads')">
                <a href="{!!route('ads.index')!!}" title="Users"><span></span>Ads</a></li>
            <li class=" ssi_menuETL ssi_itemMenu @yield('testimonials') ">
                <a class="ssi_itemMenu " href="{!!route('testimonials.index')!!}" title="Testimonials"><span></span>Testimonials</a></li>
        </ul>
    </div>
<script>
    function popupMenu(elem){
        $(elem).parent().find('ul').slideToggle();
    }
</script>