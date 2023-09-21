@extends('layouts.layout')
@section('title')    
    {{Config::get('constants.site.name')}} | Edit User
@stop
@section('header_assets')
    @parent
    {!! HTML::style('assets/public/css/footable-0.1.css') !!}
    {!! HTML::style('assets/public/css/footable.sortable-0.1.css') !!}
    <style type="text/css">
        .date-icon { position: absolute; right:10px; top: 39px; pointer-events: none;}
        .calendar .form-group { position: relative;}
    </style>
@show
@section('main')
<div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12">
      <div>
         <div class="pull-left">
            <h1 class="section-title-inner">
               <span>Edit User</span>
            </h1>
         </div>
         <div class="pull-right">
            <h4 class="caps"><a href="{{route('users')}}"><i class="fa fa-chevron-left"></i> Back </a></h4>
         </div>
         <div class="clearfix"></div>
      </div>
      <hr/>
      <div>
         {!! Form::model($user, ['method' => 'post','url' => [route('update_user'),$user->id],'class' => 'form-horizontal']) !!}
         @if ($errors->any())
         <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
         </ul>
         @endif
         <div class="row main-div" style='margin-left:0px;'>
            <div class="col-sm-12 col-md-6 col-lg-6">
               <div class="row">
                  <div class="col-sm-12 col-md-6 col-lg-6">
                     <div style="display:none;">
                        {!! Form::text('id', $user->id, ['class' => 'form-control']) !!}
                     </div>
                     <div >
                        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                           {!! Form::label('first_name', 'First Name ') !!}
                           {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                           {!! Form::text('first_name', null, ['class' => 'form-control','placeholder' => 'First Name']) !!}
                           <!--  {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!} -->
                        </div>
                     </div>
                     <div >
                        <div class="form-group {{ $errors->has('email_address') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                           {!! Form::label('email_address', 'Email Address ') !!}
                           {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                           {!! Form::text('email_address', null, ['class' => 'form-control','placeholder' => 'Email']) !!}
                           <!-- {!! $errors->first('email_address', '<p class="help-block">:message</p>') !!} -->
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-6" >
                     <div >
                        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                           {!! Form::label('last_name', 'Last Name ') !!} 
                           {!! Form::label('*', '*', ['class' => 'text-danger']) !!} 
                           {!! Form::text('last_name', null, ['class' => 'form-control','placeholder' => 'Last Name']) !!}
                           <!--  {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!} -->
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
                           {!! Form::password('password', ['class' => 'form-control','placeholder' => 'Password']) !!}
                           <!-- {!! $errors->first('password', '<p class="help-block">:message</p>') !!} -->
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-6">
                     <div >
                        <div class="form-group  {{ $errors->has('confirm_password') ? 'has-error' : ''}}"style=" margin-right: 1px;">
                           {!! Form::label('confirm_password', 'Confirm Password ') !!}
                           {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                           {!! Form::password('confirm_password', ['class' => 'form-control','placeholder' => 'Confirm Password']) !!}
                           <!-- {!! $errors->first('confirm_password', '<p class="help-block">:message</p>') !!} -->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
            </div>
         </div>
         <hr/>
            <div class="row">
                <div class="col-sm-6 col-md-3 col-lg-3">
                    {!! Form::label('roles', 'Roles ') !!}
                    {!! Form::select('roles[]', $allroles, null, array('class' => 'role form-control', 'multiple'=>'true', 'style'=>'height:150px;')) !!}
                </div>
                <div class="col-sm-2 col-md-1 col-lg-1">
                    {!! Form::button('>>', array('class' => 'form-control left_button primary_color','style'=>'margin-top:54px; color:white')) !!}
                    {!! Form::button('<<', array('class' => 'form-control right_button primary_color','style'=>'margin-top:20px; color:white;')) !!}

                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 {{ $errors->has('roles_assigned') ? 'has-error' : ''}}"> 
                    {!! Form::label('role_assigned', 'Assigned Roles') !!}
                    {!! Form::label('*', '*', ['class' => 'text-danger']) !!}
                    {!! Form::select('roles_assigned[]',$roles_assigned, null, array('class' => 'roles_assigned form-control', 'multiple'=>'true','style'=>'height:150px;')) !!}
                </div>
            </div>
         <div class="form-group">
            <div class="col-md-offset-9 col-md-3 col-sm-6">
               {!! Form::submit('Edit', ['class' => 'submit btn btn-primary form-control primary_color']) !!}
            </div>
         </div>
         {!! Form::close() !!}
      </div>
   </div>
</div>
<script>
   $( document ).ready(function() {
     $('.roles_assigned option').prop('selected', true)
     $('.role option').prop('selected', true)
   });

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
</script>

@stop