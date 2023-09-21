<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class State extends Model implements AuthenticatableContract{

    use Authenticatable;
    protected $primaryKey = 'id';

    protected $table = 'states';

    public static function getStates(){
        
        $state = state::get(array("id","name"));
        $stateArr = array('' => 'Select State');
        foreach($state as $state){
            $stateArr[$state->id] = $state->name;
        }
        return $stateArr;
    }
    public static function getStateValidationArray(){
        
        $stateValidation = array(
            'name' => 'required|unique:states',
            'country' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        );
        return $stateValidation;
    }

    protected $fillable = ['name', 'longitude', 'latitude', 'country_id', 'slug','created_at','updated_at'];
  
}