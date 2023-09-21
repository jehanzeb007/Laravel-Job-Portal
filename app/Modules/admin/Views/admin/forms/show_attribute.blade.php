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
                <span style="color:white;">Show {{$form['name']}}</span>
        </h1>
    </div>
</div>
<div class="clearfix"></div>
<div class="pop_up">
   <div class="row userInfo">
            <div class="col-xs-12 col-sm-12">
                <table class="footable footable-loaded tablet breakpoint">
                    <thead>
                        <tr>
                            <th><span>Attributes</span></th>
                            <th><span>Action</span></th>
                        </tr>
                    </thead>
                    <tbody id="content">
                        @foreach($attributes as $item)
                        <tr>
                            <td>{{$item['name']}}</td>
                            <td> 
                                <span style="padding-left:20px;">
                                    {!! link_to_route('delete_form', '', array($item['id']), array('class' => 'glyphicon glyphicon-trash', "onclick"=>"return confirm('Are you sure?')")) !!}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</div>

@stop

