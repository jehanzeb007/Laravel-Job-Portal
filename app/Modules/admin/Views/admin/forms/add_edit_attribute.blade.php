@extends('layouts.pop_up')
@section('header_assets')
    @parent
    {!! HTML::style('assets/public/css/footable-0.1.css') !!}
    {!! HTML::style('assets/public/css/footable.sortable-0.1.css') !!}
    <style type="text/css">
        .cpt_data .btn{ margin-top: 25px; width: 100% }
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
                <span style="color:white;">Attributes Form</span>
        </h1>
    </div>
</div>
<div class="clearfix"></div>
<div class="pop_up">
   {!! Form::model($form,['url' => [route('save_attribute'), $form->id], 'class' => 'form-horizontal','method' => 'post']) !!}
            @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
    <div style="display:none;" id="id">
        {!! Form::text('id', $form->id, ['class' => 'form-control']) !!}
    </div>
    @if( \Session::get('remove') )
        <div id="remove" style="display:none;">
            <?php $remove_string = \Session::get('remove')?>
            {!! Form::text('remove_id', $remove_string , ['class' => 'form-control ','id'=>'remove_id']) !!}
        </div>
    @else
        <div id="remove" style="display:none;">
            {!! Form::text('remove_id', null, ['class' => 'form-control ','id'=>'remove_id']) !!}
        </div>
    @endif
    <div class="all_cpts">
        
        @if (empty($attributes))
            <?php
                $index = 0;
            ?> 
            @include('admin::admin.forms.partials.attribute',$attributes)
        @else
            <?php
                $index = 0;
            ?>
            @foreach($attributes as $item)
                @include('admin::admin.forms.partials.attribute',$attributes)
            <?php
                $index++;
            ?>
            @endforeach
        @endif

        
    </div>

    <div class="row">   
        <div class="form-group">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4 headerOffset" style="float:right;">
                @if( \Session::get('success_msg') )
                    {!! Form::button('Save', ['class' => 'btn btn-primary form-control primary_color auto_click','onclick'=> 'parent.closeFancyBox()']) !!}
                @else
                    {!! Form::submit('Save', ['class' => 'btn btn-primary form-control primary_color']) !!}
                @endif
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<script type="text/javascript">

        function cloneMe(){
            $(".cpt_data:first").clone(false).insertAfter(".cpt_data:last").find("input").val("");
            $(".remove").show(); 
            $(".remove:first").hide();
            //$(".cpt_data select").minimalect("update");
        }

        function removeMe(elem,id){
            console.log(id);
            $('#remove_id').val($('#remove_id').val()+","+id);
            $(elem).parent().parent().remove();
        }

    jQuery(function(){
        jQuery('.auto_click').click();
    }); 

</script>
@stop

