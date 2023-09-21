@foreach($users as $item)
   <div class="job-box job-box-2">
      <div class="col-md-2 col-sm-2 col-xs-12 hidden-sm">
        
           @if(!empty($item->image_path))
            <img src="/assets/images/profile/thumbnail/{{$item->image_path}}" alt="user-img" class="img-circle" width="140" style="border-radius:50%">
           @else
              <img src="/assets/images/user.png" alt="" class="img-responsive center-block"  style="border-radius:50%; width:140px;">
           @endif
       
      </div>
      <div class="col-md-10 col-sm-10 col-xs-12">
         <div class="job-title-box">
            <a href="{{route('user_detail',$item->id)}}">
               <div class="job-title"> {{$item->first_name." ".$item->last_name}}</div>
               @if(!empty($item->distance))
                <h4>Distance: <b>{{$item->distance}} km.</b> from you.</h4>
               @endif
            </a>
            @if(!empty($item->company_name))
            <span class="comp-name">{{$item->company_name}}</span>
            @else
            <span class="comp-name">{{$item->last_education}}</span>
            @endif
         </div>
         <p>{{substr($item->description,0,100)}} {{{ strlen($item->description) > 100 ? '...............' : '' }}}</p>
      </div>
   </div>
@endforeach
<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
  <div class="pagination-box clearfix">
    {{$users->links()}}
  </div>
</div>
<script>
   $(document).ready(function() {
      $(document).on('click', '.pagination a', function (e) {
          callSearch($(this).attr('href').split('page=')[1]);
         //$("a.scrollup").click();
          e.preventDefault();
      });
    });
 </script>