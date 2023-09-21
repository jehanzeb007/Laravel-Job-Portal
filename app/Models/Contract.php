<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;



class Contract extends Model{


    use Authenticatable;
    use SoftDeletes;
    
    protected $primaryKey = 'id';

    protected $table = 'contracts';

    protected $fillable = [ 'user_id', 'job_id','payment','start_date','end_date'];
    protected $dates = ['deleted_at'];

}