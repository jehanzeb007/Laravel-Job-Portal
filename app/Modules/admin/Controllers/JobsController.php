<?php 
namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Req;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Job;
use App\Models\Job_Applied, App\Models\Job_Attribute, App\Models\Job_Categorie;
use App\Models\User;

class JobsController extends Controller {

    protected $limit;
    protected $count;

    public function __construct() {
        $this->limit = 20;
        $this->count = 0;
    }

    public function index() {

        $this->count = Job::count();
        $jobs = Job::join('users','jobs.user_id','=','users.id')
        ->orderBy('jobs.created_at', 'desc')
        ->select('*','jobs.id as job_id','jobs.created_at as job_created_at')
        ->paginate($this->limit)->toArray();
        foreach ($jobs['data'] as $key => $value) {
            $count = Job_Applied::where('job_id',$value['job_id'])->count();
            $jobs['data'][$key]['count'] = $count;
        }
        return view('admin::admin.jobs.index', array('jobs' => $jobs, 'count' => $this->count, 'index' => $this->limit));
    }
    
    public function listing() {
        $page = \Input::get('page',0);
        $searchTxt = \Input::get('search',"");
        $selectedTxt = \Input::get('select',"");
        //echo "<pre>";print_r($selectedTxt);exit;
        $where = "";
        if($searchTxt != ""){
          $where .= " ( name like '%$searchTxt%') AND ";
        }
        if($selectedTxt != ""){
          $where .= " ( is_active like '%$selectedTxt%') AND ";
        }
        $where .= " 1 = 1 ";
        $jobs = job::whereRaw($where)->join('users','jobs.user_id','=','users.id')
        ->orderBy('jobs.created_at', 'desc')
        ->select('*','jobs.id as job_id','jobs.created_at as job_created_at')
        ->paginate($this->limit)->toArray();
        foreach ($jobs['data'] as $key => $value) {
            $count = Job_Applied::where('job_id',$value['job_id'])->count();
            $jobs['data'][$key]['count'] = $count;
        }
        return view('admin::admin.jobs.listing', array('jobs' => $jobs));
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
        return redirect('admin/jobs');
    }
        
    public function block($id)
    {   
        $job = Job::findOrFail($id);
        if ($job->is_active==1) {
            $job->is_active = 0;
            \Session::flash('flash_message', 'Job Blocked!');
        }else{
            $job->is_active = 1;
            \Session::flash('flash_message', 'Job Unblocked!');
        }
        $job->save();
        
        return redirect('admin/jobs');
    }
    public function feature($id)
    {   
        $job = Job::findOrFail($id);
        if ($job->is_featured==1) {
            $job->is_featured = 0;
            \Session::flash('flash_message', 'Job Unfeatured!');
        }else{
            $job->is_featured = 1;
            \Session::flash('flash_message', 'Job Featured!');
        }
        $job->save();
        
        return redirect('admin/jobs');
    }
    public function showAppliedUser($id) {
        $job_applied = Job_Applied::where('job_id','=',$id)->get()->toArray();
        if (!empty($job_applied)) {
            foreach ($job_applied as $key => $value) {
            $users[$key] = User::where('id','=',$value['user_id'])->first(array("id","email_address","first_name","last_name"))->toArray();
            $users[$key]['created_at'] = $value['created_at'];
            }
        }else{
            $users = array();
        }
        return view('admin::admin.jobs.show_applied_user',compact('users'));
    }
}