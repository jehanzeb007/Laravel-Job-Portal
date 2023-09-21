<?php 

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Req;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\State;
use App\Models\Country;
use App\Helpers\Slug;

class StatesController extends Controller {

  protected $limit;
  protected $count;

  public function __construct() {
    $this->limit = 20;
    $this->count = 0;
  }

  public function index() {
    $this->count = State::count();
    $state = State::join('countries','states.country_id','=','countries.id')
    ->orderBy('states.created_at', 'desc')
    ->select('*','states.id as states_id','states.name as state_name','states.longitude as longitude','states.latitude as latitude')
    ->paginate($this->limit);
    //echo "<pre>";print_r($state->toArray());exit;
    return view('admin::admin.states.index', array('state' => $state, 'count' => $this->count, 'index' => $this->limit));
  }

  public function listing() {

    $page = \Input::get('page',0);
    $searchTxt = \Input::get('search',"");
    //die('here');
    $where = "";
    if($searchTxt != ""){
      $where .= " ( states.name like '%$searchTxt%') AND ";
    }
    $where .= " 1 = 1 ";
    $state = State::whereRaw($where)->join('countries','states.country_id','=','countries.id')
    ->orderBy('states.created_at', 'desc')
    ->select('*','states.id as states_id','states.name as state_name','states.longitude as longitude','states.latitude as latitude')
    ->paginate($this->limit);
    //echo "<pre>";print_r($state);exit;
    return view('admin::admin.states.listing', array('state' => $state));
  }

  public function add() {
    $countries = Country::getCountries();
    //echo "<pre>";print_r($countries);exit;
    return view('admin::admin.states.add',compact('countries'));
  }
  
  public function store(Request $request) {

    $req = $request->all();
    //echo "<pre>";print_r($req );exit;
    $validationArray = State::getStateValidationArray();
    $this->validate($request, $validationArray);

    $slug_obj = new Slug;
    $model_name = 'State';
    $slug = $slug_obj->slug($req['name'] , $model_name, null);
  
    $state= new State;
    $state->name = $request['name'];
    $state->country_id = $request['country'];
    $state->longitude = $request['longitude'];
    $state->latitude = $request['latitude'];
    $state->slug = $slug;

    $state->save();

    \Session::flash('success_msg', 'State added!');
    return redirect(route('add_state'));
  }

  public function edit($id) {

    $state = State::findOrFail($id);
    //echo "<pre>";print_r($state);exit;
    $countries = Country::getCountries();

    return view('admin::admin.states.edit',  compact('state','countries'));
  }

  public function update(Request $request)  {
      
    $alldata = $request->all();
    //echo "<pre>";print_r($alldata);exit;

    $state_id = $request->id;
    $state = State::findOrFail($state_id);


    $validationArray = State::getStateValidationArray();
    $validationArray['name'] = 'required|unique:states,name,'.$state_id;
    $this->validate($request, $validationArray);

    $slug_obj = new Slug;
    $model_name = 'State';
    $slug = $slug_obj->slug($alldata['name'] , $model_name, $alldata['old_slug']);

    $state->name = $request['name'];
    $state->country_id = $request['country'];
    $state->longitude = $request['longitude'];
    $state->latitude = $request['latitude'];
    if ($slug!=null) {
      $state->slug = $slug;
    }
    
    $state->save();

    \Session::flash('success_msg', 'state successfully updated!');

    return redirect(route('edit_state',$state_id));
    exit;
  }
  public function destroy($id)
  {   
    State::destroy($id);

    \Session::flash('flash_message', 'State deleted!');

    return redirect('admin/states');
  }

}