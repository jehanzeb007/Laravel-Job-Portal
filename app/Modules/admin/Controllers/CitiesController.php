<?php 

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Req;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\State;
use App\Models\City;
use App\Helpers\Slug;

class CitiesController extends Controller {

  protected $limit;
  protected $count;

  public function __construct() {
    $this->limit = 20;
    $this->count = 0;
  }

  public function index() {
    $this->count = City::count();
    $city = City::join('states','cities.state_id','=','states.id')
    ->orderBy('cities.created_at', 'desc')
    ->select('*','cities.id as cities_id','cities.name as city_name','cities.longitude as longitude','cities.latitude as latitude')
    ->paginate($this->limit);
    //echo "<pre>";print_r($city->toArray());exit;
    return view('admin::admin.cities.index', array('city' => $city, 'count' => $this->count, 'index' => $this->limit));
  }

  public function listing() {

    $page = \Input::get('page',0);
    $searchTxt = \Input::get('search',"");
    //die('here');
    $where = "";
    if($searchTxt != ""){
      $where .= " ( cities.name like '%$searchTxt%') AND ";
    }
    $where .= " 1 = 1 ";
    $city = City::whereRaw($where)->join('states','cities.state_id','=','states.id')
    ->orderBy('cities.created_at', 'desc')
    ->select('*','cities.id as cities_id','cities.name as city_name','cities.longitude as longitude','cities.latitude as latitude')
    ->paginate($this->limit);
    //echo "<pre>";print_r($city);exit;
    return view('admin::admin.cities.listing', array('city' => $city));
  }

  public function add() {
    $states = State::getStates();
    //echo "<pre>";print_r($states);exit;
    return view('admin::admin.cities.add',compact('states'));
  }
  
  public function store(Request $request) {

    $req = $request->all();
    //echo "<pre>";print_r($req );exit;
    $validationArray = City::getCityValidationArray();
    $this->validate($request, $validationArray);

    $slug_obj = new Slug;
    $model_name = 'City';
    $slug = $slug_obj->slug($req['name'] , $model_name, null);
  
    $city= new City;
    $city->name = $request['name'];
    $city->state_id = $request['state'];
    $city->longitude = $request['longitude'];
    $city->latitude = $request['latitude'];
    $city->slug = $slug;

    $city->save();

    \Session::flash('success_msg', 'City added!');
    return redirect(route('add_city'));
  }

  public function edit($id) {

    $city = City::findOrFail($id);
    //echo "<pre>";print_r($city);exit;
    $states = State::getStates();

    return view('admin::admin.cities.edit',  compact('city','states'));
  }

  public function update(Request $request)  {
      
    $alldata = $request->all();
    //echo "<pre>";print_r($alldata);exit;

    $city_id = $request->id;
    $city = City::findOrFail($city_id);


    $validationArray = City::getCityValidationArray();
    $validationArray['name'] = 'required|unique:cities,name,'.$city_id;
    $this->validate($request, $validationArray);

    $slug_obj = new Slug;
    $model_name = 'City';
    $slug = $slug_obj->slug($alldata['name'] , $model_name, $alldata['old_slug']);

    $city->name = $request['name'];
    $city->state_id = $request['state'];
    $city->longitude = $request['longitude'];
    $city->latitude = $request['latitude'];
    if ($slug!=null) {
      $city->slug = $slug;
    }
    
    $city->save();

    \Session::flash('success_msg', 'City successfully updated!');

    return redirect(route('edit_city',$city_id));
    exit;
  }
  public function destroy($id)
  {   
    City::destroy($id);

    \Session::flash('flash_message', 'City deleted!');

    return redirect('admin/cities');
  }

}