@extends('default.login_layout')
@section('header_bar')
<section class="job-breadcrumb">
  <div class="container">
     <div class="row">
        <div class="col-md-6 col-sm-7 co-xs-12 text-left">
           <h3>Sign up Page</h3>
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
                  <div class="loginbox-title">Sign Up</div>
                  @if ($errors->any())
                     <ul class="alert alert-danger">
                         @foreach ($errors->all() as $error)
                         <li>{{ $error }}</li>
                         @endforeach
                     </ul>
                  @endif
                  {!! Form::open(array('url' => route('registerStore'), 'class'=>'loginForm ')) !!}
                  <div class="form-group  {{ $errors->has('first_name') ? 'has-error' : ''}}" style="margin-top:25px;">
                     <label>First Name: <span class="required">*</span></label>
                     {!! Form::text('first_name', null, array('class' => 'form-control','placeholder' => 'Enter First Name')) !!}
                  </div>
                  <div class="form-group  {{ $errors->has('last_name') ? 'has-error' : ''}}">
                     <label>Last Name: <span class="required">*</span></label>
                     {!! Form::text('last_name', null, array('class' => 'form-control','placeholder' => 'Enter Last Name')) !!}
                  </div>
                  <div class="form-group  {{ $errors->has('email_address') ? 'has-error' : ''}}">
                     <label>Email: <span class="required">*</span></label>
                     {!! Form::text('email_address', null, array('class' => 'form-control','placeholder' => 'Enter Email')) !!}
                  </div>
                  <div class="form-group  {{ $errors->has('mobile_number') ? 'has-error' : ''}}">
                     <label>Mobile: <span class="required">*</span></label>
                     {!! Form::text('mobile_number', null, array('class' => 'form-control','placeholder' => 'Enter Mobile Number')) !!}
                  </div>
                  <div class="form-group  {{ $errors->has('registration_type') ? 'has-error' : ''}}">
                     <label>Registration type: <span class="required">*</span></label>
                     {!! Form::select('registration_type',['JobSeeker' => 'JobSeeker','Employer' =>'Employer','Both'=>'Both'],null, array('class' => 'form-control') ) !!}
                  </div>
                  <div class="form-group  {{ $errors->has('country') ? 'has-error' : ''}}">
                     <label>Country: <span class="required">*</span></label>
                     {!! Form::select('country',$country,$defaultCountry, array('id' => 'country','class' => 'form-control','onchange' => 'filterMe(this, "country")') ) !!}
                  </div>
                  <div class="form-group  {{ $errors->has('states') ? 'has-error' : ''}}">
                     <label>States: <span class="required">*</span></label>
                     {!! Form::select('states',$states,null, array('id' => 'states','placeholder'=>'Select State','class' => 'form-control', 'onchange' => 'filterMe(this, "states")') ) !!}
                  </div>
                  <div class="form-group  {{ $errors->has('city') ? 'has-error' : ''}}" {{ $errors->any() ? '' : 'style=display:none'}}>
                     <label>City: <span class="required">*</span></label>
                     {!! Form::select('city',$city,null, array('id' => 'city','placeholder'=>'Select City','class' => 'form-control','onchange' => 'filterMe(this, "city")') ) !!}
                  </div>
                  <div class="form-group  {{ $errors->has('sub_city') ? 'has-error' : ''}}" {{ $errors->any() ? '' : 'style=display:none'}}>
                     <label>Sub City: <span class="required">*</span></label>
                     {!! Form::select('sub_city',$sub_city,null, array('id' => 'sub_city','placeholder'=>'Select Sub City','class' => 'form-control','onchange' => 'filterMe(this, "sub_city")') ) !!}
                  </div>
                  <div class="form-group  {{ $errors->has('password') ? 'has-error' : ''}}">
                     <label>Password: <span class="required">*</span></label>
                     {!! Form::password('password', array('class' => 'form-control','placeholder' => 'Enter Password')) !!}
                  </div>
                  <div class="form-group  {{ $errors->has('confirm_password') ? 'has-error' : ''}}">
                     <label>Confirm Password: <span class="required">*</span></label>
                     {!! Form::password('confirm_password', array('class' => 'form-control','placeholder' => 'Enter Confirm password')) !!}
                  </div>
                  <!-- <div class="loginbox-forgot">
                     <input type="checkbox"> I accept <a href="">Term and consitions?</a>
                  </div> -->
                  <div class="loginbox-submit">
                     {!! Form::submit('Register', array('class' => 'btn btn-default btn-block')) !!}
                  </div>
                  <div class="loginbox-signup"> Already have account <a href="login">Sign in</a> </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

@stop
<script>
  function filterMe(elem, type){
    id = $(elem).val();
    $.post("/get_list",{type:type,id:id},function(data){
      select_id = '';
      if (type == "country"){
        select_id = "states";
      }else if(type == "states"){
        select_id = "city";
      }else if( type == "city"){
        select_id = "sub_city";
      }
      if(select_id != '' ){
        $("select#"+select_id).parent().show();
        $("select#"+select_id).html(data);
      }
      
    })
  }
</script>