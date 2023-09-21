<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;



class Job_Invite extends Model{


    use Authenticatable;
    
    protected $primaryKey = 'id';

    protected $table = 'job_invite';

    protected $fillable = [ 'user_id', 'job_id'];

}