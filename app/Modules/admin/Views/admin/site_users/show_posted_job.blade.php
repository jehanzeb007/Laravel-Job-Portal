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
                <span style="color:white;">Show Posted Jobs</span>
        </h1>
    </div>
</div>
<div class="clearfix"></div>
<div class="pop_up">
   <div class="row jobInfo">
            <div class="col-xs-12 col-sm-12">
                <table class="footable footable-loaded tablet breakpoint">
                    <thead>
                        <tr>
                            <th><span>Job Title</span></th>
                            <th><span>Posted at</span></th>
                        </tr>
                    </thead>
                    <tbody id="content">
                        @if(empty($jobs))
                        <tr>
                            <td>No job Posted</td>
                        </tr>
                        @else
                        @foreach($jobs as $item)
                        <tr>
                            <td>{{$item['name']}}</td>
                            <td>{{$item['created_at']}}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
</div>

@stop

