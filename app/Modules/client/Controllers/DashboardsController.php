<?php 

namespace App\Modules\client\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Req;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\State, App\Models\City, App\Models\Sub_City, App\Models\Country, App\Models\Job_Applied, App\Models\Job_Categorie;
use App\Models\Job, App\Models\Categorie, App\Models\Resume, App\Models\Chat, App\Models\Contract, App\Models\Job_Invite;
use App\Models\General;
use App\Helpers\Location, App\Helpers\TimeSpan;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

use Mail;
use DB;
class DashboardsController extends Controller {

    protected $limit;
    protected $count;

    public function __construct(){
        $this->limit = 6;
        $this->count = 0;
    }

    public function index() {
    	$user = Auth::user();
        $sub_city = Sub_City::where('id','=',$user->sub_city)->first();
        $city = City::where('id','=',$user->city)->first();
        $state = State::where('id','=',$user->state)->first();
        $country = Country::where('id','=',$user->country)->first();
        $count = Job_Applied::where('user_id',$user->id)->count();
        $job_posted = Job::where('user_id',$user->id)->count();
    	//echo "<pre>";print_r($job_posted);exit;
    return view('client::client.dashboards.dashboard',compact('user','sub_city','city','state','country','count','job_posted'));
    }
    
    public function edit() {

        $user = Auth::user();
        //echo "<pre>"; print_r(public_path('assets\images\profile\thumbnail/'.$user->image_path));exit;
        $location = new Location();
        list($lon_lat, $country, $states, $cities, $sub_cities) = $location->locations();
        //echo "<pre>";print_r($user->date_of_birth);exit;
        return view('client::client.dashboards.edit', compact('user','cities','sub_cities','states','country','lon_lat'));
    }

    public function update(Request $request) {
        //echo "<pre>";print_r($request->all());exit;
        $allData = $request->all();
        if (isset($allData['is_individual'])) {
            $validationArray = [
            'first_name' => 'required', 
            'last_name' => 'required',
            'email_address' =>  'required|email|max:255|unique:users,email_address,'.$allData['id'],
            /*'profile_pic' =>  'required|Image|mimes:jpeg,jpg,gif,png|max:3000',
            'cover_pic' =>  'required|Image|mimes:jpeg,jpg,gif,png|max:3000'*/
            ];
        }else{
            $validationArray = [
            'first_name' => 'required', 
            'last_name' => 'required',
            'company' => 'required',
            'email_address' =>  'required|email|max:255|unique:users,email_address,'.$allData['id'],
            /*'profile_pic' =>  'required|Image|mimes:jpeg,jpg,gif,png|max:3000',
            'cover_pic' =>  'required|Image|mimes:jpeg,jpg,gif,png|max:3000'*/
            ];
        }
 
        $this->validate($request, $validationArray);
        
        if(!empty($allData['date_of_birth'])){
            list($m,$d,$y) = explode("/", $allData['date_of_birth']);
            $allData['date_of_birth'] = $y.'-'.$m.'-'.$d;
        }else{
            $allData['date_of_birth'] = null;     
        }
        

        $user = User::findOrFail($allData['id']);
        $user->first_name = $allData['first_name'];
        $user->last_name = $allData['last_name'];
        $user->father_name = $allData['father_name'];
        $user->email_address = $allData['email_address'];
        $user->date_of_birth = $allData['date_of_birth'];
        $user->phone = $allData['phone'];
        $user->last_education = $allData['last_education'];
        $user->address = $allData['address'];
        $user->description = $allData['description'];
        

        if($request->file('profile_pic')){
            $file = $request->file('profile_pic');
            $orignialPath = 'assets/images/profile';
            $thumbnailPath = $orignialPath.'/thumbnail';

            //Upload image
            $imageData = General::uploadImage($file, $orignialPath);
            //Resizing image to thumbnail icon
            General::resizeImage($orignialPath, $imageData['image_stored_name'], $thumbnailPath, 150, 150, false);
            $user->image_name =  $imageData['image_name'];
            $user->image_path =  $imageData['image_stored_name'];
        }

        if($request->file('cover_pic')){
            $file_cover = $request->file('cover_pic');
            $mainPath = 'assets/images/cover';
            $thumbnailsPath = $mainPath.'/thumbnail';
            //Upload Cover image
            $imageData = General::uploadImage($file_cover, $mainPath);
            //Resizing image to thumbnail icon
            General::resizeImage($mainPath, $imageData['image_stored_name'], $thumbnailsPath, 1200, 444, true);
            $user->cover_image_name =  $imageData['image_name'];
            $user->cover_image_path =  $imageData['image_stored_name'];
        }
        if (!isset($allData['is_individual'])) {
            $user->company_name = $allData['company'];
        }else{
            $user->company_name = null;
        }
        if ($allData['country']==null) {
            $user->country = 0;
        }else{
            $user->country = $allData['country'];
        }
        if ($allData['state']==null) {
            $user->state = 0;
        }else{
            $user->state = $allData['state'];
        }
        if ($allData['city']==null) {
            $user->city = 0;
        }else{
            $user->city = $allData['city'];
        }
        if ($allData['sub_city']==null) {
            $user->sub_city = 0;
            $user->latitude = null;
            $user->longitude = null;
        }else{
            $user->sub_city = $allData['sub_city'];
            $sub_city = Sub_City::where("id","=", $allData['sub_city'])->first();
            if(!empty($sub_city)){
                $user->latitude = $sub_city->latitude;
                $user->longitude = $sub_city->longitude;
            }
        }
        $user->save();
        \Session::flash('flash_message', 'Profile updated!');
        return redirect(route('client_user_profile'));
    }

    public function resumeList() {
        
        $user = Auth::user();
        $resumes = Resume::where("user_id","=",$user->id)->orderBy('created_at','desc')->get();
        //echo "<pre>";print_r($resume_list);exit;
        return view('client::client.dashboards.resume_list',compact('user','resumes'));
    }

    public function updateResume(Request $request) {

        //echo "<pre>";print_r($request->all());exit;
            $allData = $request->all();
            $file = $request['doc'];
            //echo "<pre>";print_r($file);exit;

            $validationArray = 
            [
                'title' => 'required',
                'doc' => 'required|mimes:pdf,doc,docx|max:40000'
            ];

            $validator = Validator::make($request->all(), $validationArray);
            if($validator->fails()){
                \Session::flash('validate_fails',1);
                return redirect(route('resume_list'))->withErrors($validator)->withInput(\Input::all());
            }   

            //cho "<pre>";print_r($error);exit;
            if (\Input::hasFile('doc')) {

                //get image name and rename
                $imageName = $file->getClientOriginalName();
                $imageStoredName = date('YmdHis') . '-' . $imageName;
                //echo "<pre>";print_r($imageStoredName);exit;
                $destinationPath = 'assets/resume';
                $file->move($destinationPath,$imageStoredName);
                
                $user = Auth::user();

                $resume = new Resume;
                $resume->title = $allData['title'];
                $resume->path = $imageStoredName;
                $resume->user_id = $user->id;

                $resume->save();

                return redirect(route('resume_list'));
            }
    }

    public function getDownload($id){
        $resume = Resume::findOrFail($id);
        $path = $resume->path;
        
        $file=  public_path()."/assets/resume/".$path;
        //echo "<pre>";print_r($file);exit;
        $headers = array(
              'Content-Type: application/pdf',
              'Content-Type: application/msword',
            );

        return \Response::download($file, $path, $headers);
    }

    public function getResume($path){
        
        $file=  public_path()."/assets/jobApplied/resume/".$path;
        //echo "<pre>";print_r($file);exit;
        $headers = array(
              'Content-Type: application/pdf',
              'Content-Type: application/msword',
            );

        return \Response::download($file, $path, $headers);
    }


    public function destroyResume($id)
    {   
        $resume = Resume::findOrFail($id);
        $path = $resume->path;
        $file=  public_path()."/assets/resume/".$path;
        //unlink($file);
        //echo "<pre>";print_r($file);exit;
        $resume->delete();

        \Session::flash('flash_message', 'Resume deleted!');

        return redirect('dashboard/resume_list');
    }

    public function jobApplied() {
        $user = Auth::user();

        if($user->user_type == "Employer"){
            return redirect(route('client_user_profile'));
        }
        $count = Job_Applied::where('user_id',$user->id)->count();
        $jobs_applied = Job_Applied::where('user_id',$user->id)->orderBy('created_at','desc')->get();
        //echo "<pre>";print_r($jobs_applied->toArray());exit;
        $job_applied = array();
        $jobStatus = [];
		foreach ($jobs_applied as $key => $value) {
            $where="";
            $where .= " ( placement_options like '%dashboard_job_applied%') AND  1 = 1 ";
            $attribute = Job::getJopAttributes($where, $value);
            $job_category = Job_Categorie::where('job_id','=',$value->job_id)->first();
            $category = Categorie::where('id','=',$job_category['categorie_id'])->first();
            $job =  Job::where('id','=',$value->job_id)->first()->toArray();
            
			$jobStatus[$value->job_id] = $job['is_completed'];
			
			$contract = Contract::where('job_id','=',$value->job_id)->where('user_id', '=',$user->id)->first();
            $invited = Job_Invite::where('job_id','=',$value->job_id)->where('user_id', '=',$user->id)->first();
            $job_applied[$key] = $job;
            $job_applied[$key]['job_applied_id'] = $value->id;
            if(!empty($invited)){
                $job_applied[$key]['invited'] = Job_Invite::where('job_id','=',$value->job_id)->where('user_id', '=',$user->id)->first();
            }else{
                $job_applied[$key]['invited'] = null;
            }
            $job_applied[$key]['contract'] = $contract;
            $job_applied[$key]['user'] = User::where('id','=',$job['user_id'])->first();
            $job_applied[$key]['category'] = $category['icon'];
            $job_applied[$key]['attribute'] = $attribute;
            //echo "<pre>";print_r($job_applied);exit;
        }
        //echo "<pre>";print_r($job_applied);exit;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $col = new Collection($job_applied); 
        //$job_applied = $col->paginate($this->limit);
        $perPage = 5;
        $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all(); 
        //echo "<pre>";print_r($currentPageSearchResults);exit;
        $entries = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);

	
    return view('client::client.dashboards.job_applied_list',compact('user','count','job_applied','entries','jobStatus'));
    }

    public function jobPosted() {
		$user = Auth::user();
        if($user->user_type == "JobSeeker"){
            return redirect(route('client_user_profile'));
        }
        $count = Job::where('user_id',$user->id)->count();
        $job_posted = Job::where('user_id',$user->id)->orderBy('created_at','desc')->paginate($this->limit);
        foreach ($job_posted as $key => $value) {
            $where="";
            $where .= " ( placement_options like '%dashboard_job_posted%') AND  1 = 1 ";
            $attribute = Job::getJopAttributes($where, $value);
            $job_category = Job_Categorie::where('job_id','=',$value->id)->first();
            //echo "<pre>";print_r($job_category);exit;
            $category = Categorie::where('id','=',$job_category['categorie_id'])->first();
            $job_posted[$key]['category'] = $category['icon'];
            $job_applied_count = Job_Applied::where('job_id',$value->id)->count();
            $job_posted[$key]['count'] = $job_applied_count;
            $job_posted[$key]['attribute'] = $attribute;

            /*$job_applied = Job_Applied::where('job_id','=',$value->id)->get()->toArray();
            if (!empty($job_applied)) {
                foreach ($job_applied as $k => $v) {
                
                $users[$k] = User::where('id','=',$v['user_id'])->first(array("id","email_address","first_name","last_name"))->toArray();
                $users[$k]['created_at'] = $v['created_at'];
                $job_posted[$key]['user'] = $users;
                }
            }else{
                $users = array();
                $job_posted[$key]['user'] = $users;
            }*/
        }

        //echo "<pre>";print_r($job_posted->toArray());exit;
    return view('client::client.dashboards.job_posted_list',compact('user','count','job_posted'));
    }

    public function userApplied($slug) {
        $user = Auth::user();
        $job = Job::where('slug','=',$slug)->where('user_id','=',$user->id)->first();
        $count=0;
        $job_applied = [];
        if (!empty($job)) {
            $job_applied = Job_applied::where('jobs_applied.job_id','=',$job->id)
            ->leftJoin('job_invite', function($join){
               $join->on('job_invite.user_id','=','jobs_applied.user_id');
               $join->on('job_invite.job_id','=','job_invite.job_id');
            })
            ->join('users','users.id','=','jobs_applied.user_id')
            ->select('*','jobs_applied.id as jobs_applied_id','jobs_applied.created_at as jobs_applied_created_at','job_invite.id as job_invite_id','users.id as user_id','jobs_applied.job_id as job_id')
            ->orderBy('jobs_applied.created_at', 'asc')->paginate($this->limit);
            $count = Job_applied::where('job_id','=',$job->id)->count();
            
            }
        //echo "<pre>";print_r($job_applied);exit;
        return view('client::client.dashboards.user_applied_list',compact('user', 'count','job_applied','job'));   
    }

    public function jobApply(Request $request) {

        //echo "<pre>";print_r($request->all());exit;
        $allData = $request->all();
        $file = $request['resume'];
        //echo "<pre>";print_r($file);exit;
        $user = Auth::user();
        //echo "<pre>";print_r($user);exit;
        $job_applied = Job_Applied::where('job_id','=',$allData['job_id'])->where('user_id','=',$user->id)->count();
        if ($job_applied>0) {
            return redirect(route('job_detail',$allData['job_slug']))->withErrors(['job_already_applied'=>'You have already applied for this job']);
        }
        //echo "<pre>";print_r($job_applied);exit;
        $validationArray = 
        [
            'cover_letter' => 'required',
            'resume' => 'required|mimes:pdf,doc,docx|max:40000'
        ];

        $validator = Validator::make($request->all(), $validationArray);
        if($validator->fails()){
            \Session::flash('validate_fails',1);
            return redirect(route('job_detail',$allData['job_slug']))->withErrors($validator)->withInput(\Input::all());
        }   

        //cho "<pre>";print_r($error);exit;
        if (\Input::hasFile('resume')) {

            //get image name and rename
            $imageName = $file->getClientOriginalName();
            $imageStoredName = date('YmdHis') . '-' . $imageName;
            //echo "<pre>";print_r($imageStoredName);exit;
            $destinationPath = 'assets/jobApplied/resume';
            $file->move($destinationPath,$imageStoredName);

            $job_applied = new Job_Applied;
            $job_applied->job_id = $allData['job_id'];
            $job_applied->user_id = $user->id;
            $job_applied->cover_letter = $allData['cover_letter'];
            $job_applied->path = $imageStoredName;

            $job_applied->save();
			
			/*************Send Job apply email start******************/
			
			$jobData = Job::select('jobs.slug as job_slug','jobs.name as job_name','jobs.id as job_id','users.first_name as user_first_name','users.last_name as user_last_name','users.email_address as user_email_address')->
				leftJoin('users','users.id','=','jobs.user_id')->
				where('jobs.id','=',$allData['job_id'])->first();
			if(!empty($jobData)){
				$jobData = $jobData->toArray();
				
				$dataEmail = $jobData;
				Mail::send('client::client.emails.job_applied_email', $dataEmail, function ($message) use ($dataEmail) {
				  $message->subject('Job Notification.')
						  ->to(trim($dataEmail['user_email_address']))
						  ->sender('no-reply@toil.com', 'Toil')
						  ->replyTo('no-reply@toil.com');
				});
			}
			/*************Send Job apply email end******************/
			
			
			
			
			
            return redirect(route('job_detail',$allData['job_slug']))->with('status', 'Job Applied Successfully');
        }
    }

    public function acceptJob(Request $request) {
        //echo "<pre>";print_r($request->all());exit;
        $job = Job::where('id','=',$request->jobs_id)->first();
		if($request->accepted == '1'){
			$job->is_accepted = $request->accepted;
			$job->contract_accept_date = date('Y-m-d H:i:s');
			$job->save();
			
			$dataEmail = $jobData = Job::select('jobs.slug as job_slug','jobs.name as job_name','jobs.id as job_id','users.first_name as user_first_name','users.last_name as user_last_name','users.email_address as user_email_address')->
				leftJoin('users','users.id','=','jobs.user_id')->
				where('jobs.id','=',$request->jobs_id)->first()->toArray();
			//echo '<pre>';print_r($dataEmail);exit;	
			Mail::send('client::client.emails.job_contract_accept_email', $dataEmail, function ($message) use ($dataEmail) {
			  $message->subject('Job Notification.')
					  ->to($dataEmail['user_email_address'])
					  ->sender('no-reply@toil.com', 'Toil')
					  ->replyTo('no-reply@toil.com');
			});
			return redirect(route('user_job_applied'))->with('status', 'Contract Send Successfully');
		}else{
			$job->is_contracted = NULL;
			$job->awarded_user = NULL;
			$job->save();
			$dataEmail = $jobData = Job::select('jobs.slug as job_slug','jobs.name as job_name','jobs.id as job_id','users.first_name as user_first_name','users.last_name as user_last_name','users.email_address as user_email_address')->
				leftJoin('users','users.id','=','jobs.user_id')->
				where('jobs.id','=',$request->jobs_id)->first()->toArray();
			
			//echo '<pre>';print_r($dataEmail);exit;	
			Job_Applied::where('user_id','=',Auth::user()->id)->where('job_id','=',$request->jobs_id)->delete();
			
			Mail::send('client::client.emails.job_contract_reject_email', $dataEmail, function ($message) use ($dataEmail) {
			  $message->subject('Job Notification.')
					  ->to($dataEmail['user_email_address'])
					  ->sender('no-reply@toil.com', 'Toil')
					  ->replyTo('no-reply@toil.com');
			});
			DB::table('jobs_contract_log')->insert(['job_id'=>$request->jobs_id,'rejected_by_user_id'=>Auth::user()->id]);
			return redirect(route('user_job_applied'))->with('status', 'Contract Reject Successfully');
		}
		
    }

    public function acceptInvitation($id) {
        // echo "<pre>";print_r($request->all());exit;
        $job_applied = Job_Applied::where('jobs_applied.id','=',$id)
        ->join('jobs','jobs.id','=','jobs_applied.job_id')
        ->join('users','users.id','=','jobs_applied.user_id')
        ->select('*','jobs_applied.id as jobs_applied_id','jobs_applied.created_at as jobs_applied_created_at')
        ->first();
		//echo "<pre>";print_r($job_applied);exit;
        $job_invitation = Job_Invite::where('job_id','=',$job_applied->job_id)->where('user_id','=',$job_applied->id)->first();
        $job_invitation->is_accepted = 1;
        $job_invitation->save();
		
		/*************Accept Job invitation email start******************/
		
		if(!empty($job_applied)){
			$dataEmail = $job_applied->toArray();
			$userData = User::select('email_address')->where('id','=',$dataEmail['user_id'])->first()->toArray();
			$dataEmail['to_email'] = trim($userData['email_address']);
			//echo "<pre>";print_r($userData);exit;	
			Mail::send('client::client.emails.job_accept_invitation_email', $dataEmail, function ($message) use ($dataEmail) {
			  $message->subject('Job Notification.')
					  ->to($dataEmail['to_email'])
					  ->sender('no-reply@toil.com', 'Toil')
					  ->replyTo('no-reply@toil.com');
			});
		}
		/*************Accept Job invitation email end******************/
		
		return redirect(route('user_job_applied'))->with('status', 'Contract Send Successfully');
    }

    public function inviteJob($id) {
        //echo "<pre>";print_r($id);exit;

        $job_applied = Job_Applied::where('jobs_applied.id','=',$id)
        ->join('jobs','jobs.id','=','jobs_applied.job_id')
        ->join('users','users.id','=','jobs_applied.user_id')
        ->select('*','jobs_applied.id as jobs_applied_id','jobs_applied.created_at as jobs_applied_created_at')
        ->first();
        $jobs = Job::findOrFail($job_applied->job_id);
        //echo "<pre>";print_r($jobs);exit;
        $job_invite = Job_Invite::where('job_id','=',$job_applied->job_id)->where('user_id','=',$job_applied->id)->first();
        if(empty($job_invite)){
            $job_invite = new Job_Invite;
        }
        $job_invite->job_id = $job_applied->job_id;
        $job_invite->user_id = $job_applied->id;
        $job_invite->save();
		
		/*************Send Job invitation email start******************/
		
		$userData = User::select('first_name','last_name','email_address')->
					where('id','=',$job_applied->id)->first();
		if(!empty($userData)){
			$dataEmail = $userData->toArray();
			$dataEmail['job_slug'] = $jobs->slug;
			$dataEmail['job_name'] = $jobs->name;
			
			Mail::send('client::client.emails.job_invitation_email', $dataEmail, function ($message) use ($dataEmail) {
			  $message->subject('Job Notification.')
					  ->to(trim($dataEmail['email_address']))
					  ->sender('no-reply@toil.com', 'Toil')
					  ->replyTo('no-reply@toil.com');
			});
		}
		/*************Send Job invitation email end******************/
		
        //echo "<pre>";print_r($job_applied);exit;
        return redirect(route('job_user_applied',$jobs->slug))->with('status', 'Job Invited Successfully');
    }


    public function sendContract(Request $request) {
        //echo "<pre>";print_r($request->all());exit;

        $validationArray = [
            'start_date' => 'required',
            'end_date' => 'required',
            'payment' => 'required|numeric',
            'description' => 'required',
			'payment_via' => 'required'
	    ];
        \Session::flash('validate_fails',$request->job_applied_id);
        $this->validate($request, $validationArray);
        \Session::flash('validate_fails',null);

        $job_applied = Job_Applied::where('jobs_applied.id','=',$request->job_applied_id)
        ->join('jobs','jobs.id','=','jobs_applied.job_id')
        ->join('users','users.id','=','jobs_applied.user_id')
        ->select('*','jobs_applied.id as jobs_applied_id','jobs_applied.created_at as jobs_applied_created_at')
        ->first();
        $jobs = Job::findOrFail($job_applied->job_id);
        
		//echo "<pre>";print_r($job_applied);exit;
        
		$jobs->is_contracted = 1;
        $jobs->is_canceled = null;
        $jobs->awarded_user = $job_applied->id;
        $jobs->is_accepted = null;
        $jobs->save();

        list($m,$d,$y) = explode("/", $request->start_date);
        $request->start_date = $y.'-'.$m.'-'.$d;

        list($m,$d,$y) = explode("/", $request->end_date);
        $request->end_date = $y.'-'.$m.'-'.$d;
        
        $contract = Contract::where('job_id','=',$job_applied->job_id)->where('user_id','=',$job_applied->id)->first();
        if(empty($contract)){
            $contract = new Contract;
        }
        //echo "<pre>";print_r($start_date);exit;
        $contract->user_id = $job_applied->id;
        $contract->job_id = $job_applied->job_id;
        $contract->payment = $request->payment;
        $contract->description = $request->description;
        $contract->start_date = $request->start_date;
        $contract->end_date = $request->end_date;
		$contract->payment_via = $request->payment_via;
        $contract->save();

        Job_Invite::where('job_id','=',$job_applied->job_id)->delete();
		
		/*************Send Contract email start******************/
		//need to fix email its raw code
		$dataEmail = $job_applied->toArray();
		Mail::send('client::client.emails.job_contract_send_email', $dataEmail, function ($message) use ($dataEmail) {
		  $message->subject('Job Notification.')
				  ->to(trim($dataEmail['email_address']))
				  ->sender('no-reply@toil.com', 'Toil')
				  ->replyTo('no-reply@toil.com');
		});
		
		/*************Send Contract email end******************/
		
	    //echo "<pre>";print_r($job_applied);exit;
        return redirect(route('job_user_applied',$jobs->slug))->with('status', 'Contract Send Successfully');
    }

    public function awardJob($id) {
        //echo "<pre>";print_r($id);exit;

        $job_applied = Job_Applied::where('jobs_applied.id','=',$id)
        ->join('jobs','jobs.id','=','jobs_applied.job_id')
        ->join('users','users.id','=','jobs_applied.user_id')
        ->select('*','jobs_applied.id as jobs_applied_id','jobs_applied.created_at as jobs_applied_created_at')
        ->first();
		$dataEmail = $job_applied;
		//echo "<pre>";print_r($job_applied);exit;
        $jobs = Job::findOrFail($job_applied->job_id);
        //echo "<pre>";print_r($job_applied);exit;
        $jobs->is_awarded = 1;
        $jobs->awarded_user = $job_applied->id;
        $jobs->save();
		
		$dataEmail = $dataEmail->toArray();
		//echo '<pre>';print_r($dataEmail);exit;	
		Mail::send('client::client.emails.job_award_email', $dataEmail, function ($message) use ($dataEmail) {
		  $message->subject('Job Notification.')
				  ->to($dataEmail['email_address'])
				  ->sender('no-reply@toil.com', 'Toil')
				  ->replyTo('no-reply@toil.com');
		});
		
		
        //echo "<pre>";print_r($job_applied);exit;
        return redirect(route('job_user_applied',$jobs->slug))->with('status', 'Job Awarded Successfully');
    }

    public function cancelJob($id) {
        //echo "<pre>";print_r($id);exit;

        $job_applied = Job_Applied::where('jobs_applied.id','=',$id)
        ->join('jobs','jobs.id','=','jobs_applied.job_id')
        ->join('users','users.id','=','jobs_applied.user_id')
        ->select('*','jobs_applied.id as jobs_applied_id','jobs_applied.created_at as jobs_applied_created_at')
        ->first();
        $jobs = Job::findOrFail($job_applied->job_id);
        //echo "<pre>";print_r($jobs->slug);exit;
        $jobs->is_contracted = null;
        $jobs->is_awarded = null;
        $jobs->is_canceled = 1;
        $jobs->is_accepted = null;
        $jobs->awarded_user = $job_applied->id;
        $jobs->save();
        //echo "<pre>";print_r($job_applied);exit;
        return redirect(route('job_user_applied',$jobs->slug))->with('status', 'Job Cancel Successfully');
    }
	public function completeJob(Request $request) {
		$post = $request->all();
		//echo '<pre>';print_r($post);exit;
		$id = $post['job_completed_id'];
		$job_applied = Job_Applied::where('jobs_applied.id','=',$id)
        ->join('jobs','jobs.id','=','jobs_applied.job_id')
        ->join('users','users.id','=','jobs_applied.user_id')
        ->select('*','jobs_applied.id as jobs_applied_id','jobs_applied.created_at as jobs_applied_created_at')
        ->first();
        $jobs = Job::findOrFail($job_applied->job_id);
        //echo "<pre>";print_r($jobs->slug);exit;
        $jobs->is_completed = 1;
		$jobs->completed_comment = $post['description'];
		$jobs->completion_rate = $post['rate_select'];
        $jobs->save();
        
		$jobData = Job::select('jobs.slug as job_slug','jobs.name as job_name','jobs.id as job_id','users.first_name as user_first_name','users.last_name as user_last_name','users.email_address as user_email_address')->
				leftJoin('users','users.id','=','jobs.awarded_user')->
				where('jobs.id','=',$job_applied->job_id)->first();
		//echo "<pre>";print_r($jobData);exit;		
		if(!empty($jobData)){
			$dataEmail = $jobData->toArray();
			//echo '<pre>';print_r($dataEmail);exit;
			Mail::send('client::client.emails.job_completed_email', $dataEmail, function ($message) use ($dataEmail) {
			  $message->subject('Job Notification.')
					  ->to(trim($dataEmail['user_email_address']))
					  ->sender('no-reply@toil.com', 'Toil')
					  ->replyTo('no-reply@toil.com');
			});
		}
		
		return redirect(route('job_user_applied',$jobs->slug))->with('status', 'Job Completed Successfully');
	}
    public function destroy($id)
    {   
        
        $job_applied = Job_Applied::where('job_id', '=', $id)->get();
        $job_attribute = Job_Attribute::where('job_id', '=', $id)->get();
        $job_categorie = Job_Categorie::where('job_id', '=', $id)->get();
        //echo "<pre>";print_r($job_attribute);exit;
        if (!empty($job_applied)) {
            foreach ($job_applied as $key => $value) {
                $value->delete();
            }
        }
        if (!empty($job_attribute)) {
            foreach ($job_attribute as $key => $value) {
                //echo "<pre>";print_r($value);exit;
                $value->delete();
            }
        }
        if (!empty($job_categorie)) {
            foreach ($job_categorie as $key => $value) {
                $value->delete();
            }
        }
        $job = Job::findOrFail($id);
        $job->delete();

        \Session::flash('flash_message', 'Job deleted!');
        return redirect('dashboards/profile');
    }

    public function userChat() {
        //die('here');
        $chatTxt = \Input::get('chat',"");
        $job_id = \Input::get('job_id',"");
        $sender_id = \Input::get('sender_id',"");
        $reciever_id = \Input::get('reciever_id',"");
        $message_sender = \Input::get('message_sender',"");

        $chat = new Chat;
        $chat->chat = $chatTxt;
        $chat->job_id = $job_id;
        $chat->sender_id = $sender_id;
        $chat->reciever_id = $reciever_id;
        $chat->message_sender = $message_sender;
        $chat->save();

        $timestamp = date("Y/m/d h:i:sa");
        $date = TimeSpan::time_passed($timestamp);
        if ($message_sender == 0) {
            $sender = User::where('id','=',$sender_id)->first();        
            //echo "<pre>";print_r($chat);exit;
            return view('client::client.dashboards.chat',array('chatText'=> $chatTxt,'sender'=>$sender,'date'=>$date ,'message_sender'=>$message_sender));
        }else{
            $reciever = User::where('id','=',$reciever_id)->first();        
            //echo "<pre>";print_r($chat);exit;
            return view('client::client.dashboards.chat',array('chatText'=> $chatTxt,'reciever'=>$reciever,'date'=>$date ,'message_sender'=>$message_sender));
        }
        
    }

    public function allMessages() {

        $job_id = \Input::get('job_id',"");
        $sender_id = \Input::get('sender_id',"");
        $reciever_id = \Input::get('reciever_id',"");

        $chats = Chat::where('job_id','=',$job_id)->where('sender_id','=',$sender_id)->where('reciever_id','=',$reciever_id)->orderBy('created_at','asc')->get();
        foreach ($chats as $key => $value) {
            $reciever = User::where('id','=',$reciever_id)->first();
            $sender = User::where('id','=',$sender_id)->first();
            $date = TimeSpan::time_passed($value->created_at);
            $value->date = $date;
            $value->reciever_first_name = $reciever->first_name;
            $value->reciever_last_name = $reciever->last_name;
            $value->reciever_image_path = $reciever->image_path;
            $value->sender_first_name = $sender->first_name;
            $value->sender_last_name = $sender->last_name;
            $value->sender_image_path = $sender->image_path;
            //echo "<pre>";print_r($reciever_name);exit;
        }        
        //die('here');
        //echo "<pre>";print_r($chats->toArray());exit;
        return view('client::client.dashboards.all_messages',array('chats'=> $chats));    
    }
	function showContract($id){
		$jobData = Job::select('jobs.name as job_name','jobs.awarded_user','jobs.job_attributes','users.*','contracts.created_at as contracts_date','contracts.description as contract_description','contracts.payment_via')
					->join('users','users.id','=','jobs.user_id')
					->join('contracts','contracts.job_id','=','jobs.id')
					->where('jobs.id','=',$id)->first();
		
		if($jobData->awarded_user != '' && $jobData->awarded_user != '0' && $jobData->awarded_user != 'null' && $jobData->awarded_user != NULL ){
			$awardedUserData = User::where('id','=',$jobData->awarded_user)->first();
			return view('client::client.dashboards.contract',array('jobData'=>$jobData,'awardedUserData'=>$awardedUserData));
		}else{
			exit('Wrong');
		}
	}
	function chatRoomSeeker(){
		if(Auth::user()->user_type == 'Both' || Auth::user()->user_type == 'JobSeeker'){
			
			$relatedJobs = Job_Applied::select('jobs.id as job_id','jobs.user_id as job_poster_id','users.image_path as user_image','jobs.name as job_name','users.first_name as job_poster_fname','users.last_name as job_poster_lname','jobs_applied.user_id as job_applid_user')->
			where('jobs_applied.user_id','=',Auth::user()->id)->
			/*join('jobs', function($join)
			 {
				 $join->on('jobs.id','=','jobs_applied.job_id')->where('jobs.user_id','!=',Auth::user()->id);

			 })->*/
			join('jobs','jobs.id','=','jobs_applied.job_id')->
			join('users','users.id','=','jobs.user_id')->
			get();
			//echo Auth::user()->id.'<pre>';print_r($relatedJobs);exit;
			
			return view('client::client.dashboards.chatroom',array('user'=>Auth::user(),'relatedJobs'=>$relatedJobs));
		}else{
			return redirect(url('/'));
		}
	}
	
	function getChatSeeker($user_id,$job_id,$poster_id){
		
		$chats1 = Chat::where('job_id','=',$job_id)->where('sender_id','=',$user_id)->where('reciever_id','=',$poster_id)->orderBy('created_at','asc')->get()->toArray();
		$chats2 = Chat::where('job_id','=',$job_id)->where('sender_id','=',$poster_id)->where('reciever_id','=',$user_id)->orderBy('created_at','asc')->get()->toArray();
		
		$chats = array_merge($chats1, $chats2);
		usort($chats, function($a, $b) {
			return $a['id'] - $b['id'];
		});
		
		if(empty($chats)){
			exit('empty');
		}else{
			$receiverImage = User::select('image_path')->where('id','=',$poster_id)->first()->toArray();
			return view('client::client.dashboards.chatroomload',array('chats'=>$chats,'receiverImage'=>$receiverImage['image_path']));
		}
		
	}
	function sendMessage(Request $request){
		$post = $request->all();
		$data = ['job_id'=>$post['job_id'],'reciever_id'=>$post['receiver_id'],'chat'=>$post['message'],'sender_id'=>Auth::user()->id,'created_at'=>date('Y-m-d H:i:s')];
		Chat::insert($data);
		exit;
	}
	
	
	function chatRoomEmployer(){
		if(Auth::user()->user_type == 'Both' || Auth::user()->user_type == 'Employer'){
			
			$relatedJobs = Job_Applied::select('jobs.id as job_id','jobs.user_id as job_poster_id','users.image_path as user_image','jobs.name as job_name','users.first_name as job_poster_fname','users.last_name as job_poster_lname','jobs_applied.user_id as job_applid_user')->
			//where('jobs_applied.user_id','=',Auth::user()->id)->
			join('jobs', function($join)
			 {
				 $join->on('jobs.id','=','jobs_applied.job_id')->where('jobs.user_id','=',Auth::user()->id);

			 })->
			//join('jobs','jobs.id','=','jobs_applied.job_id')->
			join('users','users.id','=','jobs_applied.user_id')->
			get();
			//echo Auth::user()->id.'<pre>';print_r($relatedJobs);exit;
			//echo "<pre>"; print_r($relatedJobs->count());
			return view('client::client.dashboards.chatroom_employe',array('user'=>Auth::user(),'relatedJobs'=>$relatedJobs));
		}else{
			return redirect(url('/'));
		}
	}
	function getChatEmployer($user_id,$job_id,$poster_id){
		
		$chats1 = Chat::where('job_id','=',$job_id)->where('sender_id','=',$user_id)->where('reciever_id','=',$poster_id)->orderBy('created_at','asc')->get()->toArray();
		$chats2 = Chat::where('job_id','=',$job_id)->where('sender_id','=',$poster_id)->where('reciever_id','=',$user_id)->orderBy('created_at','asc')->get()->toArray();
		
		$chats = array_merge($chats1, $chats2);
		usort($chats, function($a, $b) {
			return $a['id'] - $b['id'];
		});
		if(empty($chats)){
			exit('empty');
		}else{
			$receiverImage = User::select('image_path')->where('id','=',$poster_id)->first()->toArray();
			return view('client::client.dashboards.chatroomload_employe',array('chats'=>$chats,'receiverImage'=>$receiverImage['image_path']));
		}
		
	}
}