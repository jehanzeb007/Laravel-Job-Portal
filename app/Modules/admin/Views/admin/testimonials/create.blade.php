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
               <span>Create Testimonials</span>
            </h1>
         </div>
         <div class="pull-right">
            <h4 class="caps"><a href="{{route('testimonials.index')}}"><i class="fa fa-chevron-left"></i> Back </a></h4>
         </div>
         <div class="clearfix"></div>
      </div>
      <hr/>
      <div>
{!! Form::open(array('route' => "testimonials.store", 'files' => true)) !!}
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
                    <div class="col-sm-12 col-md-6 col-lg-6">
                    <div >
                        <div class="form-group {{ $errors->has('logo') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                            {!! Form::label('logo', 'Logo:') !!}
                            {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                            {!! Form::file('logo', null, array('class' => 'adminTextInput', 'id' => 'logo_image')) !!}
                            <div class="note"><small>Size requirements: {!!App\Models\Testimonial::$testimonialWidth!!} x {!! App\Models\Testimonial::$testimonialHeight!!} (.png,.gif, .jpeg, .jpg).</small></div>
                        </div>
                    </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6" >
                     <div >
                        <div class="form-group {{ $errors->has('sequence') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                            {!! Form::label('sequence', 'Sequence:') !!}
                            {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                            {!! Form::text('sequence', null, array('class' => 'form-control  adminTextInput')) !!}
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
                            'class'=>'form-control  ckeditor',
                            'rows'    => 6) ) !!}
                        </div>
                     </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-8 col-md-4 col-sm-6">
                            {!! Form::submit('Submit', array('class' => 'btn btn-primary adminBTNInput')) !!}
                            {!! link_to_route('testimonials.index', 'Cancel', null, array('class' => 'btn btn-primary adminBTNInput', 'style' => 'float:right')) !!}
                        </div>
                    </div>
            </div>
        </div>
    </div>    
{!! Form::close() !!}

@stop


