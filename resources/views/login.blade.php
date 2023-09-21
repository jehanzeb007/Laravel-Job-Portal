@extends('layouts.layout')

@section('title')    
{{Config::get('constants.site.name')}} | Login           
@stop
@section('main')

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
<style type="text/css">
	.center {
     float: none;
     margin-left: auto;
     margin-right: auto;
}
.login_bg {
    background: url(../assets/images/login_bg.png) left top repeat-y;

    padding: 55px 75px 62px 20px;
}
.login_top {
    background: url(../assets/images/login_top.png) left top no-repeat;
    padding-top: 7px;
}
.login_bottom {
    background: url(../assets/images/login_bottom_bg.png) left bottom no-repeat;
    padding-bottom: 6px;
}
label.error{
	font-weight: normal;
}
</style>
<div class="row">
    <div class="col-lg-7 col-md-7 col-sm-7 center">
    	<div class="login_top">
    		<div class="login_bottom">
		    	<div class="login_bg">
		    		<div class="col-lg-10 col-md-10 col-sm-10">
			    		@if ($errors->any())
	                    <div class="error">
	                        <ul>
	                        	<!-- {!! $errors->first('g-recaptcha-response','<p class="alert alert-danger">:message</p>')!!} -->
	                            {!! implode('', $errors->all('
	                            <li><label class="error">:message</label></li>
	                            ')) !!}
	                        </ul>
	                    </div>
	                    @endif
	                    @if(isset($status) && $status = "error")
	                        <div class="error">
	                        	<label class="error">{!! $message !!}</label>
	                        </div>
	                    @endif
			    		<h1>Sign In</h1>
					    {!! Form::open(array('url' => route('admin_loginPost'), 'class'=>'loginForm ')) !!}
					    <div class="form-group">
						    <label class="control-label">Email</label>
						    {!! Form::text('email_address', null, array('class' => 'form-control','placeholder' => 'Enter email')) !!}
						</div>
						<div class="form-group">
							<label class="control-label">Password</label>
					    	{!! Form::password('password', array('class' => 'form-control','placeholder' => 'Enter password')) !!}
					    </div>
					    <h2 class="block-title-2">
					    	<a href="{{route('admin_forgot_password')}}" class="pull-right">Forgot Your Password?</a>
					    	 <div style="clear:both"></div>
					    </h2>
					    <div class="form-group">
						    {!! Form::submit('Sign In', array('class' => 'btn btn-primary primary_color')) !!}
						    <!-- <a href="/register" style="float:right">Register your account</a> -->
						    <div style="clear:both"></div>
						</div>
					    <label for="checkboxes-0">
							<input name="checkboxes" id="checkboxes-0" value="1" type="checkbox">
 							Keep Me Logged In
 						</label>
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
					<div style="clear:both"></div>
			   	</div>
			</div>
		</div>
	   	<div style="clear:both"></div>
        <!--/row end-->
    </div>
</div>
<div style="clear:both"></div>
@stop