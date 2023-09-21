@extends('layouts.layout')
@section('announcements')
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
                    <span>Announcements</span>
                </h1>
            </div>
            <div class="pull-right"><a class="btn btn-primary btn-small primary_color" href="{{route('announcements.create')}}">+ Add new Announcement</a></div>
            <div class="clearfix"></div>
        </div>
        <hr/>
        <div class="row userInfo">
            <div class="col-xs-12 col-sm-12">
                <table class="footable footable-loaded tablet breakpoint">
                    <thead>
                        <tr>
                            <th><span>Title</span></th>
                            <th><span>Image</span></th>
                            <th><span>Date</span></th>
                            <th><span>Location</span></th>
                            <th><span>Action</span></th>
                        </tr>
                    </thead>
                    <tbody id="content">
                        @if ($announcements->count())
                        @foreach ($announcements as $announcement)
                        <tr>
                            <td>{{{ $announcement->title }}}</td>
                            <td>
                            @if(File::exists('data/announcement/images/thumbnail/'.$announcement->image_path))
                            
                            <a href="{{--asset('data/announcement/images/'.$announcement->image_path)--}}" class="fancybox">
                            {!!HTML::image('data/announcement/images/thumbnail/'.$announcement->image_path, 'Image not found', array('id' => $announcement->id) )!!}
                            </a>
                            
                            @else
                            {!!HTML::image('assets/images/noimage.jpg', '' )!!}
                            @endif
                            </td>
                            <td>{!! date('m-d-Y', strtotime($announcement->date)) !!}
                            </td>
                            <td>{!! $announcement->location !!}</td>
                            <td>
                                <span>
                                    {!! link_to_route('announcements.edit', '', array($announcement->id), array('class' => 'adminGridLinks adminGridLinks glyphicon glyphicon-edit')) !!}
                               
                                    {!! Form::open(array('method' => 'DELETE', 'route' => array('announcements.destroy', $announcement->id), 'class' => 'adminFormWraper')) !!}
                                    {!! Form::submit('Delete', array('class' => 'adminGridLinks delete-it')) !!}
                                    {!! Form::close() !!}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                    @else
                    <li class="gridDataContent">
                        <div class="cell cw25">There are no announcements</div>
                    </li>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    <div style="float: right;">{!! str_replace('/?', '?', $announcements->render()) !!}</div>
@stop
