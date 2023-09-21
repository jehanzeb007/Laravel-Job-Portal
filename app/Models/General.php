<?php
namespace App\Models;
/*
 * General Model for General Funtions
 * @package: Models
 */

class General {

    /**
     * American States 
     */
    public static $usStates = array(
        'Alabama' => 'Alabama',
        'Alaska' => 'Alaska',
        'Arizona' => 'Arizona',
        'Arkansas' => 'Arkansas',
        'California' => 'California',
        'Colorado' => 'Colorado',
        'Connecticut' => 'Connecticut',
        'Delaware' => 'Delaware',
        'Florida' => 'Florida',
        'Georgia' => 'Georgia',
        'Hawaii' => 'Hawaii',
        'Idaho' => 'Idaho',
        'Illinois' => 'Illinois',
        'Indiana' => 'Indiana',
        'Iowa' => 'Iowa',
        'Kansas' => 'Kansas',
        'Kentucky' => 'Kentucky',
        'Louisiana' => 'Louisiana',
        'Maine' => 'Maine',
        'Maryland' => 'Maryland',
        'Massachusetts' => 'Massachusetts',
        'Michigan' => 'Michigan',
        'Minnesota' => 'Minnesota',
        'Mississippi' => 'Mississippi',
        'Missouri' => 'Missouri',
        'Montana' => 'Montana',
        'Nebraska' => 'Nebraska',
        'Nevada' => 'Nevada',
        'New Hampshire' => 'New Hampshire',
        'New Jersey' => 'New Jersey',
        'New Mexico' => 'New Mexico',
        'New York' => 'New York',
        'North Carolina' => 'North Carolina',
        'North Dakota' => 'North Dakota',
        'Ohio' => 'Ohio',
        'Oklahoma' => 'Oklahoma',
        'Oregon' => 'Oregon',
        'Pennsylvania' => 'Pennsylvania',
        'Rhode Island' => 'Rhode Island',
        'South Carolina' => 'South Carolina',
        'South Dakota' => 'South Dakota',
        'Tennessee' => 'Tennessee',
        'Texas' => 'Texas',
        'Utah' => 'Utah',
        'Vermont' => 'Vermont',
        'Virginia' => 'Virginia',
        'Washington' => 'Washington',
        'West Virginia' => 'West Virginia',
        'Wisconsin' => 'Wisconsin',
        'Wyoming' => 'Wyoming',
    );
    
    public static $timeZone = array(
        'Eastern' => 'Eastern',
        'Central' => 'Central',
        'Mountain' => 'Mountain',
        'Pacific' => 'Pacific',
        'Alaskan' => 'Alaskan',
        'Hawaiian' => 'Hawaiian'
    );
    
    static function init(){
      
    }    
    
    /**
     * Functino responsible to upload image
     * @param Input $file : File to be uploaded
     * @param type $orignialPath : Original Path to Upload
     * @return type Array
     */
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
    /**
     * Functino responsible to resize and upload image
     * 
     * @param string $orignialPath : Original Path to Upload
     * @param string $imageName : Name of the Image
     * @param string $resizedPath : Resized Image Path
     * 
     * @param integer $width  The target width for the image
     * @param integer $height The target height for the image
     * @param boolean $ratio  Determines if the image ratio should be preserved
     * @param boolean $upsize Determines whether the image can be upsized
     * 
     * @return type Array
     */
    public static function resizeImage($orignialPath, $imageName, $resizedPath = null, $width = null, $height = null, $ratio = false, $upsize = true
    ) {
        if (!is_dir($resizedPath)) {
            @mkdir($resizedPath, 0777, true);
        }

        // open an image file
        $img = \Image::make($orignialPath . '/' . $imageName);       

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
    
    public static function getDateAbbr( $date ) {
        $abbreviation = '';
        $dayNum = date('d', strtotime($date));
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ( ( $dayNum % 100 ) >= 11 && ( $dayNum % 100 ) <= 13 ) {
           $abbreviation = 'th';
        } else {
           $abbreviation = $ends[$dayNum % 10];
        }

        return $abbreviation;
    }

    public static function getTimeZoneDate(){
        $gmt_dt = gmdate('m/d/Y h:i a T',strtotime(date('Y-m-d H:i:s')));
        if ( empty( Sentry::getUser()->time_zone) ) {
            $date =  new \DateTime( $gmt_dt );
            $date->setTimezone(new \DateTimezone( Sentry::getUser()->time_zone ));
            return $date->format("Y-m-d h:i:s");

        } else {
            return date('Y-m-d H:i:s');
        }
    }
    
    public static function num_to_letter($num, $uppercase = FALSE){
        $num -= 1;
        $letter = 	chr(($num % 26) + 97);
        $letter .= 	(floor($num/26) > 0) ? str_repeat($letter, floor($num/26)) : '';
        return 		($uppercase ? strtoupper($letter) : $letter); 
    }

    // Author: Adnan Ahmed
    /* creates a compressed zip file */
    public static function create_zip($valid_files = array()) {

        $files = $valid_files;
        $currentUserId =  Sentry::getUser()->id;
        $pathTmp = 'data/tmp/' ;
        
        $zip = new \ZipArchive();
        $zipFileName = $currentUserId .'_'.time() . ".zip";
        $path = public_path($pathTmp);
        if (!is_dir($path)) {
            @mkdir($path, 0777, true);
        }
        $zipFileNameFullPath = $path . $zipFileName; // Zip name
        $zip->open($zipFileNameFullPath,  \ZipArchive::CREATE);
        foreach ($files as $f) {
              $fullPath = $f;
              if(file_exists($fullPath)){
                  $zip->addFromString(basename($fullPath),  file_get_contents($fullPath));
              }
              else{
                  $response['errors'][] = "file $f does not exist";
              }
        }
        $zip->close();
        if(file_exists($zipFileNameFullPath)){
            $response['success'] = 'Yes';
            $response['zipFileFullPath'] = $zipFileNameFullPath;
        }else{
            $response['errors'] = array('Zip-File did not successfully created.');
        }

        $filePathInfo = pathinfo($zipFileNameFullPath);
        $fileName = $filePathInfo['basename'];

        // Poooof!!! All done now download that file :)
        header("Content-type: application/zip"); 
        header("Content-Disposition: attachment; filename=$fileName"); 
        header("Content-length: " . filesize($zipFileNameFullPath));
        header("Pragma: no-cache"); 
        header("Expires: 0");
        readfile("$zipFileNameFullPath");
    }
}
General::init();