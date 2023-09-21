@if($communities->count())    
    
        <div class="communitiesTab">
            <ul>
               @foreach($communities as $cType)
                    @if($cType->id == '1')
                        <li class="communitiesTabRCA community-tab {{$cType->slug}}" id="tab{{$cType->id}}" onclick="showCommunity({{{$cType->id}}})">
                        <div class="communityRCAHover">
						{{ HTML::image("assets/images/communitiesTabRCA-dHover.png") }}
                        </div>
                        <a href="javascript:void(0)"> </a></li>
                   @elseif($cType->id == '2')            
                        <li class="communitiesTabSCA community-tab {{$cType->slug}}" id="tab{{$cType->id}}" onclick="showCommunity({{{$cType->id}}})">
                        <div class="communitySCAHover">
						{{ HTML::image("assets/images/communitiesTabSCA-dHover.png") }}
                        </div>
                        <a href="javascript:void(0)"> </a></li>
                     @elseif($cType->id == '3')            
                        <li class="communitiesTabCQA community-tab {{$cType->slug}}" id="tab{{$cType->id}}"  onclick="showCommunity({{{$cType->id}}})">
                        <div class="communityCQAHover">
						{{ HTML::image("assets/images/communitiesTabCQA-dHover.png") }}
                        </div>
                        <a href="javascript:void(0)"> </a></li>
                    @elseif($cType->id == '4')            
                        <li class="communitiesTabITA community-tab last {{$cType->slug}}" id="tab{{$cType->id}}" onclick="showCommunity({{{$cType->id}}})">
                        <div class="communityITAHover">
						{{ HTML::image("assets/images/communitiesTabITA-dHover.png") }}
                        </div>
                        <a href="javascript:void(0)"> </a></li>
                    @else
                        <li class="communitiesTabITA community-tab last {{$cType->slug}}" id="tab{{$cType->id}}" onclick="showCommunity({{{$cType->id}}})">
                        <div class="communityITAHover">
						{{ HTML::image("assets/images/communitiesTabITA-dHover.png") }}
                        </div>
                        <a href="javascript:void(0)"></a></li>
                    @endif
                @endforeach
            </ul>
        </div>
        @foreach($communities as $cType)
        <div class="grayLeftBg borBot{{$cType->id}} content-{{$cType->slug}}" id="community{{$cType->id}}" style="display: none;">
            <h3>{{{$cType->title}}}</h3>
            <div class="short_description">{{$cType->short_description}} </div>
            <div class="long_description"> {{$cType->long_description}} </div>
            
        </div>
        @endforeach
    
@endif    
<div class="clr"></div>
<div class="fr">
    <div class="siteButtonSmall"> <span> {{link_to_route('services', 'Learn More About Our Services') }} </span> </div>
    <div class="siteButtonSmall fr"> <span><a href="{{route('servicespopup', array('width' => '800px')) }}"  class="fancybox fancybox.ajax" caption="Options" ><i class="getQuote icons"></i>Become a Member</a></span> </div>
</div>