@extends('layouts.layout')
@section('title')
    @parent - {{ $page->title }}
@stop

@section($page->slug) 
   active
@endsection
@section('content')

<div id="content">
    <div class="contentInner">
        <h1>{{$page->title}}</h1>
        <h2>{{$page->short_description}}</h2>
        <div class="proMatrixWrapper">
           {{--  <div class="proMatrix">
                <div class="proMatrixInn"> Please select items from The Product matrix to customize your product. </div>
                <span class="proMatrixDownArrow"></span> <span class="proMatrixDownUp"></span>
            </div> --}}
            <ul class="itemProductMartix">
                @foreach($allCommunities as $community)
                <li class="itemProductMartixFor_{{$community->slug}}{{$community->sequence == 4 ? ' selectedDepartment mrNone':''}}"> <img src="../assets/images/{{Config::get('settings.pricing_'.$community->slug)}}" alt="" />
                   <span> <a href="javascript:void(0)"> 
                        <span class="icons"></span> 
                        {{$community->title}}
                    </a>
                    <div class="comToolTip">
                        <h3>{{$community->title}} </h3>
                        <div class="comToolTipCont">
                            {{ strip_tags($community->short_description) }}
                        </div>
                    </div>
                    </span>
                </li>
                @endforeach
            </ul>
            <div class="clr"></div>
            <div class="grid">
                <ul>
                {{-- */$i=0;/* --}}                  
                   @foreach($serviceData as $service => $subData)
                   
                   <li class="gridDataHeader">
                        <div class="cell wp100">{{$service}}</div>
                    </li>
                    <li class="gridDataContent">
                        <div class="cell cw35">
                            <ul id="service_{{str_replace(array(' ','-'),'',$service)}}">
                                @foreach($subData as $subservice)
                                <li class="serviceWrapper mL20" id="">
                                    {{-- <span class="icons plus"></span> --}}
                                        {{$subservice['title']}}
                                        <div class="serviceDetail" style="display: none;">
                                            <div class="serviceid">{{$subservice['id']}}</div>
                                            <div class="title">{{$subservice['title']}}</div>
                                            <div class="serviceCommunities">{{implode(',',$subservice['community'])}}</div>
                                           
                                            <div class="description" id="description_rca">{{$subservice['description_rca']}}</div>
                                            <div class="description" id="description_sca">{{$subservice['description_sca']}}</div>
                                            <div class="description" id="description_cqa">{{$subservice['description_cqa']}}</div>
                                            <div class="description" id="description_ita">{{$subservice['description_ita']}}</div>
                                        </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="cell cw11">
                            
                            <ul class="{{str_replace(array(' ','-'),"",$service)}}_rca">
                                @foreach($subData as $subservice)
                                    <li class="selectedRec" service_item ="{{$subservice['id']}}" onclick='manageState($("#rca_{{str_replace(" ","",$service)}}_{{$subservice['id']}}"))'>
                                        @if(in_array(1, $subservice['community']))
                                        <i class="icons unSelectedState"></i>
                                        @else
                                        <i class="icons disableState"></i>
                                        @endif
                                        <div class="overlay overlayRCA" service_index="{{$subservice['service_index']}}" id="rca_{{str_replace(' ','',$service)}}_{{$subservice['id']}}" serviceid="{{$subservice['id']}}">
                                            <div class="stateTextMain">
                                            <div class="stateText">
                                                <table width="100%" height="100%">

                                                    <tr>
                                                        <td class="statusText">SELECT</td>

                                                    </tr>

                                                </table>

                                            </div></div>
                                            </div>
                                    </li>
                                 @endforeach
                            </ul>
                            <div class="academy" name="Revenue Cycle" community="1" color='E51937' abbreviation="rca" newabbreciation="rca" slug="revenue-cycle" servicename="{{$service}}"></div><div class="servicedescription">{{ $services[$i]['description_revenue_cycle']}}</div>
                        </div>
                        <div class="cell cw17">
                            <ul class="{{str_replace(array(' ','-'),"",$service)}}_sc">
                                 @foreach($subData as $subservice)
                                    <li class="selectedRec" service_item ="{{$subservice['id']}}" onclick='manageState($("#sc_{{str_replace(" ","",$service)}}_{{$subservice['id']}}"))'>
                                        @if(in_array(2, $subservice['community']))
                                        <i class="icons unSelectedState"></i>
                                        @else
                                        <i class="icons disableState"></i>
                                        @endif
                                        <div class="overlay overlaySPA" service_index="{{$subservice['service_index']}}" id="sc_{{str_replace(' ','',$service)}}_{{$subservice['id']}}" serviceid="{{$subservice['id']}}">
                                             <div class="stateText">
                                                <table width="100%" height="100%">

                                                    <tr>
                                                        <td class="statusText">SELECT</td>

                                                    </tr>

                                                </table>

                                            </div>
                                        </div>
                                    </li>
                                 @endforeach
                                
                            </ul>
                            
                            <div class="academy" name="Supply Chain" community="2" color='9B5BA4' abbreviation="sc" newabbreciation="sca" slug="supply-chain" servicename="{{$service}}"></div><div class="servicedescription">{{ $services[$i]['description_supply_chain']}}</div>
                        </div>
                        <div class="cell cw16">
                            <ul class="{{str_replace(array(' ','-'),"",$service)}}_cq">
                                 @foreach($subData as $subservice)
                                    <li class="selectedRec" service_item ="{{$subservice['id']}}" onclick='manageState($("#cq_{{str_replace(" ","",$service)}}_{{$subservice['id']}}"))'>
                                        @if(in_array(3, $subservice['community']))
                                        <i class="icons unSelectedState"></i>
                                        @else
                                        <i class="icons disableState"></i>
                                        @endif
                                        <div class="overlay overlayCQA" service_index="{{$subservice['service_index']}}" id="cq_{{str_replace(' ','',$service)}}_{{$subservice['id']}}" serviceid="{{$subservice['id']}}">
                                             <div class="stateText">
                                                <table width="100%" height="100%">

                                                    <tr>
                                                        <td class="statusText">SELECT</td>

                                                    </tr>

                                                </table>

                                            </div>
                                        </div>
                                    </li>
                                 @endforeach
                                
                            </ul>
                            
                            <div class="academy" name="Cost &amp; Quality" community="3" color='00A890' abbreviation="cq" newabbreciation="cqa" slug="cost-quality" servicename="{{$service}}"></div> <div class="servicedescription">{{ $services[$i]['description_cost_quality']}}</div>
                        </div>
                        <div class="cell cw15">
                            <ul class="{{str_replace(array(' ','-'),"",$service)}}_it">
                                 @foreach($subData as $subservice)
                                    <li class="selectedRec" service_item ="{{$subservice['id']}}" onclick='manageState($("#it_{{str_replace(" ","",$service)}}_{{$subservice['id']}}"))'>
                                        @if(in_array(4, $subservice['community']))
                                        <i class="icons unSelectedState"></i>
                                        @else
                                        <i class="icons disableState"></i>
                                        @endif
                                        <div class="overlay overlayITA" service_index="{{$subservice['service_index']}}" id="it_{{str_replace(' ','',$service)}}_{{$subservice['id']}}" serviceid="{{$subservice['id']}}">
                                             <div class="stateText">
                                                <table width="100%" height="100%">

                                                    <tr>
                                                        <td class="statusText">SELECT</td>

                                                    </tr>

                                                </table>

                                            </div>
                                        </div>
                                    </li>
                                 @endforeach
                                 
                                
                            </ul>
                            
                            <div class="academy" name="Information Technology" community="4" color='8DC63F' abbreviation="it" newabbreciation="ita" slug="information-technology" servicename="{{$service}}"></div><div class="servicedescription">{{ $services[$i]['description_information_technology']}}</div>
                        </div>
                        <div class="clr"></div>
                    </li>
{{-- */ $i++; /* --}}
                    @endforeach
                </ul>
            </div>
            <div class="fr">
                <div class="itemDetail"><span>0</span> items selected</div>
                <div class="grayBtn quoteBtn"> <span><a title="Learn More About Membership" caption="Contact Us" class="fancybox fancybox.ajax" href="{{route('contactus', array('width'=>800, 'modal'=>'true', 'source' => 'quote')) }}">Learn More About Membership</a></span> </div>
                <div class="clr"></div>
            </div>
            <div class="clr"></div>
        </div>
        <div class="selectedItemWrapper">
            <h4 style="display: none;">MY SELECTED ITEM DETAILS</h4>
            <div id="selectedDetail"></div>
            <div class="clr"></div>
            <div class="fr" style="display: none;">
                <div class="itemDetail"><span>0</span> items selected</div>
                <div class="grayBtn quoteBtn"> <span><a title="Learn More About Membership" caption="Contact Us" class="fancybox fancybox.ajax" href="{{route('contactus', array('width'=>800, 'modal'=>'true', 'source' => 'quote')) }}">Learn More About Membership</a></span> </div>
                <div class="clr"></div>
            </div>
        </div>
        <div class="clr"></div>
    </div>
</div>
@stop

@section('footer_assets')
@parent
<script type="text/javascript">
    /**
     * Global Variables Declaration
     **/
    var isIPad = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    var totalItemSelected = 0;
    var view_name = 'pricing';
    called = true;
    /**
     * Get current states of service items
     * @param object: element
     * @return string: Class name
     **/
    function findIconClass(element){
        var classtext = '';
        $element = $(element);
            
        if($element.parent().find('i').attr('class') == 'icons unSelectedState') {
            classtext = "icons unSelectedState";
        } else {
            classtext = "icons selectedState";
        }
            
        return classtext;
    }
    function selectServiceIcons(test){
        //do nothing.
    }
    
    function manageState(element, clickedOnCross){
        var $this = $(element);
        var stateClass = findIconClass($this);
        var serviceId = "";
        var academy = "";
        var serviceName = "";
        var abbreviation = "";
        idName = "";
        idToPass = "";
        if(!clickedOnCross){            
            academy = $this.closest('ul').next('div');
            serviceName = academy.attr('servicename');
            abbreviation = academy.attr('abbreviation');
            tempArr = $this.attr('id').split('_');
            serviceId = parseInt(tempArr[tempArr.length-1]);
            idName = serviceName.replace(/ |-/g,'')+'_'+abbreviation;
            idToPass = abbreviation+'_'+serviceName.replace(/ |-/g,'');
            community_id = parseInt(academy.attr('community'));
            service_index = parseInt($this.attr('service_index'));              
        }
        
        if(stateClass == 'icons unSelectedState') {
            $('selectedItemWrapper h4, selectedItemWrapper .fr').show();
            $('.fr .quoteBtn').removeClass('grayBtn').addClass('siteButtonSmall');
            $this.parent().find('i').removeClass('unSelectedState').addClass('selectedState');
            totalItemSelected++;
            
//            $('itemDetail').find('span').html(totalItemSelected);
            //create dom element
            if($('#'+idName).length < 1){
                var html = '';
                //display priority
                priority = ( (service_index+1) + community_id*10);
                html += '<span class="removable" priority='+priority+'>';
                html += '<div class="selectedRep_'+academy.attr('slug')+' selectedServices" id="'+idName+'">';
                html += '<div class="selectedTop_'+academy.attr('slug')+'">';
                html += '<div class="selectedBot_'+academy.attr('slug')+'">';
                html += '<div class="selectedItemLeft">';
                html += '<h5>'+academy.attr('servicename')+'</h5>';
                html += '<span>('+academy.attr('name')+')</span>'
                html += '<div class="selectedRemove"><a class="icons" href="javascript:void(0);" onclick="passManageState(\''+idName+'\')"></a><span>Remove</span></div>';
                html += '</div>';
                html += '<div class="selectedItemRgt">';
                html += ''+academy.next().html()+'';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '<div class="clr"></div>';
                html += '<div class="borderSeprator mb10"></div>';
                html += '<div class="clr"></div>';
                html += '</span>';
                
                length = $('#selectedDetail .removable').length;                
                
                insertFlag = false;                
                for(i = 0 ; i < length; i++){
                    obj = $('#selectedDetail .removable')[i];                    
                    if(parseInt($(obj).attr('priority')) >= priority){
                        $(html).insertBefore($(obj));
                        insertFlag = true;
                        break;
                    }
                }
                if(length == 0 || !insertFlag){
                    $('#selectedDetail').append(html);
//                    insertFlag = true;
                }
                
            }
            var innerHtml = "";
            ul_id = '#service_'+serviceName.replace(/ |-/g,'');
            data = $(ul_id);
//            console.log(ul_id);
            data.find('liserviceWrapper').each(function(){
                serviceCommunities = $(this).find('div').find('.serviceCommunities').html();
                    service_id = $(this).find('div').find('.serviceid').text()*1;
                    if(serviceCommunities.indexOf(academy.attr('community')) != -1 && serviceId == service_id) {
                        innerHtml += '<span class="service_item" academy='+abbreviation+' service='+serviceName.replace(/ /g,'_')+' serviceItemId='+service_id+' shown'+service_id+'=true>';
                        innerHtml += '<h5 class="dtSrSbHeading">'+$(this).find('div').find('.title').html()+'</h5>';
                        innerHtml += '<p class="mb0">'+$(this).find('div').find('#description_'+academy.attr('newabbreciation')).html()+'</p>';
                        innerHtml += "</span>";
                    }
            });
            
            len = $('#'+idName+' span.service_item[academy='+abbreviation+']').length;                
            innerFlag = false;
            for(i = 0 ; i < len; i++){
                obj = $('#'+idName+' span.service_item[academy='+abbreviation+']')[i];
                if(parseInt($(obj).attr('serviceitemid')) >= serviceId){
                    $(innerHtml).insertBefore($(obj));
                    innerFlag = true;
                    break;
                }
            }
            if(len == 0 || !innerFlag){
                $('#'+idName+' selectedItemRgt').append(innerHtml);
            }
            
        } else if(stateClass == 'icons selectedState' && !clickedOnCross) {
//            --totalItemSelected;
//            $this.parent().find('i').removeClass('selectedState').addClass('unSelectedState');
//            console.log(idName);
//            return;
//            var parentElement = $('div#'+idName);
//            elementToRemove = parentElement.find('span[shown'+serviceId+']');
//            elementToRemove.remove();
//            itemsSelected = parentElement.find('span.service_item').length;
//            if(itemsSelected == 0){
//                parentElement.closest('span.removable').remove();
//            }
            removeItem(idName, $this.parent(), serviceId);
            return;
        }        
        if(clickedOnCross) {
            list = $('ul.'+element);
            list.find('table td').text('SELECT');
            list.find('i').removeClass('selectedState').addClass('unSelectedState');
            //remove Service from selected academy
            elementToRemove = $('div#'+element);
            itemsSelected = elementToRemove.find('span.service_item').length;
            elementToRemove.closest('span.removable').remove();
            totalItemSelected -= itemsSelected;
        }
        if(totalItemSelected == 0) {
            $('selectedItemWrapper h4, selectedItemWrapper .fr').hide();
            $('.fr .quoteBtn').removeClass('siteButtonSmall').addClass('grayBtn');
        }
            
        $('itemDetail').find('span').html(totalItemSelected);
        called = false;
    }
    function removeItem(div_id, li, serviceId){
        totalItemSelected = $('divitemDetail span').html();
        --totalItemSelected;
        
        window.setTimeout(function(){
                    li.find('table td').text('SELECT');
                }, 1 * 1000);
                
        li.find('i').removeClass('selectedState').addClass('unSelectedState');
        var parentElement = $('div#'+div_id);
        elementToRemove = parentElement.find('span[shown'+serviceId+']');
        elementToRemove.remove();
        itemsSelected = parentElement.find('span.service_item').length;
        if(itemsSelected == 0){
            parentElement.closest('span.removable').remove();
        }
        if(totalItemSelected == 0) {
            $('selectedItemWrapper h4, selectedItemWrapper .fr').hide();
            $('.fr .quoteBtn').removeClass('siteButtonSmall').addClass('grayBtn');
        }
        
        $('itemDetail').find('span').html(totalItemSelected);
    }
    function isEnabled(overlayObj){
        if(overlayObj.children('.iconsdisableState').length > 0){
            return false;
            
        }else{
            return true;
            
        }
//        var enabled = true;        
//        totalIcons = $(overlayObj).parent().parent().find('.icons').length;
//        totalDisabled = $(overlayObj).parent().parent().find('.iconsdisableState').length;
//        console.log("total: "+totalIcons);
//        console.log("totalDisabled: "+totalDisabled);
//        if(totalIcons == totalDisabled){
//            enabled = false;
//        }
//        return enabled;
    }
    
    $(document).ready(function() {
        $('selectedRec').hover(function(e){
            if(isEnabled($(this))) {
                var statusText = $(this).find('.statusText').text();
                
                if(statusText == 'SELECT') {
                    $(this).find('overlay').addClass('selectState');
                } else if(statusText == 'SELECTED!') {
                    // do nothing
                } else if(statusText == 'REMOVE?') {
                    $(this).find('overlay').addClass('removClass');
                }
            }
        },function(){
            var statusText = $(this).find('.statusText').text();
            if(statusText == 'SELECT') {
                $(this).find('overlay').removeClass('selectState');
            } else if(statusText == 'SELECTED!') {
                // do nothing
            } else if(statusText == 'REMOVE?') {
                $(this).find('overlay').removeClass('removClass');
            }
        });
        
        $('overlay').click(function(e){
            var clickedOverlayObj = this;
            
            if(!($(this).hasClass('selectState') || $(this).hasClass('selectStated') || $(this).hasClass('removClass') || $(this).hasClass('removedClass')) ){
                e.preventDefault();
                if(isIPad) {
                    $(clickedOverlayObj).parent().trigger('mouseenter');
                }
                return false;
            }
            var statusText = $(this).find('.statusText').text();
            if(statusText == 'SELECT') {
                $(this).addClass('selectStated').removeClass('selectState').find('td').text('SELECTED!');
                window.setTimeout(function(){
                    $(clickedOverlayObj).removeClass('selectStated').find('td').text('REMOVE?');
                    
                    if($(':hover', clickedOverlayObj).length > 0){
                        $(clickedOverlayObj).parent().trigger('mouseenter');
                        if(isIPad) {
                            $(clickedOverlayObj).parent().trigger('mouseleave');
                        }
                    }
                }, 1 * 1000)
            } else if(statusText == 'REMOVE?') {
                $(this).addClass('removedClass').removeClass('removClass').find('td').text('REMOVED');
                window.setTimeout(function(){
                    $(clickedOverlayObj).removeClass('removedClass').find('td').text('SELECT');
                    
                    //if($(clickedOverlayObj).is(':hover')){    //is(':hover') is deprecated in jQuery 1.9 to onward
                    
                    if($(':hover', clickedOverlayObj).length > 0){
                        $(clickedOverlayObj).parent().trigger('mouseenter');
                        if(isIPad) {
                            $(clickedOverlayObj).parent().trigger('mouseleave');
                        }
                    }
                }, 1 * 1000);
            } else {
                e.preventDefault();
                e.stopPropagation();
            }
        });
//        $('selectedRec').hover(function(){
//                var stateClass = $(this).find('ul li i').attr('class');
//                if(stateClass == 'icons unSelectedState') {
//                    $(this).find('divoverlay').addClass('selectState');
//                    $(this).find('divstateText table td').text('SELECT');
//                    $(this).find('divstateText').show();
//                } else if(stateClass == 'icons selectedState') {
//                    $(this).find('divoverlay').addClass('removClass');
//                    $(this).find('divstateText table td').text('REMOVE?');
//                    $(this).find('divstateText').show();
//                }
//            },function() {
//                $(this).find('divoverlay').removeClass('removClass');
//                $(this).find('divoverlay').removeClass('selectState');
//                $(this).find('divstateText table td').text('');
//                $(this).find('divstateText').hide();
//            }
//        );
        /**
         * Get a quote button enable, disable functionality
         **/
        $('.fr .quoteBtn a').click(
            function() {
                if(totalItemSelected == 0) {
                    return false;
                }
            }
        );
            
    /**
    * Function to manage tooptip of community elements
    * @param string: action show or hide
    * @param object: element to show/hide
    */
    function manageTooltip(action,element) {
        $element = $(element);
        if(action == 'show') {
            $('comToolTip').hide();
            $element.next().show();
        }else {
            $element.next().hide();
        }
}
     
     $('ulitemProductMartix li').mouseenter(function(e){
         $(this).addClass('selected');
         //manageTooltip('show',$(this).find('span a'));
         e.preventDefault();
         e.stopPropagation();
     });
     
     $('ulitemProductMartix li').mouseleave(function(e){
         $(this).removeClass('selected');
         //manageTooltip('hide',$(this).find('span a'));
         e.preventDefault();
         e.stopPropagation();
     });
     
     $('ulitemProductMartix li').click(function(e){
         $(this).toggleClass('selected');
         e.preventDefault();
         e.stopPropagation();
     });
     
     $('#content').on('click', function(e){
         $('ulitemProductMartix li').removeClass('selected');
     });
 
     /**
     * preLoadCssClasses() method is used to prelaod images required for pricing section. 
     */
    preLoadCssClasses([
                'preLoad_researchBgRep_jpg',
                'preLoad_researchBgTop_jpg',
                'preLoad_researchBgBot_jpg',
                'preLoad_selectedSPARep_jpg',
                'preLoad_selectedSPATop_jpg',
                'preLoad_selectedSPABot_jpg',
                'preLoad_selectedCQARep_jpg',
                'preLoad_selectedCQATop_jpg',
                'preLoad_selectedCQABot_jpg',
                'preLoad_selectedITARep_jpg',
                'preLoad_selectedITATop_jpg',
                'preLoad_selectedITABot_jpg',
                'preLoad_itemtabRCA_png',
                'preLoad_itemtabSPA_png',
                'preLoad_itemtabCQA_png',
                'preLoad_itemtabITA_png'
                ]
            );
                
    
                
     $('.ssi_closeTooltip').click(function(e){
         $(this).parents('li:first').removeClass('selected').find('comToolTip').hide();
         e.preventDefault();
         e.stopPropagation();
         return false;
     });
     
     $('.ssi_closeTooltip').hover(function(e){
         e.preventDefault();
         e.stopPropagation();
     },function(e){
         e.preventDefault();
         e.stopPropagation();
     })
         
    });
    /**
     * Function to reverse ID element and make a call on other Function
     * @param int uniqueID
     * 
     **/
    function passManageState(uniqueID){
        manageState(uniqueID, true);
//        idArr = uniqueID.split('_');
//        newID = idArr[1]+'_'+idArr[0];
//        manageState($('#'+newID), true)
    }
    /**
     * Call Back function to control class add/remove animations
     **/
    function onRemoved(){
        called = true;
    }
    /**
     * Function to control states of selected services in communities
     * @param object: A DOM element
     **/
//    function manageState(element) {
//        var $this = $(element);
//        var stateClass = $this.parent().find('ul li i').attr('class');
//        idName = $this.next().next().attr('servicename').replace(/ /g,'')+'_'+$this.next().next().attr('abbreviation');
//        if(stateClass == 'icons unSelectedState') {
//            $('selectedItemWrapper h4, selectedItemWrapper .fr').show();
//            $('.fr .quoteBtn').removeClass('grayBtn').addClass('siteButtonSmall');
//            $this.parent().find('ul li i').removeClass('unSelectedState').addClass('selectedState');
//            
//            if(called){
//                $this.parent().removeClass('selectState',1000).addClass('selectStated',1000).removeClass("selectStated", 2000, "easeInOutCubic", onRemoved);
//            }
//
//            $this.next().find('table td').text('SELECTED!');
//            totalItemSelected++;
//            $('itemDetail').find('span').html(totalItemSelected);
//            
//            //create dom element
//            var html = '';
//            html += '<div class="selectedRep_'+$this.next().next().attr('slug')+' selectedServices" id="'+idName+'">';
//            html += '<div class="selectedTop_'+$this.next().next().attr('slug')+'">';
//            html += '<div class="selectedBot_'+$this.next().next().attr('slug')+'">';
//            html += '<div class="selectedItemLeft">';
//            html += '<h5>'+$this.next().next().attr('servicename')+'</h5>';
//            html += '<span>('+$this.next().next().attr('name')+')</span>'
//            html += '<div class="selectedRemove"><a class="icons" href="#" onclick="passManageState(\''+idName+'\')"></a><span>Remove</span></div>';
//            html += '</div>';
//            html += '<div class="selectedItemRgt">';
//            $this.parent().parent().first().find('ul').find('liserviceWrapper').each(function(){
//                serviceCommunities = $(this).find('div').find('.serviceCommunities').html();
//                if(serviceCommunities.indexOf($this.next().next().attr('community')) != -1) {
//                    html += '<h5>'+$(this).find('div').find('.title').html()+'</h5>';
//                    html += '<p class="mb0">'+$(this).find('div').find('.description').html()+'</p>';
//                }
//                
//            });
//            html += '</div>';
//            html += '</div>';
//            html += '</div>';
//            html += '</div>';
//            html += '<div class="clr"></div>';
//            html += '<div class="borderSeprator mb10"></div>';
//            html += '<div class="clr"></div>';
//            $('#selectedDetail').append(html);
//            
//            
//        } else if(stateClass == 'icons selectedState') {
//            
//            $this.parent().find('ul li i').removeClass('selectedState').addClass('unSelectedState');
//            if(called){
//                
//                $this.parent().removeClass('removClass',1000).addClass('removedClass',1000).removeClass("removedClass", 2000, "easeInOutCubic", onRemoved);
//            }
//            
//            $this.next().find('table td').text('REMOVED');
//            
//            //remove Service from selected academy
//            $elementToRemove = $('#'+idName);
//            $($elementToRemove).next().next().remove();
//            $($elementToRemove).remove();
//            totalItemSelected--;
//            if(totalItemSelected == 0) {
//                $('selectedItemWrapper h4, selectedItemWrapper .fr').hide();
//                $('.fr .quoteBtn').removeClass('siteButtonSmall').addClass('grayBtn');
//            }
//            $('itemDetail').find('span').html(totalItemSelected);
//        }
//        called = false;
//    }
    
</script>
@stop
