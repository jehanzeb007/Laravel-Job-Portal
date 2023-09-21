@extends('layouts.layout')

@section('pages')
class="active"
@stop
@section('header_assets')
    @parent
    {!! HTML::style('assets/public/css/footable-0.1.css') !!}
    {!! HTML::style('assets/public/css/footable.sortable-0.1.css') !!}
    <style type="text/css">
        .date-icon { position: absolute; right:795px; top: 100px; pointer-events: none;}
        .calendar .form-group { position: relative;}
    </style>
@show
@section('main')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div>
            <div class="pull-left">
                <h1 class="section-title-inner">
                    <span>Pages</span>
                </h1>
            </div>
            <div class="clearfix"></div>
        </div>
        <hr/>
        <div class="row userInfo">
            <div class="col-xs-12 col-sm-12">
                <table class="footable footable-loaded tablet breakpoint">
                    <thead>
                        <tr>
                            <th><span>Title</span></th>
                            <th><span>Slug</span></th>
                            <th><span>Action</span></th>
                        </tr>
                    </thead>
                    <tbody id="content">
                        @if ($cmsPages->count())
                        @foreach ($cmsPages as $page)
                        <tr>
                            <td>{{{ $page->title }}}</td>
                            <td>{{{ $page->slug }}}</td>
                             <td>
                                <span>
                                    {!! link_to_route('pages.edit', '', array($page->id), array('class' => 'adminGridLinks glyphicon glyphicon-edit')) !!}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <li class="gridDataContent">
                            <div class="cell cw25">There are no pages</div>
                        </li>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div style="float: right;">{{-- {$cmsPages->links()} --}}</div>

@stop
