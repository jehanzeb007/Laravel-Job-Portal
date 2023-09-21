<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Form extends Model implements AuthenticatableContract{

    use Authenticatable;
    protected $primaryKey = 'id';

    protected $table = 'form_attributes';

    /*public static function getForms(){
        
        $form = form::get(array("id","name"));
        $formArr = array('' => 'Select form');
        foreach($form as $form){
            $formArr[$form->id] = $form->name;
        }
        return $formArr;
    }*/
    public static function getForms(){
        
        $form = Form::with("children")->whereNull("parent_id")->get();
        
        return $form;
    }
    public static function getFormValidationArray(){
        
        $formValidation = array(
            'name' => 'required|unique:form_attributes'
        );
        return $formValidation;
    }

    protected $fillable = ['name','parent_id', 'placement_options','created_at','updated_at'];

    public function children()
    {
        return $this->hasMany('\App\Models\Form', 'parent_id', 'id');
    }

    public function parent()
       {
    return $this->belongsTo('\App\Models\Form', 'parent_id');
    }
}