@extends('layouts.popup_iframe')

@section('title')
@parent - Apply
@stop


@section('popup_content')
<div class="appyjob">
    
    <div class="popupContent">
        
        <div class="popupContentRight  appyjobContent" style="float:none; width:455px;">
            <div id="top-part" class="popupHeading"><h3></h3></div>
            <div class="sendMessage">
                
                {{ Form::open(array('route' => 'applyjobrequest', 'id' => 'applyjob', 'name' => 'applyjob', 'files' => true)) }}
                @if ($errors->any())
                <div>
                    <ul class="errorMsg">
                        @if($errors->any())
                        {{ implode('', $errors->all('
                        <li>:message</li>
                        ')) }}
                        @endif
                    </ul>
                </div>
                @endif
                 <div class="clr"></div>
            <div class="popupContactForm">
                <ul>
                    <li>
                        {{ Form::hidden('job_id', $job_id, array('class' => 'input')) }}
                        
                        <div class="fl">
                            {{ Form::label('first_name', 'First Name') }}
                            <small class="required">*</small>
                            <div class="clr"></div>
                            {{ Form::text('first_name', null, array('class' => 'textInputPop input')) }}
                        </div>
                        <div class="fr">
                            {{ Form::label('last_name', 'Last Name') }}
                            <small class="required">*</small>
                            <div class="clr"></div>
                            {{ Form::text('last_name', null, array('class' => 'textInputPop input')) }}
                        </div>
                        <div class="clr"></div>
                    </li>
                    <li>
                        <div class="fl">
                            {{ Form::label('email', 'Email') }}
                            <small class="required">*</small>
                            <div class="clr"></div>
                            {{ Form::text('email', null, array('class' => 'textInputPop input')) }}
                        </div>
                        <div class="fr">
                            {{ Form::label('address', 'Address') }}
                            <div class="clr"></div>
                            {{ Form::text('address', null, array('class' => 'textInputPop input')) }}
                        </div>
                        <div class="clr"></div>
                    </li>
                    <li>
                        <div class="fl">
                            {{ Form::label('city', 'City') }}
                            <div class="clr"></div>
                            {{ Form::text('city', null, array('class' => 'textInputPop input')) }}
                        </div>
                        <div class="fr">
                            {{ Form::label('state', 'State') }}
                            <div class="clr"></div>
                            {{ Form::select('state', $usStates, null, array('class' => 'textSelectPop input')) }}
                        </div>
                        <div class="clr"></div>
                    </li>
                    
                    <li>
                        <div class="fl">
                            {{ Form::label('postal', 'Zip Code') }}
                            <div class="clr"></div>
                            {{ Form::text('postal', null, array('class' => 'textInputPop input','maxlength'=>'5')) }}
                        </div>
                        <div class="fr">
                            {{ Form::label('phone', 'Phone') }}
                            <div class="clr"></div>
                            {{ Form::text('phone', null, array('class' => 'textInputPop input phone_formator')) }}
                        </div>
                        <div class="clr"></div>
                    </li>
                    <li>
                        <div class="fl">
                            {{ Form::label('resume', 'Resume') }}
                            <div class="clr"></div>
                            {{ Form::file('resume', array('class' => 'textInputPop input')) }}
                        </div>
                        <div class="clr"></div>
                    </li>
                    
                </ul>
                
                <div class="clr"></div>
                <div class="fl">
                           
                    <div class="siteButtonSmall formSend mR10">
                        <span class="submitForm">
                            {{ Form::submit('Send', array('class' => 'textInputPop', 'id' => 'btnApplyJobSend'))}}
                        </span>
                    </div>
                    <div class="grayBtn "> <span><a href="javascript:void(0)" onclick="javascript:parent.jQuery.fancybox.close();" class="">Cancel</a></span> </div>
                    <div class="clr"></div>
                </div>

            </div>
            {{ Form::close() }}
        </div>
        <div class="clr"></div>
    </div>
</div>
<div class="clr"></div>
@stop

@section('footer_asset_popup')
@parent
{{ HTML::script('assets/js/jquery-1.10.1.min.js') }}
<script>
    parent.$(document).ready(function(){
        div = document.getElementById('top-part');
        div.innerHTML = '<h3>'+parent.$("a#{{$job_id}}").attr('title')+'<h3>';
        @if (isset($message) && $message == 'success')
            parent.$.fancybox.close();
        @endif
        
      /**
      * Enable form submit on enter key press in form.
      * 
      */
    $('#applyjob input[type="text"]').keypress(function(e){
        if(e.which == 13){
            // avoid double call for "Sign In" enter event. 
            if($(this).attr('id') !== 'btnApplyJobSend'){
                $('#btnApplyJobSend').trigger('click');
            }
        }
    }); 
    
    // Phone number formator
       $(".phone_formator").keydown(function(evt){
          var charCode = (evt.which) ? evt.which : event.keyCode;
          var phEntered = this.value;
          
          // check for entered number should bot exceed 10
          phEntered = phEntered.replace(/-/g,'');
          var numEntered = new String(phEntered);
          
          if(numEntered.length > 9 ){
              // No more numeric entry 
              if((charCode < 48 || charCode > 57) && (charCode < 96 || charCode > 105)){
                  return true;
              }
              return false;  
          }
          
       });
       
    });
</script>
@stop
