<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;


class Job_Attribute extends Model implements AuthenticatableContract{

    use Authenticatable;
    use SoftDeletes;
    protected $primaryKey = 'id';

    protected $table = 'job_attributes';

    protected $fillable = [ 'job_id', 'form_id','attribute_id', 'created_at', 'deleted_at'];
    protected $dates = ['deleted_at'];

    public function attributes(){
    	return $this->belongsToMany('App\Models\Attribute');
    }
    public function jobs(){
        return $this->belongsToMany('App\Models\Job');
    }

}