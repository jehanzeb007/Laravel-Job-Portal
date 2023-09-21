@extends('default.main_layout')
@section('title')    
{{Config::get('constants.site.name')}} | Job Listing
@stop
@section('header_assets')
   @parent  
   {!! HTML::style('/assets/client/css/select2.min.css') !!}
   <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAi7FJBxb4YuT_S7_YOSQbkx_k15pG29KI"></script>
@stop
@section('home')
<style type="text/css">
#map {
    height: 343px;
    width: 100%;
}
</style>
<section class="job-breadcrumb">
   <div class="container">
      <div class="row">
         <div class="col-md-6 col-sm-7 co-xs-12 text-left">
            <h3>Radial Search</h3>
         </div>
      </div>
   </div>
</section>
<section class="contact-us light-blue">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="Heading-title black">
                    <h1>Radial Search</h1>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <form class="row">
                              <div class="col-md-12 col-sm-12" id="country">
                                <div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
                                      <label>Filter By: </label>
                                      {!! Form::select('type',['jobs'=>'By Jobs','users'=>'By Users'], 'jobs', ['class'=>'form-control', 'id'=>'type', "onchange" => "selectChange(this)"])!!}
                                   </div>
                                </div>
                              <div class="col-md-12 col-sm-12" id="country">
                                <div class="form-group {{ $errors->has('country_id') ? 'has-error' : ''}}">
                                      <label>Country </label>
                                      {!! Form::select('country', $country, null, ['class'=>'form-control', 'id'=>'country', "onchange" => "selectChange(this)"])!!}
                                   </div>
                                </div>
                                <div class="col-md-12 col-sm-12" id="states">
                                   <div class="form-group {{ $errors->has('state_id') ? 'has-error' : ''}}">
                                      <label>State </label>
                                      {!! Form::select('state', $states, null, ['class'=>'form-control', 'id'=>'state','placeholder'=>'Select Option', "onchange" => "selectChange(this)"])!!}
                                   </div>
                                </div>
                                <div class="col-md-12 col-sm-12" id="cities">
                                   <div class="form-group {{ $errors->has('city_id') ? 'has-error' : ''}}">
                                      <label>City </label>
                                      {!! Form::select('city', $cities, null, ['class'=>'form-control', 'id'=>'city','placeholder'=>'Select Option', "onchange" => "selectChange(this)"])!!}
                                   </div>
                                </div>
                                <div class="col-md-12 col-sm-12" id="sub_cities">
                                   <div class="form-group {{ $errors->has('sub_city_id') ? 'has-error' : ''}}">
                                      <label>Sub City </label>
                                      {!! Form::select('sub_city', $sub_cities, null, ['class'=>'form-control', 'id'=>'sub_city','placeholder'=>'Select Option', "onchange" => "selectChange(this)"])!!}
                                   </div>
                                </div>
                                <div class="col-md-12 col-sm-12" id="sub_cities">
                                   <div class="form-group {{ $errors->has('sub_city_id') ? 'has-error' : ''}}">
                                      <label>Distance </label>
                                      {!! Form::select('radius', ['5'=>'5 KM','10'=>'10 KM', '15'=>'15 KM', '20'=>'20 KM'], null, ['class'=>'form-control', 'id'=>'radius','placeholder'=>'Select Radius', "onchange" => "selectChange(this)"])!!}
                                   </div>
                                </div>
                        </form>
                    </div>
                    <div style="display:none;">
                        {!! Form::text('latitude', null, ['class'=>'form-control', 'id'=>'latitude']) !!}
                        {!! Form::text('longitude', null, ['class'=>'form-control', 'id'=>'longitude']) !!}
                        {!! Form::text('zoom', null, ['class'=>'form-control', 'id'=>'zoom']) !!}
                    </div>
                    <div id="spinner"></div>
                    <div class="col-md-9 col-sm-6 col-xs-12">
                      <div id="map">
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('footer_assets')
   @parent
   <script>
  function selectChange(elem){

    var data = select_filters(elem);
    var location = {lat: data.latitude, lng: data.longitude};
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: data.zoom,
      center: location
    });

    var country = $("select#country").val();
    var state = $("select#state").val();
    var city = $("select#city").val();
    var sub_city = $("select#sub_city").val();
    var radius = $("select#radius").val();

    param = "country_id="+ country+"&state_id="+state+"&city_id="+city+"&sub_city_id="+sub_city+"&radius="+radius+"&lat="+data.latitude+"&long="+data.longitude+"&type="+$("select#type").val();
    var url = "{{URL::route('job_radial_search')}}?" + param;
    $.ajax({
      url: url
    }).done(function(response) {
      
      $.each(response, function (i, elem) {
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(elem.latitude, elem.longitude),
          title: elem.title,
          map: map
        });
        var infowindow = new google.maps.InfoWindow();
        var marker, i;
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
            slug = elem.slug
            if($("select#type").val() == "users"){
              title = "<a href='/home/user_detail/"+slug+"' target='_blank'>"+marker.title+"</a>"
            }else{
              title = "<a href='/home/job_detail/"+slug+"' target='_blank'>"+marker.title+"</a>"  
            }
            
            infowindow.setContent(title);
            infowindow.open(map, marker);
          }
        })(marker, i));
      })

    });
  }
  
  function select_filters(elem){
    
    var type = $(elem).attr("id");
    var value = $(elem).val();
    console.log(value)
    var geo_data =  <?php echo json_encode($lon_lat); ?>;
    zoom = 4;
    if(type == "country" && value != "" ){
      $("#state, #city, #sub_city").find('option').remove().end();
      $("#state, #city, #sub_city").append($("<option></option>").attr("value","").text("Select Option"));

      arrayFromPHP = <?php echo json_encode($states); ?>;
      selected = arrayFromPHP[value];
      $.each(selected, function (key, value) {
        $("#state").append($("<option></option>")
                .attr("value",key)
                .text(value)); 
      })
      zoom = 6;
      longitude = parseFloat(geo_data['longitude'][type][value]);
      latitude = parseFloat(geo_data['latitude'][type][value]);
    }else if( type == "state" && value != ""  ){
      
      $("#city, #sub_city").find('option').remove().end();
      $("#city, #sub_city").append($("<option></option>").attr("value","").text("Select Option"));

      arrayFromPHP = <?php echo json_encode($cities); ?>;
      selected = arrayFromPHP[value];
      $.each(selected, function (key, value) {
        $("#city").append($("<option></option>")
                .attr("value",key)
                .text(value)); 
      })
      zoom = 8;
      longitude = parseFloat(geo_data['longitude'][type][value]);
      latitude = parseFloat(geo_data['latitude'][type][value]);
    }else if( type == "city" && value != "" ){

      $("#sub_city").find('option').remove().end();
      $("#sub_city").append($("<option></option>").attr("value","").text("Select Option"));

      arrayFromPHP = <?php echo json_encode($sub_cities); ?>;
      selected = arrayFromPHP[value];
      $.each(selected, function (key, value) {
        $("#sub_city").append($("<option></option>")
                .attr("value",key)
                .text(value)); 
      })
      zoom = 11;
      longitude = parseFloat(geo_data['longitude'][type][value]);
      latitude = parseFloat(geo_data['latitude'][type][value]);
    }else if( type == "sub_city" && value != "" ){
      zoom = 13;
      longitude = parseFloat(geo_data['longitude'][type][value]);
      latitude = parseFloat(geo_data['latitude'][type][value]);
    }else if( type == "radius"){
      zoom = 11;
      if( $("select#sub_city").val() != ""){
        type = 'sub_city';
        value = $("select#sub_city").val();
      }else if( $("select#city").val() != ""){
        type = 'city';
        value = $("select#city").val();
      }else if( $("select#state").val() != ""){
        type = 'state';
        value = $("select#state").val();
      }else if( $("select#country").val() != ""){
        type = 'country';
        value = $("select#country").val();
      }else{
        type = 'none';
        geo_data['longitude'][type] = parseFloat(45);
        geo_data['latitude'][type] = parseFloat(25);
      }
      longitude = parseFloat(geo_data['longitude'][type][value]);
      latitude = parseFloat(geo_data['latitude'][type][value]);
      
    }else{
      longitude = parseFloat(45);
      latitude = parseFloat(25);
      zoom = 4;
    }
    data = {longitude:longitude,latitude:latitude,zoom:zoom}
    console.log("data",data);
    return data;
  }

  $(document).ready(function() {
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

  });

  $(document).ready(function() {
    $("select#type").trigger("change");
  });
</script>
@show
@stop