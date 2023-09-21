@extends('layouts.layout')
@section('title')
@parent - {{ 'Account Recovery' }}
@stop

@section('login') 
class="active"
@endsection
@section('content')
<style type="text/css">
.w280{ width: 300px;}
.brd_dash{  border-right: #cccccc dashed 1px;}
.mr80{ margin-right: 80px}
.mb40{ margin-bottom: 40px;}
.pb90{ padding-bottom: 90px;}
#reset_msg.error { color: #222222; font-size: 13px; line-height: 18px; font-style: normal; margin-left: 0px; }
#inform-msg.error { color: #222222; font-size: 13px; line-height: 18px; font-style: normal; margin-left: 0px; }
</style>
<div id="content">
  <div class="loginTrouble">
    <div class="login-trouble-left"> @if($error = Session::get('error'))
      <div class="loginErrorDetail pb20"> {{ $error }} </div>
      @endif
      <h1> Password Problems </h1>
      <h2>To reset your password using email, please enter<br />
        your username and your email address. To <br />
        retrieve your password by answering your security<br />
        questions, provide your username and click continue.</h2>
      <div class="verifiedPass">
        {{ Form::open(array('route' => 'processForgotPassword', 'id' =>'processForgotPassword')) }}
        <ul class="fl w280 brd_dash mr80 mb40 pb90">
          <div class="clr"></div>
          <li class="txt_1">Reset with Email</li>
          <li>
            <label>Username</label>
            <input name="username" id="username" type="text" class="textInputPop fl"/>
            <div class="success" id="username_msg"></div>
            <div class="clr"></div>
          </li>
          <!-- <li class="forgotOR"> {{ HTML::image("assets/images/forgotOR.jpg") }} </li> -->
          <li>
            <label>Email</label>
            <input name="username_resetpass" id="username_resetpass" type="text" class="textInputPop fl"/>
            <div class="success" id="username_msg"></div>
            <div class="clr"></div>
          </li>
          <li>
            <div class="siteButtonSmall"> <span>
              <input name="password" id="password" type="button" value="Reset your password" onclick="resetPassword()" />
              </span> 
          
              </div>
              <div class="clr"></div>
          </li>
          <div id="reset_msg" class="error"></div>
          <div id="inform-msg" style="margin-top: 20px;" class="error">
            *To ensure that you receive the password in
            your inbox, please make sure the email
            address web-admin@hbinsights.com is
            whitelisted.
          </div>
          <div class="clr"></div>
        </ul>
        {{Form::close()}}
        <ul class="fl w400 sec-questions">
          <div class="clr"></div>
          <li class="txt_1">Reset with Security Question</li>
          <li>
            <label>Username</label>
            <input name="username" id="sec-username" type="text" class="textInputPop fl"/>
            <div class="success" id="username_msg"></div>
            <div class="clr"></div>
          </li>
          <li>
            <div class="siteButtonSmall"> <span>
              <input name="password" id="password" type="button" value="Continue" onclick="fetchSecurityQuestions()" />
              </span> 
          
              </div>
              <div class="clr"></div>
          </li>
          <li class="success sec-question-error" style="display:none; margin-top: 5px;"></li>
          <div class="clr"></div>
        </ul>

        <ul class="clr">
          <li class="last verifiedInfo">
            <p> If you still cannot login with the new password or do not receive a password reset email, please <br /> contact The Academy at 888.700.5223 for further assistance.</p>
            <!-- <p> If you still cannot login with the new password or do not receive a password reset email, please <br /> contact The Academy at 888.700.5223 for further assistance or <a href="javascript:void(0)" onclick="phplive_launch_chat_0(0)">click here</a> to chat with a <br /> membership services advisor. </p> -->
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="clear">&nbsp;</div>
</div>

<script type="text/javascript">
    

    function fetchSecurityQuestions() {
      $('.sec-question-error').html('');
      $('.sec-question-error').hide();

      $.ajax({
          method: "POST",
          url: "{{URL::route('fetchSecurityQuestions')}}",
          data: { username: $('#sec-username').val(),_token:$("input[name=_token]").val()},
          success: function ( response ) {
            if(response.status != 'error'){
              $('.sec-questions').html( response );
            } else {
              $('.sec-question-error').html('* ' + response.message);
              $('.sec-question-error').show();
            }
          }
      });
    }

    function resetPassword(){   

      $("#reset_msg").addClass('success');
      $("#reset_msg").html('');

      $.ajax({
          method: "POST",
          url: "{{URL::route('processForgotPassword')}}",
          data: { username: $('#username').val(), useremail: $('#username_resetpass').val(),_token:$("input[name=_token]").val()},
          success: function ( response ) {
            if ( (response.status == 'success') && ( response.url )) {
               window.location =  response.url;
            } else if(response.status != 'error'){

                var msg_success = '<span>An email with instructions to reset your password has been sent to your email address. If your email address cannot be found, please contact The Academy at 888-700-5223 or by email (contact@hbinsights.com). If you do not receive the password reset instructions email within the next 15 minutes, please check your junk mail or spam filter for this message.</span>';
                $("#reset_msg").removeClass('error');
                $("#reset_msg").addClass('success');
                $("#reset_msg").html(msg_success);
                $('#username').removeClass('errorBox');
                $('#username_resetpass').removeClass('errorBox');
            } else {
              var msg_success = '<span>* ' + response.message + '</span>';
              $("#reset_msg").removeClass('error');
              $("#reset_msg").addClass('success');
              $("#reset_msg").html(msg_success);
              $('#username').removeClass('errorBox');
              $('#username_resetpass').removeClass('errorBox');
            }
          }
      });
    }
</script> 
@stop

@section('footer_assets')
@parent
 <script type="text/javascript">
     $(document).ready(function(){

        // $.getScript("{{Config::get('settings.liveChat')}}");
        
        /**
         * Enable form submit on enter key press in form.
         */
       
       $('#username_resetpass').keypress(function(e){
           if(e.which == 13){
               // avoid double call for "Sign In" enter event. 
               if($(this).attr('id') !== 'password'){
                   $('#password').trigger('click');
               }
           }
       });
       $('#username').keypress(function(e){
           if(e.which == 13){
               // avoid double call for "Sign In" enter event. 
               if($(this).attr('id') !== 'password'){
                   $('#password').trigger('click');
               }
           }
       });
    });
 </script>
@stop
