<?php 

namespace App\Modules\client\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Req;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Job, App\Models\Categorie , App\Models\Resume , 
	App\Models\User, App\Models\Form, App\Models\Job_Categorie, 
	App\Models\Job_Attribute, App\Models\Job_Applied, App\Models\Page, 
	App\Models\Country, App\Models\City, App\Models\Sub_City, App\Models\State,
	App\Helpers\Location;

use DB;

class HomeController extends Controller {

	protected $limit;
	protected $count;

	public function __construct(){
		$this->limit = 6;
		$this->count = 0;
	}

	public function index(){
		
		
		$this->count = Job::count();
		$job = Job::where('is_active','=',1)->where('is_featured','=',0)->whereNull('is_awarded')->orderBy('id','desc')->take(5)->get();
		//echo "<pre>";print_r($job->toArray());exit;
		$job = Job::getJobListing($job,null,null);

		$users = User::where("active","=",1)->where("user_type","!=","Employer")->whereNull('deleted_at');
		if ( \Auth::user()){
			$users = $users->where("id","!=",\Auth::user()->id);
		}

		$users = $users->orderBy('created_at','DESC')->take(6)->get();
		//echo "<pre>";print_r($job->toArray());exit;
		$featured_job = Job::where('is_active','=',1)->where('is_featured','=',1)->whereNull('is_awarded')->orderBy('id','desc')->take(6)->get();
		$featured_job = Job::getJobListing(null,$featured_job,null);
		//echo "<pre>";print_r($featured_job->toArray());exit;

		$total_jobs = Job::where('is_active','=',1)->whereNull('is_awarded')->count();
		$total_resumes = Resume::count();
		$total_users = User::where('active','=',1)->where('is_admin','=',0)->whereNull('company_name')->count();
		$total_companies = User::where('active','=',1)->where('is_admin','=',0)->whereNotNull('company_name')->count();
		$categories = Categorie::whereNull('parent_id')->orderBy('created_at','desc')->get();
		$category_array = Categorie::getCategorieListing($categories);
		$sub_categories = Categorie::whereNotNull('parent_id')->orderBy('created_at','desc')->get();
		$sub_category_array = Categorie::getSubCategorieListing($sub_categories,0);

		if ( \Auth::user() ){
			$lat1 = \Auth::user()->latitude;
			$lon1 = \Auth::user()->longitude;
			foreach($users as $user){
				$lat2 = $user->latitude;
				$lon2 = $user->longitude;
				$user->distance = $this->distance($lat1, $lon1, $lat2, $lon2);
			}
		}
		return view('client::client.home.index',array('job'=> $job, 'featured_job'=> $featured_job, 'category_array' => $category_array, 'sub_category_array' => $sub_category_array, 'total_companies' => $total_companies, 'total_users' => $total_users, 'total_resumes' => $total_resumes, 'total_jobs' => $total_jobs, 'count' => $this->count, 'index' => $this->limit, 'users' => $users));
	}

	public function welcome()
	{
		
	$ip = request()->ip();
    $data = \Location::get($ip);
    //dd($data);

		return view('welcome')->withData($data);
	}
	public function jobListing() {
		
			$job = Job::where('is_active','=',1)->whereNull('is_awarded');
			$jobCount = Job::where('is_active','=',1);
			$searchTxt = \Input::get('searchinput','');
			if(!empty($searchTxt)){
				$job = $job->where('name','LIKE',$searchTxt);
				$jobCount = $jobCount->where('name','LIKE',$searchTxt);
			}

			$job = $job->orderBy('created_at','desc')->paginate($this->limit);
	  	$this->count = $jobCount->count();

			$job = Job::getJobListing($job,null,null);

	    return view('client::client.home.job_listing',array('job'=> $job, 'count' => $this->count, 'page' => $this->limit));
  	}

  	public function users() {
			$user = User::where('active','=',1)->whereNull('deleted_at')->where("user_type","!=","Employer");
			$userCount = User::where('active','=',1)->whereNull('deleted_at')->where("user_type","!=","Employer");

			$searchTxt = \Input::get('searchinput','');
			if(!empty($searchTxt)){
				$user = $user->where('name','LIKE',$searchTxt);
				$userCount = $userCount->where('name','LIKE',$searchTxt);
			}
			if ( \Auth::user()){
				$user = $user->where("id","!=",\Auth::user()->id);
				$userCount = $userCount->where("id","!=",\Auth::user()->id);
			}

			$users = $user->orderBy('created_at','desc')->paginate($this->limit);
			if ( \Auth::user() ){
				$lat1 = \Auth::user()->latitude;
				$lon1 = \Auth::user()->longitude;
				foreach($users as $user){
					$lat2 = $user->latitude;
					$lon2 = $user->longitude;
					$user->distance = $this->distance($lat1, $lon1, $lat2, $lon2);
				}
			}

	  	$this->count = $userCount->count();

	    return view('client::client.home.users',array('users'=> $users, 'count' => $this->count, 'page' => $this->limit));
  	}

  	public function user_listing() {

			$page = \Input::get('page',0);
			$searchTxt = \Input::get('search',"");

			$where = " 1 = 1";
			if($searchTxt != ""){
				$pieces = explode(" ", $searchTxt);
				$where = " ( ";
				foreach($pieces as $i => $piece){
					if($i != 0){
						$where .= ' OR ';
					}
					$where .= " users.`first_name` like '%$piece%' OR users.`last_name` like '%$piece%' ";
				}
				$where .= " ) ";
			}

			$users = User::where('active','=',1)->whereNull('deleted_at')->where("user_type","!=","Employer")
							->whereRaw($where);

			$count = User::where('active','=',1)->whereNull('deleted_at')->where("user_type","!=","Employer")
											->whereRaw($where);
				        			
			if ( \Auth::user()){
				$users = $users->where("id","!=",\Auth::user()->id);
				$count = $count->where("id","!=",\Auth::user()->id);
			}

			$users = $users->select('*')->orderBy('users.created_at','desc')->paginate($this->limit);
			$count = $count->select('users.id as user_id')->count();
			if ( \Auth::user() ){
				$lat1 = \Auth::user()->latitude;
				$lon1 = \Auth::user()->longitude;
				foreach($users as $user){
					$lat2 = $user->latitude;
					$lon2 = $user->longitude;
					$user->distance = $this->distance($lat1, $lon1, $lat2, $lon2);
				}
			}
			
			return view('client::client.home.user_listing',array('users'=> $users,'count' => $count,'page' => $page));
	}

	public function userDetail($id) {
		
		$user = User::findOrFail($id);
		$distance = '';
		if ( \Auth::user() && !empty($user->latitude) && !empty($user->longitude) ){
			$lat1 = \Auth::user()->latitude;
			$lon1 = \Auth::user()->longitude;
			$lat2 = $user->latitude;
			$lon2 = $user->longitude;
			$distance = $this->distance($lat1, $lon1, $lat2, $lon2);
		}

	  $sub_city = Sub_City::where('id','=',$user->sub_city)->first();
	  $city = City::where('id','=',$user->city)->first();
	  $state = State::where('id','=',$user->state)->first();
	  $country = Country::where('id','=',$user->country)->first();
	  $count = Job_Applied::where('user_id',$user->id)->count();
	  $job_posted = Job::where('user_id',$user->id)->count();
	//echo "<pre>";print_r($job_posted);exit;
		return view('client::client.home.user_detail',compact('user','sub_city','city','state','country','count','job_posted','distance'));
  }

  	public function radialSearch() {

			$job = Job::where('is_active','=',1)->whereNull('is_awarded')->orderBy('created_at','desc')->get();

			$location = new Location();
			list($lon_lat, $country, $states, $cities, $sub_cities) = $location->locations();
		
	    return view('client::client.home.job_radial_search',compact('job','cities','sub_cities','states','country','lon_lat'));
  	}

  public function distance($lat1, $lon1, $lat2, $lon2, $unit = "K") {

	  $theta = $lon1 - $lon2;
	  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	  $dist = acos($dist);
	  $dist = rad2deg($dist);
	  $miles = $dist * 60 * 1.1515;
	  $unit = strtoupper($unit);

  	if ($unit == "K") {
    	return Round($miles * 1.609344);
  	} else if ($unit == "N") {
      return Round($miles * 0.8684);
    } else {
			return $miles;
    }
	}

	public function jobRadialSearch(Request $request) {

		//echo "<pre>";print_r($request->all());exit;
		//die('here');
	    $radius = \Input::get('radius',0);
	    $lat = \Input::get('lat','');
	    $long = \Input::get('long','');

	    $type = \Input::get('type','jobs');

	    if($type == "users"){
	    	if(!empty($radius)){
	    		$user = DB::select("SELECT *,( 6371 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians( latitude ) ) ) ) AS distance FROM `users` HAVING distance <= $radius ORDER BY distance ASC");
	    	}else{
	    		$where = "";
			    if (!empty($request->country_id)) {
			    	$where .= "country = $request->country_id AND ";
			    }
			    if(!empty($request->state_id)){
			    	$where .= "state = $request->state_id AND ";
			    }
			    if(!empty($request->city_id)){
			    	$where .= "city = $request->city_id AND ";
			    }
			    if(!empty($request->sub_city_id)){
			    	$where .= "sub_city = $request->sub_city_id AND ";
			    }

			    $user = User::where('active','=',1)->where('user_type','=','JobSeeker');

			    if( !empty($where)){
			    	$where = " 1=1 ";
			    	$user = $user->whereRaw($where);
			    }
			    $user = $user->get();
	    	}

	    	$lat_lon = array();
		    foreach ($user as $key => $value) {
		    	$lat_lon[$key]['latitude'] = $value->latitude;
		    	$lat_lon[$key]['longitude'] = $value->longitude;
		    	$lat_lon[$key]['title'] = $value->first_name;
		    	$lat_lon[$key]['slug'] = $value->id;
		    	//$jobs_lat_lon[$key]['title'] = $value->name;
		    }
				
				return $lat_lon;

	    }else{
	    	if(!empty($radius)){
	    	$job = DB::select("SELECT *,( 6371 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians( latitude ) ) ) ) AS distance FROM `jobs` HAVING distance <= $radius ORDER BY distance ASC");
	    }else{
	    	$where = "";
		    if (!empty($request->country_id)) {
		    	$where .= "country_id = $request->country_id AND ";
		    }
		    if(!empty($request->state_id)){
		    	$where .= "state_id = $request->state_id AND ";
		    }
		    if(!empty($request->city_id)){
		    	$where .= "city_id = $request->city_id AND ";
		    }
		    if(!empty($request->sub_city_id)){
		    	$where .= "sub_city_id = $request->sub_city_id AND ";
		    }

		    $job = Job::where('is_active','=',1)->whereNull('is_awarded');

		    if( !empty($where)){
		    	$where = " 1=1 ";
		    	$job = $job->whereRaw($where);
		    }
		    $job = $job->get();
	    }
	    
	    $jobs_lat_lon = array();
	    foreach ($job as $key => $value) {
	    	$jobs_lat_lon[$key]['latitude'] = $value->latitude;
	    	$jobs_lat_lon[$key]['longitude'] = $value->longitude;
	    	$jobs_lat_lon[$key]['title'] = $value->name;
	    	$jobs_lat_lon[$key]['slug'] = $value->slug;
	    	//$jobs_lat_lon[$key]['title'] = $value->name;
	    }
	    //echo "<pre>";print_r($jobs_lat_lon);exit;
	    return $jobs_lat_lon;
		}

	}    

	public function listing() {

		$page = \Input::get('page',0);
		$searchTxt = \Input::get('search',"");

		$where = " 1 = 1";
		if($searchTxt != ""){
			$where = " ( jobs.`name` like '%$searchTxt%') ";
		}

		$job = Job::where('is_active','=',1)->whereNull('is_awarded')
						->join('job_categories','jobs.id','=','job_categories.job_id')
						->whereRaw($where)
						->select('*','jobs.id as job_id','jobs.created_at as job_created_at')
			      ->orderBy('jobs.id','desc')->paginate($this->limit);

		$count = Job::where('is_active','=',1)->whereNull('is_awarded')
										->join('job_categories','jobs.id','=','job_categories.job_id')
										->whereRaw($where)
			        			->select('jobs.id as job_id')->count();

		return view('client::client.home.listing',array('job'=> $job,'count' => $count,'page' => $page));
	}

  	public function categorieListing(){
  		$categories = Categorie::whereNull('parent_id')->orderBy('created_at','desc')->get();
		$category_array = Categorie::getCategorieListing($categories);
		$sub_categories = Categorie::whereNotNull('parent_id')->orderBy('created_at','desc')->get();
		$sub_category_array = Categorie::getSubCategorieListing($sub_categories,1);
		//echo "<pre>";print_r($sub_category_array);exit;
		return view('client::client.home.categorie_listing',array('count' => $this->count, 'index' => $this->limit, 'category_array' => $category_array, 'sub_category_array' => $sub_category_array));
	}

	public function categoryListing() {

	    $page = \Input::get('page',0);
	    $searchTxt = \Input::get('search',"");
	    $country_id = \Input::get('country',"");
	    $categorie_id = \Input::get('categorie',"");
	    
	    //die('here');
	    //echo "<pre>";print_r($page);exit;
	    $where = "";
	    if($searchTxt != ""){
	      	$where .= " ( job_summary like '%$searchTxt%') AND ";
	      	$this->limit = null;
	    }	    
	    //echo "<pre>";print_r($form);exit;
	    return view('client::client.home.categorie_listing',array('category_array'=> $category_array, 'sub_category_array'=> $sub_category_array));
  	}


  	public function searchJobsByCountry($slug){


  		$country = Country::where('slug','=',$slug)->first();
		$where="";
		$job = Job::where('country_id','=',$country->id)->where('is_active','=',1)->whereNull('is_awarded')->orderBy('id','desc')->paginate($this->limit);
  		$this->count = Job::where('country_id','=',$country->id)->where('is_active','=',1)->whereNull('is_awarded')->count();
	    $job = Job::getJobListing($job,null,null);
		//echo "<pre>";print_r($job);exit;
		return view('client::client.home.job_listing',array('job'=> $job, 'count' => $this->count, 'index' => $this->limit, 'country' => $country));
	}

  	public function searchJobsByCategory($slug){

  		$categorie = Categorie::where('slug','=',$slug)->first();
		$where="";
		if ($categorie->parent_id ==null) {
			$where .= "job_categories.categorie_id = $categorie->id";
		}else{
			$where .= "job_categories.sub_categorie_id = $categorie->id";
		}
        
		$job = Job::where('is_active','=',1)->whereNull('is_awarded')
				->join('job_categories','jobs.id','=','job_categories.job_id')
				->whereRaw($where)
		        ->select('*','jobs.id as job_id','jobs.created_at as job_created_at')
		        ->orderBy('jobs.id','desc')->paginate($this->limit);
  		$this->count = Job::where('is_active','=',1)->whereNull('is_awarded')
				->join('job_categories','jobs.id','=','job_categories.job_id')
				->whereRaw($where)
		        ->select('*','jobs.id as job_id','jobs.created_at as job_created_at')->count();
	    $job = Job::getJobListing($job,null,1);
		//echo "<pre>";print_r($job->toArray());exit;
		return view('client::client.home.job_listing',array('job'=> $job, 'count' => $this->count, 'index' => $this->limit, 'categorie' => $categorie));
	}

  	public function JobDetail($slug){

		$job = Job::where('slug','=',$slug)->first();
		
		$where="";
        $where .= " ( placement_options like '%home_job_detail%') AND  1 = 1 ";
        $attribute = Job::getJopAttributes($where, $job);
		$job['attribute'] = $attribute;
		$job_summary = unserialize($job->job_summary);
		if (isset($job_summary['country'])) {
			$job['country'] = $job_summary['country'];	
		}
		if (isset($job_summary['state'])) {
			$job['state'] = $job_summary['state'];	
		}
		if (isset($job_summary['city'])) {
			$job['city'] = $job_summary['city'];	
		}
		if (isset($job_summary['sub_city'])) {
			$job['sub_city'] = $job_summary['sub_city'];	
		} 
		//echo "<pre>";print_r($job);exit;
		
		$user = User::where('id','=',$job->user_id)->first();
		$job_category = Job_Categorie::where('job_id','=',$job->id)->first();
		//echo "<pre>";print_r($job_category);exit;
		$category = Categorie::where('id','=',$job_category['categorie_id'])->first();
		$job_categorie = Job_Categorie::where('job_id','=',$job->id)->first();
		$job_attributes = Job_Attribute::where('job_id','=',$job->id)->get();
		$job['category'] = $category['icon'];
		//echo "<pre>";print_r($job->toArray());exit;
		$form_attributes = unserialize($job->job_attributes);

		//echo "<pre>";print_r($form_attributes);exit;
		return view('client::client.home.job_detail',array('job'=> $job, 'user'=>$user, 'category'=>$category, 'form_attributes'=>$form_attributes));
	}

	public function homePages($slug){
		//echo "<pre>";print_r($slug);exit;
		$page = Page::where('slug','=',$slug)->first();
		return view('client::client.home.home_pages',compact('page'));
	}

}

