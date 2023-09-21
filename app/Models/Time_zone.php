<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Time_zone extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'time_zones';

    public static function getZones(){
        
        $zones = Time_zone::whereNotNull("php_timezone")->get(array("id","php_timezone","gmt_offset"));

        $zoneArr = array('' => 'Select Time Zone');
        foreach($zones as $zone){
            $zoneArr[$zone->id] = $zone->php_timezone." (".$zone->gmt_offset.")";
        }
        //echo "<pre>";print_r($zones);exit;
        return $zoneArr;
    }


}
