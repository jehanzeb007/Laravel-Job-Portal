@extends('layouts.popup')

@section('title')
@parent - {{ 'Sign In' }}
@stop

@section('head_asset_popup')
@parent
<style type="text/css">
 
 .fancybox-inner{
     height:auto !important;
 }
 
 loginErrorDetail{
     padding-bottom: 0px;
 }
</style>
@stop

@section('popup_content')
<div class="signin-popup">
    {{Form::open(array('route' => 'loginPostAjax', 'class'=>'signin-popup-form', 'id' => 'signinForm'))}}
        <div class="loginErrorDetail" style="display: none;"></div>
        <div class="signup-row">
            <label for="username">Username</label>
            <input id="username" class="inputText" placeholder="Username" autocomplete="off" name="username" type="text"/>
        </div>
        <div class="signup-row">
            <a class="link-forgot-pass" href="{{URL::to('loginhelp')}}">Forgot Your Password?</a>
            <label for="password">Password</label>
            <input id="password" class="inputText" placeholder="Password" autocomplete="off" name="password" type="password" value=""/>               
            <input name="comefrom" type="hidden" value="{{ isset($comefrom) ? $comefrom : "" }}">
        </div>
        <div class="btn-holder">
            <input id="btnSignIn" class="btn-signin" type="button" value="Sign In" />
            <div class="check-holder">
                <input id="remember" type="checkbox" name="remember" value="1"/>
                <label for="remember" style="margin-bottom:0px; margin-top:2px;">Keep Me Logged In</label>
            </div>
        </div>
        <div class="popup-info">
            <h3>Become a Member</h3>
            <p>Contact us to become part of the community today, and gain access the latest best practice research and resources in your field.</p>
            <a class="btn-contact fancybox fancybox.ajax" href="{{route('contactus', array('width'=>800, 'modal'=>'true', 'source' => 'inquiry')) }}"  title="Contact Us" caption="Contact Us">Contact Us</a>
        </div>
    {{Form::close()}}
</div>

<script>
    
    $(function() {

        // Ajax Login
        $("form#signinForm #btnSignIn").bind("click", function() {
            
            var dataStr = $("#signinForm").serialize();
            $("form#signinForm").find("divloginErrorDetail").hide();

            $.ajax({
                url: "{{route('loginPostAjax')}}",
                type: 'json',
                data: dataStr,
                method: "POST",
                success: function(response) {

                    if (response.status == "error") {
                        $("form#signinForm").find("divloginErrorDetail").html(response.message);
                        $("form#signinForm").find("divloginErrorDetail").show();
                        return;
                    }

                    if (response.status == "success") {
                        location.href = response.redirectTo;
                    }
                },
                failure: function(response) {
                    // failure case, server end
                }
            });
        });
    });

</script>
@stop
