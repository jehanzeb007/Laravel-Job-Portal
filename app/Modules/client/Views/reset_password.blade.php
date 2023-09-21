@extends('default.login_layout')

@section('login')
<style type="text/css">
   .login-container .form-control {
      text-transform: inherit;
   }
</style>

<section class="login-page-4 parallex">
   <div class="container">
      <div class="row">
         <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="login-container">
               <div class="loginbox">
                  <div class="loginbox-title" style="margin-top:10px;">Reset Password</div>
                  @if ($errors->any())
                     <ul class="alert alert-danger">
                         @foreach ($errors->all() as $error)
                         <li>{{ $error }}</li>
                         @endforeach
                     </ul>
                  @endif
                  {!! Form::open(['url' => route('reset_password'), 'class' => 'form-horizontal','method' => 'post']) !!}
                  <div class="form-group  {{ $errors->has('password') ? 'has-error' : ''}}" style="margin-top:10px;">
                     <label>Password: <span class="required">*</span></label>
                     {!! Form::password('password', array('class' => 'form-control','placeholder' => 'Enter Password')) !!}
                  </div>
                  <div class="form-group  {{ $errors->has('confirm_password') ? 'has-error' : ''}}" style="margin-bottom:67px;">
                     <label>Confirm Password: <span class="required">*</span></label>
                     {!! Form::password('confirm_password', array('class' => 'form-control','placeholder' => 'Enter Confirm password')) !!}
                  </div>
                  {!! Form::hidden('token', $token) !!}
                  <div class="loginbox-submit" >
                     {!! Form::submit('Reset', array('class' => 'btn btn-default btn-block')) !!}
                  </div>
                  {!!Form::close()!!}
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@stop