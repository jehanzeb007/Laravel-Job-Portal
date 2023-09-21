<?php
/**
 * Ad Controller control CRUD operation of Ads
 * @package admin
 *
 */

namespace App\Modules\Admin\Controllers;
use App\Http\Controllers\Controller,App\Models\Ad,App\Models\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Req;
use App\Http\Requests;

class AdsController extends Controller {

	/**
	 * Ad Repository
	 *
	 * @var Ad
	 */
	protected $ad;
	protected $ads_path;
    /**
     * construct function of controller intiliaze resource
     * @param object : Model object
     */
	public function __construct(Ad $ad)
	{
		$this->ad = $ad;
        $this->ads_path = 'data/ads';
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){
		$ads = Ad::paginate(10);
        return view('admin::admin.ads.index')->with('ads',$ads);
	}

	/**
	 * Show the form for creating a new ad
	 * @return Response
	 */
	public function create(){
    	return view('admin::admin.ads.create');
	}

	/**
	 * Store a newly created ad immage.
	 * @author: Babar Sajjad
	 * @return Response
	 */
	public function store(Request $request)	{

        $input = $request->all();

        $file = $request->file('image');
        $orignialPath = $this->ads_path;
        $thumbnailPath = $orignialPath.'/thumbnail';

        //Upload image
        $imageData = General::uploadImage($file, $orignialPath);
        //Resizing image to thumbnail icon
        General::resizeImage($orignialPath, $imageData['image_stored_name'], $thumbnailPath, 70, 70, $ratio = true);
        $data = array(
	      'title'  => $input['title'],
	      'image'  => $imageData['image_name'],
	      'image_path' => $imageData['image_stored_name'],
	      'link' => $input['link']
        );
        //store information in database
        $this->ad->create($data);
        return redirect()->route('ads.index')
                ->with('success', 'Ad Created Successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id){

		$ad = $this->ad->findOrFail($id);
		return view('admin::admin.ads.show', compact('ad'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$ad = $this->ad->find($id);
                
		if (is_null($ad)) {
			return redirect()->route('admin.ads.index');
		}

		return view('admin::admin.ads.edit', compact('ad'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,Request $request)	{
            
		$data = array();
		$ad = $this->ad->find($id);
		$input = $request->all();

		if (!empty($input['image'])) {
		    
		    $file = $request->file('image');
		    $orignialPath = $this->ads_path;
		    $thumbnailPath = $orignialPath.'/thumbnail';

		    //delete existing file of same record
		    if (\File::exists($orignialPath . '/' . $ad->image_path)) {
		        \File::delete($orignialPath . '/' . $ad->image_path);
		    }
		    if (\File::exists($thumbnailPath . '/' . $ad->image_path)) {
		        \File::delete($thumbnailPath . '/' . $ad->image_path);
		    }

		    //Upload image
		    $imageData = General::uploadImage($file, $orignialPath);
		    //Resizing image to thumbnail icon
		    General::resizeImage($orignialPath, $imageData['image_stored_name'], $thumbnailPath, 70, 70, $ratio = true);

		    $data['image'] = $imageData['image_name'];
		    $data['image_path'] = $imageData['image_stored_name'];
		}
		$data['title'] = $input['title'];
		$data['link'] = $input['link'];
		   
		$ad->update($data);
		return redirect()->route('ads.index')
		           ->with('success', 'Ad Updated Successfully.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
            $ad = $this->ad->find($id);
            if (\File::exists($this->ads_path . '/' . $ad->image_path)) {
                \File::delete($this->ads_path . '/' . $ad->image_path);
            }
            if (\File::exists($this->ads_path . '/thumbnail/' . $ad->image_path)) {
                \File::delete($this->ads_path . '/thumbnail/' . $ad->image_path);
            }
            $ad->delete();
            return redirect()->route('ads.index');
	}

}
