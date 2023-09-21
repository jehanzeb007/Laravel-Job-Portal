<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use App\Models\Country, App\Models\State, App\Models\City, 
	App\Models\Sub_City, App\Models\Categorie, App\Models\Job;

class Slug{

	public function slug($string, $model_name, $old_slug){
		//echo "<pre>";print_r($model_name );exit;
		
		$slug = Str::slug($string);
		if ($old_slug == $slug) {
			return null;
		}else{
			// /die('here');
		    //echo "<pre>";print_r($slug );exit;
		    if ($model_name == "Country") {
		    	$model = new Country();
		    }else if($model_name == "State"){
		    	$model = new State();
		    }else if($model_name == "City"){
		    	$model = new City();
		    }else if($model_name == "Sub_City"){
		    	$model = new Sub_City();
		    }else if($model_name == "Categorie"){
		    	$model = new Categorie();
		    }else if($model_name == "Job"){
		    	$model = new Job();
		    }
		    $data = $model->where('slug','=',$slug)->first();
		    // /echo "<pre>";print_r($data);exit;
		    if (!empty($data)) {
		      $ran_num = rand(1,1000);
		      $slug = $slug.$ran_num;
		      //echo "<pre>";print_r($slug);exit;
		    }

		    return $slug;
			//die('slug');
		}
		
		
		
	}
} 