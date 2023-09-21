<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
/**
 * Page Model
 * @package: Models
 * @author: Kashif Irshad
 */
class Page extends Model {

    protected $guarded = array();
    /**
     * banner width
     */
    public static $bannerWidth = '';

    /**
     * banner height
     */
    public static $bannerHeight = '';
    /**
     * validatin rules for model
     */
    public static $rules = array();

    /**
     * Custom messages
     */
    public static $messages = array();
     // Hierarchy and Rout Name
    public static $page_fields = array(
        'home'          => array('title', 'hero_banners', 'service_banners', 'meta_keyword', 'meta_description'),
                'about-us'      => array('title', 'short_description', 'long_description', 'banner_image', 'meta_keyword', 'meta_description', 'ad_slot_1', 'ad_slot_2', 'ad_slot_3'),
                'communities'   => array('title', 'short_description', 'banner_image', 'meta_keyword', 'meta_description', 'ad_slot_1', 'ad_slot_2', 'ad_slot_3'),
                'services'      => array('title', 'short_description', 'banner_image', 'meta_keyword', 'meta_description', 'ad_slot_1', 'ad_slot_2', 'ad_slot_3'),
                'pricing'       => array('title', 'short_description', 'banner_image', 'meta_keyword', 'meta_description'),
                'contact-us'    => array('title', 'short_description', 'meta_keyword', 'meta_description'),
                'careers'       => array('title', 'long_description','banner_image', 'meta_tags', 'meta_description'),
                'terms-of-use'       => array('title', 'long_description','banner_image', 'meta_keyword', 'meta_description'),
                'privacy'       => array('title', 'long_description','banner_image', 'meta_keyword', 'meta_description'),
                'announcement'       => array('title', 'meta_keyword', 'meta_description', 'banner_image'),
                'events'       => array('title', 'short_description', 'long_description', 'banner_image','meta_keyword', 'meta_description' ),
                'research'       => array('title', 'short_description', 'long_description', 'banner_image','meta_keyword', 'meta_description'),
                'consulting'       => array('title', 'short_description', 'long_description', 'banner_image','meta_keyword', 'meta_description'),
                'membership'       => array('title', 'short_description', 'long_description', 'banner_image','meta_keyword', 'meta_description'),
                'partnerships'       => array('title', 'short_description', 'long_description', 'banner_image','meta_keyword', 'meta_description'),
                'elearning'       => array('title', 'short_description', 'our_approach','customization','course_packages','certification_programs', 'banner_image','ad_slot_1', 'ad_slot_2', 'ad_slot_3','meta_keyword', 'meta_description'),
     );
    
    // Page Ad Types
    
    public static $page_ad_types = array(
            'none'=>'None',
            'Ad' => 'Ad',
            'Testimonial' => 'Testimonial',
            'randomized'=>'Randomized',
            'Announcement'=>'Announcement'
     );
    
     public static $random_ad_types = array(
            'Ad' => 'Ad',
            'Testimonial' => 'Testimonial',
            'Announcement'=>'Announcement'
     );
     /**
     * bind function of Eloquent to bind class attributes
     * @author : Waqas Ahmad
     */
    public static function boot() {
        Page::$bannerWidth = 1080;
        Page::$bannerHeight = 228;
        Page::$rules['title'] = 'required';
        Page::$rules['banner_image'] = 'Image|mimes:jpeg,jpg,gif,png|max:3000|image_size:' . Page::$bannerWidth . ',' . Page::$bannerHeight;
        
        Page::$messages['required'] = ':attribute is required.';
        Page::$messages['Image'] = 'Image is required.';
        Page::$messages['mimes'] = 'Image must be of jpeg,jpg,gif or png type.';
        Page::$messages['max'] = 'Maximum size of Image must be less than 3 MB.';
        Page::$messages['image_size'] = 'Image must have '.Page::$bannerWidth.' x '.Page::$bannerHeight.' resolution.';
        parent::boot();
    }
    
    public static function uploadImage($file, $orignialPath) {
        if (!is_dir($orignialPath)) {
            @mkdir($orignialPath, 0777, true);
        }

        //get image name and rename
        $imageName = $file->getClientOriginalName();
        $imageStoredName = date('YmdHis') . '-' . $imageName;

        //save image
        $file->move($orignialPath, $imageStoredName);
        
        return array('image_name' => $imageName, 'image_stored_name' => $imageStoredName);
    }
    
    public static function resizeImage($orignialPath, $imageName, $resizedPath = null, $width = null, $height = null, $ratio = false, $upsize = true
    ) {
        if (!is_dir($resizedPath)) {
            @mkdir($resizedPath, 0777, true);
        }

        // open an image file
        $img = \Intervention\Image\Facades\Image::make($orignialPath . '/' . $imageName);       

        // resize the uploaded ad image with respect to showable size
        if (!empty($resizedPath)) {
//            $img->resize($width, $height, $ratio, $upsize);
            $img->resize($width, $height, function ($constraint) use($ratio,$upsize) {
                if($ratio)
                    $constraint->aspectRatio();
                if($upsize)
                    $constraint->upsize();
            });
        }

        // save resized image
        $img->save($resizedPath . '/' . $imageName);

        
        return $imageName;
    } 
    /**
     * 
     * A Banner belongs to many Banners
     * 
     */
     public function Banners()
     {
              return $this->belongsToMany('Banner');
     }
       
    /**
     * 
     * A Page may contain communities on it
     * 
     */
    public function pageAdSlots() {
        return $this->hasMany('App\Models\PageAdSlot')->orderBy('sequence');
        //return $this->hasMany('PageAdSlot')->orderBy('sequence');
    }
    

    /**
     * Get public cms pages object.
     * @author: Adeel Ahsan
     * @param: page slug
     * @return Page model object
     */
    public static function getPageData($slug) {
        return Page::where('slug', '=', $slug)->first();
    }

    /**
     * Pages scope.
     * @author: Adeel Ahsan
     * @param: Model query object
     * @return Model object
     */
    public function scopeAttributes($query, array $attributes) {
        return $query->select($attributes)->orderBy('id');
    }
    /**
     * Function to update Ad Slots for a particular page
     * @param int $pageID ID of the pags
     * @param array $ads array
     * @return boolean
     */
    public function updateAdSlots($pageID, $ads=array()){
        $saveData = array();
        if(!empty($ads)){
            foreach($ads as $key=>$ad){
                if($ad['page_ad_slot_type']!=='none'){
                    $saveData[$key]['page_id'] = $pageID;
                    $saveData[$key]['slotable_type'] = $ad['page_ad_slot_type'];
                    if($ad['page_ad_slot_type']=='Ad' && !empty($ad['page_ad_slot_content_image'])){
                        $saveData[$key]['slotable_id'] = $ad['page_ad_slot_content_image'];                    
                    } elseif($ad['page_ad_slot_type']=='Announcement' && !empty($ad['page_ad_slot_content_announcement'])) {
                        $saveData[$key]['slotable_id'] = $ad['page_ad_slot_content_announcement'];
                    }
                    else {
                        $saveData[$key]['slotable_id'] = '';
                    }
                    $saveData[$key]['sequence'] = $key;
                }
            }
        }
        $affectedRows = PageAdSlot::where('page_id', '=', $pageID)->delete();
        PageAdSlot::insert($saveData);
        return true;
    }
    /**
     * get Random entry 
     * @param string $type
     * return object
     */
    public static function getRandomAd($type='Ad'){
        $ad = NULL;
        if($type=='Ad'){
            $adObj = new Ad();
            $ad = $adObj->getRandomAd();
        }else if($type=='Announcement'){
            $announcementObj = new Announcement();
            $ad = $announcementObj->getRandomAnnouncement();
        }
        return $ad;
        
    }

}
