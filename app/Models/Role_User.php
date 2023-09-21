<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;


class Role_User extends Model implements AuthenticatableContract{

    use EntrustUserTrait; // add this trait to your user model
    use Authenticatable;
    use SoftDeletes;
    protected $primaryKey = 'id';

    protected $table = 'role_user';

    protected $fillable = [ 'user_id', 'role_id'];
    protected $dates = ['deleted_at'];

    public function roles(){
    	return $this->belongsToMany('App\Models\Role');
    }
    public function users(){
        return $this->belongsToMany('App\Models\User');
    }

}