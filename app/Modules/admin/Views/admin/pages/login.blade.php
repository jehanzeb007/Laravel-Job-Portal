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

          {{Form::open(array('route' => 'loginPost', 'class'=>'loginForm'))}}
            <h3>Sign In</h3>
              <div class="clr"></div>
            <div class="loginErrorDetail" style="{{isset($response['status'])&&$response['status']=='error'?'':'display:none'}};">{{isset($response['status'])&&$response['status']=='error'?$response['message']:''}}  </div>
            <ul class="loginForm">
         
              <li>
              {{ Form::label('title', 'Username') }}
                {{ Form::text('username', null, array('class' => 'inputText'. (isset($response['status'])&&$response['status']=='error'?' loginError':''),'placeholder' => 'Username','autocomplete' => 'off')) }}
                
              </li>
              <li>
              {{ Form::label('title', 'Password') }}
                {{ Form::password('password', array('class' => 'inputText'. (isset($response['status'])&&$response['status']=='error'?' loginError':''),'placeholder' => 'Password','autocomplete' => 'off')) }}
               
              
                <a class="forGotPassward" href="{{ URL::to("loginhelp") }}">Forgot Your Password?</a> </li>
              <li></li>
            </ul>
            <div class="siteButton mt0 mb10"> <span> 
                    <input id="btnSignIn" class="sp53" type="submit" value="Sign In" class="adminBTNInput"/>      
                </span> </div>
            <div class="clr"></div>
            <div class="keepLoginCheck">
              <input class="keepLogCheckBox" type="checkbox" name="remember" value="1" {{ isset($remember)&& $remember==1? 'checked="checked"' : '' }} />
              <label>Keep Me Logged In</label>
            </div>
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
{{-- HTML::script('assets/esourcing/js/placeholders.jquery.js') --}}
<script type="text/javascript">

/**
 * Checks for internet explorer version
 */
var ie = (function(){
    var undef, v = 3, div = document.createElement('div'), all = div.getElementsByTagName('i');
    while ( div.innerHTML = '<!--[if gt IE ' + (++v) + ']><i></i><![endif]-->', all[0] );
    return v > 4 ? v : undef;
}());

 $(document).ready(function() { 

    function fixPlaceholders () {
      $('input[placeholder]').each(function(){

        if($(this).val() === $(this).attr('placeholder')){
            // in the odd situation where the field is prepopulated with
            // a value and the value just happens to match the placeholder,
            // then we need to flag it
            $(this).data('skipCompare','true');
        }    

        // move the placeholder text into the field for the rest of the blank inputs
        if($(this).val().length===0){
          $(this).val($(this).attr('placeholder'))
        }

        // move the placeholder text into the field for the rest of the blank inputs
        if ($(this).val().length===0){
          $(this).val() = $(this).attr('placeholder');
        }


        $(this)
            .focus(function(){
                  // remove placeholder text on focus
                  if($(this).val()==$(this).attr('placeholder')){
                      $(this).val('')
                  }
            })
            .blur(function(){
                // flag fields that the user edits
                if( $(this).val().length>0 && $(this).val()==$(this).attr('placeholder')){
                    $(this).data('skipCompare','true');
                }
                if ( $(this).val().length==0){
                    // put the placeholder text back
                    $(this).val($(this).attr('placeholder'));
                }
        })
      })
    }

    if ( ( typeof ie != 'undefined' ) && ( ie <= 9 ) ) {
      fixPlaceholders();
    };

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
</script>
@stop