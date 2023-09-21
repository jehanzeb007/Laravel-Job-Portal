<?php 

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Req;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Sub_City;
use App\Models\City;
use App\Helpers\Slug;

class SubCitiesController extends Controller {

  protected $limit;
  protected $count;

  public function __construct() {
    $this->limit = 20;
    $this->count = 0;
  }

  public function index() {
    $this->count = Sub_City::count();
    $sub_city = Sub_City::join('cities','sub_cities.city_id','=','cities.id')
    ->orderBy('sub_cities.created_at', 'desc')
    ->select('*','sub_cities.id as sub_cities_id','sub_cities.name as Sub_city_name','sub_cities.longitude as longitude','sub_cities.latitude as latitude')
    ->paginate($this->limit);
    //echo "<pre>";print_r($sub_city->toArray());exit;
    return view('admin::admin.sub_cities.index', array('sub_city' => $sub_city, 'count' => $this->count, 'index' => $this->limit));
  }

  public function listing() {

    $page = \Input::get('page',0);
    $searchTxt = \Input::get('search',"");
    //die('here');
    $where = "";
    if($searchTxt != ""){
      $where .= " ( sub_cities.name like '%$searchTxt%') AND ";
    }
    $where .= " 1 = 1 ";
    $sub_city = Sub_City::whereRaw($where)->join('cities','sub_cities.city_id','=','cities.id')
    ->orderBy('sub_cities.created_at', 'desc')
    ->select('*','sub_cities.id as sub_cities_id','sub_cities.name as Sub_city_name','sub_cities.longitude as longitude','sub_cities.latitude as latitude')
    ->paginate($this->limit);
    //echo "<pre>";print_r($sub_city);exit;
    return view('admin::admin.sub_cities.listing', array('sub_city' => $sub_city));
  }

  public function add() {
    $cities = City::getCities();
    //echo "<pre>";print_r($cities);exit;
    return view('admin::admin.sub_cities.add',compact('cities'));
  }
  
  public function store(Request $request) {

    $req = $request->all();
    //echo "<pre>";print_r($req );exit;
    $validationArray = Sub_City::getSubCityValidationArray();
    $this->validate($request, $validationArray);

    $slug_obj = new Slug;
    $model_name = 'Sub_City';
    $slug = $slug_obj->slug($req['name'] , $model_name, null);
  
    $sub_city= new Sub_City;
    $sub_city->name = $request['name'];
    $sub_city->city_id = $request['city'];
    $sub_city->longitude = $request['longitude'];
    $sub_city->latitude = $request['latitude'];
    $sub_city->slug = $slug;

    $sub_city->save();

    \Session::flash('success_msg', 'Sub City added!');
    return redirect(route('add_sub_city'));
  }

  public function edit($id) {

    $sub_city = Sub_City::findOrFail($id);
    //echo "<pre>";print_r($city);exit;
    $cities = City::getCities();

    return view('admin::admin.sub_cities.edit',  compact('sub_city','cities'));
  }

  public function update(Request $request)  {
      
    $alldata = $request->all();
    //echo "<pre>";print_r($alldata);exit;

    $sub_city_id = $request->id;
    $sub_city = Sub_City::findOrFail($sub_city_id);


    $validationArray = Sub_City::getSubCityValidationArray();
    $validationArray['name'] = 'required|unique:sub_cities,name,'.$sub_city_id;
    $this->validate($request, $validationArray);

    $slug_obj = new Slug;
    $model_name = 'Sub_City';
    $slug = $slug_obj->slug($alldata['name'] , $model_name, $alldata['old_slug']);

    $sub_city->name = $request['name'];
    $sub_city->city_id = $request['city'];
    $sub_city->longitude = $request['longitude'];
    $sub_city->latitude = $request['latitude'];    
    if ($slug!=null) {
      $sub_city->slug = $slug;
    }
    
    $sub_city->save();

    \Session::flash('success_msg', 'Sub City successfully updated!');

    return redirect(route('edit_sub_city',$sub_city_id));
    exit;
  }
  public function destroy($id)
  {   
    Sub_City::destroy($id);

    \Session::flash('flash_message', 'Sub City deleted!');

    return redirect('admin/sub_cities');
  }

}