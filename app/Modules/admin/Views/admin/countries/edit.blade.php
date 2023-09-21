@extends('layouts.pop_up')
@section('header_assets')
    @parent
    {!! HTML::style('assets/public/css/footable-0.1.css') !!}
    {!! HTML::style('assets/public/css/footable.sortable-0.1.css') !!}
    <style type="text/css">

    </style>
@show
@section('modal')

<style type="text/css">
        .calendar .form-group { position: relative;}
        .container { width: 94% !important;}
</style>

<div class="topBar" >
    <div class="navbar primary_color navbar-fixed-top megamenu" role="navigation" style="background:#9b59b6">
        <h1 class="section-title-inner" style="text-align:center; padding:20px;">
                <span style="color:white;">Edit Country</span>
        </h1>
    </div>
</div>
<div class="clearfix"></div>
<div class="pop_up">
   {!! Form::model($country,['url' => [route('update_country'), $country->id], 'class' => 'form-horizontal','method' => 'post']) !!}
        @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif

    <div class="row">    
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div style="display:none;">
                        {!! Form::text('id', $country->id, ['class' => 'form-control']) !!}
                        {!! Form::text('old_slug', $country->slug, ['class' => 'form-control']) !!}
                </div>
                <div>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                        {!! Form::label('name', 'Country ') !!}
                        {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                        {!! Form::text('name', $country->name, ['class' => 'form-control','placeholder' => 'Country Name']) !!}
                    </div>
                </div>
        </div> 
    </div>
    <div class="row"> 
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="calendar">
                    <div class="form-group {{ $errors->has('latitude') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                        {!! Form::label('latitude', 'Latitude ') !!}
                        {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                        {!! Form::number('latitude', $country->latitude, ['class' => 'form-control','placeholder' => 'Latitude', 'step'=>'any']) !!}
                    </div>
                </div>
        </div>    
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="calendar">
                    <div class="form-group {{ $errors->has('longitude') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                        {!! Form::label('longitude', 'Longitude ') !!}
                        {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                        {!! Form::number('longitude', $country->longitude, ['class' => 'form-control','placeholder' => 'Longitude', 'step'=>'any']) !!}
                    </div>
                </div>
        </div> 
    </div>
    <div class="row">   
        <div class="form-group">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4 headerOffset" style="float:right;">
                @if( \Session::get('success_msg') )
                    {!! Form::button('Edit', ['class' => 'btn btn-primary form-control primary_color auto_click','onclick'=> 'parent.closeFancyBox()']) !!}
                @else
                    {!! Form::submit('Edit', ['class' => 'btn btn-primary form-control primary_color']) !!}
                @endif
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<script type="text/javascript">
    jQuery(function(){
        jQuery('.auto_click').click();
    }); 
</script>
@stop

