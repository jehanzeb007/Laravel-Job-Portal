<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;


class Job_Categorie extends Model implements AuthenticatableContract{

    use Authenticatable;
    use SoftDeletes;
    protected $primaryKey = 'id';

    protected $table = 'job_categories';

    protected $fillable = [ 'job_id', 'categorie_id','sub_categorie_id', 'created_at', 'deleted_at'];
    protected $dates = ['deleted_at'];

    public function jobs(){
    	return $this->belongsToMany('App\Models\Job');
    }
    public function categories(){
        return $this->belongsToMany('App\Models\Categories');
    }

}