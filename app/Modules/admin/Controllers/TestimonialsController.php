<?php
/**
 * Testimonials Controller control CRUD operation of Testimonials
 * @package admin
 *
 */
namespace App\Modules\Admin\Controllers;
use App\Http\Controllers\Controller,App\Models\Testimonial,App\Models\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Req;
use App\Http\Requests;

class TestimonialsController extends Controller {

    /**
     * Testimonial Repository
     *
     * @var Testimonial
     */
    protected $testimonial;
    protected $testimonial_image_path;

    public function __construct(Testimonial $testimonial) {
        $this->testimonial = $testimonial;
        $this->testimonial_image_path = 'data/testimonial/images';
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $testimonials = $this->testimonial->paginate(10);
        return view('admin::admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
       
        return view('admin::admin.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store( Request $request) {

        $input = $request->all();
        $file = $request->file('logo');
        $orignialPath = $this->testimonial_image_path;
        $thumbnailPath = $orignialPath.'/thumbnail';

        //Upload image
        $imageData = General::uploadImage($file, $orignialPath);
        //Resizing image to thumbnail icon
        General::resizeImage($orignialPath, $imageData['image_stored_name'], $thumbnailPath, 70, 70, $ratio = true);

        $data = array(
            'description' => $input['description'],
            'sequence' => $input['sequence'],
            'logo' => $imageData['image_name'],
            'image_path' => $imageData['image_stored_name'],
        );
        //store information in database
        $this->testimonial->create($data);
        return redirect()->route('testimonials.index')
                  ->with('success', 'Testimonial Created Successfully.');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {

        $testimonial = $this->testimonial->find($id); 
        if (is_null($testimonial)) {
            return redirect()->route('testimonials.index');
        }
        
        return view('admin::admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request) {

        $input = $request->all();
        $testimonial = $this->testimonial->find($id);
        if (!empty($input['logo'])) {

            $file = $request->file('logo');
            $orignialPath = $this->testimonial_image_path;
            
            $thumbnailPath = $orignialPath.'/thumbnail';
            
            //delete existing file of same record
            if (\File::exists($orignialPath . '/' . $testimonial->image_path)) {
                \File::delete($orignialPath . '/' . $testimonial->image_path);
            }
            
            if (\File::exists($thumbnailPath . '/' . $testimonial->image_path)) {
                \File::delete($thumbnailPath . '/' . $testimonial->image_path);
            }
                
            //Upload image
            $imageData = General::uploadImage($file, $orignialPath);
            //Resizing image to thumbnail icon
            General::resizeImage($orignialPath, $imageData['image_stored_name'], $thumbnailPath, 70, 70, $ratio = true);
            
            $input['logo'] = $imageData['image_name'];
            $input['image_path'] = $imageData['image_stored_name'];
        } else {
            unset($input['logo']);
            unset($input['image_path']);
        }
        if(isset($input['formType'])){
            unset($input['formType']);
        }
        $testimonial->update($input); 
        return redirect()->route('testimonials.index')
                        ->with('success', ' Testimonial Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $testimonial = $this->testimonial->find($id);
        if (\File::exists($this->testimonial_image_path . '/' . $testimonial->image_path)) {
            \File::delete($this->testimonial_image_path . '/' . $testimonial->image_path);
        }
        $testimonial->delete();        
        return redirect()->route('testimonials.index');
    }

}
