<!--
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
-->
@if(!empty($adSlotThreeData))
    @if($adSlotThreeData->slotable_type=='Ad' && !empty($adSlotThreeData['content']->image_path) )
    <div class="memberShip">
        <a href="{{ $adSlotThreeData['content']->link }}">
          <div class="memberShipOverlay"></div>
            {{  HTML::image("data/ads/" . $adSlotThreeData['content']->image_path) }}
        </a>
      
    </div>
    @endif
    @if( !empty($adSlotTwoData) && $adSlotThreeData->slotable_type=='Testimonial' && !empty($testimonials))
    <ul class="bxslider">
        @foreach($testimonials as $tesimonial)
        <li>
            <div class="information">
                <h4>What members are saying about HBI communities.</h4>
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
    @if($adSlotThreeData->slotable_type=='Announcement')
        <div class="information">
          <h4>Related Information<br />{{isset($adSlotThreeData['content']->title)?$adSlotThreeData['content']->title:''}}</h4>
          <div class="relatedInfo">
            @if(!empty($adSlotThreeData['content']->image_path) && is_file("data/announcement/images/" . $adSlotThreeData['content']->image_path))
            <div class="relatedInfoThumb">
                {{  HTML::image("data/announcement/images/" . $adSlotThreeData['content']->image_path) }}
            </div>
            @endif
            <h4>{{$adSlotThreeData['content']->title}}</h4>
            <span>
                @if(isset($adSlotThreeData['content']->date))
                {{{date('M d, Y',strtotime($adSlotThreeData['content']->date))}}}
                @endif
                at 
                {{isset($adSlotThreeData['content']->location)?$adSlotThreeData['content']->location:''}}</span>
            <p>{{isset($adSlotThreeData['content']->short_description)?$adSlotThreeData['content']->short_description:''}}</p>
            @if(!empty($adSlotThreeData['content']->link))
            <a href="{{$adSlotThreeData['content']->link}}" target='_blank'>Click here for more information</a>
            @endif
             </div>
        </div>
    @endif
@endif