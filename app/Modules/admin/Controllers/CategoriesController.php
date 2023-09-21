<?php 

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Req;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Categorie;
use App\Helpers\Slug;

class CategoriesController extends Controller {

  protected $limit;
  protected $count;

  public function __construct() {
    $this->limit = 20;
    $this->count = 0;
  }

  public function index() {
    $this->count = Categorie::count();
    $categorie = Categorie::with("children")->whereNull("parent_id")->orderBy('created_at', 'desc')->paginate($this->limit);
    //echo "<pre>";print_r($categorie->toArray());exit;
    return view('admin::admin.categories.index', array('categorie' => $categorie, 'count' => $this->count, 'index' => $this->limit));
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
    $categorie = Categorie::whereRaw($where)->with("children")->whereNull("parent_id")->orderBy('created_at', 'desc')->paginate($this->limit);
    //echo "<pre>";print_r($categorie);exit;
    return view('admin::admin.categories.listing', array('categorie' => $categorie));
  }

  public function add() {
    $categorie = Categorie::getCategories();
    //echo "<pre>";print_r($categorie );exit;
    return view('admin::admin.categories.add',compact('categorie'));
  }
  
  public function store(Request $request) {

    $req = $request->all();
    //echo "<pre>";print_r($req );exit;
    $validationArray = Categorie::getCategorieValidationArray();
    $this->validate($request, $validationArray);

    $slug_obj = new Slug;
    $model_name = 'Categorie';
    $slug = $slug_obj->slug($req['subcategorie'] , $model_name, null);
    //echo "<pre>";print_r($slug);exit;
  
    $categorie= new Categorie;
    $categorie->name = $request['subcategorie'];
    $categorie->icon = $request['icon'];
    if ($req['categorie']=='') {
      $categorie->parent_id = null;
    }else{
      $categorie->parent_id = $request['categorie'];
    }
    $categorie->slug = $slug;

    $categorie->save();

    \Session::flash('success_msg', 'Categorie added!');
    return redirect(route('add_categorie'));
  }

  public function edit($id) {

    $categorie = Categorie::findOrFail($id);
    //echo "<pre>";print_r($categorie);exit;
    $categories = Categorie::getCategories();

    return view('admin::admin.categories.edit',  compact('categorie','categories'));
  }

  public function update(Request $request)  {
      
    $alldata = $request->all();
    //echo "<pre>";print_r($alldata);exit;

    $categorie_id = $request->id;
    $categorie = Categorie::findOrFail($categorie_id);


    $validationArray = Categorie::getCategorieValidationArray();
    $this->validate($request, $validationArray);

    $slug_obj = new Slug;
    $model_name = 'Categorie';
    $slug = $slug_obj->slug($alldata['subcategorie'] , $model_name, $alldata['old_slug']);

    $categorie->name = $request['subcategorie'];
    $categorie->icon = $request['icon'];
    if ($request['categorie']=='') {
      $categorie->parent_id = null;
    }else{
      $categorie->parent_id = $request['categorie'];
    }
    if ($slug!=null) {
      $categorie->slug = $slug;
    }

    $categorie->save();

    \Session::flash('success_msg', 'Categorie successfully updated!');

    return redirect(route('edit_categorie',$categorie_id));
    exit;
  }
  public function destroy($id)
  {   
    //die('here');
    $categorie = Categorie::where('parent_id','=',$id)->get()->toArray();
    //echo "<pre>";print_r($categorie);exit;
    if (!empty($categorie)) {

      foreach ($categorie as $key => $value) {
        //echo "<pre>";print_r();exit;
        Categorie::destroy($value['id']);
      }
      
    }
    Categorie::destroy($id);

    \Session::flash('flash_message', 'Categorie deleted!');

    return redirect('admin/categories');
  }

}