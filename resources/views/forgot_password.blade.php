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
                    <span>Forgot Password</span>
                </h1>
            </div>
            <div class="pull-right">
                <h4 class="caps"><a href="{{route('admin_login')}}"><i class="fa fa-chevron-left"></i> Back </a></h4>
            </div>
            <div class="clearfix"></div>
        </div>
        <hr/>
        <div class="col-sm-12 col-md-6 col-lg-6">
            {!! Form::open(['url' => route('admin_send_mail'), 'class' => 'form-horizontal','method' => 'post']) !!}
            @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
            @if (session('warning'))
              <div class="alert alert-warning">
                  {{ session('warning') }}
              </div>
            @endif
            @if (session('error'))
              <div class="alert alert-danger">
                  {{ session('error') }}
              </div>
            @endif
            <div class="row main-div" style='margin-left:0px;'>  
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                    	<div >
                            <div class="form-group {{ $errors->has('email_address') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                                {!! Form::label('email_address', 'Email Address ') !!}
                                {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                                {!! Form::text('email_address', null, ['class' => 'form-control','placeholder' => 'Email','tabindex'=>'1']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-9 col-md-3 col-sm-3" style="padding-top:20px;">
                {!! Form::submit('Send email', ['class' => 'btn btn-primary form-control primary_color submit','tabindex'=>'2']) !!}
            </div>
        </div>
        {!! Form::close() !!}

    </div>
</div>
@stop