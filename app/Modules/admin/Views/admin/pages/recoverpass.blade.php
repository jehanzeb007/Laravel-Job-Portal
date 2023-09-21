@extends('layouts.layout')
@section('title')
    @parent - {{ 'Login' }}
@stop

<?php 
  // To keep track of where the user has came from
  // ..as this page can get called from email link or via the security questions
  // ..and both the pages have a bit different layout
  $camefrom = Input::get('camefrom', Session::get('cfrom', 'na'));

  // Persist this
  if (!Session::has('cfrom')) {
    Session::put('cfrom', $camefrom);
  }

  $pageHead = ( $camefrom == 'secanswers' ) ? 'Password problems' : 'Change Password';
  $headMsg = ( $camefrom == 'secanswers' ) ? 'You have answered your security questions<br> correctly. Please setup a new password to<br> login to your account' : '';

  $adFieldStyle = ( $camefrom == 'secanswers' ) ? 'display:none;' : '';
?>

@section('login')
    class="active"
@endsection
@section('content')
<div id="content">
  <div class="loginTrouble">
    <div class="login-trouble-left"> 

      <h1>{{ $pageHead }}</h1>

      @if( $headMsg )
        <h2 class="plarge-head-msg">{{$headMsg}}</h2>
      @endif

      <div class="verifiedPass">
       {{Form::model($user, array('class'=>'loginForm')) }}  
          
        <input type="hidden" name="camefrom" value="{{ Input::old('camefrom', Input::get('camefrom', 'na')) }}">

        <ul>
          {{ Form::hidden('id',null, array('class' => 'inputText', 'readonly'=>'readonly')) }}  
          <div class="clr"></div>

          <li style="{{ $adFieldStyle }}">
              
            {{Form::label('email', 'Email')}}
            {{ Form::text('email',null, array('class' => 'textInputPop fl inputTextRead', 'readonly'=>'readonly')) }}  
            <div class="error">{{$errors->first('email')}}</div>
            <div class="clr"></div>
          </li>

          <li style="{{ $adFieldStyle }}">
            {{Form::label('username', 'Username')}}
            {{ Form::text('username',null, array('class' => 'textInputPop fl inputTextRead', 'readonly'=>'readonly')) }}  
            <div class="error">{{$errors->first('username')}}</div>
            <div class="clr"></div>
          </li>

          <li>
            {{Form::label('password', 'New Password')}}
            {{ Form::password('password', array('class' => $errors->has('confirm_password')? 'textInputPop fl errorBox' : 'textInputPop fl', 'placeholder' => 'New Password')) }}  
            <div class="error">{{$errors->first('password')}}</div>
            <div class="clr"></div>
          </li>
           <li>
            {{Form::label('confirm_password', 'Confirm Password')}}
            {{ Form::password('confirm_password', array('class' => $errors->has('confirm_password')? 'textInputPop fl errorBox' : 'textInputPop fl', 'placeholder' => 'Confirm Password')) }}   
            <div class="error">{{$errors->first('confirm_password')}}</div>
            <div class="clr"></div>
          </li>
          
          <li>
            <div class="siteButtonSmall"> <span>{{ Form::submit('Change Password', array('id' => 'btnChangePassword'))}}</span></div>
            <div class="clr"></div>
          </li>

          @if( Session::has('error') )
            <li class="error" style="margin: 0px; font-style: normal;width: 560px;">* {{ Session::get('error', '')}}</li>
          @endif

          <div class="clr"></div>
          
        </ul>

       {{Form::close()}}
      </div>
    </div>
  </div>
  <div class="clear">&nbsp;</div>
   </div>
@stop

@section('footer_assets')
@parent
 <script type="text/javascript">
$(document).ready(function() { 
        /**
         * Enable form submit on enter key press in form.
         * 
         */
       
       $('.loginForm input').keypress(function(e){
           if(e.which == 13){
               // avoid double call for "Sign In" enter event. 
               if($(this).attr('id') !== 'btnChangePassword'){
                   $('#btnChangePassword').trigger('click');
               }
           }
       });
    });
</script>
@stop
    