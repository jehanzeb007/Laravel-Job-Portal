@extends('layouts.layout')
@section('ads')
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
                    <span>Ads</span>
                </h1>
            </div>
            <div class="pull-right"><a class="btn btn-primary btn-small primary_color" href="{{route('ads.create')}}">+ Add new ad</a></div>
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
                            <th><span>URL</span></th>
                            <th><span>Actions</span></th>
                        </tr>
                    </thead>
                    <tbody id="content">
                        @if ($ads->count())
                        @foreach ($ads as $ad)
                        <tr>
                            <td>{!! !empty($ad->title)?$ad->title:'-' !!}</td>
                            <td>
                                @if(File::exists('data/ads/thumbnail/'.$ad->image_path))
                                <a href="{!!asset('data/ads/'.$ad->image_path)!!}" class="fancybox">
                                {!! HTML::image('data/ads/thumbnail/'.$ad->image_path, $ad->image, array('id' => $ad->id)) !!}
                                </a>
                                @else
                                {!!HTML::image('assets/images/noimage.jpg', '' )!!}
                                @endif
                            </td>
                            <td>
                                {!!link_to( $ad->link,  (strlen($ad->link)> 35)? substr($ad->link, 0, 32) . '...'  : $ad->link, array('target'=>'_blank','class' => 'adminGridLinks', 'title' => $ad->link), $secure = null)!!}
                            </td>
                            <td>
                                <span>
                                    {!! link_to_route('ads.edit', '', array($ad->id), array('class' => 'adminGridLinks glyphicon glyphicon-edit')) !!}
                                </span>
                                <span class="col-xs-offset-2">
                                    {!! Form::open(array('method' => '', 'route' => array('ads.destroy', $ad->id),'class' => 'adminFormWraper')) !!}
                                    {!! Form::submit('Delete', array('class' => 'adminGridLinks delete-it  glyphicon glyphicon-trash')) !!}
                                    {!! Form::close() !!}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <li class="gridDataContent">
                            <div class="cell cw25">There are no ads</div>
                        </li>
                            
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div style="float: right;">{!! str_replace('/?', '?', $ads->render()) !!}</div>



@stop