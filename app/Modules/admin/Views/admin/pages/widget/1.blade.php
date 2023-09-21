<!--
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
-->
<?php
$text = "What members are saying about HBI communities.";
if( Request::is("pages/elearning") || Request::is("healthcare-training-classroom-to-e-learning-modules") ){
    $text = "What members are saying about HBI E-Learning.";
}

$url = "";
$class = "";
if( !empty($adSlotOneData) && $adSlotOneData->slotable_type=='Ad' && !empty($adSlotOneData['content']->image_path) ){
    $url = "".$adSlotOneData['content']->link."";
    
    if(Request::is("pages/services") || Request::is("pages/communities") || Request::is("hbi-products-services") || Request::is("healthcare-research-memberships") || Request::is("revenue-cycle-best-practice-research-benchmarks") || Request::is("suppy-chain-best-practice-research") || Request::is("cost-quality-best-practice-research")  || Request::is("information-technology-IT-best-practice-research") ){
        $url = "".route('servicespopup', array('width' => '800px'))."";
        $class = "class='fancybox fancybox.ajax' caption='Options'";
    }
}

?>
@if(!empty($adSlotOneData))
    <!-- Start of Simple Image Ad Widget -->
    @if($adSlotOneData->slotable_type=='Ad' && !empty($adSlotOneData['content']->image_path) )
    <div class="memberShip">
       <a href="{{ $url }}" {{$class}}>
       <div class="memberShipOverlay" ></div>
            {{  HTML::image("data/ads/" . $adSlotOneData['content']->image_path) }}
            
        </a>
        
    </div>
    @endif
    <!-- End of Simple Image Ad Widget -->
    <!-- Start of Testimonial Widget -->
    @if($adSlotOneData->slotable_type=='Testimonial' && !empty($testimonials))
    <ul class="bxslider">
        @foreach($testimonials as $tesimonial)
        <li>
            <div class="information">
                <h4>{{$text}}</h4>
                <div class="memberInfo">
                    <div class="memberInfoRotater">
                        <a class="anchRotater" href="#"></a>
                        <div class="memberLogo"> {{ HTML::image('data/testimonial/images/'.$tesimonial->image_path) }}  </div>
                        <a class="anchRotater" href="#"></a>
                        <div class="clr"></div>
                    </div>
                    <p>{{$tesimonial->description}}</p>
                    <div class="clr"></div>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
    @endif
    <!-- End of Testimonial Widget -->
    <!-- Start of Announcement Widget -->
    @if($adSlotOneData->slotable_type=='Announcement')
        <div class="information">
          <h4>Related Information<br />{{isset($adSlotOneData['content']->title)?$adSlotOneData['content']->title:''}}</h4>
          <div class="relatedInfo">
            @if(!empty($adSlotOneData['content']->image_path) && is_file("data/announcement/images/" . $adSlotOneData['content']->image_path))
            <div class="relatedInfoThumb">
                {{  HTML::image("data/announcement/images/" . $adSlotOneData['content']->image_path) }}
            </div>
            @endif
            <h4>{{$adSlotOneData['content']->title}}</h4>
            <span>
                @if(isset($adSlotOneData['content']->date))
                {{{date('M d, Y',strtotime($adSlotOneData['content']->date))}}}
                @endif
                at 
                {{isset($adSlotOneData['content']->location)?$adSlotOneData['content']->location:''}}</span>
            <p>{{isset($adSlotOneData['content']->short_description)?$adSlotOneData['content']->short_description:''}}</p>
            @if(!empty($adSlotOneData['content']->link))
            <a href="{{$adSlotOneData['content']->link}}" target='_blank'>Click here for more information</a>
            @endif
             </div>
        </div>
    @endif
    <!-- End of Announcement Widget -->
@endif