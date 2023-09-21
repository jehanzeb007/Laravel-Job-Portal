<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Model implements AuthenticatableContract{

    use EntrustUserTrait; // add this trait to your user model
    use Authenticatable;
    use SoftDeletes;
    protected $primaryKey = 'id';

    public static $userValidation = array();
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $dates = ['deleted_at'];
    
    public static function getUsers(){
        
        $user = User::get(array("id","name"));
        $userArr = array('' => 'Select User');
        foreach($user as $user){
            $userArr[$user->id] = $user->name;
        }
        return $userArr;
    }

    public static function getUserValidationArray(){
        
        $userValidation = array(
            'first_name' => 'required', 
            'last_name' => 'required',
            'email_address'=>  'required|email|max:255|unique:users',
            'password'=> 'required',
            'confirm_password'=> 'required|same:password',
            'roles_assigned'=>'required'
        );
        
        return $userValidation;
    }
    
    

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'email_address','password', 'father_name','date_of_birth','address','last_education','phone','sub_city','city','state','country', 'description','active','remember_token','no_of_attempts','is_admin'];

    public function roles(){
    	return $this->belongsToMany('App\Models\Role');
    }
    public function jobs(){
        return $this->belongsToMany('App\Models\Job');
    }

}