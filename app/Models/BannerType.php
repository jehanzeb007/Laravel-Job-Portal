<?php
/**
 * Banner Model
 * @package: Models
 * @author: Babar Sajjad
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BannerType extends Model {

    protected $guarded = array();
    public static $rules = array(
        'type' => 'required'
    );

    /**
     * 
     * A Type belongs to many Banners
     * 
     */
    public function Banner() {
        return $this->hasMany('App\Models\Banner');
    }

    /**
     * 
     * Will return banner types
     * @author: Adeel Ahsan
     */
    public static function getBannerTypes() {
        $types = BannerType::select('id', 'type')->get();
        $return = array();
        foreach($types as $type) {
            $return[$type->id] = $type->type;
        }
        return $return;
    }

}
