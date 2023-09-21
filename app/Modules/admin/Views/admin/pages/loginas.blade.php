@extends('layouts.layout')
@section('title')
    @parent - {{ 'Login' }}
@stop
@section('login') 
    class="active"
@endsection

@section('content')
<div id="content">
  <div class="loginWrapper">
      <div class="loginTopBg">
        <div class="loginBotBg">
          <div class="loginRepBg">
              
@if($success = Session::get('success'))
    <div class="alert-box success">
        <h2>{{ $success }}</h2>
    </div>
@endif              
              
          {{Form::open(array('route' => 'internalIndex', 'class'=>'loginForm'))}}
            <h3>Sign In</h3>
              <div class="clr"></div>
            <div class="loginErrorDetail" style="display:none;"></div>
            <ul class="loginForm">
         
              <li>
              {{ Form::label('title', 'Username') }}
                {{ Form::text('username', null, array('class' => 'inputText','placeholder' => 'Username','autocomplete' => 'off')) }}
                
              </li>
              <li>
              {{ Form::label('title', 'Password') }}
                {{ Form::password('password', array('class' => 'inputText','placeholder' => 'Password','autocomplete' => 'off')) }}
              </li>
              <li>
              {{ Form::label('title', 'Login As') }}
              {{ Form::text('loginas', null, array('class' => 'inputText','placeholder' => 'Username','autocomplete' => 'off')) }}
                <a class="forGotPassward" href="{{ URL::to("loginhelp") }}">Forgot Your Password?</a> </li>
              <li></li>
            </ul>
            <div class="siteButton mt0 mb10"> <span> 
                    <input id="btnSignIn" class="sp53" type="button" value="Sign In" class="adminBTNInput" onclick="login(this)"/>      
                </span> </div>
            <div class="clr"></div>
            {{Form::close()}}
          </div>
        </div>
      </div>
      <div class="clr"></div>
    </div>
  

  <div class="clear">&nbsp;</div>
   </div>
@stop

@section('footer_assets')
@parent
{{ HTML::script('assets/js/jquery.watermark.min.js') }}
{{ HTML::script('assets/esourcing/js/placeholders.jquery.js') }}
<script type="text/javascript">
 $(document).ready(function() { 
     /**
      * Enable form submit on enter key press in form.
      * 
      * @author Waqas Ahmad
      */
    $('.loginForm input').keypress(function(e){
        if(e.which == 13){
            // avoid double call for "Sign In" enter event. 
            if($(this).attr('id') !== 'btnSignIn'){
                $('#btnSignIn').trigger('click');
            }
        }
    }); 
 });
 /**
 * login function to handle redirect or show error messages
 * @param elem Object
 **/
function login(elem){
    postData = $(elem).parents('.loginForm').find('input');
    var jqryXHR = $.ajax({
      type : 'POST',				
      url : "{{route('dologinas')}}",
      data : postData,
      success: function(responseData, textStatus, jqXHR) {
          if(responseData.status=='error'){
              $(elem).parents('#content').find('loginErrorDetail').show();
              $(elem).parents('#content').find('loginErrorDetail').html(responseData.message);
              $('inputText').addClass('loginError');
              return;
          }
          $(elem).parents('.loginForm').submit();
          var redirectTo = '{{route("internalIndex")}}';
          //window.location = redirectTo;
          return;
      },
      error: function (responseData, textStatus, errorThrown) {
          $(elem).parents('#content').find('loginErrorDetail').html(responseData.message)
      }
    });
    return;
}
</script>
@stop