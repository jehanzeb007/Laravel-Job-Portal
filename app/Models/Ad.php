<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
/**
 * Ad Model
 * @package: Models
 * @author: Kashif Irshad
 */
class Ad extends Model {

    protected $guarded = array();

    /**
     * banner width
     */
    public static $adImageWidth = '';

    /**
     * banner height
     */
    public static $adImageHeight = '';

    /**
     * validatin rules for model
     */
    public static $rules = array();

    /**
     * Custom messages
     */
    public static $messages = array();

    /**
     * bind function of Eloquent to bind class attributes
     * @author : Waqas Ahmad
     */
    public static function boot() {
        Ad::$adImageWidth = 270;
        Ad::$adImageHeight = 210;
        Ad::$rules = array(
            'link' => 'required',
            'image' => 'Image|mimes:jpeg,jpg,gif,png|max:3000|required_without:id|image_size:' . Ad::$adImageWidth . ',' . Ad::$adImageHeight
        );
        Ad::$messages = array(
            'required' => 'URL is required.', //the reason not to use :attribute is that label of link field is URL
            //'url' => 'URL must start with "http://".',
            'image_size' => 'Image must have '.Ad::$adImageWidth.' x '.Ad::$adImageHeight.' resolution.',
            'Image' => 'Please upload Image only.',
            'mimes' => 'Image must be of jpeg,jpg,gif or png type.',
            'max' => 'Maximum size of Image must be less than 3 MB.',
            'required_without' => 'Image is required.'
        );
        parent::boot();
    }

    /**
     * 
     * Ad can be used at slots available at pages 
     * 
     */
    public function pageAdSlots() {
        return $this->morphMany('PageAdSlot', 'slotable');
    }

    /**
     * Ad scope.
     * @author: Adeel Ahsan
     * @params: Model query object, attributes to select
     * @return Model object
     */
    public function scopeAttributes($query, array $attributes) {
        return $query->select($attributes)->orderBy('id');
    }
    /**
     * get Random entry from Ad table
     * return object
     */
    public function getRandomAd(){
        return $this::orderBy(DB::raw('RAND()'))->first();
    }

}
