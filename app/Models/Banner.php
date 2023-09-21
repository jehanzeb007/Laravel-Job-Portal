<?php
/**
 * Banner Model
 * @package: Models
 * @author: Babar Sajjad
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model {

    protected $guarded = array();

    /**
     * Hero banner width
     */
    public static $heroBannerWidth = '';
    /**
     * Mobile Hero banner width
     */
    public static $mobileHeroBannerWidth = '';
    /**
     * Mobile Hero banner Height
     */
    public static $mobileHeroBannerHeight = '';

    /**
     * Hero banner height
     */
    public static $heroBannerHeight = '';
    /**
     * Hero banner width
     */
    public static $serviceBannerWidth = '';

    /**
     * Hero banner height
     */
    public static $serviceBannerHeight = '';

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
        Banner::$heroBannerWidth = 720;
        Banner::$heroBannerHeight = 520;
        Banner::$mobileHeroBannerWidth = 640;
//        Banner::$mobileHeroBannerHeight = 353;
        Banner::$mobileHeroBannerHeight = 472;
        Banner::$serviceBannerWidth = 1080;
        Banner::$serviceBannerHeight = 260;
        Banner::$rules = array(
            'title' => 'required',
            'link' => 'required|url',
            'banner_type_id' => 'required',
            'description' => 'required',
            'sequence' => 'numeric'
        );
        Banner::$messages = array(
            'required' => ':attribute is required.',
            'link.required' => 'URL is required.', //the reason not to use :attribute is that label of link field is URL
            'url' => 'URL must start with "http://".',
            'Image' => 'Please upload Image only.',
            'mimes' => 'Image must be of jpeg,jpg,gif or png type.',
            'max' => 'Maximum size of Image must be less than 3 MB.',
            'image.required_without' => 'Image is required.',
            'mobile_image.required_without' => 'Mobile image is required.'
        );
        parent::boot();
    }

    //enable softdelete for Banners
    protected $softDelete = true;

    /**
     * 
     * A Banner belongs to many Banners
     * 
     */
    public function Pages() {
        return $this->belongsToMany('App\Models\Page');
    }

    /**
     * 
     * A Banner has one type
     * 
     */
    public function BannerType() {
        return $this->belongsTo('App\Models\BannerType');
    }

}
