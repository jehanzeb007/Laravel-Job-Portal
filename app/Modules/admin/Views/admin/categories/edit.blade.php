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
                <span style="color:white;">Edit subcategory</span>
        </h1>
    </div>
</div>
<div class="clearfix"></div>
<div class="pop_up">
   {!! Form::model($categorie,['url' => [route('update_categorie'), $categorie->id], 'class' => 'form-horizontal','method' => 'post']) !!}
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
                    {!! Form::text('id', $categorie->id, ['class' => 'form-control']) !!}
                    {!! Form::text('old_slug', $categorie->slug, ['class' => 'form-control']) !!}
            </div>
            <div>
                <div class="form-group {{ $errors->has('subcategorie') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                    {!! Form::label('subcategorie', 'Subcategory ') !!}
                    {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                    {!! Form::text('subcategorie', $categorie->name, ['class' => 'form-control','placeholder' => 'Subcategory']) !!}
                </div>
            </div>
        </div> 
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div>
                <div class="form-group  {{ $errors->has('categorie') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                    {!! Form::label('categorie', 'Parent Category') !!}
                    @if($categorie->parent_id=='')
                        {!! Form::select('categorie', $categories, null, array('class' => 'form-control')) !!}
                    @else
                        {!! Form::select('categorie', $categories, $categorie->parent_id, array('class' => 'form-control')) !!}
                    @endif
                </div>
            </div>
        </div> 
    </div>
    <div class="row"> 
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group {{ $errors->has('icon') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                {!! Form::label('icon', 'Icon Class') !!}
                {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                {!! Form::text('icon', $categorie->icon, ['class' => 'form-control','placeholder' => 'Icon Class']) !!}
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

