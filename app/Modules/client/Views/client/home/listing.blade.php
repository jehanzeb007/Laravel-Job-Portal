@foreach($job as $item)
   <div class="job-box job-box-2">
      <div class="col-md-2 col-sm-2 col-xs-12 hidden-sm">
         <div class="comp-logo">
            <!-- <a href=""><img src="/assets/client/images/company/5.png" class="img-responsive" alt="scriptsbundle"> </a> -->
            <div class="col-md-2 col-sm-6 col-xs-6">
               @if(isset($item->category))
               <div class="company-img"  style="text-align:center; height:100px; width:150px; border: 1px solid #F1F1F1 !important;  box-sizing: border-box;" >
                   <!-- <img src="images/company/logo2.png" alt=""> -->
                   <i style="font-size: 95px; color:#29aafe;" class="{{$item->category}}"></i>
               </div>
               @else
                  <div class="company-img"  style="text-align:center; height:100px; width:150px; border: 1px solid #F1F1F1 !important;  box-sizing: border-box;" >
                   <i style="font-size: 95px; color:#29aafe;" class="fa fa-graduation-cap"></i>
               </div>
               @endif
           </div>
         </div>
      </div>
      <div class="col-md-10 col-sm-10 col-xs-12">
         <div class="job-title-box">
            <a href="{{route('job_detail',$item->slug)}}">
               <div class="job-title"> {{$item->name}}</div>
            </a>
            @if(isset($item->company_name))
            <a ><span class="comp-name">{{$item->company_name}}</span></a>
            @else
            <a ><span class="comp-name">{{$item->first_name}} {{$item->last_name}}</span></a>
            @endif
            @if(!empty($item->attribute['Job Timing']))
              <a  class="job-type jt-full-time-color"> <i class="fa fa-clock-o"></i> {{$item->attribute['Job Timing']}} </a>
            @endif
            
         </div>
         <p>{{substr($item->description,0,100)}} {{{ strlen($item->description) > 100 ? '...............' : '' }}}<!-- .......<a href="">Read More</a> --> </p>
      </div>
      <div class="job-salary"> <i class="fa fa-money"></i> ${{!empty($item->attribute['Price Range']) ? $item->attribute['Price Range'] : '0'}} </div>
   </div>

   
@endforeach
<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
  <div class="pagination-box clearfix">
    {{$job->links()}}
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