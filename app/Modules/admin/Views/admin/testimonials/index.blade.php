@extends('layouts.layout')
@section('testimonials')
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
                    <span>Testimonials</span>
                </h1>
            </div>
            <div class="pull-right"><a class="btn btn-primary btn-small primary_color" href="{{route('testimonials.create')}}">+ Add new Testimonial</a></div>
            <div class="clearfix"></div>
        </div>
        <hr/>
        <div class="row userInfo">
            <div class="col-xs-12 col-sm-12">
                <table class="footable footable-loaded tablet breakpoint">
                    <thead>
                        <tr>
                            <th><span>Logo</span></th>
                            <th><span>Sequence</span></th>
                            <th><span>Action</span></th>
                        </tr>
                    </thead>
                    <tbody id="content">
                        @if ($testimonials->count())
                        @foreach ($testimonials as $testimonial)
                        <tr>
                            <td>
                                @if(File::exists('data/testimonial/images/thumbnail/'.$testimonial->image_path))
                                <a href="{{asset('data/testimonial/images/'.$testimonial->image_path)}}" class="fancybox">
                                {!!HTML::image('data/testimonial/images/thumbnail/'.$testimonial->image_path, '', array('id' => $testimonial->id))!!}
                                </a>    
                                @else
                                    {!!HTML::image('assets/images/noimage.jpg', '' )!!}
                                @endif
                            </td>
                            <td>{!! $testimonial->sequence !!}</td>
                             <td>
                                <span>
                                    {!! link_to_route('testimonials.edit', '', array($testimonial->id), array('class' => 'adminGridLinks glyphicon glyphicon-edit')) !!}
                                </span>
                                <span class="col-xs-offset-2">
                                    {!!Form::open(array('method' => 'DELETE', 'route' => array('testimonials.destroy', $testimonial->id),'class' => 'adminFormWraper')) !!}
                                    {!! Form::submit('Delete', array('class' => 'adminGridLinks delete-it')) !!}
                                    {!!Form::close() !!}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <li class="gridDataContent">
                            <div class="cell cw25">There are no testimonials</div>
                        </li>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div style="float: right;">{!! str_replace('/?', '?', $testimonials->render()) !!}</div>

@stop
