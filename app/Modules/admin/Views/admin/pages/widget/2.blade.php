<!--
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
-->
@if(!empty($adSlotTwoData))
    @if($adSlotTwoData->slotable_type=='Ad' && !empty($adSlotTwoData['content']->image_path) )
    <div class="memberShip">
        <a href="{{ $adSlotTwoData['content']->link }}">
                <div class="memberShipOverlay"></div>
            {{  HTML::image("data/ads/" . $adSlotTwoData['content']->image_path) }}
        </a>

    </div>
    @endif
    @if( !empty($adSlotTwoData) && $adSlotTwoData->slotable_type=='Testimonial' && !empty($testimonials))
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
    @if($adSlotTwoData->slotable_type=='Announcement')
        <div class="information">
          <h4>Related Information<br />{{isset($adSlotTwoData['content']->title)?$adSlotTwoData['content']->title:''}}</h4>
          <div class="relatedInfo">
            @if(!empty($adSlotTwoData['content']->image_path) && is_file("data/announcement/images/" . $adSlotTwoData['content']->image_path))
            <div class="relatedInfoThumb">
                {{  HTML::image("data/announcement/images/" . $adSlotTwoData['content']->image_path) }}
            </div>
            @endif
            <h4>{{$adSlotTwoData['content']->title}}</h4>
            <span>
                @if(isset($adSlotTwoData['content']->date))
                {{{date('M d, Y',strtotime($adSlotTwoData['content']->date))}}}
                @endif
                at 
                {{isset($adSlotTwoData['content']->location)?$adSlotTwoData['content']->location:''}}</span>
            <p>{{isset($adSlotTwoData['content']->short_description)?$adSlotTwoData['content']->short_description:''}}</p>
            @if(!empty($adSlotTwoData['content']->link))
            <a href="{{$adSlotTwoData['content']->link}}" target='_blank'>Click here for more information</a>
            @endif
             </div>
        </div>
    @endif
@endif