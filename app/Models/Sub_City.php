<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Sub_City extends Model implements AuthenticatableContract{

    use Authenticatable;
    protected $primaryKey = 'id';

    protected $table = 'sub_cities';

    public static function getSubCities(){
        
        $sub_city = Sub_City::get(array("id","name"));
        $sub_cityArr = array('' => 'Select Sub City');
        foreach($sub_city as $sub_city){
            $sub_cityArr[$sub_city->id] = $sub_city->name;
        }
        return $sub_cityArr;
    }

    public static function getSubCityValidationArray(){
        
        $subCityValidation = array(
            'name' => 'required|unique:sub_cities',
            'city' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        );
        return $subCityValidation;
    }

    protected $fillable = ['name', 'longitude', 'latitude', 'city_id', 'slug','created_at','updated_at'];
  
}