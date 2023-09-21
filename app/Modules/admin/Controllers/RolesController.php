<?php 

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Req;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Permission_Role;

class RolesController extends Controller {

    protected $limit;
    protected $count;

    public function __construct() {
        $this->limit = 20;
        $this->count = 0;
    }

    public function index() {
        $this->count = Role::count();
        $role = Role::orderBy('created_at', 'desc')->paginate($this->limit);
        return view('admin::admin.roles.index', array('role' => $role, 'count' => $this->count, 'index' => $this->limit));
    }

    public function listing() {
      $page = \Input::get('page',0);
      $searchTxt = \Input::get('search',"");
      $searchDate = \Input::get('date',"");

      $where = "";
      if($searchTxt != ""){
        $where .= " ( name like '%$searchTxt%') AND ";
      }
      if($searchDate != ""){
        $where .= " date_of_birth = '$searchDate' AND ";
      }
      $where .= " 1 = 1 ";
      $role = Role::whereRaw($where)->orderBy('created_at', 'desc')->paginate($this->limit);
      return view('admin::admin.roles.listing', array('role' => $role));
    }

    public function add() {
        $permission = Permission::getPermissions();
        return view('admin::admin.roles.add',compact('permission'));
    }
    
    public function store(Request $request) {

        $req = $request->all();
        //echo "<pre>";print_r($req );exit;
        $validationArray = Role::getUserValidationArray();
        $this->validate($request, $validationArray);
        
        $role= Role::create([
           'name' => $request['name'],
           'display_name' => $request['display_name'],
           'description' => $request['description'],
          ]);

        $role_id = $role->id;
        $role = Role::where('id','=',$role_id)->first();
        
        if(isset($req['child_name'])){
        $permissionArr = array();
        foreach ($req['child_name'] as $key => $value) {
            //echo "<pre>";print_r($key );exit;
            $permission = Permission::where('id','=',$key)->first();
            //echo "<pre>";print_r($permission );exit;
            //$role->attachPermission($permission);
            Permission_Role::create([
           'permission_id' => $key,
           'role_id' => $role_id,
          ]);
        }
      }

      \Session::flash('success_msg', 'Role added!');
      return redirect(route('roles'));
    }

    public function edit($id) {

        $role = Role::findOrFail($id);
        $permission = Permission::getPermissions();

        $permission_role = Permission_Role::where("role_id",$id)->get()->toArray();
        //echo "<pre>";print_r($permission_role );exit;
        $permission_id = array();
        foreach ($permission_role as $key => $value) {
          
            $permission_id[$value['permission_id']] = $value['permission_id'];

        }
        //echo "<pre>";print_r($permission_id );exit;
        return view('admin::admin.roles.edit',  compact('role','permission','permission_id'));
    }

    public function update(Request $request)  {
      
        $role_id = $request->id;
        $role = Role::findOrFail($role_id);
        $permission_array = array();
        $alldata = $request->all();
        //echo "<pre>";print_r($alldata);exit;
        $validationArray = Role::getUserValidationArray();
        $this->validate($request, $validationArray);

        $role->name = $alldata['name'];
        $role->display_name = $alldata['display_name'];
        $role->description = $alldata['description'];
        $role->save();

        if (!empty($alldata['child_name'])) {

          foreach ($alldata['child_name'] as $key => $value) {
            $permission_array[$key] = $value;
          }

        }
        //echo "<pre>";print_r($permission_array);exit;

        if( empty($permission_array) ){
          Permission_Role::where("role_id","=",$role_id)->delete();
        }else{
          $permission_key = array_keys($alldata['child_name']);
          Permission_Role::where("role_id","=",$role_id)->whereNotIn('permission_id', $permission_key )->delete();
        }
        
        
        //$permission_role = array();
        foreach ($permission_array as $key => $value) {
          //echo "<pre>";print_r($alldata['child_name'] );exit;

          $permission_role = Permission_Role::where("role_id","=",$role_id)->where("permission_id","=",$key)->first();
          //echo "<pre>";print_r($permission_role);
          
          if(!$permission_role){
            $permission_role = new Permission_Role;
            //echo "<pre>";print_r($permission_role);
          }
          //echo "<pre>";print_r($permission_role->toArray());exit;
          $permission_role->permission_id = $key;
          $permission_role->role_id = $role_id;
          $permission_role->save(); 
        }
        //echo "<pre>";print_r($permission_role);exit;

        \Session::flash('success_msg', 'Role successfully updated!');

        return redirect(route('roles'));
        exit;
    }
    public function destroy($id)
    {   
        Role::destroy($id);
        //die('here');
        \Session::flash('flash_message', 'Role deleted!');

        return redirect('admin/roles');
    }

}