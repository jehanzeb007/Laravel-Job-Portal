<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
 
class PageAdSlot extends Model {
	protected $guarded = array();

	public static $rules = array(
		'page_id' => 'required'
	);
        /*
         * A slot can contain objects of many types e.g; add, announcement, testimonial
         */
        public function slotable()
        {
            return $this->morphTo();
        }
        /*
         * A slot is assosiated with one Page
         */
        public function pages()
        {
            return $this->belongsTo('Page');
        }    
        
        /*
         * A slot is assosiated with one Page
         * @param array: $data
         */
        public function checkExists($data)
        {
            if(is_array($data)) {
                
                $page_id        = $data['page_id'];
                $sequence       = $data['sequence'];
                $id = PageAdSlot::select('id')
                        ->where('page_id', '=', $page_id)
                        ->where('sequence', '=', $sequence)
                        ->first();
                if(isset($id->id))
                    return $id->id;
            }
            return false;
            
        }
        
}
