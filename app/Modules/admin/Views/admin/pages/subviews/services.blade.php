<style type="text/css">
    siteButtonSmall_update {
        float: right;
        margin-right: 8px;
        margin-top: 7px;
    }
</style>

@if($services->count())
@foreach($services as $service)
    @if($service->serviceItems->count())
    <div class="services">
        <h3>{{{ $service->title }}} <div class="siteButtonSmall siteButtonSmall_update fr"> <span><a href="{{route('servicespopup', array('width' => '800px')) }}"  class="fancybox fancybox.ajax" caption="Options"><i class="getQuote icons"></i>Become a Member</a></span> </div></h3>
    
        @foreach($service->serviceItems as $sItem)
        <div class="servicesInn">
            <h4>{{{ $sItem->title }}}</h4>
            {{ $sItem->description }}
            @if($sItem->communities->count())
            <h5>Available Communities</h5>
            <ul class="availableDepartment">
                @foreach($sItem->communities as $community)
                @if($community->id == 1)
                <li class="departmentRCA"> <a href="{{route('communities-rc') }}"> <span class="icons"></span> Revenue <br>
                        Cycle </a> </li>
                @elseif($community->id == 2)
                <li class="departmentSCA"> <a href="{{route('communities-sc') }}"> <span class="icons"></span> Supply <br>
                        Chain </a> </li>
                @elseif($community->id == 3)            
                <li class="departmentCQA"> <a href="{{route('communities-cq') }}"> <span class="icons"></span> Cost &amp;<br>
                        Quality </a> </li>
                @elseif($community->id == 4)
                <li class="departmentITA"> <a href="{{route('communities-it') }}"> <span class="icons"></span> Information <br>
                        Technology </a> </li>
                @else
                <li class="departmentITA"> <a href="{{route('communities-it') }}"> <span class="icons"></span> {{$community->title}} </a> </li>
                @endif            
                @endforeach

            </ul>
            @endif    
            <div class="clr"></div>
        </div>
        @endforeach
    


        </div>
    @endif
@endforeach
@endif
<div class="fr">
    {{-- <div class="siteButtonSmall"> <span> {{link_to_route('page', 'Learn More About Our Communities',  array('slug' => 'communities')) }} </span> </div> --}}
</div>