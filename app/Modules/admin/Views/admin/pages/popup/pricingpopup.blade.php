@extends('layouts.popup')

@section('title')
@parent - {{ $page->title }}
@stop

@section('head_asset_popup')
@parent
@include('layouts.frontend.head_asset')
<style>
    popup{
        width: @if(isset($input['width'])){{$input['width']}}px @else 800px @endif;
    }
    .fancybox-inner{
        height: 810px !important;
    }
    popupSelectedModule {
        height: 28px;
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
    <div class="popupTabBar">
        <ul>
            <li id="tb_inquiry" class= "
                @if ($input['source'] == 'inquiry')
                    active
                @endif
                ">
                <a href="javascript:void(0)">General Inquiry</a>
            </li>

            <li id="tb_quote" class="
                @if ($input['source'] == 'quote')
                    active
                @endif
                ">
                <a href="javascript:void(0)">Get a Quote</a>
            </li>
        </ul>
    </div>
    <div class="popupContent">
        <div class="popupContentLeft">
            <ul>
<!-- Add Sub Views for left side quote  -->
            @include('guest.pages.subviews.lmspricingquote')

                <li>
                    <div class="popLocation">
                        <div class="popLocationLeft iconLocation  icons"> </div>
                        <div class="popLocationRight"> <span>Location</span> 
                            <p> 4600 W. Loomis Road, Suite 310
                                Milwaukee, WI 53220 <a href="https://maps.google.com/maps?q=4600+W.+Loomis+Road,+Suite+310+Milwaukee,+WI+53220&hl=en&geocode=+&hnear=4600+W+Loomis+Rd+%23310,+Milwaukee,+Wisconsin+53220&t=m&z=16&iwloc=Ahttps://maps.google.com/maps?q=4600+W.+Loomis+Road,+Suite+310+Milwaukee,+WI+53220&hl=en&geocode=+&hnear=4600+W+Loomis+Rd+%23310,+Milwaukee,+Wisconsin+53220&t=m&z=16&iwloc=A" target="_blank">Get Directions</a> 
                            </p>
                        </div>
                    </div>
                    <div class="clr"></div>
                </li>

                <li>
                    <div class="popLocation">
                        <div class="popLocationLeft iconCallUs  icons"> </div>
                        <div class="popLocationRight"> <span>CALL US AT</span>
                            <p><b class="textBlue">888.700.5223</b> 8:00am-5:00pm CST,
                                <br />Monday through Friday </p>
                        </div>
                        <div class="clr"></div>
                        <div class="popHelpInfoBox" style="display: none;">
                            <div class="popHelpInfoBoxTop">
                                <div class="popHelpInfoCon">
                                    <p> To help us serve you better, 
                                        mention<b> ConnectID 12345 </b> to your representative.</p>
                                    <div class="clr"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clr"></div>
                </li>
                <li>
                    <div class="popupLeftBelowText">
                        <p>For immediate answers to your questions or personal support, simply call us; then, click on the link below. Your phone rep will give you a code to enter that will allow us to walk through your question on the website.</p>
                        <a href="https://www.livelook.com/welcome/view.aspx" target="_blank">Click here for web help</a> 
                    </div>
                </li>
                <div class="clr"></div>
            </ul>
        </div>
        <div class="popupContentRight">
            <div id="top-part"></div>
            <div class="sendMessage">
                <h3><i class="icons sendMessageIcon"></i> SEND US A MESSAGE</h3>
                <div class="clr"></div>
                <span>{{$page->short_description}}</span> </div>
            {{ Form::open(array('route' => 'lmsContact', 'id' => 'contact_hcbs', 'name' => 'contact_hcbs')) }}
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
                <ul style="display:none" class="errorMsg"></ul>
                <ul>
                    <li>
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
                            {{ Form::label('organization', 'Organization') }}
                            <small class="required">*</small>
                            <div class="clr"></div>
                            {{ Form::text('organization', null, array('class' => 'textInputPop input')) }}
                        </div>
                        <div class="fr">
                            {{ Form::label('title', 'Title') }}
                            <small class="required">*</small>
                            <div class="clr"></div>
                            {{ Form::text('title', null, array('class' => 'textInputPop input')) }}
                        </div>
                        <div class="clr"></div>
                    </li>
                    <li>
                        <div class="fl">
                            {{ Form::label('phone', 'Phone') }}
                            <small class="required">*</small>
                            <div class="clr"></div>
                            {{ Form::text('phone', null, array('class' => 'textInputPop input')) }}
                        </div>
                        <div class="fr">
                            {{ Form::label('email', 'Email') }}
                            <small class="required">*</small>
                            <div class="clr"></div>
                            {{ Form::text('email', null, array('class' => 'textInputPop input')) }}
                        </div>
                        <div class="clr"></div>
                    </li>

                    

                    <li>
                        <div class="fl">
                            {{ Form::label('note', 'Note (Up to 500 characters)') }}
                            <small class="required">*</small>
                            <div class="clr"></div>
                            {{ Form::textarea('note', NULL, array(
                            'class'      => 'textTextAreaPop input',
                            'onKeyDown'  => "limitText(this.form.note,this.form.countdown,500);",
                            'onKeyUp'    => "limitText(this.form.note,this.form.countdown,500);"
                            ) ) }}
                            <div class="requestDemo">
                           <div class="requestDemoCheck">{{ Form::checkbox('demo', 'Demo Request', $input['demo'], array('id'=>'demo', 'class' => 'demo')) }}</div>
                      <div class="fl"> {{ Form::label('demo', 'Request a Demo') }}</div>  
                           </div>
                           
                            <div class="charCounter"> You have <input class="textInputPop wAuto" readonly type="text" id="countdown" name="countdown" size="3" value="500"> characters left.</div>
                           
                        </div>
                        <div class="clr"></div>
                    </li>
                    
                </ul>
                <div class="clr"></div>
                <div class="userVerfication">
                    <?php printCaptcha('contact_hcbs', 0); ?>
                </div>
                <div class="clr"></div>
                <div class="fl">
                    <div class="siteButtonSmall formSend mR10"> <span><a id="btnSend" href="javascript:void(0)" onclick="submitForm(this);">Send</a></span> </div>
                    <div class="grayBtn "> <span><a href="javascript:void(0)" onclick="javascript:jQuery.fancybox.close();">Cancel</a></span> </div>
                    <div class="clr"></div> 
                    <div class="sendFormInfo">
                        <span>We will contact you within 24 hours.</span>
                    </div>
                </div>
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
<script> 
    var source = '{{$input["source"]}}';

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
         * @author Waqas Ahmad
         */
       $('#contact_hcbs input').keypress(function(e){
           if(e.which == 13){
               // avoid double call for "Send", "Note" and "characters counter" enter event. 
               if($(this).attr('id') !== 'btnSend' && $(this).attr('id') !== 'note' && $(this).attr('id') !== 'countdown'){
                   $('#btnSend').trigger('click');
               }
           }
       }); 
    });
    
   /**
     * Prepare data to post the Form
     * @param {type} elem
     * @returns {undefined}
     */
    function submitForm(elem) {
       services = "";
        jQuery(elem).parents().find("#side-block").children().each(function(){
            if(services){
                services += ', \r\n';
            }
               services += jQuery(this).find('popupModuleInfo h4').text()+':'+jQuery(this).find('#learnerResc').text();
        ;
        });
        // Prepare the Data to Post
        postData = {'first_name'  :jQuery(elem).parents('#contact_hcbs').find("#first_name").val(),
                'last_name'  :jQuery(elem).parents('#contact_hcbs').find("#last_name").val(),
                'email'    :jQuery(elem).parents('#contact_hcbs').find("#email").val(),
                'note'     :jQuery(elem).parents('#contact_hcbs').find("#note").val(),
                'organization' :jQuery(elem).parents('#contact_hcbs').find("#organization").val(),
                'phone'     :jQuery(elem).parents('#contact_hcbs').find("#phone").val(),
                'title'     :jQuery(elem).parents('#contact_hcbs').find("#title").val(),
                'captcha-value':jQuery(elem).parents('#contact_hcbs').find("#captcha-value").val(),
                'demo'     :jQuery(elem).parents('#contact_hcbs').find("#demo").is(':checked')? 'Yes' : 'No',
                'services'   :services,
                'source'    :source,
                'npr'  :jQuery(elem).parents('#contact_hcbs').find("#title").val(),
                'nprValue' :$('input[name="npr"').val(),
                'learnerCount' :$('input[name="learnerNum"').val(),
                'clearer' : $('input[name="funarea"]:checked').val(),
                'credits' : $('input[name="numCredits"').val(),
                'researchservices': ($('input[name="researchservices"').is(':checked'))? "Yes": "No",
                'auditing': ($('input[name="auditing"').is(':checked'))? "Yes": "No",
                'strategy': ($('input[name="strategy"').is(':checked'))? "Yes": "No",
                'license': ($('input[name="license"').is(':checked'))? "Yes": "No",
                'library': ($('input[name="library"').is(':checked'))? "Yes": "No",
                'custom': ($('input[name="custom"').is(':checked'))? "Yes": "No",
                'learnercount': ($('input[name="learnercount"').is(':checked'))? "Yes": "No",
                'traininservices':($('input[name="learnercount"]').is(':checked') ||$('input[name="custom"]').is(':checked') || $('input[name="library"]').is(':checked')|| $('input[name="license"]').is(':checked')|| $('input[name="strategy"]').is(':checked'))? "Yes": "No",
                   };
        url = "{{route('lmsContact')}}";
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