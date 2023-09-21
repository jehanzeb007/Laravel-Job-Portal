<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model {

    protected $guarded = array();

    /**
     * Hero banner width
     */
    public static $testimonialWidth = '';

    /**
     * Hero banner height
     */
    public static $testimonialHeight = '';

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
     * @author : Babar Sajjad
     */
    public static function boot() {
        Testimonial::$testimonialWidth = 230;
        Testimonial::$testimonialHeight = 86;
        
        Testimonial::$rules = array(
            'logo' => 'Image|mimes:jpeg,jpg,gif,png|max:3000|required_without:id|image_size:' . Testimonial::$testimonialWidth . ',' . Testimonial::$testimonialHeight,
            'sequence' => 'numeric|required',
            'description' => 'required'
        );
        
        Testimonial::$messages = array(
            'required' => ':attribute is required.',
            'image_size' => 'Image must have '.Testimonial::$testimonialWidth.' x '.Testimonial::$testimonialHeight.' resolution.',
            'mimes' => 'Logo must be of jpeg,jpg,gif or png type.',
            'max' => 'Maximum size of Image must be less than 3 MB.',
            'required_without' => 'Logo is required.'
        );
    }

    /**
     * 
     * Testimonial can be used at slots available at pages 
     * 
     */
    public function pageAdSlots() {
        return $this->morphMany('PageAdSlot', 'slotable');
    }

}
