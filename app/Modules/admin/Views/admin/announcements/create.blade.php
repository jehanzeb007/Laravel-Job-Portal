@extends('layouts.layout')
@section('announcements')
class="active"
@stop
@section('main')

<div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12">
      <div>
         <div class="pull-left">
            <h1 class="section-title-inner">
               <span>Create Announcement</span>
            </h1>
         </div>
         <div class="pull-right">
            <h4 class="caps"><a href="{{route('announcements.index')}}"><i class="fa fa-chevron-left"></i> Back </a></h4>
         </div>
         <div class="clearfix"></div>
      </div>
      <hr/>
      <div>

{!! Form::open(array('route' => 'announcements.store', 'files' => true)) !!}


@if($errors->any())
<div class="adminFormErrorList">
<ul>
  {!! implode('', $errors->all('
  <li class="error">:message</li>
  ')) !!}
</ul></div>
@endif

{!! Form::hidden('id') !!}
{!! Form::hidden('formType','edit-announcements') !!}
  <div class="row main-div" style='margin-left:0px;'>
            <div class="col-sm-12 col-md-6 col-lg-6">
               <div class="row">
                  <div class="col-sm-12 col-md-6 col-lg-6">
                    <div >
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                          {!! Form::label('title', 'Title:') !!}
                          {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                          {!! Form::text('title', null, array('class' => 'form-control  adminTextInput')) !!} 
                        </div>
                    </div>
                    <div >
                        <div class="form-group {{ $errors->has('date') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                          {!! Form::label('date', 'Date:') !!}
                          {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                          {!! Form::text('date', null, array('class' => 'form-control  adminTextInput', 'id' => 'calendar_date' )) !!}
                        </div>
                    </div>
                    <div >
                        <div class="form-group {{ $errors->has('banner_image') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                          {!! Form::label('banner_image', 'Image:') !!}
                          {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                          {!! Form::file('banner_image', null, array('class' => 'form-control  adminTextInput')) !!} 
                          <div class="note"><small>Size requirements:  647 x 145 (.png,.gif, .jpeg, .jpg).</small></div>
                       </div>
                    </div>
                    <div class='grid_6'>
                      {!! Form::label('published', 'Published:') !!}
                      {!! Form::checkbox('published', null) !!} 
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-6">
                    <div >
                        <div class="form-group {{ $errors->has('sub_title') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                          {!! Form::label('sub_title', 'Sub Title:') !!}
                          {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                          {!! Form::text('sub_title', null, array('class' => 'form-control  adminTextInput')) !!}
                        </div>
                    </div>
                    <div >
                        <div class="form-group {{ $errors->has('location') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                        {!! Form::label('location', 'Location:') !!}
                        {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                        {!! Form::text('location', null, array('class' => 'form-control  adminTextInput')) !!} 
                        </div>
                    </div>
                    
                    <div >
                        <div class="form-group {{ $errors->has('link') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                          {!! Form::label('link', 'URL:') !!}
                          {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                          {!! Form::text('link', null, array('class' => 'form-control  adminTextInput')) !!} 
                        </div>
                    </div> 
                    <div class='grid_6'>
                        {!! Form::label('featured', 'Featured:') !!}
                        {!! Form::checkbox('featured', null) !!} 
                    </div>
                  </div>
                <div class="col-sm-12 col-md-12 col-lg-12" >
                  <div >
                    <div class="form-group {{ $errors->has('short_description') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                      {!! Form::label('short_description', 'Short Description:') !!}
                      <div class="clear">&nbsp;</div>
                        {!! Form::textarea('short_description', NULL, array(
                        'id'      => 'short_description',
                        'class'=>'form-control ckeditor',
                        'rows'    => 5) ) !!} 
                    </div>
                  </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-12" >
                  <div >
                    <div class="form-group {{ $errors->has('long_description') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                      {!! Form::label('long_description', 'Content:') !!}

                      {!! Form::textarea('long_description', NULL, array(
                      'id'      => 'long_description',
                      'class'=>'form-control  ckeditor',
                      'rows'    => 5) ) !!} 
                    </div>
                  </div>
                </div>
              <div class="form-group">
                <div class="col-md-offset-8 col-md-4 col-sm-6">
                  {!! Form::submit('Submit', array('class' => 'btn btn-primary adminBTNInput')) !!}
                  {!! link_to_route('announcements.index', 'Cancel', null, array('class' => 'btn btn-primary adminBTNInput', 'style' => 'float:right')) !!}
                </div>
              </div>
            </div>
          </div>
          </div>
{!! Form::close() !!}
<script>
        $(document).ready(function() {

            $("#calendar_date" ).datepicker({dateFormat: "mm/dd/yy"});
            @if($sucess = \Session::get('success_msg'))
                showTimerMsg("{{$sucess}}",3000);
            @endif
        });
    </script>
@stop


