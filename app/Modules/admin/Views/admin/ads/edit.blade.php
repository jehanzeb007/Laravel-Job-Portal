@extends('layouts.layout')
@section('ads')
class="active"
@stop
@section('main')
<div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12">
      <div>
         <div class="pull-left">
            <h1 class="section-title-inner">
               <span>Edit Ads</span>
            </h1>
         </div>
         <div class="pull-right">
            <h4 class="caps"><a href="{{route('ads.index')}}"><i class="fa fa-chevron-left"></i> Back </a></h4>
         </div>
         <div class="clearfix"></div>
      </div>
      <hr/>
      <div>
{!! Form::model($ad, array('method' => 'PATCH', 'route' => array('ads.update', $ad->id),'files'=>true)) !!}
{!! Form::hidden('formType','ads') !!}
<div class="adminForm container_12">

    @if ($errors->any())
    <div class="adminFormErrorList">
        <ul>
            {!! implode('', $errors->all('
            <li class="error">:message</li>
            ')) !!}
        </ul></div>
    @endif

    
    <div class="row main-div" style='margin-left:0px;'>
            <div class="col-sm-12 col-md-6 col-lg-6">
               <div class="row">
                  <div class="col-sm-12 col-md-6 col-lg-6">
                    <div >
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                            {!!Form::hidden('id')!!}
                            {!! Form::label('title', 'Title:') !!}
                            {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                            {!! Form::text('title', null, array('class' => 'form-control adminTextInput')) !!}
                        </div>
                    </div>
                    </div>
                        <div class="col-sm-12 col-md-6 col-lg-6" >
                     <div >
                        <div class="form-group {{ $errors->has('link') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                            {!! Form::label('link', 'URL:') !!}
                            {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                            {!! Form::text('link', null, array('class' => 'form-control adminTextInput')) !!}
                        </div>
                    </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                    <div >
                        <div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                            {!! Form::label('image', 'Image:') !!}
                            {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                            {!! Form::file('image', null, array('class' => 'adminTextInput')) !!}
                            <div class="note"><small>Size requirements: {!!App\Models\Ad::$adImageWidth!!} x {!!App\Models\Ad::$adImageHeight!!} (.png,.gif, .jpeg, .jpg).</small></div>
                            <div class="grid_3">
                                @if (File::exists('data/ads/thumbnail/' . $ad->image_path)) 
                                    <a href="{!!asset('data/ads/'.$ad->image_path)!!}" class="fancybox">
                                        {!!HTML::image('data/ads/thumbnail/'.$ad->image_path, $ad->image, array('id' => $ad->id, 'class' => 'adminBannerIMG'))!!}
                                    </a>
                                @else
                                    {!!HTML::image('assets/images/noimage.jpg', '' )!!}
                                @endif
                            </div>
                        </div>
                     </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-8 col-md-4 col-sm-6">
                            {!! Form::submit('Update', array('class' => 'btn btn-primary adminBTNInput')) !!}
                            {!! link_to_route('ads.index', 'Cancel', null, array('class' => 'btn btn-primary  adminBTNInput')) !!}
                        </div>
                    </div>
            </div>
        </div>
    </div>    
{!! Form::close() !!}

@stop
