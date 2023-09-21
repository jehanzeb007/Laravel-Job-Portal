@extends('layouts.layout')
@section('title')
    @parent - {{ 'Login' }}
@stop

@section('login')
    class="active"
@endsection

<?php 
  \Session::forget('passResetAttempt');
?>

<style type="text/css">
  .sec-count {
    border-bottom: 1px solid #0096D7;
    color: #0096D7;
    font-family: "segoe ui";
  }
</style>

@section('content')
<div id="content">
  <div class="loginTrouble">
    <div class="login-trouble-left"> 

      <h1>Password Problems</h1>
      <h2 class="plarge-head-msg">{{ Session::get('volatile.msg') }} <br>You will be redirected to the login page automatically in <span class="sec-count">10</span><br> seconds.</h2>

    </div>
  </div>
  <div class="clear">&nbsp;</div>
   </div>
@stop

@section('footer_assets')
@parent
<script type="text/javascript">
  $(document).ready(function() { 

      var secCount = $('.sec-count');

      function secondsChanger () {
          var currCount = parseInt(secCount.text(), 10);
          currCount--;
          if(currCount < 0){
            currCount = 0;
          }
          secCount.text( currCount );
          if ( currCount <= 0 ) {
             window.location = "{{ URL::route('login') }}";
          }else{
            window.setTimeout(secondsChanger, 1000);
          }
      }
      
      window.setTimeout(secondsChanger, 1000);
  });
</script>
@stop
    