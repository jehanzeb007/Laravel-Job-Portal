<script type="text/javascript">
    /***
     * function to control redirect for "Get a Quote" link
     **/
    function modify_redirect(){
            // if(typeof(view_name) != "undefined"){
            //     if(view_name == 'lmspricing'){
            //         jQuery.fancybox.close();
            //     }
            // }else {
            //         jQuery.fancybox.close();
            //         url = '{{route("lmspricing")}}';
            //         window.top.location.href = url;     
            // };
            jQuery.fancybox.close();
    }
</script>
<style type="text/css">
popupSelectedModule2{
    background: #303030;
    height: auto;
    overflow:auto;
    padding: 10px;
    margin-bottom: 3px;
}
</style>


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
        

    
        jQuery("#selectedDetail").children('selectedServices').each(
            function(){

                var $this = jQuery(this);
                var serviceId = $this.attr('id');
                idsArr = serviceId.split('_');
                
                var child =  $this.find('selectedItemLeft');
                

            html += '<div id="id-' + $this.attr('id') + '" class="popupSelectedModule"> <span class="popupSelectedCommunity_'+idsArr[1]+'"></span>';
            html += '<div class="popupModuleInfo">';
            html += '<h4>' + child.find('h5').html() + '</h4><div id="learnerResc">';
            html += '<span>-' + child.find('span').html() + '</span> </div></div>';
            html += '<a href="javascript:void(0)" onClick="removeService(\'' +  serviceId + '\' )" class="icons popupRemoveSelctedModule"></a>';
            html += '</div>';
            }
                );

        jQuery("#learnerDetail").children('selectedServices').each(
            function(){

                var $this = jQuery(this);
                var serviceId = $this.attr('id');
                idsArr = serviceId.split('_');
                
                var child =  $this.find('selectedItemLeft');

                if (child.find('div#lerner').html() !='') {


                

            html += '<div id="id-' + $this.attr('id') + '" class="popupSelectedModule" style="overflow:auto; height:auto"> <span class="popupSelectedCommunity_'+idsArr[1]+'"></span>';
            html += '<div class="popupModuleInfo">';
            html += '<h4>' + child.find('h5').html() + '</h4><div id="learnerResc">';
            html +=  child.find('div#lerner').html() + '</div></div>';
            html += '<a href="javascript:void(0)" onClick="removeService(\'' +  serviceId + '\' )" class="icons popupRemoveSelctedModule"></a>';
            html += '</div>';
                };
            }
                );
            jQuery("#side-block").html(html);
            jQuery("#total-count").html( jQuery("#side-block").children('popupSelectedModule').length );

        
    });


  /**
     * Removes Service 
     * @param {type} pid
     * @returns {void}     
     */
    function removeService(pid) {
        

        jQuery("#id-" + pid).remove();
        idArr = pid.split('_');
        newID = idArr[1]+'_'+idArr[0];
        passManageState(pid);
        jQuery("#total-count").html( jQuery("#side-block").children('popupSelectedModule').length );
    }
</script>