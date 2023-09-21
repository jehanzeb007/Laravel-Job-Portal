<?php 

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Req;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Country;
use Illuminate\Support\Str;
use App\Helpers\Slug;

class CountriesController extends Controller {

  protected $limit;
  protected $count;

  public function __construct() {
    $this->limit = 20;
    $this->count = 0;
  }

  public function index() {
    $this->count = Country::count();
    $country = Country::orderBy('created_at', 'desc')->paginate($this->limit);
    return view('admin::admin.countries.index', array('country' => $country, 'count' => $this->count, 'index' => $this->limit));
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
    $country = Country::whereRaw($where)->orderBy('created_at', 'desc')->paginate($this->limit);
    //echo "<pre>";print_r($country);exit;
    return view('admin::admin.countries.listing', array('country' => $country));
  }

  public function add() {
    $country = Country::getCountries();
    //echo "<pre>";print_r($country );exit;
    return view('admin::admin.countries.add',compact('country'));
  }
  
  public function store(Request $request) {

    $req = $request->all();
    //echo "<pre>";print_r($req );exit;

    $validationArray = Country::getCountryValidationArray();
    $this->validate($request, $validationArray);

    $slug_obj = new Slug;
    $model_name = 'Country';
    $slug = $slug_obj->slug($req['name'] , $model_name, null);
    //echo "<pre>";print_r($slug);exit;
  
    $country= new Country;
    $country->name = $request['name'];
    $country->longitude = $request['longitude'];
    $country->latitude = $request['latitude'];
    $country->slug = $slug;
    $country->save();

    \Session::flash('success_msg', 'Country added!');
    return redirect(route('add_country'));
  }

  public function edit($id) {

    $country = Country::findOrFail($id);
    //echo "<pre>";print_r($country);exit;
    $countries = Country::getCountries();

    return view('admin::admin.countries.edit',  compact('country','countries'));
  }

  public function update(Request $request)  {
      
    $alldata = $request->all();
    //echo "<pre>";print_r($alldata);exit;
    $country_id = $request->id;
    $country = Country::findOrFail($country_id);

    $validationArray = Country::getCountryValidationArray();
    $validationArray['name'] = 'required|unique:countries,name,'.$country_id;
    $this->validate($request, $validationArray);

    $slug_obj = new Slug;
    $model_name = 'Country';
    $slug = $slug_obj->slug($alldata['name'] , $model_name, $alldata['old_slug']);

    $country->name = $request['name'];
    $country->longitude = $request['longitude'];
    $country->latitude = $request['latitude'];
    if ($slug!=null) {
      $country->slug = $slug;
    }
    
    $country->save();

    \Session::flash('success_msg', 'Country successfully updated!');

    return redirect(route('edit_country',$country_id));
    exit;
  }
  public function destroy($id)
  {   

    Country::destroy($id);

    \Session::flash('flash_message', 'Country deleted!');

    return redirect('admin/countries');
  }

}