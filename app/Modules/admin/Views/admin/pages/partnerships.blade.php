@extends('layouts.layout')

@section('title')
	HBI’s Hospital & Health System Vendor Management and Analysis
@stop

@section($page->slug) 
	active
@endsection

@section('content')
<div id="content">
	
	<div class="partnerships-page">
		<div class="partnerships-header"> 
			<h1>{{ $page->title }}</h1>
			{{ $page->short_description }}			
		</div>
		<div class="partnerships-content">
			<div class="partners-widget widget-blue">
				<h2>What We Do</h2>
				<div class="partners-post">
					{{ $page->long_description }}
				</div>
			</div>
			<div class="ask_box" style="margin: 0 0 15px 29%; width:405px;">
            <div class="content" style="width:235px;">
                For more information on our strategic partnerships, please contact us.
            </div>
            <div class="fr">
                <div class="siteButtonSmall" style="margin-right: 5px;">
                    <span>
                        <a href="{{route('contactus', array('width'=>800, 'modal'=>'true', 'source' => 'inquiry')) }}" class="fancybox fancybox.ajax" title="Contact Us" caption="Contact Us">
                            <i class="getQuote icons"></i>Contact HBI
                        </a>
                    </span>
                </div>
            </div>
            <div class="clr"></div>
        </div>
		</div>
	</div>
</div>
@stop
