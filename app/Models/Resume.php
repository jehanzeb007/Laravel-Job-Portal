<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resume extends Model implements AuthenticatableContract{

    use Authenticatable;
    use SoftDeletes;
    protected $primaryKey = 'id';

    protected $table = 'resume';

    protected $fillable = ['title', 'path','created_at','updated_at','deleted_at'];
  
}