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
                <span style="color:white;">Edit Form</span>
        </h1>
    </div>
</div>
<div class="clearfix"></div>
<div class="pop_up">
   {!! Form::model($form,['url' => [route('update_form'), $form->id], 'class' => 'form-horizontal','method' => 'post']) !!}
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
                        {!! Form::text('id', $form->id, ['class' => 'form-control']) !!}
                </div>
                <div>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                        {!! Form::label('name', 'Form ') !!}
                        {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                        {!! Form::text('name', $form->name, ['class' => 'form-control','placeholder' => 'Form Name']) !!}
                    </div>
                </div>
        </div> 
    </div>
    <div class="row">    
        <div class="col-xs-6 col-sm-6 col-md-12 col-lg-6">
                <div class="calendar">
                    <div class="form-group {{ $errors->has('placement_option') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                        @php 
                            $array = Config::get('name.name');
                            $placement_options = $form->placement_options;
                            $placement_options = explode(',', $placement_options);
                        @endphp
                        {!! Form::label('placement_option', 'Placement Options') !!}
                        {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                        {{Form::select('placement_option[]',$array, $placement_options,array('class'=>'form-control','multiple'=>'multiple','id'=>'placement_option'))}}
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

