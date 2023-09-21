<?php
/**
 * Banner Controller control CRUD operation of Banners
 * @package admin
 *
 */
namespace App\Modules\Admin\Controllers;
use App\Http\Controllers\Controller,App\Models\Banner,App\Models\BannerType,App\Models\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Req;
use App\Http\Requests;

class BannersController extends Controller {

    /**
     * Banner Repository
     *
     * @var Banner
     */
    protected $banner;
    protected $banners_path;
    protected $mobile_banners_path;
    /**
     * construct function of controller intiliaze resource
     * @param object : Model object
     */
    public function __construct(Banner $banner) {
        $this->banner = $banner;
        $this->banners_path = 'data/banners';
        $this->mobile_banners_path = 'data/banners/mobile';
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $banners = $this->banner->paginate(10);
        //echo "<pre>";print_r($banners->toArray());exit;
        return view('admin::admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $bannerTypes = BannerType::getBannerTypes();
        return view('admin::admin.banners.create', compact('bannerTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $input = $request->all();
        
        $file = $request->file('image');
        $orignialPath = $this->banners_path;
        $thumbnailPath = $orignialPath.'/thumbnail';
        
        //Upload image
        $imageData = General::uploadImage($file, $orignialPath);
        //Resizing image to thumbnail icon
        General::resizeImage($orignialPath, $imageData['image_stored_name'], $thumbnailPath, 70, 70, $ratio = true);
        $input['image'] = $imageData['image_name'];
        $input['image_path'] = $imageData['image_stored_name'];
        //store information in database
        if(isset($input['formType'])){
            unset($input['formType']);
        }

        $this->banner->create($input);
        return redirect()->route('banners.index')
                        ->with('success', 'Banner Uploaded Successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $banner = $this->banner->find($id);
        $bannerTypes = BannerType::getBannerTypes();
        if (is_null($banner)) {
            return redirect()->route('banners.index');
        }

        return view('admin::admin.banners.edit', compact(array('banner', 'bannerTypes')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request) {

        $input = $request->all();
        $banner = $this->banner->find($id);
        if (!empty($input['image'])) {
            $file = $request->file('image');
            $orignialPath = $this->banners_path;
            $thumbnailPath = $orignialPath.'/thumbnail';
            
            //delete existing file of same record
            if (\File::exists($orignialPath . '/' . $banner->image_path)) {
                \File::delete($orignialPath . '/' . $banner->image_path);
            }
            
            if (\File::exists($thumbnailPath . '/' . $banner->image_path)) {
                \File::delete($thumbnailPath . '/' . $banner->image_path);
            }

            //Upload image
            $imageData = General::uploadImage($file, $orignialPath);
            //Resizing image to fit
            $width = 1080;
            $height = 228;
            if($input['banner_type_id'] == 1) {
                $width = 720;
                $height = 520;
            }
            
            //Resizing image to thumbnail icon
            General::resizeImage($orignialPath, $imageData['image_stored_name'], $thumbnailPath, 70, 70, $ratio = true);

            $input['image'] = $imageData['image_name'];
            $input['image_path'] = $imageData['image_stored_name'];
            
        } else {
            unset($input['image']);
            unset($input['image_path']);
        }

        if(isset($input['formType'])){
            unset($input['formType']);
        }
        $banner->update($input);

        return redirect()->route('banners.index')
                           ->with('success', 'Banner Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $banner = $this->banner->find($id);
        if (\File::exists($this->banners_path . '/' . $banner->image_path)) {
            \File::delete($this->banners_path . '/' . $banner->image_path);
        }
        
        if (\File::exists($this->banners_path . '/thumbnail/' . $banner->image_path)) {
            \File::delete($this->banners_path . '/thumbnail/' . $banner->image_path);
        }
        $banner->delete();
        return redirect()->route('banners.index');
    }

}
