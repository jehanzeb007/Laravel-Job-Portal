@extends('default.layout')
@section('title')    
{{Config::get('constants.site.name')}} | Edit Profile
@stop
@section('edit_profile')    
    class="active"
@stop
@section('top_nav')

@stop<div>@include('default.top_nav',['user'=>$user])</div>
@section('header_bar')

<section class="job-breadcrumb">
   <div class="container">
      <div class="row">
         <div class="col-md-6 col-sm-7 co-xs-12 text-left">
            <h3>Edit profile</h3>
         </div>
      </div>
   </div>
</section>
@stop
@section('body')
<style type="text/css">
   
   .profile-edit input.form-control, select.form-control {
      text-transform: inherit;
   }
</style>
{!! Form::model($user, ['method' => 'post','url' => [route('update_profile'),$user->id],'class' => 'form-horizontal','files'=>'true']) !!}
         
<section class="dashboard-body">
   <div class="container">
      <div class="row">
         <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-4 col-sm-4 col-xs-12">
               @include('client::client.left_side_image_bar',['$user'=>$user])
               @include('client::client.left_side_bar',['$user'=>$user])
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12">
               
               <div class="heading-inner first-heading">
                  <p class="title">Edit Profile</p>
               </div>
               @if ($errors->any())
                  <ul class="alert alert-danger" >
                     @foreach ($errors->all() as $error)
                     <li >{{ $error }}</li>
                     @endforeach
                  </ul>
               @endif
               <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                  <div class="profile-edit row">
                     <form>
                        <div>
                           {!! Form::hidden('id',$user->id) !!}
                        </div>
                        <div class="col-md-12 col-sm-12">
                           <div class="form-group">
                            
                            {{ Form::label('is_individual', 'Are you Individual') }}
                            @if(isset($user->company_name))
                            {!! Form::checkbox('is_individual',1,false, array('id'=>'checkbox', 'onclick'=>'handleClick(this)')) !!}
                            @else
                            {!! Form::checkbox('is_individual',1,true, array('id'=>'checkbox', 'onclick'=>'handleClick(this)')) !!}
                            @endif
                         </div>
                        </div>
                        <div class="col-md-12 col-sm-12" style="display:none" id = "company_div">
                           <div class="form-group {{ $errors->has('company') ? 'has-error' : ''}}">
                              <label>Company <span class="required">*</span></label>
                              {!! Form::text('company', $user->company_name, ['class'=>'form-control', 'id' => 'company','placeholder'=>'Company'])!!}
                           </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                           <div class="form-group {{ $errors->has('first_name') ? 'has-error' : ''}}">
                              <label>First Name <span class="required">*</span></label>
                              {!! Form::text('first_name', $user->first_name, ['class'=>'form-control','placeholder'=>'First Name'])!!}
                           </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                           <div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}" >
                              <label>Last Name <span class="required">*</span></label>
                              {!! Form::text('last_name', $user->last_name, ['class'=>'form-control','placeholder'=>'Last Name'])!!}
                           </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                           <div class="form-group {{ $errors->has('father_name') ? 'has-error' : ''}}" >
                              <label>Father Name </label>
                              {!! Form::text('father_name', $user->father_name, ['class'=>'form-control','placeholder'=>'Father Name'])!!}
                           </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                           <div class="form-group {{ $errors->has('date_of_birth') ? 'has-error' : ''}}">
                              <label>Date Of Birth </label>
                              @if($user->date_of_birth != Null)
                              <?php 
                                 list($y,$m,$d) = explode("-", $user->date_of_birth); 
                                 $date_of_birth = $m.'/'.$d.'/'.$y;

                              ?>
                              {!! Form::text('date_of_birth', $date_of_birth, ['class'=>'form-control service_date','placeholder'=>'Date of Birth'])!!}
                              @else
                                 {!! Form::text('date_of_birth', null, ['class'=>'form-control service_date','placeholder'=>'Date of Birth'])!!}
                              @endif
                              
                           </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                           <div class="form-group {{ $errors->has('email_address') ? 'has-error' : ''}}">
                              <label>Email <span class="required">*</span></label>
                              {!! Form::text('email_address', $user->email_address, ['class'=>'form-control','placeholder'=>'Email Address'])!!}
                           </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                           <div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
                              <label>Phone </label>
                              {!! Form::number('phone', $user->phone, ['class'=>'form-control','placeholder'=>'Phone'])!!}
                           </div>
                        </div>
                        <div class="col-md-6 col-sm-12" id="country">
                           <div class="form-group {{ $errors->has('country_id') ? 'has-error' : ''}}">
                              <label>Country </label>
                              {!! Form::select('country', $country, null, ['class'=>'form-control', 'id'=>'country', "onchange" => "selectChange(this,'states','state')"])!!}
                           </div>
                        </div>
                        <div class="col-md-6 col-sm-12" id="states">
                           <div class="form-group {{ $errors->has('state_id') ? 'has-error' : ''}}">
                              <label>State </label>
                              {!! Form::select('state', $states, null, ['class'=>'form-control', 'id'=>'state','placeholder'=>'Select Option', "onchange" => "selectChange(this,'cities','city')"])!!}
                           </div>
                        </div>
                        <div class="col-md-6 col-sm-12" id="cities">
                           <div class="form-group {{ $errors->has('city_id') ? 'has-error' : ''}}">
                              <label>City </label>
                              {!! Form::select('city', $cities, null, ['class'=>'form-control', 'id'=>'city','placeholder'=>'Select Option', "onchange" => "selectChange(this,'sub_cities','sub_city')"])!!}
                           </div>
                        </div>
                        <div class="col-md-6 col-sm-12" id="sub_cities">
                           <div class="form-group {{ $errors->has('sub_city_id') ? 'has-error' : ''}}">
                              <label>Sub City </label>
                              {!! Form::select('sub_city', $sub_cities, null, ['class'=>'form-control', 'id'=>'sub_city','placeholder'=>'Select Option', "onchange" => "selectChange(this,null,null)"])!!}
                           </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                           <div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
                              <label>Address </label>
                              {!! Form::text('address', $user->address, ['class'=>'form-control','placeholder'=>'Address'])!!}
                           </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                           <div class="form-group {{ $errors->has('last_education') ? 'has-error' : ''}}">
                              <label>Last Education </label>
                              {!! Form::text('last_education', $user->last_education, ['class'=>'form-control','placeholder'=>'Last Education'])!!}
                           </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                          <div class="form-group {{ $errors->has('profile_pic') ? 'has-error' : ''}}" style="margin-left:10px;">
                              <label>Profile Pic </label>
                              {!! Form::file('profile_pic', null, array('class' => 'form-control','id'=>'file_upload')) !!}
                              <div class="note"><small >Size requirements: 150 x 150 (.png,.gif, .jpeg, .jpg).</small></div>
                          </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                          <div class="form-group {{ $errors->has('cover_pic') ? 'has-error' : ''}}" style="margin-left:10px;">
                              <label>Cover Pic </label>
                              {!! Form::file('cover_pic', null, array('class' => 'form-control','id'=>'file_upload')) !!}
                              <div class="note"><small >Size requirements: 1200 x 444 (.png,.gif, .jpeg, .jpg).</small></div>
                          </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                           <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                              <label>About yourSelf </label>
                              {!! Form::textarea('description', $user->description, ['class'=>'form-control textarea','placeholder'=>''])!!}                           </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                           {!! Form::button(' Save Profile <i class="fa fa-angle-right"></i>', ['type'=>'submit', 'class'=>'btn btn-default pull-right ']) !!}
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
{!! Form::close() !!}

@section('footer')
   @parent
   <script type="text/javascript">

   function handleClick(cb) {
    if ($('#checkbox').is(':checked')) {
      $('#company_div').hide();
    }else{
      $('#company_div').show();
    }

  }

   
   function selectChange(select_name,div_name,select_change){
    
    console.log(select_name.name,div_name,select_change)
    var select_name = select_name.name;

    var index = '';

    $( "#"+select_name+" option:selected" ).each(function() {
      index = $( this ).val() ;
    });

    
    if (select_name != "sub_city") {
      if (div_name=="states") {
        var arrayFromPHP = <?php echo json_encode($states); ?>;
      }else if (div_name=="cities") {
        var arrayFromPHP = <?php echo json_encode($cities); ?>;
      }else if (div_name=="sub_cities") {
        var arrayFromPHP = <?php echo json_encode($sub_cities); ?>;
      };
      console.log("index"+index)
      if(  $("#"+select_change).has('option').length != 0  ) { 
        $("#"+select_change).find('option').remove().end();
      }
      console.log("array"+arrayFromPHP)
      
      $("#"+select_change).append($("<option></option>").attr("value","").text("Select Option"));
      if (select_name=="state") {
         $("#sub_city").append($("<option></option>").attr("value","").text("Select Option"));
      };
      $.each(arrayFromPHP, function (i, elem) {
        console.log("i"+i)
        console.log("elem"+elem)
        if (index == i) {
          $.each(elem, function (key, value) {
            console.log("key"+key+"value"+value)
         if (select_name=="state") {
            $("#sub_city").find('option').remove().end();
            $("#sub_city").append($("<option></option>").attr("value","").text("Select Option"));
         };
          $("#"+select_change).append($("<option></option>")
                .attr("value",key)
                .text(value)); 
          });
          return false;
        }else{
            if (select_name=='country') {
                  $("#state, #city, #sub_city").find('option').remove().end();
                  $("#state, #city, #sub_city").append($("<option></option>").attr("value","").text("Select Option"));
            }else if (select_name=='state') {
                  $("#city, #sub_city").find('option').remove().end();
                  $("#city, #sub_city").append($("<option></option>").attr("value","").text("Select Option"));
            }else if (select_name=='city') {
                  $("#sub_city").find('option').remove().end();
                  $("#sub_city").append($("<option></option>").attr("value","").text("Select Option"));
            };
        } 
      });
    };
  }

$(document).ready(function() {
  if (!$('#checkbox').is(':checked')) {
    $('#company_div').show();
  }

   var country_id = "";
   var state_id = "";
   var city_id = "";
   $( "#country option:selected" ).each(function() {
      country_id = $( this ).val() ;
   });
   $( "#state option:selected" ).each(function() {
      state_id = $( this ).val() ;
   });
   $( "#city option:selected" ).each(function() {
      city_id = $( this ).val() ;
   });
   $( "#sub_city option:selected" ).each(function() {
      sub_city_id = $( this ).val() ;
   });

   console.log("country_id",country_id)
   console.log("state_id",state_id)
   console.log("city_id",city_id)
   var arrayState = <?php echo json_encode($states); ?>;
   var arrayCity = <?php echo json_encode($cities); ?>;
   var arraySubCity = <?php echo json_encode($sub_cities); ?>;
   $("#state, #city, #sub_city").find('option').remove().end();
   $("#state, #city, #sub_city").find('optgroup').remove().end();
   $("#state").append($("<option></option>").attr("value","").text("Select State"));
   $("#city").append($("<option></option>").attr("value","").text("Select City"));
   $("#sub_city").append($("<option></option>").attr("value","").text("Select Sub City"));
   $.each(arrayState, function (i, elem) {
      if (country_id==i) {
         $.each(elem, function (key, value) {
            $("#state").append($("<option></option>").attr("value",key).text(value)); 
         });
      };
   });
   $.each(arrayCity, function (i, elem) {
      if (state_id==i) {
         $.each(elem, function (key, value) {
            $("#city").append($("<option></option>").attr("value",key).text(value)); 
         });
      };
   });
   $.each(arraySubCity, function (i, elem) {
      if (city_id==i) {
         $.each(elem, function (key, value) {
            $("#sub_city").append($("<option></option>").attr("value",key).text(value)); 
         });
      };
   });
   $("#state").val(state_id);
   $("#city").val(city_id);
   $("#sub_city").val(sub_city_id);


      $(".service_date" ).datepicker({dateFormat: "mm/dd/yy"});
      @if($sucess = \Session::get('success_msg'))
          showTimerMsg("{{$sucess}}",3000);
      @endif
  });
   </script>
@show

@stop