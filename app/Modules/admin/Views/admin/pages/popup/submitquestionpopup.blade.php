@extends('layouts.popup')

@section('title')
@parent - Submit a Question
@stop

@section('head_asset_popup')
@parent
<style>
/*popup { width: 530px; }*/
.fancybox-outer .fancybox-inner { height: auto !important; }
/*popupContent { padding: 40px 44px 22px 30px; }*/
popupContentLeft { width: 205px; }
popupContentRight popupContactForm ul li {
    overflow: hidden;
    margin-bottom: 11px;
}
popupContentLeft ul li popLocation iconLocation {
    float: left;
    padding: 2px 0 0;
}
popupContentLeft ul li popLocation popLocationRight {
    float: none;
    width: auto;
    overflow: hidden;
}
popupContentLeft ul li {
    float: none;
    margin-bottom: 11px;
}
.popup-info {
    background: #777;
    color: #fff;
    font-size: 12px;
    padding: 7px 26px 7px 32px;
    margin: -6px 0 5px;
    line-height: 18px;
    border-radius: 8px;
}
.popup-info strong{
    font-family: "Segoe UI Bold";
    font-weight: 400;
}
popup .note-label { padding: 6px 0 8px; }
popup textTextAreaPop { height: 110px; width: 660px; }
popup .note-label charCounter { margin: -3px 0 0; }
popup userVerfication {
    margin-top: 11px;
    float: none;
    /*border-bottom: 1px solid #e5e5e5;*/
}
popup userVerfication:after {
    content: "";
    display: block;
    clear: both;
}
popupContactForm .btn-area { padding: 8px 0 0; margin-top: 55px;}
popupContactForm .btn-area:after {
    content: "";
    display: block;
    clear: both;
}
popupContactForm .btn-area sendFormInfo { margin-top: 17px; }
popupSelectedModule {
    position: relative;
}
popupRemoveSelctedModule {
    position: absolute;
    top: 50%;
    right: 0;
    margin: -10px 10px 0 0;
}
popupSelectedModule popupModuleInfo {
    float: none;
    width: auto;
    overflow: hidden;
}
.ms-choice > span {
    border: solid 1px #e4e4e4;
    background: #f2f2f2;
    width: 205px;
    color: #3b3b3b;
    font-size: 15px;
    font-family: 'Segoe UI Reg';
}
.ms-drop{
    width: 213px;
}
.ms-parent{
    width: 210px !important;
}
.input-field{
    margin-right: 14px;
}
popupContentRight{
    width: 675px;
}
</style>
@stop

@section('popup_content')
<?php
@session_start();
function printCaptcha($formId = NULL, $type = NULL, $fieldName = NULL) {
    require_once(public_path() .'/assets/inc/visualcaptcha.class.php');
    $visualCaptcha = new visualCaptcha($formId,$type,$fieldName);
    $visualCaptcha->show();
}
?>
<div class="popup">
    <div class="popupContent">
        <div class="popupContentRight">
            <div id="top-part"></div>
            {{ Form::open(array('route' => 'sendSubmitQuestion', 'id' => 'contact_hcbs', 'name' => 'contact_hcbs')) }}
            @if ($errors->any())
            <div class="errorMsg">
                <ul>
                    {{ implode('', $errors->all('
                    <li class="error">:message</li>
                    ')) }}
                </ul>
            </div>
            @endif
            <div class="popupContactForm">
            <!--<div class="fltL">-->
                <ul style="display:none" class="errorMsg"></ul>
                <ul>
                    <li>
                        <div class="fl input-field">
                            {{ Form::label('first_name', 'First Name') }}
                            <small class="required">*</small>
                            <div class="clr"></div>
                            {{ Form::text('first_name', null, array('class' => 'textInputPop input')) }}
                        </div>
                        <div class="fl input-field">
                            {{ Form::label('last_name', 'Last Name') }}
                            <small class="required">*</small>
                            <div class="clr"></div>
                            {{ Form::text('last_name', null, array('class' => 'textInputPop input')) }}
                        </div>
                        <div class="fl">
                            {{ Form::label('organization', 'Organization') }}
                            <small class="required">*</small>
                            <div class="clr"></div>
                            {{ Form::text('organization', null, array('class' => 'textInputPop input')) }}
                        </div>
                    </li>
                    <li>
                        <div class="fl input-field">
                            {{ Form::label('title', 'Title') }}
                            <small class="required">*</small>
                            <div class="clr"></div>
                            {{ Form::text('title', null, array('class' => 'textInputPop input')) }}
                        </div>
                        <div class="fl input-field">
                            {{ Form::label('phone', 'Phone') }}
                            <small class="required">*</small>
                            <div class="clr"></div>
                            {{ Form::text('phone', null, array('class' => 'textInputPop input phone_formator')) }}
                        </div>
                        <div class="fl">
                            {{ Form::label('email', 'Email') }}
                            <small class="required">*</small>
                            <div class="clr"></div>
                            {{ Form::text('email', null, array('class' => 'textInputPop input')) }}
                        </div>
                    </li>

                    <li class="mb0 pB0">
                        <div class="fl">
                        {{ Form::label('community', 'Area of Focus') }}
                        <small class="required">*</small>
                        <div class="clr"></div>                        
                    </li>
                    {{Form::select('community', $academyList, '',array('id' => 'academy','class' => ''))}}
                    <li class="mb0 pB0" style="margin-top: 11px;">
                        <div class="fl">
                            <div class="note-label">
                                <div class="charCounter"> You have <input class="textInputPop wAuto" readonly type="text" id="countdown" name="countdown" size="3" value="500"> characters left.</div>
                                    {{ Form::label('question', 'Submit a Question') }}
                                    <small class="required">*</small>
                            </div>
                        <div class="clr"></div>                        
                        <div class="fl">
                            {{ Form::textarea('question', NULL, array(
                            'class'      => 'textTextAreaPop input',
                            'onKeyDown'  => "limitText(this.form.question,this.form.countdown,500);",
                            'onKeyUp'    => "limitText(this.form.question,this.form.countdown,500);"
                            ) ) }}
                        </div>
                        </div>
                    </li>
                </ul>
                <div class="clr"></div>
                <li>
                    <div class="fl">
                        <div class="userVerfication">
                            To verify you are a human
                            <?php printCaptcha('contact_hcbs', 0); ?>
                        </div>
                    </div>
                    <div class="btn-area fr">
                        <div class="siteButtonSmall formSend mR10"> <span><a id="btnSend" href="javascript:void(0)" onclick="submitForm(this);">Send</a></span> </div>
                        <div class="grayBtn "> <span><a href="javascript:void(0)" onclick="javascript:jQuery.fancybox.close();">Cancel</a></span> </div>
                        <div class="clr"></div> 
                        <div class="sendFormInfo">
                            <span>We will contact you within 24 hours.</span>
                        </div>
                    </div>
                </li>
                <div class="clr"></div>
            </div>
            {{ Form::close() }}
        </div>
        <div class="clr"></div>
    </div>
</div>
<div class="clr"></div>
@stop

@section('head_asset_popup')
@parent
{{ HTML::style('assets/multiple-select/multiple-select.css') }}
{{ HTML::script('assets/multiple-select/jquery.multiple.select.js') }}
<script> 
    var source = '{{$input["source"]}}';
    $("#academy").multipleSelect({
        selectAll: false,
        placeholder: "Community",
        allSelected: 'All Communities'
    });
//    $("#academy").multipleSelect('checkAll');
    
   /*
     * Shows the inquiry related left side information
     * @returns {void}
     */
    function showInquiry(){
        jQuery("#tb_inquiry").addClass("active");
        jQuery("#tb_quote").removeClass("active");
        jQuery("#side-block").css("display", "none");
        jQuery("#popupselectedItemHeader").css("display", "none");
        jQuery("#popupselectedItemHeader").addClass('popupItemFirst');
        source = 'inquiry';
        jQuery(".requestDemo").css("display", "block");
    }

   /*
     * Shows the quote related left side information
     * @returns {void}
     */
    function showQuote(){
        jQuery("#tb_quote").addClass("active");
            jQuery("#tb_inquiry").removeClass("active");
            jQuery("#side-block").css("display", "block");
	        jQuery("#popupselectedItemHeader").removeClass('popupItemFirst');
            jQuery("#popupselectedItemHeader").css("display", "block");
            source = 'quote';
            jQuery(".requestDemo").css("display", "none");
    }

    $(document).ready(function(){
        @if ($input['source'] == 'inquiry')
            showInquiry();
        @endif

        @if($input['source'] == 'quote')
            showQuote();
        @endif

        jQuery("#tb_inquiry").click(function(e) {
            showInquiry();
        });

        jQuery("#tb_quote").click(function(e) {
            showQuote();
        });
        
 
        /**
         * Enable form submit on enter key press in form.
         * 
         */
       $('#contact_hcbs input').keypress(function(e){
           if(e.which == 13){
               // avoid double call for "Send", "Note" and "characters counter" enter event. 
               if($(this).attr('id') !== 'btnSend' && $(this).attr('id') !== 'note' && $(this).attr('id') !== 'countdown'){
                   $('#btnSend').trigger('click');
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
    
   /**
     * Prepare data to post the Form
     * @param {type} elem
     * @returns {undefined}
     */
    function submitForm(elem) {
        var academy = $("select#academy").multipleSelect('getSelects');
       services = "";
        jQuery(elem).parents().find("#side-block").children().each(function(){
            if(services){
                services += ', ';
            }
               services += jQuery(this).find('popupModuleInfo h4').text()+jQuery(this).find('popupModuleInfo span').text();
        ;
        });
        // Prepare the Data to Post
        postData = {'first_name'  :jQuery(elem).parents('#contact_hcbs').find("#first_name").val(),
                'last_name'  :jQuery(elem).parents('#contact_hcbs').find("#last_name").val(),
                'email'    :jQuery(elem).parents('#contact_hcbs').find("#email").val(),
                'question'     :jQuery(elem).parents('#contact_hcbs').find("#question").val(),
                'organization' :jQuery(elem).parents('#contact_hcbs').find("#organization").val(),
                'phone'     :jQuery(elem).parents('#contact_hcbs').find("#phone").val(),
                'title'     :jQuery(elem).parents('#contact_hcbs').find("#title").val(),
                'captcha-value':jQuery(elem).parents('#contact_hcbs').find("#captcha-value").val(),
                'demo'     :jQuery(elem).parents('#contact_hcbs').find("#demo").is(':checked')? 'Yes' : 'No',
                'community' : academy,
                'services'   :services,
                'source'    :source
                   };
        url = "{{route('sendSubmitQuestion')}}";
        jQuery.post(
            url, 
            postData,
            function( result ) {
                if(result.status==='success'){
                    jQuery.fancybox.close();
                    return;
                }
                var errorStr = '';
                jQuery.each(result.errors, function(i, item) {
                    errorStr += '<li>'+item+'</li>';
                    $('label[for="' + i + '"]').attr('style', 'color:#C51E1E','font-weight:bold');
                })
                $('popupContent .errorMsg').html(errorStr);
                jQuery('.errorMsg').show();
            },
            "json"
        );
    }
    /**
     * Limits the Text to a specified length on input
     * @param {type} limitField
     * @param {type} limitCount
     * @param {type} limitNum
     * @returns {void}
     */
    function limitText(limitField, limitCount, limitNum) {
        if (limitField.value.length > limitNum) {
            limitField.value = limitField.value.substring(0, limitNum);
        } else {
            limitCount.value = limitNum - limitField.value.length;
        }
    }
</script>
 
@stop