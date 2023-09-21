<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;


class Permission_Role extends Model implements AuthenticatableContract{

    use EntrustUserTrait; // add this trait to your user model
    use Authenticatable;
    use SoftDeletes;
    protected $primaryKey = 'id';

    protected $table = 'permission_role';
    protected $dates = ['deleted_at'];

    public static function getPermission_roles(){
        
        $permission_role = Permission_Role::whereNotNull("permission_id")->get();
        
        return $permission_role;
    }

    protected $fillable = [ 'permission_id', 'role_id','created_by','created_at','updated_by','updated_at'];

    public function roles(){
    	return $this->belongsToMany('App\Models\Role');
    }
    public function permissions(){
        return $this->belongsToMany('App\Models\Permission');
    }

}