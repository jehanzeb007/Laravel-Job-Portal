<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class City extends Model implements AuthenticatableContract{

    use Authenticatable;
    protected $primaryKey = 'id';

    protected $table = 'cities';

    public static function getCities(){
        
        $city = City::get(array("id","name"));
        $cityArr = array('' => 'Select City');
        foreach($city as $city){
            $cityArr[$city->id] = $city->name;
        }
        return $cityArr;
    }
    public static function getCityValidationArray(){
        
        $cityValidation = array(
            'name' => 'required|unique:cities',
            'state' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        );
        return $cityValidation;
    }

    protected $fillable = ['name', 'longitude', 'latitude', 'state_id', 'slug','created_at','updated_at'];
  
}