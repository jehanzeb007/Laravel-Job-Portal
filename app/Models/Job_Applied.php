<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;



class Job_Applied extends Model{


    use Authenticatable;
    use SoftDeletes;
    
    protected $primaryKey = 'id';

    protected $table = 'jobs_applied';

    protected $fillable = [ 'user_id', 'job_id'];
    protected $dates = ['deleted_at'];

    public function jobs(){
    	return $this->belongsToMany('App\Models\Job');
    }
    public function users(){
        return $this->belongsToMany('App\Models\User');
    }

    /*public static function boot()
    {
        parent::boot();    
    
        // cause a delete of a product to cascade to children so they are also deleted
        static::deleted(function($jobs_applied)
        {
            $jobs_applied->jobs()->delete();
            $jobs_applied->users()->delete();
        });
    }    */

}