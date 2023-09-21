{!! HTML::style('assets/admin/css/style.css') !!}
{!! HTML::style('assets/admin/css/bootstrap.min.css') !!}
{!! HTML::style('assets/admin/css/bootstrap-responsive.css') !!}
{!! HTML::style('assets/admin/css/fluid_grid.css') !!}
{!! HTML::style('assets/admin/css/ui-lightness/jquery-ui-1.10.3.custom.min.css') !!}
{!! HTML::style('assets/admin/js/fencybox/jquery.fancybox.css?v=2.1.5') !!}

<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
{!! HTML::script('assets/admin/js/jquery-1.10.1.min.js') !!}
{!! HTML::script('assets/admin/js/bootstrap.min.js') !!}
{!! HTML::script('assets/admin/js/ckeditor/ckeditor.js') !!}
{!! HTML::script('assets/admin/js/jquery-ui-1.10.3.custom.min.js') !!}
{!! HTML::script('assets/admin/js/fencybox/jquery.fancybox.js?v=2.1.5') !!}


{!! HTML::style('assets/admin/css/custom.css') !!}

<script>
    $(document).ready(function() {
        //$('.fancybox').fancybox();
        $(".fancybox").fancybox({
            helpers: {
                title : {
                    type : 'inside',
                    position : 'top'
                },
                overlay : {
                    speedOut : 0
                }
            },closeBtn  : false
        });
    });
</script>