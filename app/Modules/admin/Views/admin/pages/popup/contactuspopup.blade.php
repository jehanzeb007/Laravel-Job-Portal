@extends('layouts.popup')

@section('title')
@parent - {{ $page->title }}
@stop

@section('head_asset_popup')
@parent
<style>
popup { width: 780px; }
.fancybox-outer .fancybox-inner { height: auto !important; }
popupContent { padding: 28px 49px 20px 39px; }
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
popup textTextAreaPop { height: 110px; }
popup .note-label charCounter { margin: -3px 0 0; }
popup userVerfication {
    float: none;
    border-bottom: 1px solid #e5e5e5;
}
popup userVerfication:after {
    content: "";
    display: block;
    clear: both;
}
popupContactForm .btn-area { padding: 8px 0 0; }
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
<!--    <div class="popupTabBar">
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
    </div>-->
    <div class="popupContent">
        <div class="popupContentLeft">
            <ul>
<!-- Add Sub Views for left side quote  -->
            @include('guest.pages.subviews.quote')

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
<!--                        <div class="popup-info">
                            To help us serve you better, mention <strong>ConnectID 12345</strong> to your representative.
                        </div>-->
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
            </ul>
        </div>
        <div class="popupContentRight">
            <div id="top-part"></div>
<!--            <div class="sendMessage">
                <h3><i class="icons sendMessageIcon"></i> SEND US A MESSAGE</h3>
                <div class="clr"></div>
                <span>{{$page->short_description}}</span> </div>-->
            {{ Form::open(array('route' => 'sendcontactus', 'id' => 'contact_hcbs', 'name' => 'contact_hcbs')) }}
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
                    </li>

                    <li>
                        <div class="note-label">
                        <div class="charCounter"> You have <input class="textInputPop wAuto" readonly type="text" id="countdown" name="countdown" size="3" value="500"> characters left.</div>
                            {{ Form::label('note', 'Note') }}
                            <small class="required">*</small>
                        </div>
                            <div class="clr"></div>
                        <div class="fl">
                            {{ Form::textarea('note', NULL, array(
                            'class'      => 'textTextAreaPop input',
                            'onKeyDown'  => "limitText(this.form.note,this.form.countdown,500);",
                            'onKeyUp'    => "limitText(this.form.note,this.form.countdown,500);"
                            ) ) }}
<!--                            <div class="requestDemo">
                           <div class="requestDemoCheck">{{ Form::checkbox('demo', 'Demo Request', $input['demo'], array('id'=>'demo', 'class' => 'demo')) }}</div>
                      <div class="fl"> {{ Form::label('demo', 'Request a Demo') }}</div>  
                           </div>-->
                        </div>
                    </li>
                </ul>
                <div class="clr"></div>
                <div class="userVerfication">
                    To verify you are a human
                    <?php printCaptcha('contact_hcbs', 0); ?>
                </div>
                <div class="clr"></div>
                <div class="btn-area">
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
            jQuery("#side-block").css("max-height", "400px");
            jQuery("#side-block").css("overflow", "auto");
//            jQuery("popupSelectedModule").css("height", "auto");
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
    });
    
   /**
     * Prepare data to post the Form
     * @param {type} elem
     * @returns {undefined}
     */
    function submitForm(elem) {
       services = "";
       prevService = "";
       itemCounter = 0;
        jQuery(elem).parents().find("#side-block").children().each(function(){
            serviceName = jQuery(this).find('popupModuleInfo h4').text();
            serviceItemName = jQuery(this).find('popupModuleInfo span').text().substring(1); //substring to remove -
            academy = $(this).attr('academy');
            academyName = "";
            if(academy == 'rca'){
                academyName = "Revenue Cycle";
            }else if(academy == 'sc'){
                academyName = "Supply Chain";
            }else if(academy == 'cq'){
                academyName = "Cost & Quality";
            }else if(academy == 'it'){
                academyName = "Information Technology";
            }
//            if(services){
//                services += ', ';
//            }
            currentService = academyName + " (" + serviceName + ")";
            if(prevService != currentService){
                services += "<br>"+currentService+"<br>";
                prevService = currentService;
                itemCounter = 0;
            }
            itemCounter++;
            services += "&nbsp; &nbsp;"+ itemCounter + "- "+ serviceItemName+ "<br>";
        ;
        });
//        console.log(services);
//        return;
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
                'source'    :source
                   };
        url = "{{route('sendcontactus')}}";
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