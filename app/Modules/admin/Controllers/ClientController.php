<?php 

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Req;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Job;
use App\Models\Job_Applied;
use App\Models\Role;
use App\Models\Role_User;

class ClientController extends Controller {

  protected $limit;
  protected $count;

  public function __construct() {
    $this->limit = 20;
    $this->count = 0;
  }

  public function index() {
    $this->count = User::count();
    $users = User::whereNull('is_admin')->orWhere('is_admin','=',0)->orderBy('created_at', 'desc')->paginate($this->limit)->toArray();
    //echo "<pre>";print_r($user);exit;
    foreach ($users['data'] as $key => $value) {
      $job_applied_count = Job_Applied::where('user_id',$value['id'])->count();
      $job_posted_count = Job::where('user_id',$value['id'])->count();
      $users['data'][$key]['job_applied_count'] = $job_applied_count;
      $users['data'][$key]['job_posted_count'] = $job_posted_count;
    }
    return view('admin::admin.site_users.index', array('users' => $users, 'count' => $this->count, 'index' => $this->limit));
  }

  public function listing() {
    $page = \Input::get('page',0);
    $searchTxt = \Input::get('search',"");
    $searchDate = \Input::get('date',"");
    $selectedTxt = \Input::get('select',"");

    $where = "";
    if($searchTxt != ""){
      $where .= " ( ( first_name like '%$searchTxt%' ) OR (last_name like '%$searchTxt%') ) AND ";
    }
    if($searchDate != ""){
      $where .= " date_of_birth = '$searchDate' AND ";
    }
    if($selectedTxt != ""){
        $where .= " ( active like '%$selectedTxt%') AND ";
    }
    $where .= " 1 = 1 ";

    $users = User::whereRaw($where)->where('is_admin','=',0)->orderBy('created_at', 'desc')->paginate($this->limit)->toArray();
    foreach ($users['data'] as $key => $value) {
        $job_applied_count = Job_Applied::where('user_id',$value['id'])->count();
        $job_posted_count = Job::where('user_id',$value['id'])->count();
        $users['data'][$key]['job_applied_count'] = $job_applied_count;
        $users['data'][$key]['job_posted_count'] = $job_posted_count;
      }
    //echo "<pre>";print_r($users);exit;
    return view('admin::admin.site_users.listing', array('users' => $users));
  }

  public function destroy($id)
  {  
    $job_applied = Job_Applied::where('user_id', '=', $id)->get();
    if (!empty($job_applied)) {
        foreach ($job_applied as $key => $value) {
          $value->delete();
            //Job_Applied::destroy($value['id']);
        }
    }
    $user = User::findOrFail($id);
    $user->delete();

    \Session::flash('flash_message', 'User deleted!');

    return redirect(route('site_users'));
  }

  public function block($id)
  {   
    $user = User::findOrFail($id);
    if ($user->active==1) {
        $user->active = 0;
        \Session::flash('flash_message', 'User Blocked!');
    }else{
        $user->active = 1;
        \Session::flash('flash_message', 'User Unblocked!');
    }
    $user->save();

    return redirect('admin/site_users');
  }

  public function showAppliedjob($id) {
    //echo "<pre>";print_r($id);exit;
    $job_applied = Job_Applied::where('user_id','=',$id)->get()->toArray();
    //echo "<pre>";print_r($user_applied);exit;
    if (!empty($job_applied)) {
      foreach ($job_applied as $key => $value) {
      $jobs[$key] = Job::where('id','=',$value['job_id'])->first(array("id","name"))->toArray();
      $jobs[$key]['created_at'] = $value['created_at'];
      }
    }else{
        $jobs = array();
    }
    //echo "<pre>";print_r($jobs);exit;
    return view('admin::admin.site_users.show_applied_job',compact('jobs'));
  }

  public function showPostedjob($id) {

    $jobs= Job::where('user_id','=',$id)->get(array("id","name","created_at"))->toArray();

    return view('admin::admin.site_users.show_posted_job',compact('jobs'));
  }

  public function changePassword($id) {
    return view('admin::admin.site_users.change_password',compact('id'));
  }
 
  public function storePassword(Request $request) {
    $allData = $request->all();
    //echo "<pre>";print_r($allData);exit;
    $validate = Validator::make($allData, [
          'password'=> 'required',
          'confirm_password'=> 'required|same:password'
          ]);
    if ($validate->fails()) {
      return redirect()->back()->withErrors($validate);
    }
    $user = User::findOrFail($allData['id']);
    //echo "<pre>";print_r($user);exit;
    $user->password = bcrypt($allData['password']);
    $user->save();
      
      return redirect(route('site_users'));
    }
}