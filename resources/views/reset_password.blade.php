@extends('layouts.layout')

@section('title')    
{{Config::get('constants.site.name')}} | Register           
@stop
@section('main')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div>
            <div class="pull-left">
                <h1 class="section-title-inner">
                    <span>Change your Password</span>
                </h1>
            </div>
            <div class="pull-right">
                <h4 class="caps"><a href="{{route('admin_login')}}"><i class="fa fa-chevron-left"></i> Back </a></h4>
            </div>
            <div class="clearfix"></div>
        </div>
        <hr/>
        <div class="col-sm-12 col-md-6 col-lg-6">
            {!! Form::open(['url' => route('admin_reset_password'), 'class' => 'form-horizontal','method' => 'post']) !!}
            @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
            <div class="row main-div" style='margin-left:0px;'>  
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div >
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                                {!! Form::label('password', 'Password ') !!}
                                {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                                {!! Form::password('password', ['class' => 'form-control','placeholder' => 'Password','tabindex'=>'1']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div >
                            <div class="form-group {{ $errors->has('confirm_password') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                                {!! Form::label('confirm_password', 'Confirm Password ') !!}
                                {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                                {!! Form::password('confirm_password', ['class' => 'form-control','placeholder' => 'Confirm Password','tabindex'=>'2']) !!}
                                {!! Form::hidden('token', $token) !!}
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-9 col-md-3 col-sm-3" style="padding-top:20px;">
                {!! Form::submit('Reset', ['class' => 'btn btn-primary form-control primary_color submit','tabindex'=>'3']) !!}
            </div>
        </div>
        {!! Form::close() !!}

    </div>
</div>
@stop