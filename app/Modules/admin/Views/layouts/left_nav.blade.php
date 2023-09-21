<div class="leftMenu">
    <ul>
        <li>
            <a href="javascript:{}" class="left-nav-anchor">CMS<span class="listArrowUp"></span></a>
            <ul>
                <li @yield('pages')>
                     {!! link_to_route('pages.index','Pages',array()) !!}
                </li>
                <li @yield('announcements')>
                    {!! link_to_route('announcements.index','Announcements',array()) !!}
                </li>
                <li class="{!!Request::is('admin/testimonials') || Request::is('admin/testimonials/*') ? 'active' : ''!!}">
                    {!! link_to_route('testimonials.index','Testimonials',array()) !!}
                </li>
                <li @yield('ads')>
                    {!! link_to_route('ads.index','Ads',array()) !!}
                </li>
                <li @yield('banners')>
                    {!! link_to_route('banners.index','Banners',array()) !!}
                </li>
                <li @yield('users')>
                    {!! link_to_route('users','Admin Panel',array()) !!}
                </li>
            </ul>
        </li>


    </ul>
</div>
<script>
    $('a.left-nav-anchor').bind('click', function(){
        $(this).parent().find('ul').slideToggle();
        if($(this).find('span').hasClass('listArrowUp')){
            $(this).find('span').removeClass('listArrowUp');
            $(this).find('span').addClass('listArrowDown');
        }else {
            $(this).find('span').removeClass('listArrowDown');
            $(this).find('span').addClass('listArrowUp');
        }
   
    });
</script>
