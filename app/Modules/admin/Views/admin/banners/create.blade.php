@extends('layouts.layout')

@section('banners')
class="active"
@stop

@section('main')

<div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12">
      <div>
         <div class="pull-left">
            <h1 class="section-title-inner">
               <span>Create Banner</span>
            </h1>
         </div>
         <div class="pull-right">
            <h4 class="caps"><a href="{{route('banners.index')}}"><i class="fa fa-chevron-left"></i> Back </a></h4>
         </div>
         <div class="clearfix"></div>
      </div>
      <hr/>
      <div>

{!! Form::open(array('route' => 'banners.store','files'=>true)) !!}
{!! Form::hidden('formType','banner') !!}
    @if ($errors->any())
    <div class="adminFormErrorList">
        <ul>
            {!! implode('', $errors->all('
            <li class="error">:message</li>
            ')) !!}
        </ul>
    </div>
    @endif
    <div class="row main-div" style='margin-left:0px;'>
            <div class="col-sm-12 col-md-6 col-lg-6">
               <div class="row">
                  <div class="col-sm-12 col-md-6 col-lg-6">
                    <div >
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                            {!! Form::label('title', 'Title:') !!}
                            {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                            {!! Form::text('title', null, array('class' => 'adminTextInput form-control')) !!}

                        </div>
                    </div>
                    <div >
                        <div class="form-group {{ $errors->has('link') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                            {!! Form::label('link', 'URL:') !!}
                            {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                            {!! Form::text('link', null, array('class' => 'adminTextInput form-control')) !!}
                        </div>
                     </div>
                     <div >
                        <div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                            {!! Form::label('image', 'Image:') !!}
                            {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                            {!! Form::file('image') !!}
                            <div class="note 1" id="1" style="display: none;"><small>Size requirements:  {!!App\Models\Banner::$heroBannerWidth!!} x {!!App\Models\Banner::$heroBannerHeight!!} (.png,.gif, .jpeg, .jpg).</small></div>
                            <div class="note 2" id="2" style="display: none;"><small>Size requirements:  {!!App\Models\Banner::$serviceBannerWidth!!} x {!!App\Models\Banner::$serviceBannerHeight!!}  (.png,.gif, .jpeg, .jpg).</small></div>
                        </div>
                    </div>
                     </div>
                    <div class="col-sm-12 col-md-6 col-lg-6" >
                     <div >
                        <div class="form-group {{ $errors->has('sequence') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                        {!! Form::label('sequence', 'Sequence:') !!}
                        {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                        {!! Form::text('sequence', null, array('class' => 'adminTextInput form-control')) !!}
                        </div>
                     </div>
                     <div >
                        <div class="form-group {{ $errors->has('banner_type_id') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                            {!! Form::label('banner_type_id', 'Banner Type:') !!}
                            {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                            {!! Form::select('banner_type_id', $bannerTypes, null, array('id' => 'banner_type_id','class' => 'adminTextSelect form-control')); !!}
                        </div>
                     </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12" >
                        <div >
                        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                            {!! Form::label('description', 'Description:') !!}
                            {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                            {!! Form::textarea('description', NULL, array(
                            'id'      => 'description',
                            'class'=>'form-control ckeditor',
                            'rows'    => 5) ) !!}
                        </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-8 col-md-4 col-sm-6">
                            {!! Form::submit('Submit', array('class' => 'btn btn-primary adminBTNInput')) !!}
                            {!! link_to_route('banners.index', 'Cancel', null, array('class' => 'btn btn-primary adminBTNInput', 'style' => 'float:right')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

<script>
    $(document).ready(function() {
        showHide();
        $( "#banner_type_id" ).change(function() {
            showHide();
        });
    });
    /**
     * Show hide helping text for banner resolution
     **/
    function showHide(){
        $('.note').hide();
        $('.' + $('#banner_type_id').val()).show();
        if($('#banner_type_id').val() == 1) {
            $('#hero_description').show();
        } else {
            $('#hero_description').hide();
        }
    }
</script>
{!! Form::close() !!}
@stop