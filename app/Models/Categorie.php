<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Categorie extends Model implements AuthenticatableContract{

    use Authenticatable;
    protected $primaryKey = 'id';

	protected $table = 'categories';

	public static function getCategories(){
        
        $categorie = Categorie::whereNull("parent_id")->get(array("id","name"));
        $categorieArr = array('' => 'Select Parent Category');
        foreach($categorie as $categorie){
            $categorieArr[$categorie->id] = $categorie->name;
        }
        return $categorieArr;
    }
    public static function getSubCategories(){
        
        $sub_categories = Categorie::with("children")->whereNull("parent_id")->get(array("id","name"));
        
        return $sub_categories;
    }
    public static function getCategorieValidationArray(){
        
        $categorieValidation = array(
            'subcategorie' => 'required',
            'icon' => 'required'
        );
        return $categorieValidation;
    }

    public static function getCategorieListing($categories){

        $category_array = array();
        foreach ($categories as $key => $value) {
            $categorie_count = Job_Categorie::where('categorie_id','=',$value->id)->count();
            if ($categorie_count!=null) {
                $category_array[$key] = $value;
                $category_array[$key]['categorie_count'] = $categorie_count;
            }
            //echo "<pre>";print_r($categorie_count);exit;
        }

        return $category_array;
    }

    public static function getSubCategorieListing($sub_categories,$index){

        $sub_category_array = array();
        foreach ($sub_categories as $key => $value) {
            $sub_categorie_count = Job_Categorie::where('sub_categorie_id','=',$value->id)->count();
            if ($sub_categorie_count!=null) {
                if ($index == 0) {
                    $sub_category_array[$key] = $value;
                    $sub_category_array[$key]['sub_categorie_count'] = $sub_categorie_count;    
                }else{
                    $sub_category_array[$value->parent_id][$key] = $value;
                    $sub_category_array[$value->parent_id][$key]['sub_categorie_count'] = $sub_categorie_count;
                }
                
            }
            //echo "<pre>";print_r($sub_categorie_count);exit;
        }

        return $sub_category_array;
    }

    protected $fillable = ['name', 'icon','parent_id', 'slug','created_at','updated_at'];

	public function children()
	{
        return $this->hasMany('\App\Models\Categorie', 'parent_id', 'id');
	}

	public function parent()
	   {
    return $this->belongsTo('\App\Models\Categorie', 'parent_id');
	}

    public function jobs(){
        return $this->belongsToMany('App\Models\Job');
    }
	
}