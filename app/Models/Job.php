<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Form;
use App\Models\City, App\Models\Sub_City, App\Models\State, App\Models\Country, App\Models\Categorie;
use App\Helpers\TimeSpan;

class Job extends Model{

    use SoftDeletes;

    protected $primaryKey = 'id';

    public static $userValidation = array();

    protected $table = 'jobs';

    
    public static function getJob(){
        
        $job = Job::get(array("id","name"));

        $jobArr = array('' => 'Select Job');
        foreach($job as $job){
            $jobArr[$job->id] = $job->name;
        }
        return $jobArr;
    }

    public static function getUserValidationArray(){
        
        $userValidation = array(
            'name' => 'required', 
            'description' => 'required',
        );
        
        return $userValidation;
    }

    public static function getJobPostValidationArray($allData){

        $validationArray = [
            'name' => 'required',
            'ckeditor' => 'required',
            'attributes.*' => 'required',
            'categorie' => 'required',
            'country' => 'required'
        ];
        if (isset($allData['state']) && trim($allData['state'] ) != '') {
            $validationArray['state'] = 'required';
        }
        if (isset($allData['city']) && trim($allData['city'] ) != '') {
            $validationArray['city'] = 'required';
        }
        if (isset($allData['sub_city']) && trim($allData['sub_city'] ) != '') {
            $validationArray['sub_city'] = 'required';
        }
        if (isset($allData['sub_categorie']) && trim($allData['sub_categorie'] ) != '') {
            $validationArray['sub_categorie'] = 'required';
        }
        
        return $validationArray;
    }

    public static function getJobSummary($allData){
        
        $country = Country::where('id','=',$allData['country'])->first();
        $categorie = Categorie::where('id','=',$allData['categorie'])->first();
        //echo "<pre>";print_r($categorie);exit;
        if (isset($allData['state'])) {
            $state = State::where('id','=',$allData['state'])->first();
        }
        if (isset($allData['city'])) {
            $city = City::where('id','=',$allData['city'])->first();
        }
        if (isset($allData['sub_city'])) {
            $sub_city = Sub_City::where('id','=',$allData['sub_city'])->first();
        }
        $job_summary = ['name'=>$allData['name'], 'description'=>$allData['ckeditor'], 'country'=>$country->name, 'categorie'=>$categorie->name];
        if(isset($state) && trim($state) != ''){
            $job_summary['state'] = $state->name;
        }
        if(isset($city) && trim($city) != ''){
            $job_summary['city'] = $city->name;
        }
        if(isset($sub_city) && trim($sub_city) != ''){
            $job_summary['sub_city'] = $sub_city->name;
        }       
        if (isset($allData['sub_categorie'])) {
            $sub_categorie = Categorie::where('id','=',$allData['sub_categorie'])->first();
        }
        if(isset($sub_categorie) && trim($sub_categorie) != ''){
            $job_summary['sub_categorie'] = $sub_categorie->name;
        }
        
        $job_summary = serialize($job_summary);
        
        return $job_summary;
    }

    public static function getJobAttribute($allData){
        
        foreach ($allData['forms'] as $key => $value) {
            if(array_key_exists($key, $allData['attributes'])) {
                
                $form = Form::where('id','=',$value)->first();
                $attribute = Form::where('id','=',$allData['attributes'][$key])->first();
                $job_attributes[$form->name] = $attribute->name;
                }
        }
        $job_attributes = serialize($job_attributes);

        return $job_attributes;
    }

    public static function getJobListing($job,$featured_job,$jobByCategorie){
        if($job==null){
            $job = $featured_job;
        }
        foreach ($job as $key => $value) {

            $where="";
            if ($featured_job==null) {
                $where .= " ( placement_options like '%home_latest_job%') AND  1 = 1 ";
            }else{
                $where .= " ( placement_options like '%home_featured_job%') AND  1 = 1 ";
            }
            $attribute = Job::getJopAttributes($where, $value);

            if ($jobByCategorie==null) {
                $job_category = Job_Categorie::where('job_id','=',$value->id)->first();
            }else{
                $job_category = Job_Categorie::where('job_id','=',$value->job_id)->first();
            }
            $category = Categorie::where('id','=',$job_category['categorie_id'])->first();
            $user = User::where('id','=',$value->user_id)->first();
            $job[$key]['category'] = $category['icon'];
            //echo "<pre>";print_r($value->id);exit;
            $job[$key]['first_name'] = $user['first_name'];
            $job[$key]['last_name'] = $user['last_name'];
            $job[$key]['company_name'] = $user['company_name'];
            $job[$key]['attribute'] = $attribute;
            if ($featured_job!=null) {
                $timespan = TimeSpan::time_passed($value->created_at);
                $job[$key]['timespan'] = $timespan;
            }
        }
        //echo "<pre>";print_r($job);exit;
        return $job;
    }

    public static function getJopAttributes($where, $value){
        $job_attributes = unserialize($value->job_attributes);
        //echo "<pre>";print_r($job_attributes);exit;
        $form_attributes = Form::whereRaw($where)->get();
        $attribute = array();
        foreach ($form_attributes as $k => $v) {
            
            $attribute[$v->name] = $job_attributes[$v->name];
        }
        //echo "<pre>";print_r($attribute);exit;
        //echo "<pre>";print_r($form_attributes->toArray());exit;
        return $attribute;
    }

    public function users(){
        return $this->belongsToMany('App\Models\User');
    }
    public function categories(){
        return $this->belongsToMany('App\Models\Categorie');
    }

    protected $fillable = ['name','description','is_active','user_id', 'slug','sub_city_id','city_id','state_id','country_id','latitude','longitude','created_at','updated_at'];
    protected $dates = ['deleted_at'];
    
}