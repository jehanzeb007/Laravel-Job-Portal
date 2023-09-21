
@extends('layouts.layout')
@section('title')    
{{Config::get('constants.site.name')}} | Change Admin Password
@stop
@section('main')
    <div>
        <div class="pull-left">
            <h1 class="section-title-inner">
                <span>Change Admin Password</span>
            </h1>
        </div>
        <div class="pull-right"><h4 class="caps"><a href="{{route('users')}}"><i class="fa fa-chevron-left"></i> Back </a></h4></div>
        <div class="clearfix"></div>
    </div>
    <hr/>

    {!! Form::open(['url' => route('store_user_password'), 'class' => 'form-horizontal','method' => 'post']) !!}
        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

    <div class="row">
        <div class="col-sm-12 col-md-3 col-lg-3">
            <div class="form-group {{ $errors->has('old_password') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                {!! Form::label('old_password', 'Old Password ') !!}
                {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                {!! Form::password('old_password',['class' => 'form-control','placeholder' => 'Old Password']) !!}
            </div>
            <div class="form-group {{ $errors->has('new_password') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                    {!! Form::label('new_password', 'New Password ') !!}
                    {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                    {!! Form::password('new_password', ['class' => 'form-control','placeholder' => 'New Password']) !!}
            </div>
            <div class="form-group  {{ $errors->has('confirm_new_password') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                    {!! Form::label('confirm_new_password', 'Confirm New Password ') !!}
                    {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                    {!! Form::password('confirm_new_password', ['class' => 'form-control','placeholder' => 'Confirm New Password']) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-2 col-md-2 col-ld-2">
            {!! Form::submit('Change Password', ['class' => 'btn btn-primary form-control primary_color']) !!}
        </div>
    </div>
@stop