@extends('default.layout')
@section('title')    
{{Config::get('constants.site.name')}} | Post Job
@stop
@section('header_assets')
   @parent  
   {!! HTML::style('/assets/client/css/select2.min.css') !!}
   {!! HTML::style('/assets/client/css/jquery.tagsinput.min.css') !!}
   <link rel="stylesheet" type="text/css" href="/assets/client/css/font-awesome.min.css">
   <link rel="stylesheet" href="/assets/client/css/et-line-fonts.css" type="text/css">
   <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css">
   <style type="text/css">
      .current {
          color: #FFF !important;
          background-color: #29aafe !important;
      }
      .done {
          color: #FFF !important;
          background-color: #2ECC71 !important;
      }
      .disabled {
        cursor: not-allowed !important;
        pointer-events:none;
      }
      .wizard-button{
          padding: 10px 40px;
          border: 1px solid #29aafe;
          background-color: #29aafe;
          color: #FFF !important;
          float: right;
      }
      .wizard-back{
        float: left;
      }
      input.error {
          border: 1px solid darkgrey;
      }
      html,
      body {
        height: 100%;
        width: 100%;
      }
      #map {
        height: 300px;
        width: 100%;
      }
      .form-horizontal .form-group {
          margin-right: 0px;
          margin-left: 0px;
      }
   </style>
@stop
@section('top_nav')

@stop<div>@include('default.top_nav',['user'=>$user])</div>
@section('header_bar')

<section class="job-breadcrumb">
   <div class="container">
      <div class="row">
         <div class="col-md-6 col-sm-7 co-xs-12 text-left">
            <h3>Post Job</h3>
         </div>
      </div>
   </div>
</section>
@stop
@section('body')

<section class="post-job">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        @if ($errors->any())
          <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
              <li> {{ $error }} </li>
            @endforeach
          </ul>
        @endif
        <div id="exampleBasic" class="wizard">
          <ul class="wizard-steps light-grey panel" role="tablist" >
            <li id="tab_1" class="active current" role="tab" href="#pane_1">
              <h4><span>1</span>Step</h4>
            </li>
            <li id="tab_2" role="tab" href="#pane_2">
              <h4><span>2</span>Step</h4>
            </li>
            <li id="tab_3" role="tab" href="#pane_3">
              <h4><span>3</span>Step</h4>
            </li>
          </ul>
          @if(!empty($slug))
            {!! Form::model($user, ['method' => 'post','url' => [route('update_job_post'),$slug],'class' => 'form-horizontal','files'=>'true', 'id'=>'save_job_post']) !!}
            {!! Form::hidden('job_id',$job->id) !!}
          @else
            {!! Form::open(['url'=>route('store_job_post'),'method'=>'post', 'id'=>'save_job_post'])!!}
          @endif
          
            <div style="display:none">
                {!! Form::text('tab_id', null, ['class' => 'form-control' ,'id'=>'tab_id']) !!}
            </div>
            <?php 
              $tab = \Session::get('tab');
              $categorie_id = \Session::get('categorie_id');
              if (\Session::get('country_id')!=null) {
                $country_id = \Session::get('country_id');
              }else{
                $country_id = null;
              }
              if (\Session::get('state_id')!=null) {
                $state_id = \Session::get('state_id');
              }else{
                $state_id = null;
              }
              if (\Session::get('city_id')!=null) {
                $city_id = \Session::get('city_id');
              }else{
                $city_id = null;
              }
              if (empty($tab) ) {
                $tab = 0; 
              }
              if (empty($slug) ) {
                $job_index = 0;  
              }else{
                $job_index = 1; 
              }
              if ($job->country_id!=null){
                $country_index = 1; 
              }else{
                $country_index = 0; 
              } 
              if ($job->state_id!=null){
                $state_index = 1; 
              }else{
                $state_index = 0; 
              }  
              if ($job->city_id!=null){
                $city_index = 1; 
              }else{
                $city_index = 0; 
              }  
            ?>
          <div class="wizard-content">
            
            <div id="pane_1" class="wizard-pane active" role="tabpanel">
              <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12"  id="categories">
                    <div id="categorie_container" class="form-group {{ $errors->has('categorie') ? 'has-error' : ''}}">
                        <label>Category</label>
                        @if(empty($slug))
                          {!! Form::select("categorie",$categories,null, ['class'=>'questions-category form-control select2-hidden-accessible', 'id'=>'categorie', 'type'=>'text' ,'required' ,'tabindex'=>'-1', "onchange" => "selectChange(this,'sub_categories','sub_categorie')"])!!}
                        @else
                          @if($category!=null)
                          {!! Form::select("categorie",$categories, $category->categorie_id, ['class'=>'questions-category form-control select2-hidden-accessible', 'id'=>'categorie', 'type'=>'text' ,'required' ,'tabindex'=>'-1', "onchange" => "selectChange(this,'sub_categories','sub_categorie')"])!!}
                          @else
                          {!! Form::select("categorie",$categories,null, ['class'=>'questions-category form-control select2-hidden-accessible', 'id'=>'categorie', 'type'=>'text' ,'required' ,'tabindex'=>'-1', "onchange" => "selectChange(this,'sub_categories','sub_categorie')"])!!}
                          @endif
                        @endif
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12" id="sub_categories" style="display:none">
                  <div id="sub_categorie_container" class="form-group {{ $errors->has('sub_categorie') ? 'has-error' : ''}}">
                    <label>Sub Category</label>
                    <div >
                      @if($tab==1)
                        @if($categorie_id!=null )
                        {!! Form::select("sub_categorie", $sub_categories[$categorie_id],$category->sub_categorie_id, ['class'=>'questions-category form-control select2-hidden-accessible','tabindex'=>'1', 'type'=>'text' ,'required' , 'id'=>"sub_categorie"])!!}
                        @php $sub_categorie_index = 1; @endphp
                        @else
                        {!! Form::select("sub_categorie",array(),null, ['class'=>'questions-category form-control select2-hidden-accessible','tabindex'=>'1', 'type'=>'text' ,'required' , 'id'=>"sub_categorie"])!!}
                        @php $sub_categorie_index = 1; @endphp
                        @endif
                      @elseif(empty($slug))
                        {!! Form::select("sub_categorie",array(),null, ['class'=>'questions-category form-control select2-hidden-accessible','tabindex'=>'1', 'type'=>'text' ,'required' , 'id'=>"sub_categorie"])!!}
                        @php $sub_categorie_index = 0; @endphp
                      @else

                        @if($category->categorie_id !=null && $category->sub_categorie_id)
                          {!! Form::select("sub_categorie", $sub_categories[$category->categorie_id],$category->sub_categorie_id, ['class'=>'questions-category form-control select2-hidden-accessible','tabindex'=>'1', 'type'=>'text' ,'required' , 'id'=>"sub_categorie"])!!}
                          @php $sub_categorie_index = 1; @endphp
                        @else
                          {!! Form::select("sub_categorie",array(),null, ['class'=>'questions-category form-control select2-hidden-accessible','tabindex'=>'1', 'type'=>'text' ,'required' , 'id'=>"sub_categorie"])!!}
                          @php $sub_categorie_index = 0; @endphp
                        @endif
                        
                      @endif
                      
                    </div>
                  </div> 
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                        <label>Title</label>
                        @if(empty($slug))
                          {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Title','id'=>'name', 'type'=>'text' ,'required']) !!}
                        @else
                          {!! Form::text('name', $job->name, ['class'=>'form-control', 'placeholder'=>'Title','id'=>'name', 'type'=>'text' ,'required']) !!}
                        @endif
                    </div>
                </div>
                <!-- <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group {{ $errors->has('tags') ? 'has-error' : ''}}">
                        <label>Tags</label>
                        <input name="tags" type="text" id="tags" value="{{ old('tags') }}" />
                    </div>
                </div> -->
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group {{ $errors->has('ckeditor') ? 'has-error' : ''}}">
                        <label>Details</label>
                        @if(empty($slug))
                          <textarea name="ckeditor" id="ckeditor" style ="width:100%; height:200px;"  type = "text" required >{{old('ckeditor')}}</textarea>
                        @else
                          <textarea name="ckeditor" id="ckeditor" style ="width:100%; height:200px;"  type = "text" required >{{$job->description}}</textarea>
                        @endif
                    </div>
                </div>
              </div>
             </div>
             <div id="pane_2" class="wizard-pane" role="tabpanel">
                <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-12 location" id="countries">
                      <div id="country_container" class="form-group {{ $errors->has('country') ? 'has-error' : ''}}">
                          <label>Country</label>
                          @if (empty($slug))
                            {!! Form::select('country', $country , null, ['class'=>'questions-category form-control select2-hidden-accessible', 'id'=>'country', 'type'=>'text' ,'required', "onchange" => "selectChange(this,'states','state')"])!!}
                          @else
                            {!! Form::select('country', $country , $job->country_id, ['class'=>'questions-category form-control select2-hidden-accessible', 'id'=>'country', 'type'=>'text' ,'required', "onchange" => "selectChange(this,'states','state')"])!!}
                          @endif
                          
                      </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12 location" id="states" style="display:none;">
                      <div id="state_container" class="form-group {{ $errors->has('state') ? 'has-error' : ''}}">
                          <label>State</label>
                          @if($tab==1)
                            
                            @if($country_id!=null)
                            {!! Form::select("state", $states[$country_id]  ,null, ['class'=>'questions-category form-control select2-hidden-accessible', 'id'=>'state', 'type'=>'text' ,'required', "onchange" => "selectChange(this,'cities','city')"])!!}
                            @php $country_index = 1; @endphp
                            @else
                            {!! Form::select("state", array()  ,null, ['class'=>'questions-category form-control select2-hidden-accessible', 'id'=>'state', 'type'=>'text' ,'required', "onchange" => "selectChange(this,'cities','city')"])!!}
                            @php $country_index = 0; @endphp
                            @endif
                          @elseif (empty($slug))
                            {!! Form::select('state', array(), null, ['class'=>'questions-category form-control select2-hidden-accessible', 'id'=>'state', 'type'=>'text' ,'required', "onchange" => "selectChange(this,'cities','city')"])!!}
                          @else
                            @if ($job->country_id != null && $job->state_id != null)
                            {!! Form::select('state', $states[$job->country_id], $job->state_id, ['class'=>'questions-category form-control select2-hidden-accessible', 'id'=>'state', 'type'=>'text' ,'required', "onchange" => "selectChange(this,'cities','city')"])!!}
                            @else
                            {!! Form::select('state', array(), null, ['class'=>'questions-category form-control select2-hidden-accessible', 'id'=>'state', 'type'=>'text' ,'required', "onchange" => "selectChange(this,'cities','city')"])!!}
                            @php $country_index = 0;  @endphp
                            @endif
                          @endif
                      </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12 location" id="cities" style="display:none;">
                      <div id="city_container" class="form-group {{ $errors->has('city') ? 'has-error' : ''}}">
                          <label>City</label>
                          @if($tab==1)
                            
                            @if($state_id!=null)
                            {!! Form::select("city", $cities[$state_id] ,null, ['class'=>'questions-category form-control select2-hidden-accessible', 'id'=>'city', 'type'=>'text' ,'required', "onchange" => "selectChange(this,'sub_cities','sub_city')"])!!}
                            @php $state_index = 1; @endphp
                            @else
                            {!! Form::select("city", array() ,null, ['class'=>'questions-category form-control select2-hidden-accessible', 'id'=>'city', 'type'=>'text' ,'required', "onchange" => "selectChange(this,'sub_cities','sub_city')"])!!}
                            @php $state_index = 0; @endphp
                            @endif
                          @elseif (empty($slug))
                            {!! Form::select('city', array(), null, ['class'=>'questions-category form-control select2-hidden-accessible', 'id'=>'city', 'type'=>'text' ,'required', "onchange" => "selectChange(this,'sub_cities','sub_city')"])!!}
                          @else
                            @if ($job->state_id != null && $job->city_id != null)
                            {!! Form::select('city', $cities[$job->state_id], $job->city_id, ['class'=>'questions-category form-control select2-hidden-accessible', 'id'=>'city', 'type'=>'text' ,'required', "onchange" => "selectChange(this,'sub_cities','sub_city')"])!!}
                            @else
                            {!! Form::select('city', array(), null, ['class'=>'questions-category form-control select2-hidden-accessible', 'id'=>'city', 'type'=>'text' ,'required', "onchange" => "selectChange(this,'sub_cities','sub_city')"])!!}
                            @php $state_index = 0;  @endphp
                            @endif
                          @endif
                      </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12 location" id="sub_cities" style="display:none;">
                      <div id="sub_city_container" class="form-group {{ $errors->has('sub_city') ? 'has-error' : ''}}">
                          <label>Sub City</label>
                          @if($tab==1)
                            @if($city_id!=null)
                            {!! Form::select("sub_city", $sub_cities[$city_id],null, ['class'=>'questions-category form-control select2-hidden-accessible', 'type'=>'text' ,'required', 'id'=>'sub_city', "onchange" => "selectChange(this,null,null)"])!!}
                            @php $city_index = 1; @endphp
                            @else
                            {!! Form::select("sub_city", array(),null, ['class'=>'questions-category form-control select2-hidden-accessible', 'type'=>'text' ,'required', 'id'=>'sub_city', "onchange" => "selectChange(this,null,null)"])!!}
                            @php $city_index = 0; @endphp
                            @endif
                          @elseif (empty($slug))
                            {!! Form::select('sub_city', array(), null, ['class'=>'questions-category form-control select2-hidden-accessible', 'type'=>'text' ,'required', 'id'=>'sub_city', "onchange" => "selectChange(this,null,null)"])!!}
                          @else
                            @if ($job->city_id != null && $job->sub_city_id != null)
                            {!! Form::select('sub_city', $sub_cities[$job->city_id], $job->sub_city_id, ['class'=>'questions-category form-control select2-hidden-accessible', 'type'=>'text' ,'required', 'id'=>'sub_city', "onchange" => "selectChange(this,null,null)"])!!}
                            @else
                            {!! Form::select('sub_city', array(), null, ['class'=>'questions-category form-control select2-hidden-accessible', 'type'=>'text' ,'required', 'id'=>'sub_city', "onchange" => "selectChange(this,null,null)"])!!}
                            @php $city_index = 0;  @endphp
                            @endif
                          @endif
                      </div>
                  </div>
              </div>
                <div style="display:none;">
                  @if(empty($slug))
                    {!! Form::text('latitude', old('latitude'), ['class'=>'form-control', 'id'=>'latitude']) !!}
                    {!! Form::text('longitude', old('longitude'), ['class'=>'form-control', 'id'=>'longitude']) !!}
                    {!! Form::text('zoom', old('zoom'), ['class'=>'form-control', 'id'=>'zoom']) !!}
                  @else
                    {!! Form::text('latitude', $job->latitude, ['class'=>'form-control', 'id'=>'latitude']) !!}
                    {!! Form::text('longitude', $job->longitude, ['class'=>'form-control', 'id'=>'longitude']) !!}
                    {!! Form::text('zoom', $job->zoom, ['class'=>'form-control', 'id'=>'zoom']) !!}
                  @endif
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12" id="map" style="display:none;">
                <input id="pac-input" class="controls" type="text" placeholder="Search Box">
               </div>
             </div>
             <div id="pane_3" class="wizard-pane" role="tabpanel">
                <div class="row">
                    @foreach($form as $value)
                      <?php 
                        $name = $value['name'];
                      
                      ?> 
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div id="attributes[$name]" class="form-group {{ $errors->has('$name') ? 'has-error' : ''}} forms">
                            <label>{{$value['name']}}</label>
                            {!! Form::hidden("forms[$name]",$value['id']) !!}
                            @if(empty($slug))
                            {!! Form::select("attributes[$name]",$value['children'],null, ['class'=>'questions-category form-control select2-hidden-accessible attributes','tabindex'=>'-1', 'type'=>'text' ,'required'])!!}
                            @else
                            {!! Form::select("attributes[$name]",$value['children'],$value['attribute_id'], ['class'=>'questions-category form-control select2-hidden-accessible attributes','tabindex'=>'-1', 'type'=>'text' ,'required'])!!}
                            @endif
                        </div>
                    </div>
                    @endforeach

                </div>
                  
             </div>
              
          </div>
          <div class="clearfix"></div>
          <div class="wizard-buttons">
          <a class="wizard-back wizard-button"  data-wizard="back" role="button" ,type="button">Back</a>
          <a class="wizard-next wizard-button" data-wizard="next" role="button">Next</a>
          <a class="wizard-finish hide wizard-button" data-wizard="finish" role="button">Finish</a></div>
        </div>
      </div>
      {!! Form::close() !!}
  </div>
</section>
@section('footer')
 @parent
 <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js"></script>
 <script type="text/javascript" src="/assets/client/js/jquery.tagsinput.min.js"></script>
 <script type="text/javascript">
    $(".questions-category").select2({
        placeholder: "Select option",
        allowClear: true,
        maximumSelectionLength: 3,
        /*width: "50%",*/
    });
    $('#tags').tagsInput({
        width: 'auto'
    });
 </script>
 <script>
  
 

  function selectChange(select_name,div_name,select_change){
    
    console.log(select_name.name,div_name,select_change)
    var select_name = select_name.name;

    var index = '';

    $( "#"+select_name+" option:selected" ).each(function() {
      index = $( this ).val() ;
    });

    if (select_name != "categorie"&&select_name != "sub_categorie") {

      $('#map').show();
      var zoom = null;
      var longitude_latitude =  <?php echo json_encode($lon_lat); ?>;
      console.log("lon_lat"+longitude_latitude)
      var longitude = null;
      var latitude = null;
      if (index==0) {
        if (select_name=="country") {
          longitude = 0;
          latitude = 0;
          //$('#map').hide();
          zoom = 1;
        }else if(select_name=="state"){
          var country_id = $('#country').val();
          longitude = parseFloat(longitude_latitude['longitude']['country'][country_id]);
          console.log('longitude',longitude)
          latitude = parseFloat(longitude_latitude['latitude']['country'][country_id]);
          zoom = 4;
        }else if(select_name=="city"){
          var state_id = $('#state').val();
          longitude = parseFloat(longitude_latitude['longitude']['state'][state_id]);
          latitude = parseFloat(longitude_latitude['latitude']['state'][state_id]);
          zoom = 6;
        }else if(select_name=="sub_city"){
          var city_id = $('#city').val();
          longitude = parseFloat(longitude_latitude['longitude']['city'][city_id]);
          latitude = parseFloat(longitude_latitude['latitude']['city'][city_id]);
          zoom = 11;
        }

      }else{
        longitude = parseFloat(longitude_latitude['longitude'][''+select_name+''][index]);
        latitude = parseFloat(longitude_latitude['latitude'][''+select_name+''][index]);
        console.log("lon"+longitude_latitude['longitude'][''+select_name+''][index])
        console.log("lat"+longitude_latitude['latitude'][''+select_name+''][index])
        if (select_name=="country") {
          zoom = 4;
        }else if (select_name=="state") {
          zoom = 6;
        }else if (select_name=="city") {
          zoom = 11;
        }else if (select_name=="sub_city") {
          zoom = 13;
        };
      };

      $('#longitude').val(longitude);
      $('#latitude').val(latitude);
      $('#zoom').val(zoom);

      var location = {lat: latitude, lng: longitude};
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: zoom,
        center: location
      });
      var marker = new google.maps.Marker({
          position: new google.maps.LatLng(location),
          title: 'Marker',
          map: map,
          draggable: false
      });
    };
    if (select_name != "sub_city") {
      if (div_name=="states") {
        var arrayFromPHP = <?php echo json_encode($states); ?>;
      }else if (div_name=="cities") {
        var arrayFromPHP = <?php echo json_encode($cities); ?>;
      }else if (div_name=="sub_cities") {
        var arrayFromPHP = <?php echo json_encode($sub_cities); ?>;
      }else if (div_name=="sub_categories") {
        var arrayFromPHP = <?php echo json_encode($sub_categories); ?>;
      };
      console.log("index"+index)
      if(  $("#"+select_change).has('option').length != 0  ) { 
        $("#"+select_change).find('option').remove().end();
      }
      console.log("array"+arrayFromPHP)
      
      $("#"+select_change).append($("<option></option>")
                .attr("value","")
                .text("")); 
      $.each(arrayFromPHP, function (i, elem) {
        console.log("i"+i)
        console.log("elem"+elem)
        if (index == i) {
          
          $("#"+div_name).show();
          $.each(elem, function (key, value) {
            console.log("key"+key+"value"+value)
          $("#"+select_change).append($("<option></option>")
                .attr("value",key)
                .text(value)); 
          });
          return false;
        }else{
          if (div_name=='sub_categories') {
            $("#sub_categories").hide();
          }else{
            $(".location").hide();
            if (div_name=='states') {
              $("#countries").show();
              $("#state").val("");
              $("#city").val("");
              $("#sub_city").val("");
            }else if (div_name=='cities') {
              $("#countries").show();
              $("#states").show();
              $("#city").val("");
              $("#sub_city").val("");
            }else if (div_name=='sub_cities') {
              $("#countries").show();
              $("#states").show();
              $("#cities").show();
              $("#sub_city").val("");
            };
          } 
        } 
      });
    };
    

     $.ajax({
      type: 'GET',
      url: '{{route("get_states")}}/?id='+index,           
      success: function(data)
                {
                  //alert("Do whatever you want if the call completed successfully")
                }           
     });
  }

  $(document).ready(function() {
    console.log('xyz');
      if ({{$job_index}}==1 || {{$tab}}>0) {

      var longitude = parseFloat($('#longitude').val());
      var latitude = parseFloat($('#latitude').val());
      var zoom = parseInt($('#zoom').val());
      
      var location = {lat: latitude, lng: longitude};
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: zoom,
        center: location
      });
      // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        // custom code google map start marker
var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
        // custom code google map end marker

        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -33.8688, lng: 151.2195},
          zoom: 13,
          mapTypeId: 'roadmap'
        });
        
      //var marker = new google.maps.Marker({
      //    position: new google.maps.LatLng(location),
      //    title: 'Marker',
      //    map: map,
       //   draggable: true
     // });

      $('#map').show();
      if ({{$country_index}}==1) {
        $("#states").show();
      }else{
        $("#states").hide();
      };
      if ({{$state_index}}==1) {
        $("#cities").show();
      }else{
        $("#cities").hide();
      };
      if ({{$city_index}}==1) {
        $("#sub_cities").show();
      }else{
        $("#sub_cities").hide();
      }; 
      if ({{$sub_categorie_index}}==1) {
        $("#sub_categories").show();
      }else{
        $("#sub_categories").hide();
      };
      
      };

      if ({{$tab}}==1) {

        if ($("#state").length > 0) {
          $("#states").show();
        };
        if ($("#city").length > 0) {
          $("#cities").show();
        };
        if ($("#sub_city").length > 0) {
          $("#sub_cities").show();
        }; 
        if ($("#sub_categorie").length > 0) {
          
          $("#sub_categories").show();
        };
        if ($("#longitude").length > 0) {
          $("#map").show();
        };
      };  

    function tab1(e){
      $('#tab_1,#tab_2,#tab_3').removeAttr('class');
      $('#tab_1').tab('show');
      $('#tab_1').addClass("current");
      $('.wizard-next').removeClass("hide");
      $('.wizard-finish, .wizard-back').addClass("hide");
      $('html,body').animate({
        scrollTop: $("#tab_1").offset().top},
        'slow');  
    }

    function tab2(e){
      $('#tab_1,#tab_2,#tab_3').removeAttr("class");
      $('#tab_2').tab('show');
      $('#tab_1').addClass("done");
      $('#tab_2').addClass("current");
      $('.wizard-next, .wizard-back').removeClass("hide");
      $('.wizard-finish').addClass("hide");     
      $('html,body').animate({
        scrollTop: $("#tab_1").offset().top},
        'slow');  
    }
    function tab3(e){
      $('#tab_1,#tab_2,#tab_3').removeAttr('class');
      $('#tab_3').tab('show');
      $('#tab_1').addClass("done");
      $('#tab_2').addClass("done");
      $('#tab_3').addClass("current");
      $('.wizard-next').addClass("hide");
      $('.wizard-finish, .wizard-back').removeClass("hide");
      $('html,body').animate({
        scrollTop: $("#tab_1").offset().top},
        'slow');  
    }
    tab1()
    $( ".wizard-next" ).click(doClick);
    $( ".wizard-finish" ).click(doClick);
    $( ".wizard-back" ).click(back);

    function validate1(e){
      var categorieError = $( '#categorie-error' );
      var sub_categorieError = $( '#sub_categorie-error' );
      categorieError.appendTo( categorieError.parent() );
      sub_categorieError.appendTo( sub_categorieError.parent() );
    }

    function validate2(e){
      var countryError = $('#country-error');
      var stateError = $('#state-error');
      var cityError = $('#city-error');
      var subCityError = $('#city-error');
      countryError.appendTo( countryError.parent() );
      cityError.appendTo( cityError.parent() );
      stateError.appendTo( stateError.parent() );
      subCityError.appendTo( subCityError.parent() );
    }

  function doClick(e) {
    
    var numitems =  $(".wizard-steps li").length;
      var id;
      $( ".wizard-steps li" ).each(function( index ) {
        
        index++
        if ($( "#pane_"+index ).hasClass("active" )) {
            id = index;
        };
      });
    $("#tab_id").val(id);
    //alert(id)
    if (id==1) {
        var validate = $('#name, #ckeditor, #categorie, #sub_categorie:visible').valid();
        validate1()
        if ( validate == true) {
          tab2() 
        };
        console.log()
        //
    }else if (id==2) {
      var validate = $('#country, #state:visible, #city:visible, #sub_city:visible').valid();
      validate2()
      if (validate== true) {
        tab3()
      };
    }else if (id==3) {
      var validate = $('#save_job_post').valid();
      /*var items = document.getElementsByClassName('attributes');
      for (var i = 0; i < items.length; i++){
        console.log(items[i].name);
        var name = items[i].name;
        $('<label class="error">This field is required.</label>').appendTo("#"+name+"");
        //console.log('Error name',$("#"+name+"-error").parent())
      }
      console.log('Name',name)  */
      
      validate1()
      validate2()
      if (validate==true) {
        $('#save_job_post').submit();
      };
    };
  };

  function back(e){
      var numitems =  $(".wizard-steps li").length;
      var id;
      $( ".wizard-steps li" ).each(function( index ) {
        index++
        if ($( "#tab_"+index ).hasClass("current" )) {
            console.log( index + ": " + $( this ).text() );
            id = index;
        };
      });
      id = id-1;
      //alert(id)
      if (id==1) {
        tab1()
      }else if (id==2) {
        tab2()
      }else if (id==3) {
        tab3()
      }

    };
    $(".wizard-steps li").click(function(e){
        e.preventDefault();
        console.log(this.id);
        $(this).tab('show');
        if (this.id =='tab_1') {
          tab1()
        }else if (this.id =='tab_2') {
          tab2()
        }else if (this.id =='tab_3') {
          tab3()
        }
        
    });
    
  });
</script>
<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAi7FJBxb4YuT_S7_YOSQbkx_k15pG29KI">
</script>
@show

@stop