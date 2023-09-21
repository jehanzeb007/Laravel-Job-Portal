<?php

namespace App\Modules\client\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Req;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User, App\Models\Form, App\Models\Job_Attribute, App\Models\Job, App\Models\Job_Categorie;
use App\Models\City, App\Models\Sub_City, App\Models\State, App\Models\Country, App\Models\Categorie;
use App\Helpers\Slug, App\Helpers\Location;

Class JobPostsController extends Controller{

	public function index(){

	}

	public function getStates(Request $request){
		$id = $_GET['id'];
		$state = State::where("country_id",'=',$id)->get(array("id","name"))->toArray();
		echo"<pre>"; print_r($state); exit;
		return view('client::client.job_posts.add',compact('state'));
	}

	public function add($slug=null){
		// echo "<pre>";print_r($id);exit;
		$user = Auth::user();
		if($user->user_type == "JobSeeker"){
			return redirect(route('client_user_profile'));
    }
		if (!empty($slug)) {
			$job = Job::where('slug','=',$slug)->first();
		}else{
			$job = new Job();
		}
		$location = new Location();
		list($lon_lat, $country, $states, $cities, $sub_cities)	= $location->locations();
		//echo "<pre>";print_r($job->id);exit;
		$state = State::getStates();
		$city = City::getCities();
		$sub_city = Sub_city::getSubCities();

		$categories = Categorie::getCategories();
		if ($slug!=null) {
			$category = Job_Categorie::where('job_id','=',$job->id)->first();
			if (empty($category)) {
				$category = new Job_Categorie();
			}
			
			//echo "<pre>";print_r($category);exit;
		}else{
			$category = new Job_Categorie();
		}
		//$categorie = Categorie::getSubCategories();
		$sub_categorie = Categorie::whereNotNull("parent_id")->get(array("id","name","parent_id"))->toArray();
		$sub_categories = array();
		foreach ($sub_categorie as $key => $value) {
			$sub_categories[$value['parent_id']][""] = "Select Sub Categorie"; 
			$sub_categories[$value['parent_id']][$value['id']] = $value['name']; 
		}
		//echo "<pre>";print_r($category->sub_categorie_id);exit;
        $form = Form::getForms();
        //echo "<pre>";print_r($form->toArray());exit;
        $formArr = [];
        foreach ($form as $key => $value) {
        		$formArr[$key]['name'] = $value['name'];
        		$formArr[$key]['id'] = $value['id'];
        		//echo "<pre>";print_r($formArr);exit;
        		$formArr[$key]['children'][null] = "";
        	foreach ($value['children'] as $k => $v) {
        		$formArr[$key]['children'][$v->id] = $v->name;
        		if ($slug!=null) {
					$attribute = Job_Attribute::where('job_id','=',$job->id)->where('form_id','=',$value['id'])->first();
					if (isset($attribute)) {
						//echo "<pre>"; print_r('attribute present');
						$formArr[$key]['attribute_id'] = $attribute->attribute_id;
					}else{

						//echo "<pre>"; print_r('attribute not present');
						$formArr[$key]['attribute_id'] = null;
					}
					
				}
        		
        		//echo "<pre>";print_r($v->toArray());exit;
        	}
        }
        $form = (object) $formArr;
        //echo "<pre>";print_r($states);exit;
        return view('client::client.job_posts.add',compact('sub_category','category','sub_city','city','state','job','user','form','cities','sub_cities','states','country','categories','sub_categories','lon_lat','slug'));
	}

	public function store(Request $request){
		$allData = $request->all();
		$user = Auth::user();
		//echo "<pre>";print_r(\Input::all());exit;
		//echo "<pre>";print_r($allData['categorie']);exit;
		
		$validationArray = Job::getJobPostValidationArray($allData);

		$validator = Validator::make($request->all(), $validationArray);
		if($validator->fails()){

			$tab = \Session::flash('tab',1);
			$categorie_id = \Session::flash('categorie_id',$allData['categorie']);
			$categorie = Job_Categorie::where('categorie_id','=',$allData['categorie'])->first();
			if (empty($categorie)) {
				$categorie_id = \Session::flash('categorie_id',null);
			}else{	
				$categorie_id = \Session::flash('categorie_id',$allData['categorie']);
			}
			//echo "<pre>";print_r($categorie_id);exit;
			if (isset($allData['country']) && trim($allData['country'] ) != '') {
				$country = State::where('country_id','=',$allData['country'])->first();
				//echo "<pre>";print_r($country);exit;
				if (empty($country)) {
					$country_id = \Session::flash('country_id',null);
				}else{	
					$country_id = \Session::flash('country_id',$allData['country']);
				}
			}else{
				$country_id =  \Session::flash('country_id',null);
			}
			
			if (isset($allData['state']) && trim($allData['state'] ) != '') {
				$state = City::where('state_id','=',$allData['state'])->first();
				//echo "<pre>";print_r($state);exit;
				if (empty($state)) {
					$state_id = \Session::flash('state_id',null);
				}else{	
					$state_id = \Session::flash('state_id',$allData['state']);
				}
			}else{
				$state_id = \Session::flash('state_id',null);
			}
			
			if (isset($allData['city'])  && trim($allData['city'] ) != '') {
				$city = Sub_City::where('city_id','=',$allData['city'])->first();
				//echo "<pre>";print_r($city);exit;
				if (empty($city)) {
					$city_id = \Session::flash('city_id',null);
				}else{	
					$city_id = \Session::flash('city_id',$allData['city']);
				}
			}else{
				$city_id = \Session::flash('city_id',null);
			}
			
			if (isset($allData['sub_city'])  && trim($allData['sub_city'] ) != '') {
				$sub_city_id = \Session::flash('sub_city_id',$allData['sub_city']);
			}else{
				$sub_city_id = \Session::flash('sub_city_id',null);
			}
			//echo "<pre>";print_r(\Session::get('city_id'));exit;
			return redirect(route('add_job_post'))->withErrors($validator)->withInput(\Input::all());
		}	
		//echo "<pre>";print_r($allData);exit;
		
		$job_summary = Job::getJobSummary($allData);
		//echo "<pre>";print_r($job_summary);exit;

		$job_attributes = Job::getJobAttribute($allData);
		//echo "<pre>";print_r($job_attributes);exit;

		$slug_obj = new Slug;
	    $model_name = 'Job';
	    $slug = $slug_obj->slug($allData['name'] , $model_name, null);
	    //echo "<pre>";print_r($slug);exit;
		
		$job = new Job();
		$job->name = $allData['name'];
		$job->description = $allData['ckeditor'];
		$job->user_id = $user->id;
		$job->is_active = 0;
		$job->is_featured = 0;
    	$job->slug = $slug;
    	$job->job_attributes = $job_attributes;
    	$job->job_summary = $job_summary;
		if (isset($allData['sub_city'])) {
			if ($allData['sub_city']!="") {
				$job->sub_city_id = $allData['sub_city'];
			}
		}
		if (isset($allData['city'])) {
			if ($allData['city']!="") {
				$job->city_id = $allData['city'];
			}
		}
		if (isset($allData['state'])) {
			if ($allData['state']!="") {
				$job->state_id = $allData['state'];
			}
		}
		$job->country_id = $allData['country'];
		$job->latitude = $allData['latitude'];
		$job->longitude = $allData['longitude'];
		$job->zoom = $allData['zoom'];
		//$job->tag = $allData['tags'];

		$job->save();

		$job_id = $job->id;

		$job_categorie = new Job_Categorie();
		$job_categorie->job_id = $job_id;
		$job_categorie->categorie_id = $allData['categorie'];
		if (isset($allData['sub_categorie'])) {
			if ($allData['sub_categorie']!="") {
				$job_categorie->sub_categorie_id = $allData['sub_categorie'];
			}
		}
		$job_categorie->save();

		foreach ($allData['forms'] as $key => $value) {
			if(array_key_exists($key, $allData['attributes'])) {
				//echo "<pre>";print_r($job_attributes);exit;
				$job_attribute = new Job_Attribute();
				$job_attribute->job_id = $job_id;
				$job_attribute->form_id = $value;
				$job_attribute->attribute_id = $allData['attributes'][$key];
				$job_attribute->save();
			}
		}
		return redirect(route('user_job_posted'));
	}

	public function update(Request $request){
		$allData = $request->all();
		$user = Auth::user();
		//echo "<pre>";print_r($allData);exit;
		$job = Job::where('id','=',$allData['job_id'])->first();
		
		$validationArray = Job::getJobPostValidationArray($allData);

		$validator = Validator::make($request->all(), $validationArray);
		if($validator->fails()){

			$tab = \Session::flash('tab',1);
			$categorie_id = \Session::flash('categorie_id',$allData['categorie']);
			$categorie = Job_Categorie::where('categorie_id','=',$allData['categorie'])->first();
			if (empty($categorie)) {
				$categorie_id = \Session::flash('categorie_id',null);
			}else{	
				$categorie_id = \Session::flash('categorie_id',$allData['categorie']);
			}
			//echo "<pre>";print_r($categorie_id);exit;
			if (isset($allData['country']) && trim($allData['country'] ) != '') {
				$country = State::where('country_id','=',$allData['country'])->first();
				//echo "<pre>";print_r($country);exit;
				if (empty($country)) {
					$country_id = \Session::flash('country_id',null);
				}else{	
					$country_id = \Session::flash('country_id',$allData['country']);
				}
			}else{
				$country_id =  \Session::flash('country_id',null);
			}
			
			if (isset($allData['state']) && trim($allData['state'] ) != '') {
				$state = City::where('state_id','=',$allData['state'])->first();
				//echo "<pre>";print_r($state);exit;
				if (empty($state)) {
					$state_id = \Session::flash('state_id',null);
				}else{	
					$state_id = \Session::flash('state_id',$allData['state']);
				}
			}else{
				$state_id = \Session::flash('state_id',null);
			}
			
			if (isset($allData['city'])  && trim($allData['city'] ) != '') {
				$city = Sub_City::where('city_id','=',$allData['city'])->first();
				//echo "<pre>";print_r($city);exit;
				if (empty($city)) {
					$city_id = \Session::flash('city_id',null);
				}else{	
					$city_id = \Session::flash('city_id',$allData['city']);
				}
			}else{
				$city_id = \Session::flash('city_id',null);
			}
			
			if (isset($allData['sub_city'])  && trim($allData['sub_city'] ) != '') {
				$sub_city_id = \Session::flash('sub_city_id',$allData['sub_city']);
			}else{
				$sub_city_id = \Session::flash('sub_city_id',null);
			}

			return redirect(route('edit_job_post',$job->slug))->withErrors($validator)->withInput(\Input::all());
		}	
		//echo "<pre>";print_r($allData);exit;

		$job_summary = Job::getJobSummary($allData);
		//echo "<pre>";print_r($job_summary);exit;

		$job_attributes = Job::getJobAttribute($allData);
		//echo "<pre>";print_r($job_attributes);exit;


		$slug_obj = new Slug;
	    $model_name = 'Job';
	    $slug = $slug_obj->slug($allData['name'] , $model_name, $job->slug);
	    //echo "<pre>";print_r($slug);exit;

	    $job = Job::findOrFail($allData['job_id']);
		$job->name = $allData['name'];
		$job->description = $allData['ckeditor'];
    	if ($slug!=null) {
    		$job->slug = $slug;
    	}
    	$job->job_attributes = $job_attributes;
    	$job->job_summary = $job_summary;
		if (isset($allData['sub_city']) && trim($allData['sub_city']!="")) {
			$job->sub_city_id = $allData['sub_city'];
		}else{
			$job->sub_city_id = null;
		}
		if (isset($allData['city']) && trim($allData['city']!="")) {
			$job->city_id = $allData['city'];
		}else{
			$job->city_id = null;
		}
		if (isset($allData['state']) && trim($allData['state']!="")) {
			$job->state_id = $allData['state'];
		}else{
			$job->state_id = null;
		}
		$job->country_id = $allData['country'];
		$job->latitude = $allData['latitude'];
		$job->longitude = $allData['longitude'];
		$job->zoom = $allData['zoom'];
		//$job->tag = $allData['tags'];

		$job->save();

		$job_categorie = Job_Categorie::where('job_id','=',$allData['job_id'])->first();
		if(empty($job_categorie)){
			$job_categorie = new Job_Categorie();
		}
		$job_categorie->job_id = $allData['job_id'];
		$job_categorie->categorie_id = $allData['categorie'];
		if (isset($allData['sub_categorie']) && trim($allData['sub_categorie']!="")) {
			$job_categorie->sub_categorie_id = $allData['sub_categorie'];
		}else{
			$job_categorie->sub_categorie_id = null;
		}
		$job_categorie->save();

		foreach ($allData['forms'] as $key => $value) {
			if(array_key_exists($key, $allData['attributes'])) {
				//echo "<pre>";print_r($job_attributes);exit;
				$job_attribute = Job_Attribute::where('job_id','=',$allData['job_id'])->where('form_id','=',$value)->first();
				if (empty($job_attribute)) {
					$job_attribute = new Job_Attribute();
				}

				$job_attribute->job_id = $allData['job_id'];
				$job_attribute->form_id = $value;
				$job_attribute->attribute_id = $allData['attributes'][$key];
				$job_attribute->save();	
				
			}
		}
		return redirect(route('user_job_posted'));
	}
}