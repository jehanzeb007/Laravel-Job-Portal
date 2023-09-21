<?php
/**
 * Pages Controller control CRUD operation of Pages
 * @package admin
 *
 */
namespace App\Modules\Admin\Controllers;
use App\Http\Controllers\Controller,App\Models\Page,App\Models\Ad,App\Models\Announcement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Req;
use App\Http\Requests;

class PagesController extends Controller {

    /**
     * Page Repository
     *
     * @var Page
     */
    protected $page;
    protected $banners_path;
    /**
     * construct function of controller intiliaze resource
     * @param object : Model object
     */
    public function __construct(Page $page) {

        $this->page = $page;
        $this->banners_path = 'data/banners';
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $cmsPages = $this->page->paginate(10);
        return view('admin::admin.pages.index', compact('cmsPages'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $input = Input::all();
        $validation = Validator::make($input, Page::$rules, Page::$messages);

        if ($validation->passes()) {
            $this->page->create($input);

            return Redirect::route('pages.index')
                    ->with('success', 'Page Created Successfully.');
        }

        return Redirect::route('pages.create')
                        ->withInput()
                        ->withErrors($validation)
                        ->with('message', 'There were validation errors.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //$pages = Page::all();
        $page_fields = Page::$page_fields;
        $page_ad_types = Page::$page_ad_types;
        $page = $this->page->find($id);
        $pageAdSlotData = array(
            1=>array(
                'slotable_id'=>null,
                'slotable_type'=>'none',
                'announcement_id'=>null,
                'ad_id'=>null),
            2=>array(
                'slotable_id'=>null,
                'slotable_type'=>'none',
                'announcement_id'=>null,
                'ad_id'=>null),
            3=>array(
                'slotable_id'=>null,
                'slotable_type'=>'none',
                'announcement_id'=>null,
                'ad_id'=>null)
        );
        foreach($page->pageAdSlots->toArray() as $adSlot){
            $pageAdSlotData[$adSlot['sequence']] = $adSlot;
            if($adSlot['slotable_type']=='Announcement'){
                $pageAdSlotData[$adSlot['sequence']]['announcement_id'] = $adSlot['slotable_id'];
            } else {
                $pageAdSlotData[$adSlot['sequence']]['announcement_id'] = null;
            }
            if($adSlot['slotable_type']=='Ad'){
                $pageAdSlotData[$adSlot['sequence']]['ad_id'] = $adSlot['slotable_id'];
            } else {
                $pageAdSlotData[$adSlot['sequence']]['ad_id'] = null;
            }
        }
        $pages = $this->page->all();
        $imageContents = Ad::select('id', 'title', 'image_path')->get();
        $announcements = Announcement::where('featured', '=', 1)->where('published', '=', 1)->pluck('title', 'id');//featured
        if (is_null($page)) {
            return Redirect::route('pages.index');
        }
        //echo "<pre>";print_r($page);exit;
        return view('admin::admin.pages.edit', compact('page','announcements','imageContents','pageAdSlotData','page_fields','page_ad_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,Request $request) {
        $input = array_except($request->all(), array('_method', 'ads'));

        $ads = $request->input('ads','');
        
        $page = $this->page->find($id);
        if (!empty($input['banner_image'])) {

            $file = $request->file('banner_image');
            $orignialPath = $this->banners_path;
            $resizedPath = $orignialPath.'/resized';
            $thumbnailPath = $orignialPath.'/thumbnail';
            
            //delete existing files of same record
            if (\File::exists($orignialPath . '/' . $page->banner_image)) {
                \File::delete($orignialPath . '/' . $page->banner_image);
            }
            if (\File::exists($resizedPath . '/' . $page->banner_image)) {
                \File::delete($resizedPath . '/' . $page->banner_image);
            }
            if (\File::exists($thumbnailPath . '/' . $page->banner_image)) {
                \File::delete($thumbnailPath . '/' . $page->banner_image);
            }
            //Upload image
            $imageData = Page::uploadImage($file, $orignialPath);
            //Resizing image to fit
            Page::resizeImage($orignialPath, $imageData['image_stored_name'], $resizedPath, 1080, null, $ratio = true);
            //Resizing image to thumbnail icon
            Page::resizeImage($orignialPath, $imageData['image_stored_name'], $thumbnailPath, 70, 70, $ratio = true);
            $input['banner_image'] = $imageData['image_stored_name'];
            
        } else {
            unset($input['banner_image']);
        }
        if(isset($input['formType'])){
            unset($input['formType']);
        }
        if(isset($input['page_fields'])){
            unset($input['page_fields']);
        }
        $page->update($input);
        $page->updateAdSlots($id, $ads);


        return redirect()->route('pages.index')
                ->with('success', 'Page Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $this->page->find($id)->delete();
        return Redirect::route('pages.index');
    }
}