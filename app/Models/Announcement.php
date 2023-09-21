<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model {

    protected $guarded = array();
    public static $rules = array(
        'title' => 'required',
        'date' => 'required',
        'link' => 'url',        
        'banner_image' => 'mimes:jpeg,jpg,gif,png|max:3000|required_without:id|image_size:647,145',
        'long_description' => 'required'
    );
    /**
     * Custom Messages
     */
    public static $messages = array(
        'required' => ':attribute is required.',
        'link.required' => 'URL is required.', //the reason not to use :attribute is that label of link field is URL
        'url' => 'URL must start with "http://".',
        'Image' => 'Please upload Image only.',
        'mimes' => 'Image must be of jpeg, jpg, gif or png type.',
        'max' => 'Maximum size of Image must be less than 3 MB.',
        'banner_image.required_without' => 'Banner Image is required.',
        'mobile_image.image_size' => 'Image Size should be 580 x 160'
    );
    /**
     * 
     * Announcement can be used at slots available at pages 
     * 
     */
    public function pageAdSlots() {
        return $this->morphMany('PageAdSlot', 'slotable');
    }

    /**
     * Announcement scope.
     * @author: Babar Sajjad
     * @params: Model query object, attributes to select
     * @return Model object
     */
    public function scopeAttributes($query, array $attributes) {
        return $query->select($attributes)->orderBy('id');
    }
    /**
     * get Random entry from Announcement table
     * return object
     */
    public function getRandomAnnouncement(){
        return $this::orderBy(DB::raw('RAND()'))->where('featured', 1)->where('published', 1)->first();
    }

}
