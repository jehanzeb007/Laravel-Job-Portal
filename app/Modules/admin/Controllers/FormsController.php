<?php 

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Req;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Form;

class FormsController extends Controller {

  protected $limit;
  protected $count;

  public function __construct() {
    $this->limit = 20;
    $this->count = 0;
  }

  public function index() {
    $this->count = Form::count();
    $form = Form::where('parent_id','=',null)->orderBy('created_at', 'desc')->paginate($this->limit);
    return view('admin::admin.forms.index', array('form' => $form, 'count' => $this->count, 'index' => $this->limit));
  }

  public function listing() {

    $page = \Input::get('page',0);
    $searchTxt = \Input::get('search',"");
    //die('here');
    $where = "";
    if($searchTxt != ""){
      $where .= " ( name like '%$searchTxt%') AND ";
    }
    $where .= " 1 = 1 ";
    $form = Form::whereRaw($where)->where('parent_id','=',null)->orderBy('created_at', 'desc')->paginate($this->limit);
    //echo "<pre>";print_r($form);exit;
    return view('admin::admin.forms.listing', array('form' => $form));
  }

  public function add() {
    $form = Form::getForms();
    //echo "<pre>";print_r($form);exit;
    return view('admin::admin.forms.add',compact('form'));
  }
  
  public function store(Request $request) {

    $req = $request->all();
    //echo "<pre>";print_r($req );exit;
    $validationArray = Form::getFormValidationArray();
    $this->validate($request, $validationArray);
    
    if(isset($request['placement_option']) && $request['placement_option']!=null){
      $placement_option = implode(",", $request['placement_option']);
    }
    
    //echo "<pre>";print_r($string );exit;
    $form= new Form;
    $form->name = $request['name'];
    if (isset($placement_option) && $placement_option =! null) {
      $form->placement_options = $placement_option;
    }else{
      $form->placement_options = null;
    }
    
    $form->save();

    \Session::flash('success_msg', 'Form added!');
    return redirect(route('add_form'));
  }

  public function edit($id) {

    $form = Form::findOrFail($id);
    //echo "<pre>";print_r($form);exit;
    $forms = Form::getforms();

    return view('admin::admin.forms.edit', compact('form','forms'));
  }

  public function update(Request $request)  {
      
    $alldata = $request->all();
    //echo "<pre>";print_r($alldata);exit;

    $form_id = $request->id;
    $form = Form::findOrFail($form_id);

    $validationArray = Form::getFormValidationArray();
    $validationArray['name'] = 'required|unique:form_attributes,name,'.$form_id;
    $this->validate($request, $validationArray);
    
    if(isset($request['placement_option']) && $request['placement_option']!=null){
      $placement_option = implode(",", $request['placement_option']);
    }
    //echo "<pre>";print_r($placement_option);exit;
    
    $form->name = $request['name'];
    if (isset($placement_option)) {
      $form->placement_options = $placement_option;
    }else{
      $form->placement_options = null;
    }
      
    $form->save();

    \Session::flash('success_msg', 'Form successfully updated!');

    return redirect(route('edit_form',$form_id));
    exit;
  }
  
  public function destroy($id){  

    $form = Form::where('parent_id','=',$id)->get()->toArray();
    $attribute = Form::where('id','=',$id)->first(array("parent_id"))->toArray();
    if (!empty($form)) {
      foreach ($form as $key => $value) {
        Form::destroy($value['id']);
      }
      Form::destroy($id);
      return redirect('admin/forms');
    }else{
      Form::destroy($id);
      \Session::flash('success_message', 'Form deleted!');
      return redirect(route('show_attribute',$attribute['parent_id']));
    } 
  }

  public function addEditAttribute($id) {
    $form = Form::findOrFail($id);
    $attributes = Form::where('parent_id','=',$id)->get(array('id','name'))->toArray();
    //echo "<pre>";print_r($attributes);exit;
    return view('admin::admin.forms.add_edit_attribute',compact('form','attributes'));
  }

  public function saveAttribute(Request $request) {

    $req = $request->all();
    //echo "<pre>";print_r($req);exit;

    $validator = Validator::make($req, ['name.*'=>'required']);
    $remove = array();
    $remove = explode(",", $req['remove_id']);
    \Session::flash('remove', $req['remove_id']);

    if ($validator->fails())
    { 
      $form = Form::findOrFail($req['id']);
      $attributes = array();
      foreach ($req['name'] as $key => $value) {
        
          if(array_key_exists($key, $req['name_id'])) {
            $attributes[$key]['id'] = $req['name_id'][$key];
            $attributes[$key]['name'] = $value;
          }else{
            $attributes[$key]['id'] = null;
            $attributes[$key]['name'] = $value;
          }
      }
      //echo "<pre>";print_r($attributes);exit;
      return view('admin::admin.forms.add_edit_attribute',compact('attributes','form'))->withErrors($validator);
    }
    //echo "<pre>";print_r($req);exit;
    $remove = array();
    $remove = explode(",", $req['remove_id']);
    //echo "<pre>";print_r($remove);exit;
    if (!empty($remove)) {
      foreach ($remove as $key => $value) {
        if ($key!=0 && $value!='undefined' && $value!='0') {
          if(!in_array($value, $req['name_id'])) {
            Form::destroy($value);
          }
        }
      }
    }

    foreach ($req['name'] as $key => $value) {
      if(array_key_exists($key, $req['name_id'])) {
        if ($req['name'][$key]!=null) {
          //echo "<pre>";print_r($req['name_id'][$key]);exit;
          if (empty($req['name_id'][$key])) {
            $form= new Form;
            $form->name = $req['name'][$key];
            $form->parent_id = $req['id'];
            $form->save();
          } else {
            $id = $req['name_id'][$key];
            $form = Form::findOrFail($id);
            //echo "<pre>";print_r($req['name'][$key]);exit;
            $form->name = $req['name'][$key];
            $form->parent_id = $req['id'];
            $form->save();
          }
        }
      }
      //echo "<pre>";print_r($value);
    }
    \Session::flash('success_msg', 'Attribute added!');
    return redirect(route('add_edit_attribute',$req['id']));
  }

  public function showAttribute($id) {
    $form = Form::findOrFail($id);
    $attributes = Form::where('parent_id','=',$id)->get(array('id','name'))->toArray();
    //echo "<pre>";print_r($form->toArray());exit;
    return view('admin::admin.forms.show_attribute',compact('form','attributes'));
  }

}