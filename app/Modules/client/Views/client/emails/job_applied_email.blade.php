<p>Dear <strong>{{$user_first_name.' '.$user_last_name}}</strong>,</p>

<p>{{Auth::user()->first_name.' '.Auth::user()->last_name}} has been apply on you job " {{$job_name}} ".</p>
<p>Please <a href="{{route('job_user_applied',$job_slug)}}">click here</a> for more detail.</p>

Thank You!