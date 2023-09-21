@extends('layouts.popup')

@section('title')
@parent - Options
@stop

@section('head_asset_popup')
@parent
<style>
/*popup { width: 530px; }*/
.fancybox-outer .fancybox-inner { height: auto !important; }
/*popupContent { padding: 40px 44px 22px 30px; }*/

popup{
    width: 968px;
    margin: 0;
    padding: 0;
}


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

popup .note-label { padding: 6px 0 8px; }
popup textTextAreaPop { height: 110px; width: 320px; }
popup .note-label charCounter { margin: -3px 0 0; }
popup userVerfication {
    margin-top: 7px;
    float: none;
    /*border-bottom: 1px solid #e5e5e5;*/
}
popup userVerfication:after {
    content: "";
    display: block;
    clear: both;
}
.btn-area { padding: 8px 0 0; margin-top: 15px; }
.btn-area:after {
    content: "";
    display: block;
    clear: both;
}

popupContentLeft{
    width: 223px;
}

.input-field{
    margin-right: 14px;
}

.leftCol{
    width: 75%;
    float: left;
}
.rightCol{
    width: 25%;
    float: left;
}

popupContent{
    padding: 20px 5px 25px 20px;
}

siteButtonSmallformSend span a { padding: 0px 30px; }
grayBtn{ margin: 0}
grayBtn span a{ padding: 0px 24px; }

popup siteButtonSmall{
    float: left;
    margin: 0;
}

.mL26{margin-left: 26px;}

ul.formLayout > li{ margin-bottom: 10px;float: left; }
grid ul ligridDataHeader { height: auto; padding: 0; float:left; width: 100%;}

grid ul ligridDataHeader::after {
    clear: both;
    content: "";
    display: block;
}
.cell1{ float: left;width: 35%; }
.cell1header{color: #fff; background-color: #5F6062; font-size: 13px;  }
.cell2{ float: left;width: 16%; text-align: center; }
.cell2header{color: #fff; background-color: #E51937; font-size: 13px;  }
.cell3{ float: left;width: 16%; text-align: center;}
.cell3header{color: #fff; background-color: #c41188; font-size: 13px;  }
.cell4{ float: left;width: 16%; text-align: center;}
.cell4header{color: #fff; background-color: #00A890; font-size: 13px;  }
.cell5{ float: left;width: 17%; text-align: center;}
.cell5header{color: #fff; background-color: #8DC63F; font-size: 13px;  }

.mL7{ margin-left: 7px;}
.mR15{ margin-right: 15px !important;}
.pL8 {padding-left: 8px;}
.servicesLanguage{ font-weight: normal; font-size: 17px;}
.cstm-icons{
    position: absolute;
    left: 45%;
    top: 0;
}
grid ul ligridDataContentWq ul li {
    border-radius: 4px;
}
.statusText{
    color: #fff;
}
required{
    font-size: 14px;
    color: #C51E1E;
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
        <h3 class="servicesLanguage">Interested in learning more about how partnering with HBI can help you achieve your strategic goals? Select the research and services below that best meet your business needs to request more information.</h3>
        <div class="grid">
            <ul>
                {{-- */$i=0;/* --}}      
                @foreach($serviceData as $service => $subData)

                <li class="gridDataHeader">
                    <div class="cell1 cell1header"><span class="pL8">{{$service}}</span></div>
                    <div class="cell2 cell2header"><span>Revenue Cycle</span></div>
                    <div class="cell3 cell3header"><span>Supply Chain</span></div>
                    <div class="cell4 cell4header"><span>Cost & Quality</span></div>
                    <div class="cell5 cell5header"><span>Information Technology</span></div>
                </li>
                 <li class="gridDataContentWq">
                        <div class="cell1 service_{{str_replace(array(' ','-'),'',$service)}}">
                            <ul id="service_{{str_replace(array(' ','-'),'',$service)}}">
                                @foreach($subData as $subservice)
                                <li class="serviceWrapper mL7" id="">
                                    {{$subservice['title']}}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="cell2 service_{{str_replace(array(' ','-'),'',$service)}}">
                            
                            <ul>
                                @foreach($subData as $subservice)
                                    <li class="selectedRec" service_item ="{{$subservice['id']}}" data-service-item-name="{{$subservice['title']}}" data-service-name="{{$service}}" data-academy="Revenue Cycle" data-academy-abr="rca">
                                        @if(in_array(1, $subservice['community']))
                                            <i class="icons cstm-icons"></i>
                                        @else
                                            <i class="icons cstm-icons disableState"></i>
                                        @endif
                                        <span class="statusText">SELECT</span>
                                    </li>
                                 @endforeach
                            </ul>
                            <div class="academy" name="Revenue Cycle" community="1" color='E51937' abbreviation="rca" newabbreciation="rca" slug="revenue-cycle" servicename="{{$service}}"></div><div class="servicedescription">{{ $services[$i]['description_revenue_cycle']}}</div>
                        </div>
                        <div class="cell3 service_{{str_replace(array(' ','-'),'',$service)}}">
                            <ul>
                                 @foreach($subData as $subservice)
                                    <li class="selectedRec" service_item ="{{$subservice['id']}}" data-service-item-name="{{$subservice['title']}}" data-service-name="{{$service}}" data-academy="Supply Chain" data-academy-abr="sca">
                                        <span class="statusText">SELECT</span>
                                        @if(in_array(2, $subservice['community']))
                                            <i class="icons cstm-icons "></i>
                                        @else
                                            <i class="icons cstm-icons disableState"></i>
                                        @endif
                                        
                                    </li>
                                 @endforeach
                                
                            </ul>
                            
                            <div class="academy" name="Supply Chain" community="2" color='9B5BA4' abbreviation="sc" newabbreciation="sca" slug="supply-chain" servicename="{{$service}}"></div><div class="servicedescription">{{ $services[$i]['description_supply_chain']}}</div>
                        </div>
                        <div class="cell4 service_{{str_replace(array(' ','-'),'',$service)}}">
                            <ul>
                                 @foreach($subData as $subservice)
                                    <li class="selectedRec" service_item ="{{$subservice['id']}}" data-service-item-name="{{$subservice['title']}}" data-service-name="{{$service}}" data-academy="Cost &amp; Quality" data-academy-abr="cqa">
                                        <span class="statusText">SELECT</span>
                                        @if(in_array(3, $subservice['community']))
                                            <i class="icons cstm-icons"></i>
                                        @else
                                            <i class="icons cstm-icons disableState"></i>
                                        
                                        @endif
                                    </li>
                                 @endforeach
                                
                            </ul>
                            
                            <div class="academy" name="Cost &amp; Quality" community="3" color='00A890' abbreviation="cq" newabbreciation="cqa" slug="cost-quality" servicename="{{$service}}"></div> <div class="servicedescription">{{ $services[$i]['description_cost_quality']}}</div>
                        </div>
                        <div class="cell5 service_{{str_replace(array(' ','-'),'',$service)}}">
                            <ul>
                                 @foreach($subData as $subservice)
                                    <li class="selectedRec" service_item ="{{$subservice['id']}}" data-service-item-name="{{$subservice['title']}}" data-service-name="{{$service}}" data-academy="Information Technology" data-academy-abr="ita">
                                        <span class="statusText">SELECT</span>
                                        @if(in_array(4, $subservice['community']))
                                            <i class="icons cstm-icons"></i>
                                        @else
                                            <i class="icons cstm-icons disableState"></i>
                                        @endif
                                    </li>
                                 @endforeach
                            </ul>
                            
                            <div class="academy" name="Information Technology" community="4" color='8DC63F' abbreviation="it" newabbreciation="ita" slug="information-technology" servicename="{{$service}}"></div><div class="servicedescription">{{ $services[$i]['description_information_technology']}}</div>
                        </div>
                        <div class="clr"></div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="clr"></div>
        <div style="margin-bottom: 20px;float: left;width: 100%">
            @if ($errors->any())
                <div class="errorMsg">
                    <ul>
                        {{ implode('', $errors->all('
                        <li class="error">:message</li>
                        ')) }}
                    </ul>
                </div>
                @endif
                <ul style="display:none" class="errorMsg"></ul>
        </div>
        <div class="leftCol">
            {{ Form::open(array('route' => 'sendcontactus', 'id' => 'contact_hcbs', 'name' => 'contact_hcbs')) }}
            <div class="popupContactForm">
               
                
                <ul class="formLayout">
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

                    <li class="mb0 pB0" style="margin-top: 11px;">
                        <div class="fl">
                            <div class="note-label">
                                <div class="charCounter"> You have <input class="textInputPop wAuto" readonly type="text" id="countdown" name="countdown" size="3" value="500"> characters left.</div>
                                {{ Form::label('note', 'Note') }}
                                <small class="required">*</small>
                            </div>
                            
                                {{ Form::textarea('note', NULL, array(
                            'class'      => 'textTextAreaPop input',
                            'onKeyDown'  => "limitText(this.form.note,this.form.countdown,500);",
                            'onKeyUp'    => "limitText(this.form.note,this.form.countdown,500);"
                            ) ) }}
                             
                            
                        </div>
                        <div class="fl mL26">
                            <div class="userVerfication">
                                To verify you are a human
                                <?php printCaptcha('contact_hcbs', 0); ?>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="clr"></div>
                <li>
                   
                   
                </li>
                <div class="clr"></div>
            </div>
            {{ Form::close() }}
        </div>
        <div class="rightCol">
            <div>
                <div class="popupContentLeft">
                    <ul>

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
                    </ul>
                     <div class="btn-area fr">
                        <div class="siteButtonSmall formSend mR15"> <span><a id="btnSend" href="javascript:void(0)" onclick="submitForm(this);">Send</a></span> </div>
                        <div class="grayBtn "> <span><a href="javascript:void(0)" onclick="javascript:jQuery.fancybox.close();">Cancel</a></span> </div>
                        <div class="clr"></div> 
                        <div class="sendFormInfo">
                            <span>We will contact you within 24 hours.</span>
                        </div>
                    </div>      
                </div>
               
            </div>
       
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
        var isIPad = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    $(document).ready(function(){
 
        /**
         * Enable form submit on enter key press in form.
         * 
         
       $('#contact_hcbs input').keypress(function(e){
           if(e.which == 13){
               // avoid double call for "Send", "Note" and "characters counter" enter event. 
               if($(this).attr('id') !== 'btnSend' && $(this).attr('id') !== 'note' && $(this).attr('id') !== 'countdown'){
                   $('#btnSend').trigger('click');
               }
           }
       }); */
        
       $("selectedRec").hover(function(e){
           icon = $(this).children('.cstm-icons');
           if(!icon.hasClass('disableState')){ // if button is not disabled
                icon.css('opacity', '0.3');
                var statusText = $(this).children('.statusText').text();
                if(statusText == 'SELECT') {
                    $(this).addClass('selectState');
                } else if(statusText == 'SELECTED!') {
                    // do nothing
                } else if(statusText == 'REMOVE?') {
                    $(this).addClass('removClass');
                }
            }
        },function(){
            icon = $(this).children('.cstm-icons');
            var statusText = $(this).children('.statusText').text();
            if(statusText == 'SELECT') {
                $(this).removeClass('selectState');
            } else if(statusText == 'SELECTED!') {
                // do nothing
            } else if(statusText == 'REMOVE?') {
                $(this).removeClass('removClass');
            }
           icon.css('opacity', '1');
        });
       
       $("selectedRec").click(function(e){
           var clickedObj = this;
            
            if(!($(this).hasClass('selectState') || $(this).hasClass('selectStated') || $(this).hasClass('removClass') || $(this).hasClass('removedClass')) ){
                e.preventDefault();
                if(isIPad) {
                    $(clickedObj).trigger('mouseenter');
                }
                return false;
            }
           
           icon = $(this).children('.cstm-icons');
           var academy = $(this).attr('data-academy-abr');
           var statusText = $(this).children('.statusText').text();
           var clsName = ""+academy+"_selectedState";
//           if(!icon.hasClass(clsName)){
//                icon.addClass(clsName);
//           }else{
//               icon.removeClass(clsName);
//           }
           
           if(statusText == 'SELECT') {
                $(clickedObj).children('.cstm-icons').addClass(clsName);
                $(this).addClass('selectStated').removeClass('selectState');
                $(this).children('.statusText').text('SELECTED!');
                window.setTimeout(function(){
                    $(clickedObj).removeClass('selectStated');
                    $(clickedObj).children('.statusText').text('REMOVE?');
                    if($(':hover', clickedObj).length > 0){
                        $(clickedObj).trigger('mouseenter');
                        if(isIPad) {
                            $(clickedObj).trigger('mouseleave');
                        }
                    }
                }, 1 * 1000);
            } else if(statusText == 'REMOVE?') {
                $(clickedObj).children('.cstm-icons').removeClass(clsName);
                $(clickedObj).addClass('removedClass').removeClass('removClass');
                $(clickedObj).children('.statusText').text('REMOVED');
                window.setTimeout(function(){
                    $(clickedObj).removeClass('removedClass');
                    $(clickedObj).children('.statusText').text('SELECT');
                    if($(':hover', clickedObj).length > 0){
                        $(clickedObj).trigger('mouseenter');
                        if(isIPad) {
                            $(clickedObj).trigger('mouseleave');
                        }
                    }
                }, 1 * 1000);
            } else {
                e.preventDefault();
                e.stopPropagation();
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
    var serviceName = "";
    var serviceItemName = "";
    var academy = "";
    var academyName = "";
    function submitForm(elem) {
        
        var services = "";
        var prevService = "";
        var currentService = "";
        var itemCounter = 0;
//        jQuery("grid input[type=checkbox]:checked").not(":disabled").each(function(){
        jQuery("grid i.cstm-icons").not("disableState").each(function(){
            
            serviceName = jQuery(this).closest('li').attr('data-service-name');
            serviceItemName = jQuery(this).closest('li').attr('data-service-item-name');
            academyName = jQuery(this).closest('li').attr('data-academy');
            var academy = $(this).closest("li").attr('data-academy-abr');
            var clsName = ""+academy+"_selectedState";
            
            if($(this).hasClass(clsName)){
                currentService = academyName + " (" + serviceName + ")";
                if(prevService != currentService){
                    services += "<br>"+currentService+"<br>";
                    prevService = currentService;
                    itemCounter = 0;
                }
                itemCounter++;
                services += "&nbsp; &nbsp;"+ itemCounter + "- "+ serviceItemName+ "<br>";
            }
            
            
        });
        var elearningSelected = $("div.service_ELearning irca_selectedState").length+$("div.service_ELearning isca_selectedState").length+$("div.service_ELearning icqa_selectedState").length+$("div.service_ELearning iita_selectedState").length;
        var consultingSelected =  $("div.service_Consulting irca_selectedState").length+$("div.service_Consulting icqa_selectedState").length+elearningSelected;
        
        var ccEmail = '0';
        if((elearningSelected+consultingSelected) > 0){
            ccEmail = '1';
        }
        jQuery('.errorMsg').html("");
        // Prepare the Data to Post
        postData = {'first_name'  :jQuery("#first_name").val(),
                'last_name'  :jQuery("#last_name").val(),
                'email'    :jQuery("#email").val(),
                'note'     :jQuery("#note").val(),
                'organization' :jQuery("#organization").val(),
                'phone'     :jQuery("#phone").val(),
                'title'     :jQuery("#title").val(),
                'captcha-value':jQuery("#captcha-value").val(),
                'services'   :services,
                'source'    :source,
                'demo'    :'',
                'cc' : ccEmail
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