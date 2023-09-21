<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Country extends Model implements AuthenticatableContract{

    use Authenticatable;
    protected $primaryKey = 'id';

	protected $table = 'countries';

	public static function getCountries(){
        
        $country = Country::get(array("id","name"));
        $countryArr = array('' => 'Select Country');
        foreach($country as $country){
            $countryArr[$country->id] = $country->name;
        }
        return $countryArr;
    }
    public static function getCountryValidationArray(){
        
        $countryValidation = array(
            'name' => 'required|unique:countries',
            'longitude' => 'required',
            'latitude' => 'required',
        );
        return $countryValidation;
    }

    protected $fillable = ['name', 'longitude', 'latitude', 'slug','created_at','updated_at'];

}