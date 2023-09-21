<?php 
namespace App\Models;

use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends EntrustRole{
    
    use SoftDeletes;

	public static $userValidation = array();
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';
    protected $dates = ['deleted_at'];

    public static function getUserValidationArray(){
        
        $userValidation = array(
            'name' => 'required', 
            'display_name' => 'required',
            'description'=>  'required',
            /*'change_password_access'=>  'required',*/
        );
        
        return $userValidation;
    }
    
    

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'display_name', 'description','change_password_access'];

	public function permissions(){
    	return $this->belongsToMany('App\Models\Permission');
    }
}