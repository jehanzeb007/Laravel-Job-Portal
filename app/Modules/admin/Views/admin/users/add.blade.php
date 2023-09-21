@extends('layouts.layout')
@section('title')    
{{Config::get('constants.site.name')}} | Add User
@stop
@section('header_assets')
@parent
<style type="text/css">
    #cropped_pic{
        border-radius: 500%;
        padding-left: 5px;
        padding-top: 5px;
    }
</style>
@show
@section('main')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div>
            <div class="pull-left">
                <h1 class="section-title-inner">
                    <span>Add User</span>
                </h1>
            </div>
            <div class="pull-right">
                <h4 class="caps"><a href="{{route('users')}}"><i class="fa fa-chevron-left"></i> Back </a></h4>
            </div>
            <div class="clearfix"></div>
        </div>
        <hr/>
        <div class="col-sm-12 col-md-6 col-lg-6">
            {!! Form::open(['url' => route('store_user'), 'class' => 'form-horizontal','method' => 'post']) !!}
            @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
            <div class="row main-div" style='margin-left:0px;'>
                <div >
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div >
                                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                                    {!! Form::label('first_name', 'First Name ') !!}
                                    {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                                    {!! Form::text('first_name', null, ['class' => 'form-control','placeholder' => 'First Name','tabindex'=>'1']) !!}
                                </div>
                            </div>
                            <div >
                                <div class="form-group {{ $errors->has('email_address') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                                    {!! Form::label('email_address', 'Email Address ') !!}
                                    {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                                    {!! Form::text('email_address', null, ['class' => 'form-control','placeholder' => 'Email','tabindex'=>'3']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6" >
                            <div >
                                <div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                                    {!! Form::label('last_name', 'Last Name ') !!} 
                                    {!! Form::label('*', '*', ['class' => 'text-danger']) !!} 
                                    {!! Form::text('last_name', null, ['class' => 'form-control','placeholder' => 'Last Name','tabindex'=>'2']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div >
                                <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                                    {!! Form::label('password', 'Password ') !!}
                                    {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                                    {!! Form::password('password', ['class' => 'form-control','placeholder' => 'Password','tabindex'=>'7']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div >
                                <div class="form-group  {{ $errors->has('confirm_password') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                                    {!! Form::label('confirm_password', 'Confirm Password ') !!}
                                    {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                                    {!! Form::password('confirm_password', ['class' => 'form-control','placeholder' => 'Confirm Password','tabindex'=>'8']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <hr/>
            <div class="row">
                <?php  
                    
                        //echo "<pre>";print_r(\Session::get('roles'));
                       if( \Session::get('roles') ){
                           $input = \Session::get('roles');
                           if ($input == 'a') {
                                $role_names = array();
                                //echo "<pre>";print_r($role_names);exit;
                            }else{
                                $role_names = \Session::get('roles');
                                //echo "<pre>";print_r($role_names);exit;
                            } 
                           
                           //echo "<pre>";print_r($role_names);exit;
                       }
                ?> 
                <div class="col-sm-5 col-md-5 col-lg-5">
                    {!! Form::label('roles', 'Roles ') !!}
                    {!! Form::select('roles[]', $role_names, null, array('class' => 'role form-control', 'multiple'=>'true', 'style'=>'height:150px;','tabindex'=>'14')) !!}
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2">
                    {!! Form::button('>>', array('class' => 'form-control left_button primary_color','style'=>'margin-top:54px; color:white')) !!}
                    {!! Form::button('<<', array('class' => 'form-control right_button primary_color','style'=>'margin-top:20px; color:white;')) !!}

                </div>
                <?php  
                       if( \Session::get('roles_assigned') ){
                           $role_assigned = \Session::get('roles_assigned');
                       }else{
                            $role_assigned = [];
                       }
                ?> 
                <div class="col-sm-5 col-md-5 col-lg-5 {{ $errors->has('roles_assigned') ? 'has-error' : ''}}">
                      
                    {!! Form::label('roles_assigned', 'Assigned Roles ') !!}
                    {!! Form::label('*', '*', ['class' => 'text-danger']) !!}  
                    {!! Form::select('roles_assigned[]', $role_assigned, null, array('class' => 'roles_assigned form-control', 'multiple'=>'true','style'=>'height:150px;','tabindex'=>'15')) !!}
                </div>
            </div>
            <input type="hidden" id="image_name" name="image_name">
            <div class="form-group">
                <div class="col-md-offset-6 col-md-6 col-sm-6" style="padding-top:20px;">
                    {!! Form::submit('Add', ['class' => 'btn btn-primary form-control primary_color submit','tabindex'=>'16']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}

        </div>
    </div>
</div>
    

<script>
$(document).ready(function() {

$(".submit").click(function () {
    $('.roles_assigned option').prop('selected', true)
    $('.role option').prop('selected', true)
});

$(".left_button").click(function () {
    var index = $(".role option:selected").map(function () {
        return $(this).val();
    }).get().join(',');
    var option_all = $(".role option:selected").map(function () {
        return $(this).text();
    }).get().join(',');
    var  index_array = index.split(',');
    var  array = option_all.split(',');
    console.log(option_all);
    console.log(index_array);
    console.log(array);
    console.log(array.length);
    if (array!=0) {
        for (var i = 0; i <array.length; i++) {
            array[i]
            index_array[i]
            $(".roles_assigned").prepend("<option value="+index_array[i]+" selected='selected'>"+ array[i] + "</option>");
            $('.role option:selected').remove();
        };
    };
});
$(".right_button").click(function () {
    var index = $(".roles_assigned option:selected").map(function () {
        return $(this).val();
    }).get().join(',');
    var option_all = $(".roles_assigned option:selected").map(function () {
        return $(this).text();
    }).get().join(',');
    var  index_array = index.split(',');
    var  array = option_all.split(',');
    console.log(option_all);
    console.log(index_array);
    console.log(array);
    console.log(array.length);
    if (array!=0) {
        for (var i = 0; i <array.length; i++) {
            array[i]
            index_array[i]
            $(".role").prepend("<option value="+index_array[i]+" selected='selected'>"+ array[i] + "</option>");
            $('.roles_assigned option:selected').remove();
        };
    };
});
});
</script>

@stop