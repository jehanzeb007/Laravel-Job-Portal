@extends('layouts.layout')
@section('admin_assets')
@parent
{!! HTML::script('assets/js/jquery.ddslick.min.js') !!}
@stop 

@section($page->slug) 
    class="active"
@endsection

@section('main')

    <h2>Edit Page</h2>
    {!! Form::model($page, array('method' => 'PATCH','files' => true,  'route' => array('pages.update', $page->id))) !!}
    <div class="adminForm col-md-6">
    {!! Form::hidden('formType',$page->slug ) !!}
    @if ($errors->any())
    <div class="adminFormErrorList">
        <ul>
        {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
        </ul>
    </div>
    @endif
    @if( in_array('title', $page_fields[$page->slug] ) )
    <div class='grid_6'> 
        {!! Form::label('title', 'Title:',array('class' =>'')) !!}
        <small class="adminRequired">*</small>
        <div class="clear">&nbsp;</div>
        {!! Form::text('title', null, array('class' => 'form-control adminTextInput')) !!}
    </div>
    @endif
    @if( in_array('banner_image', $page_fields[$page->slug] ) )
    <div class='grid_6'>
        <div class="fltR" style="margin-top:25px;">
        @if (File::exists('data/banners/thumbnail/' . $page->banner_image)) 
            <a href="{!!asset('data/banners/resized/'.$page->banner_image)!!}" class="fancybox">
                {!!HTML::image('data/banners/thumbnail/'.$page->banner_image, 'Image not found', array('class' => 'adminBannerIMG'))!!}
            </a>
        @endif
        </div>
        <div class="fltL">
        {!! Form::label('banner_image', 'Page Banner:') !!}
       
        {!! Form::file('banner_image', null, array('class'=>'form-control adminTextInput')) !!}
        <div class="note"><small>Size requirements: {!!App\Models\Page::$bannerWidth!!} x {!!App\Models\Page::$bannerHeight!!} (.png,.gif, .jpeg, .jpg).</small></div>
        </div>
        <div class="clr"></div>
    </div>
    @endif
    <div class="clear">&nbsp;</div>
    @if( in_array('short_description', $page_fields[$page->slug] ) )
    <div class='grid_12'> 
        {!! Form::label('short_description', 'Short Description:') !!}
        {!! Form::textarea('short_description', null, array('class'=>'form-control ckeditor', 'id'=>'form-control long_description','rows'=> 5)) !!}
    </div>
    @endif
    <div class="clear">&nbsp;</div>
    @if( in_array('long_description', $page_fields[$page->slug] ) && $page->slug != "elearning" )
    <div class='grid_12'>
        <?php 
        $txt = "Long Description:";
        if($page->slug == "partnerships"){
            $txt = "What We Do";
        }
        ?>
        {!! Form::label('long_description', $txt) !!}
        {!! Form::textarea('long_description', NULL, array('id' => 'long_description', 'class' => 'form-control ckeditor', 'rows' => 5) ) !!}
    </div>
    <div class="clear">&nbsp;</div>
    @endif
    @if( in_array('meta_keyword', $page_fields[$page->slug] ) )
    <div class='grid_6'> 
        {!! Form::label('meta_keyword', 'Meta Keyword:') !!}
        <small class="adminRequired">*</small>
        {!! Form::text('meta_keyword', null, array('class' => 'form-control adminTextInput')) !!}
    </div>
    @endif
    @if( in_array('meta_tags', $page_fields[$page->slug] ) )
    <div class='grid_6'> 
        {!! Form::label('meta_tags', 'Meta Tags:') !!}
        {!! Form::text('meta_tags', null, array('class' => 'form-control adminTextInput')) !!}
    </div>
    @endif
    <div class="clear">&nbsp;</div>
    @if( in_array('meta_description', $page_fields[$page->slug] ) )
    <div class='grid_12'> 
        {!! Form::label('meta_description', 'Meta Description:') !!}
        <small class="adminRequired">*</small>
        {!! Form::textarea('meta_description', null, array('class'=>'form-control adminTextArea', 'id'=>'long_description','rows'=> 5, 'cols'=>75)) !!}
    </div>
    @endif
    <div class="clear">&nbsp;</div>
    @if( in_array('ad_slot_1', $page_fields[$page->slug] ) )
    <div class='grid_6'> 
        {!! Form::label('ads[1][page_ad_slot_type]', 'Slot 1 - Ad Type:') !!}
        {!! Form::select('ads[1][page_ad_slot_type]', $page_ad_types, $pageAdSlotData[1]['slotable_type'], array('class'=>'form-control adminTextSelect', 'onchange'=>'updateContent(this)'))!!}
    </div>
    <div class='grid_6'> 
        @if($pageAdSlotData[1]['slotable_type']!='none')
            @if($pageAdSlotData[1]['slotable_type']!='Ad' && $pageAdSlotData[1]['slotable_type'] != 'Announcement')
            {!! Form::label('ads[1][page_ad_slot_content]', 'Slot 1 - Ad Content:', array('style'=>'display:none')) !!}
            <div style="display:none">
                <div class="contentContainer" id="page_ad_slot_content_image_1"></div>
            </div>
            {!! Form::select('ads[1][page_ad_slot_content_announcement]', $announcements, $pageAdSlotData[1]['announcement_id'],array('class' => 'form-control adminTextSelect announcement', 'style'=>'display:none')) !!}
            @endif
            @if($pageAdSlotData[1]['slotable_type']=='Ad')
            {!! Form::label('ads[1][page_ad_slot_content]', 'Slot 1 - Ad Content:') !!}
            <div><div class="contentContainer" id="page_ad_slot_content_image_1"></div></div>
            {!! Form::select('ads[1][page_ad_slot_content_announcement]', $announcements, $pageAdSlotData[1]['announcement_id'],array('class' => 'form-control adminTextSelect announcement', 'style'=>'display:none')) !!}
            @endif
            @if($pageAdSlotData[1]['slotable_type']=='Announcement')
            {!! Form::label('ads[1][page_ad_slot_content]', 'Slot 1 - Ad Content:') !!}
            <div style="display:none">
                <div class="contentContainer" id="page_ad_slot_content_image_1"></div>
            </div>
            {!! Form::select('ads[1][page_ad_slot_content_announcement]', $announcements, $pageAdSlotData[1]['announcement_id'],array('class' => 'form-control adminTextSelect announcement')) !!}
            @endif
        @endif
        @if($pageAdSlotData[1]['slotable_type']=='none')
        {!! Form::label('ads[1][page_ad_slot_content]', 'Slot 1 - Ad Content:', array('style'=>'display:none')) !!}
        <div style="display:none">
            <div class="contentContainer" id="page_ad_slot_content_image_1"></div>
        </div>
        {!! Form::select('ads[1][page_ad_slot_content_announcement]', $announcements, $pageAdSlotData[1]['announcement_id'],array('class' => 'form-control adminTextSelect announcement', 'style'=>'display:none')) !!}
        @endif
    </div>
    <div class="clear">&nbsp;</div>
    @endif
    @if( in_array('ad_slot_2', $page_fields[$page->slug] ) )
    <div class='grid_6'> 
        {!! Form::label('ads[2][page_ad_slot_type]', 'Slot 2 - Ad Type:') !!}
        {!! Form::select('ads[2][page_ad_slot_type]', $page_ad_types, $pageAdSlotData[2]['slotable_type'], array('class'=>'form-control adminTextSelect', 'onchange'=>'updateContent(this)'))!!}
    </div>
    
    <div class='grid_6'> 
        @if($pageAdSlotData[2]['slotable_type']!='none')
            @if($pageAdSlotData[2]['slotable_type']!='Ad' && $pageAdSlotData[2]['slotable_type'] != 'Announcement')
                {!! Form::label('ads[2][page_ad_slot_content]', 'Slot 2 - Ad Content:', array('style'=>'display:none')) !!}
                <div style="display:none">
                    <div class="contentContainer" id="page_ad_slot_content_image_2"></div>
                </div>
                {!! Form::select('ads[2][page_ad_slot_content_announcement]', $announcements, $pageAdSlotData[2]['announcement_id'],array('class' => 'form-control adminTextSelect announcement', 'style'=>'display:none')) !!}
            @endif
            
            @if($pageAdSlotData[2]['slotable_type']=='Ad')
            {!! Form::label('ads[2][page_ad_slot_content]', 'Slot 2 - Ad Content:') !!}
                <div><div class="contentContainer" id="page_ad_slot_content_image_2"></div></div>
                {!! Form::select('ads[2][page_ad_slot_content_announcement]', $announcements, $pageAdSlotData[2]['announcement_id'],array('class' => 'form-control adminTextSelect announcement', 'style'=>'display:none')) !!}
            @endif
            
            @if($pageAdSlotData[2]['slotable_type']=='Announcement')
            {!! Form::label('ads[2][page_ad_slot_content]', 'Slot 2 - Ad Content:') !!}
                <div style="display:none">
                    <div class="contentContainer" id="page_ad_slot_content_image_2"></div>
                </div>
                {!! Form::select('ads[2][page_ad_slot_content_announcement]', $announcements, $pageAdSlotData[2]['announcement_id'],array('class' => 'form-control adminTextSelect announcement')) !!}
            @endif
        @endif
        @if($pageAdSlotData[2]['slotable_type']=='none')
        {!! Form::label('ads[2][page_ad_slot_content]', 'Slot 2 - Ad Content:', array('style'=>'display:none')) !!}
        <div style="display:none">
            <div class="contentContainer" id="page_ad_slot_content_image_2"></div>
        </div>
        {!! Form::select('ads[2][page_ad_slot_content_announcement]', $announcements, $pageAdSlotData[2]['announcement_id'],array('class' => 'form-control adminTextInput announcement', 'style'=>'display:none')) !!}
        @endif
    </div>
    <div class="clear">&nbsp;</div>
    @endif
    @if( in_array('ad_slot_3', $page_fields[$page->slug] ) )
    <div class='grid_6'> 
        {!! Form::label('ads[3][page_ad_slot_type]', 'Slot 3 - Ad Type:') !!}
        {!! Form::select('ads[3][page_ad_slot_type]', $page_ad_types, $pageAdSlotData[3]['slotable_type'], array('class'=>'form-control adminTextSelect', 'onchange'=>'updateContent(this)'))!!}
    </div>
    <div class='grid_6'> 
        @if($pageAdSlotData[3]['slotable_type']!='none')
            @if($pageAdSlotData[3]['slotable_type']!='Ad' && $pageAdSlotData[3]['slotable_type'] != 'Announcement')
            {!! Form::label('ads[3][page_ad_slot_content]', 'Slot 3 - Ad Content:', array('style'=>'display:none')) !!}
            <div style="display:none">
                <div class="contentContainer" id="page_ad_slot_content_image_3"></div>
            </div>
            {!! Form::select('ads[3][page_ad_slot_content_announcement]', $announcements, $pageAdSlotData[3]['announcement_id'],array('class' => 'form-control adminTextSelect announcement', 'style'=>'display:none')) !!}
            @endif
            @if($pageAdSlotData[3]['slotable_type']=='Ad')
            {!! Form::label('ads[3][page_ad_slot_content]', 'Slot 3 - Ad Content:') !!}
            <div><div class="contentContainer" id="page_ad_slot_content_image_3"></div></div>
            {!! Form::select('ads[3][page_ad_slot_content_announcement]', $announcements, $pageAdSlotData[3]['announcement_id'],array('class' => 'form-control adminTextSelect announcement', 'style'=>'display:none')) !!}
            @endif
            @if($pageAdSlotData[3]['slotable_type']=='Announcement')
            {!! Form::label('ads[3][page_ad_slot_content]', 'Slot 3 - Ad Content:') !!}
            <div style="display:none">
                <div class="contentContainer" id="page_ad_slot_content_image_3"></div>
            </div>
            {!! Form::select('ads[3][page_ad_slot_content_announcement]', $announcements, $pageAdSlotData[3]['announcement_id'],array('class' => 'form-control adminTextSelect announcement')) !!}
            @endif
        @endif
        @if($pageAdSlotData[3]['slotable_type']=='none')
        {!! Form::label('ads[3][page_ad_slot_content]', 'Slot 3 - Ad Content:', array('style'=>'display:none')) !!}
        <div style="display:none">
            <div class="contentContainer" id="page_ad_slot_content_image_3"></div>
        </div>
        {!! Form::select('ads[3][page_ad_slot_content_announcement]', $announcements, $pageAdSlotData[3]['announcement_id'],array('class' => 'form-control adminTextSelect announcement', 'style'=>'display:none')) !!}
        @endif
    </div>
    <div class="clear">&nbsp;</div>
    @endif
    <div class='grid_6'>
        {!! Form::submit('Update', array('class' => 'btn btn-primary primary_color adminBTNInput')) !!}
        {!! link_to_route('pages.index', 'Cancel', null, array('class' => 'btn btn-primary primary_color adminBTNInput')) !!}
    </div>
</div>
{!! Form::close() !!}
<script>
var ddData1 = [
    @foreach ($imageContents as $i=>$image)
    {
        text: '{!!$image->title!!}',
        value: '{!!$image->id!!}',
        @if(isset($pageAdSlotData[1]) && $pageAdSlotData[1]['slotable_type']=='Ad' && $pageAdSlotData[1]['ad_id']==$image->id)
        selected: true,
        @endif
        imageSrc: "{!!asset('data/ads/thumbnail/'.$image->image_path)!!}"
    }
    @if($i<count($imageContents)-1)
    {!!','!!}
    @endif
    @endforeach
];
var ddData2 = [
    @foreach ($imageContents as $i=>$image)
    {
        text: '{!!$image->title!!}',
        value: '{!!$image->id!!}',
        @if(isset($pageAdSlotData[2]) && $pageAdSlotData[2]['slotable_type']=='Ad' && $pageAdSlotData[2]['ad_id']==$image->id)
        selected: true,
        @endif
        imageSrc: "{!!asset('data/ads/thumbnail/'.$image->image_path)!!}"
    }
    @if($i<count($imageContents)-1)
    {!!','!!}
    @endif
    @endforeach
];
var ddData3 = [
    @foreach ($imageContents as $i=>$image)
    {
        text: '{!!$image->title!!}',
        value: '{!!$image->id!!}',
        @if(isset($pageAdSlotData[3]) && $pageAdSlotData[3]['slotable_type']=='Ad' && $pageAdSlotData[3]['ad_id']==$image->id)
        selected: true,
        @endif
        imageSrc: "{!!asset('data/ads/thumbnail/'.$image->image_path)!!}"
    }
    @if($i<count($imageContents)-1)
    {!!','!!}
    @endif
    @endforeach
];

$('#page_ad_slot_content_image_1').ddslick({
    data: ddData1,
    selectText: "Please Select Ad Image",
    onSelected: function(selectedData){
        $('#page_ad_slot_content_image_1').find('input.dd-selected-value').attr('name', 'ads[1][page_ad_slot_content_image]');
    } 
});
$('#page_ad_slot_content_image_2').ddslick({
    data: ddData2,
    selectText: "Please Select Ad Image",
    onSelected: function(selectedData){
        $('#page_ad_slot_content_image_2').find('input.dd-selected-value').attr('name', 'ads[2][page_ad_slot_content_image]');
    } 
});
$('#page_ad_slot_content_image_3').ddslick({
    data: ddData3,
    selectText: "Please Select Ad Image",
    onSelected: function(selectedData){
        $('#page_ad_slot_content_image_3').find('input.dd-selected-value').attr('name', 'ads[3][page_ad_slot_content_image]');
    } 
});

/**
 * function to update content of adslots with respect to type
 * @param obj: element type
 **/
function updateContent(elem){
    if($(elem).val()=='none' || $(elem).val()=='Testimonial' || $(elem).val()=='randomized'){
        $(elem).parent().next().find('select').hide();
        $(elem).parent().next().find('div').hide();
        $(elem).parent().next().find('label').hide();
    }else if($(elem).val()=='Ad'){
        $(elem).parent().next().find('select').hide();
        $(elem).parent().next().find('div').show();
        $(elem).parent().next().find('label').show();
    }else if($(elem).val()=='Announcement'){
        $(elem).parent().next().find('select').hide();
        $(elem).parent().next().find('div').hide();
        $(elem).parent().next().find('select.announcement').show();
        $(elem).parent().next().find('label').show();
    }
}
</script>
@stop