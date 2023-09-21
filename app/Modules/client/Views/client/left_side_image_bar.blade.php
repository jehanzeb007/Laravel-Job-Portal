
<div class="profile-card">
   
   <div class="user-image">
   	  @if(isset($user->image_name))
      	<img src="/assets/images/profile/thumbnail/{{$user->image_path}}" class="img-responsive img-circle" alt="" >
      @else
      	<img src="/assets/images/user.png" class="img-responsive img-circle" alt="" >
      @endif
   </div>
   <div class="card-body">
      <h3>{{$user->first_name}} {{$user->last_name}}</h3>
      @if(!empty($distance))
      <h4>Distance: <b>{{$distance}} km.</b> from you.</h4>
      @endif
   </div>

</div>
