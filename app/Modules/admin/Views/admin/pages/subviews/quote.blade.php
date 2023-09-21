<script type="text/javascript">
    /***
     * function to control redirect for "Get a Quote" link
     **/
    function modify_redirect(){
            if(typeof(view_name) != "undefined"){
                if(view_name == 'pricing'){
                    jQuery.fancybox.close();
                }
            }else {
                    jQuery.fancybox.close();
                    url = '{{route("page", "membership")}}';
                    window.top.location.href = url;     
            };
    }
</script>

<li id="popupselectedItemHeader">
    <div class="popupselectedItemHeader">
    <span>
    <b class="fl"><div class="fl">You selected </div><i class="fl" id="total-count"></i> <div class="fl">items</div></b> <a href="javascript:void(0)" onclick="modify_redirect()">Modify</a> </span>

    </div>
    <div class="clr"></div>
    <div id = "side-block"></div>

</li>

<script type="text/javascript">
    jQuery(document).ready(function() {
        var html = "";
        
        jQuery("#selectedDetail .service_item").each(
            function(){
                var $this = jQuery(this);
                academy = $(this).attr('academy');
                serviceName = $(this).attr('service');
                serviceItemId = $(this).attr('serviceItemId');
                service = serviceName.replace(/_|-/g,'');
                service_item_id = service+ '_'+academy+'_'+serviceItemId;
                html += '<div id="id-' + service_item_id +'"academy='+academy+' class="popupSelectedModule"> <span class="popupSelectedCommunity_'+academy+'"></span>';
                html += '<div class="popupModuleInfo">';
                html += '<h4>' + serviceName.replace(/_/g,' ') + '</h4>';
                html += '<span>-' + $this.find('h5dtSrSbHeading').html() + '</span> </div>';
                html += '<a href="javascript:void(0)" onClick="removeService(\''+service+'\',\''+academy+'\',\''+serviceItemId+ '\' )" class="icons popupRemoveSelctedModule"></a>';
                html += '</div>';
            });
            
            jQuery("#side-block").html(html);
            jQuery("#total-count").html( jQuery("#selectedDetail .service_item").length );

        
    });
  /**
     * Removes Service 
     * @param {type} pid
     * @returns {void}     
     */
    function removeService(service, academy, serviceItemId) {
        pid = service + '_' + academy + '_' + serviceItemId;
        jQuery("#id-" + pid).slideUp(300);
		setTimeout(function(){
			jQuery("#id-" + pid).remove();
			idArr = pid.split('_');
			newID = idArr[1]+'_'+idArr[0];
			passManageState(pid);
			jQuery("#total-count").html( jQuery("#side-block").children('popupSelectedModule').length );
		},400);
        div_id = service + '_' + academy;
        ul = $('ul.'+service+'_'+academy);
        li = ul.find('li[service_item='+serviceItemId+']');
//        console.log(li);
//        return;
        removeItem(div_id, li, serviceItemId);
    }
</script>