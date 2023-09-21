@extends('default.login_layout')
@section('title')    
{{Config::get('constants.site.name')}} | Login
@stop
@section('header_bar')
<section class="job-breadcrumb">
  <div class="container">
     <div class="row">
        <div class="col-md-6 col-sm-7 co-xs-12 text-left">
           <h3>Login Page</h3>
        </div>
     </div>
  </div>
</section>
@stop
@section('login')
<style type="text/css">
   .login-container .form-control {
      text-transform: inherit;
   }
   .parallex::before {
      background: #f4f7fa;
   }
</style>

<section class="login-page-4 parallex">
   <div class="container">
      <div class="row">
         <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="login-container">
               <div class="loginbox">
                  <img style="margin-bottom:5px; width: 123px;" src="/assets/images/logo.png" alt="logo" class="img-responsive center-block">
                  <div class="loginbox-title">Sign In</div>
                  @if ($errors->any())
                     <ul class="alert alert-danger">
                         @foreach ($errors->all() as $error)
                         <li>{{ $error }}</li>
                         @endforeach
                     </ul>
                  @endif
                  
                  @if (session('status'))
                      <div class="alert alert-success">
                          {{ session('status') }}
                      </div>
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
                  {!! Form::open(array('url' => route('loginStore'), 'class'=>'loginForm ')) !!}
                  <div class="form-group  {{ $errors->has('email_address') ? 'has-error' : ''}}" style="margin-top:25px;">
                     <label>Email: <span class="required">*</span></label>
                     {!! Form::text('email_address', null, array('class' => 'form-control','placeholder' => 'Enter email')) !!}
                  </div>
                  <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
                     <label>Password: <span class="required">*</span></label>
                     {!! Form::password('password', array('class' => 'form-control','placeholder' => 'Enter password')) !!}
                  </div>
                  <div class="loginbox-forgot">
                     <a href="forgot_password">Forgot Password?</a>
                  </div>
                  <div class="loginbox-submit">
                     {!! Form::submit('Login', array('class' => 'btn btn-default btn-block')) !!}
                  </div>
                  <div class="loginbox-signup">
                     <a href="/register">Sign Up With Email</a>
                  </div>
                  <!-- @if(\Session::get('attempts')>3)
                  <div class="col-xs-12 col-sm-12 col-md-12" style="padding-left:0px;">
                     <div class="form-group">
                        {!! app('captcha')->display()!!}
                     </div>
                  </div>
                  <div class="g-recaptcha" data-sitekey="6LfMBw8UAAAAAM37x_eNzPVuFFso7G3jjLMzCGCy"></div>
                  @endif -->
                  {!!Form::close()!!}
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@stop