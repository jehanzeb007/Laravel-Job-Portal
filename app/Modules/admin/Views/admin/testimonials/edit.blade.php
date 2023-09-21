@extends('layouts.layout')
@section('testimonials')
class="active"
@stop
@section('main')
<div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12">
      <div>
         <div class="pull-left">
            <h1 class="section-title-inner">
               <span>Edit Testimonials</span>
            </h1>
         </div>
         <div class="pull-right">
            <h4 class="caps"><a href="{{route('testimonials.index')}}"><i class="fa fa-chevron-left"></i> Back </a></h4>
         </div>
         <div class="clearfix"></div>
      </div>
      <hr/>
      <div>
{!! Form::model($testimonial, array('method' => 'PATCH', 'files' => true, 'route' => array('testimonials.update', $testimonial->id))) !!}
{!! Form::hidden('formType','testimonial') !!}

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
                {!! Form::hidden('id') !!}
                    <div class="col-sm-12 col-md-6 col-lg-6">
                    <div >
                        <div class="form-group {{ $errors->has('logo') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                            {!! Form::label('image', 'Logo:') !!}
                            {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                            {!! Form::file('logo',  array('id' => 'logo_image')) !!}
                            <div class="note"><small>Size requirements: {!!App\Models\Testimonial::$testimonialWidth!!} x {!!App\Models\Testimonial::$testimonialHeight!!} (.png,.gif, .jpeg, .jpg).</small></div>
                            <div class="grid_3">
                            @if (File::exists('data/testimonial/images/thumbnail/' . $testimonial->image_path)) 
                                <a href="{!!asset('data/testimonial/images/'.$testimonial->image_path)!!}" class="fancybox">
                                    {!!HTML::image('data/testimonial/images/thumbnail/'.$testimonial->image_path, 'Image not found', array('id' => $testimonial->id, 'class' => 'adminBannerIMG'))!!}
                                </a>
                            @else
                                {!!HTML::image('assets/images/noimage.jpg', '' )!!}
                            @endif
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6" >
                     <div >
                        <div class="form-group {{ $errors->has('sequence') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                            {!! Form::label('sequence', 'Sequence:') !!}
                            {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                            {!! Form::text('sequence', null,array('class' => 'form-control  adminTextInput')) !!}
                        </div>
                     </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12" >
                        <div >
                        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                            {!! Form::label('description', 'Content:') !!}
                            {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                            {!! Form::textarea('description', NULL, array(
                            'id'      => 'description',
                            'class'=>'form-control ckeditor',
                            'rows'    => 10) ) !!}
                        </div>
                     </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-8 col-md-4 col-sm-6">
                            {!! Form::submit('Update', array('class' => 'btn btn-primary adminBTNInput')) !!}
                            {!! link_to_route('testimonials.index', 'Cancel', null, array('class' => 'btn btn-primary adminBTNInput', 'style' => 'float:right')) !!}
                        </div>
                    </div>
            </div>
        </div>
    </div>    
{!! Form::close() !!}

@stop
