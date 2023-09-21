<?php 

namespace App\Modules\Admin\Controllers;

use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Req;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;
use App\Models\Role_User;

class UsersController extends Controller {

    protected $limit;
    protected $count;

    public function __construct() {
      //$this->middleware('guest', ['except' => 'logout']);
        $this->limit = 20;
        $this->count = 0;
    }

    public function index() {
      //exit('here');
        $this->count = User::count();
        $user = User::where('is_admin','=',1)->orderBy('created_at', 'desc')->paginate($this->limit);
        return view('admin::admin.users.index', array('user' => $user, 'count' => $this->count, 'index' => $this->limit));
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
      $user = User::whereRaw($where)->where('is_admin','=',1)->orderBy('created_at', 'desc')->paginate($this->limit);
      //echo "<pre>";print_r($user);exit;
      return view('admin::admin.users.listing', array('user' => $user));
    }

    public function add() {

        $roles = Role::get()->toArray();
        $role_names = [];
        foreach ($roles as $key => $value) {
          $role_names[$value['id']] = $value['name'];
        }
        //echo "<pre>";print_r($role_names);exit;
        return view('admin::admin.users.add',compact('role_names'));
    }
    

    public function store(Request $request) {
      $allData = $request->all();
      //echo "<pre>";print_r($allData['image_name']);exit;

      $validationArray = User::getUserValidationArray();
      if(isset($allData['roles_assigned'])){
        $role = [];
        foreach ($allData['roles_assigned'] as $key => $value) {
          $role[] = Role::where('id','=',$value)->get(array('id','name'))->toArray();
        }
        $role_names = [];
        foreach ($role as $key => $value) {
          $role_names[$value[0]['id']] = $value[0]['name'];
        }
        \Session::flash('roles_assigned', $role_names);
        $validationArray['roles_assigned'] = ''; 
      }
      if(isset($allData['roles'])){
        $role = [];
        foreach ($allData['roles'] as $key => $value) {
          $role[] = Role::where('id','=',$value)->get(array('id','name'))->toArray();
        }
        $role_names = [];
        foreach ($role as $key => $value) {
          $role_names[$value[0]['id']] = $value[0]['name'];
        }
        \Session::flash('roles', $role_names);
      }else{
        $role_names = 'a';
        \Session::flash('roles', $role_names);
      }
      //echo "<pre>";print_r(\Session::get('roles'));exit;

      $this->validate($request, $validationArray);

      $user = new User;
      
      $user->first_name = $allData['first_name'];
      $user->last_name = $allData['last_name'];
      $user->email_address = $allData['email_address'];
      $user->password = bcrypt($allData['password']);
      $user->is_admin = 1;
      
      $user->save();
      $user_id = $user->id;
      
      $current_user = User::where('id','=',$user_id)->first();
      //echo "<pre>";print_r($current_user);exit;
       if(isset($allData['roles_assigned'])){
        foreach ($allData['roles_assigned'] as $key => $value) {
        $role = Role::where('id','=',$value)->first();
          //echo "<pre>";print_r($role);exit;
          
          $current_user->attachRole($role); 
        }
      }
      \Session::flash('success_msg', 'User added!');
      return redirect(route('users'));
    }

    public function edit($id) {

      $user = User::findOrFail($id);


      $role_user = Role_User::where("user_id","=",$id)->get()->toArray();
      $roles_assigned = [];      
      foreach ($role_user as $key => $value) {
          $assign_role_name = Role::where('id','=',$value['role_id'])->get(array("name"))->toArray();
          $roles_assigned[$value['role_id']] = $assign_role_name['0']['name'];
      } 

      $role = Role::get(array("id","name"))->toArray();
      $roles = [];
      foreach ($role as $key => $value) {
        $roles[$value['id']] = $value['name'];
      }

      $allroles =  array_diff($roles, $roles_assigned);
      return view('admin::admin.users.edit',  compact('user','roles_assigned','allroles'));
    }

    public function update(Request $request)  {
      
      $id = $request->id;
      $user = User::findOrFail($id);

      $allData = $request->all();
      //echo "<pre>";print_r($allData);exit;
      $validationArray = User::getUserValidationArray();
      $validationArray['email_address'] = 'required|email|max:255|unique:users,email_address,'.$id;
      $validationArray['password'] = '';
      $validationArray['confirm_password'] = 'same:password';

      $validation = Validator::make($allData,$validationArray);
      if ( !$validation->passes() ) {
        return redirect('admin/users/edit/'.$id)
                        ->withInput()
                        ->withErrors($validation)
                        ->with('message', 'There were validation errors.');
      }
      
      $user->first_name = $allData['first_name'];
      $user->last_name = $allData['last_name'];
      $user->email_address = $allData['email_address'];
      $user->password = bcrypt($allData['password']);

        $user->is_admin = 1;

      $user->save();

      //echo "<pre>";print_r($user_roleValues);exit;

      if( empty($allData['roles_assigned']) ){
        Role_User::where("user_id","=",$id)->delete();
      }else{
        $user_roleValues = array_values($allData['roles_assigned']);
        Role_User::where("user_id","=",$id)->whereNotIn('role_id', $user_roleValues)->delete();
      }

      if(isset($allData['roles_assigned'])){
        foreach ($allData['roles_assigned'] as $key => $value) {

          //echo "<pre>";print_r($value);exit;
          $role_user = Role_User::where('user_id','=',$id)->where('role_id','=',$value)->first();
          if(!$role_user){
            $role_user = new Role_User;
          }
          //echo "<pre>";print_r($role_user);exit;
          $role_user->user_id = $id;
          $role_user->role_id = $value;
          $role_user->save(); 
        }
      }

        \Session::flash('success_msg', 'User successfully updated!');

        return redirect(route('users'));
        exit;
    }

    public function destroy($id)
    { //die('here');
        //User::destroy($id);
        /*$user_role = Role_User::where('user_id', '=', $id)->get();
        if (!empty($user_role)) {
            foreach ($user_role as $key => $value) {
              //echo "<pre>";print_r($value);exit;
                $value->delete();
            }
        }*/
        $user = User::findOrFail($id);
        $user->delete();

        \Session::flash('flash_message', 'User deleted!');

        return redirect('admin/users');
    }

    public function changePassword() {
      return view('admin::admin.users.change_password');
    }
   
    public function storePassword(Request $request) {
      $allData = $request->all();
      $current_user = Auth::user();
      $user = User::findOrFail($current_user->id)->first();
      //echo "<pre>";print_r($user['password']);exit;
      $user_password = $user->password;
      $old_password = $allData['old_password'];
      //echo "<pre>";print_r($old_password);exit;
      if (Hash::check($old_password, $user_password) || $old_password=="") {
        $validate = Validator::make($allData, [
            'old_password'=> 'required',
            'new_password'=> 'required',
            'confirm_new_password'=> 'required|same:new_password'
            ]);
        if ($validate->fails()) {
          return redirect()->back()->withErrors($validate);
        }
        $user->password = bcrypt($allData['new_password']);
        $user->save();
        return redirect(route('users'));
      }
      else{
        return redirect()->back()->withErrors(['Wrong Password']);
      }  
    }
}