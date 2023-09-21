<?php 
namespace App\Models;

use Zizaco\Entrust\EntrustPermission;

use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends EntrustPermission{
	use SoftDeletes;
	protected $table = 'permissions';
	protected $dates = ['deleted_at'];

	public static function getPermissions(){
        
        $permission = Permission::with("children")->whereNull("parent_id")->get();
        
        return $permission;
    }


	public function children()
	{
        return $this->hasMany('\App\Models\Permission', 'parent_id', 'id');
	}

	public function parent()
	   {
    return $this->belongsTo('\App\Models\Permission', 'parent_id');
	}
	
}