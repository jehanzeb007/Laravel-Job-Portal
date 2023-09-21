@extends('layouts.layout')

@section('banners')
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
                    <span>Banners</span>
                </h1>
            </div>
            <div class="pull-right"><a class="btn btn-primary btn-small primary_color" href="{{route('banners.create')}}">+ Add new Banner</a></div>
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
                            <th><span>Banner Type</span></th>
                            <th><span>Sequence</span></th>
                            <th><span>Action</span></th>
                        </tr>
                    </thead>
                    <tbody id="content">
                        @if ($banners->count())

                        @foreach ($banners as $banner)
                        <tr>
                            <td>{!! $banner->title !!}</td>
                            <td>
                                @if(File::exists('data/banners/thumbnail/'.$banner->image_path))
                                    <a href="{!!asset('data/banners/'.$banner->image_path)!!}" class="fancybox">
                                    {!!HTML::image('data/banners/thumbnail/'.$banner->image_path, 'Image not found', array('id' => $banner->id))!!}
                                    </a>
                                @else
                                    {!!HTML::image('assets/images/noimage.jpg', '' )!!}
                                @endif
                            </td>
                            <td>{!! $banner->BannerType->type !!}</td>
                            <td>{!! !empty($banner->sequence)?$banner->sequence:'-' !!}</td>
                            <td>
                                <span>
                                    {!! link_to_route('banners.edit', '', array($banner->id), array('class' => 'adminGridLinks adminGridLinks glyphicon glyphicon-edit')) !!}
                                </span>
                                <span class="col-xs-offset-2">
                                    {!! Form::open(array('method' => 'DELETE', 'route' => array('banners.destroy', $banner->id),'class' => 'adminFormWraper')) !!}
                                    {!! Form::submit('Delete', array('class' => 'adminGridLinks delete-it')) !!}
                                    {!! Form::close() !!}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <li class="gridDataContent">
                            <div class="cell cw25">There are no Banners</div>
                        </li>

                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div style="float: right;">{!! str_replace('/?', '?', $banners->render()) !!}</div>

@stop
