<?php
/**
 * Announcement Controller control CRUD operation of Announcement
 * @package admin
 *
 */
namespace App\Modules\Admin\Controllers;
use App\Http\Controllers\Controller,App\Models\Announcement,App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Req;
use App\Http\Requests;
use DateTime;

class AnnouncementsController extends Controller {

  /**
     * Announcement Repository
     *
     * @var Announcement
     */
    protected $announcement;
    protected $announcement_image_path;
    protected $announcement_mobile_image_path;
    /**
     * construct function of controller intiliaze resource
     * @param object : Model object
     */
    public function __construct(Announcement $announcement) {
        $this->announcement = $announcement;
        $this->announcement_image_path = 'data/announcement/images';
        $this->announcement_mobile_image_path = 'data/announcement/mobile/images';
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $announcements = $this->announcement->paginate(10);

        return view('admin::admin.announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('admin::admin.announcements.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {

        $input = $request->all();

       //Upload Banner Image
        $file = $request->file('banner_image');
        $orignialPath = $this->announcement_image_path;
        $thumbnailPath = $orignialPath.'/thumbnail';
        //Upload image
        $imageData = Page::uploadImage($file, $orignialPath);
        //Resizing image to thumbnail icon
        Page::resizeImage($orignialPath, $imageData['image_stored_name'], $thumbnailPath, $width = 70, $height = 70, $ratio = true);
        $dateObj = DateTime::createFromFormat('m/d/Y', $input['date']);
        $input['date'] = date('Y-m-d', $dateObj->format('U'));
        $data = array(
            'short_description' => $input['short_description'],
            'long_description' => $input['long_description'],
            'title' => $input['title'],
            'link' => $input['link'],
            'date' => $input['date'],
            'location' => $input['location'],
            'banner_image' => $imageData['image_name'],
            'image_path' => $imageData['image_stored_name'],
            'sub_title' => $input['sub_title']
        );

        if(isset($input['featured'])){
            $data['featured'] = 1;
        }else{
            $data['featured'] = 0;
        }
        if(isset($input['published'])){
            $data['published'] = 1;
        }else{
            $data['published'] = 0;
        }

        //store information in database
        $this->announcement->create($data);

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement Created Successfully.');
    }


  /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $announcement = $this->announcement->find($id);

        if (is_null($announcement)) {
            return redirect()->route('admin::admin.announcements.index');
        }
        $announcement->date = date('m-d-Y', strtotime($announcement->date));
        return view('admin::admin.announcements.edit', compact('announcement'));
    }

  /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,Request $request) {
        $input = $request->all();
        $announcement = $this->announcement->find($id);

        if (!empty($input['banner_image'])) {

            $file = $request->file('banner_image');

            $orignialPath = $this->announcement_image_path;
            $thumbnailPath = $orignialPath.'/thumbnail';
            //delete existing file of same record
            if (\File::exists($orignialPath . '/' . $announcement->image_path)) {
                \File::delete($orignialPath . '/' . $announcement->image_path);
            }
            if (\File::exists($thumbnailPath . '/' . $announcement->image_path)) {
                \File::delete($thumbnailPath . '/' . $announcement->image_path);
            }
            //Upload image
            $imageData = Page::uploadImage($file, $orignialPath);
            //Resizing image to thumbnail icon
            Page::resizeImage($orignialPath, $imageData['image_stored_name'], $thumbnailPath, $width = 70, $height = 70, $ratio = true);
            
            //get image name and rename
            $input['banner_image'] = $imageData['image_name'];
            $input['image_path'] = $imageData['image_stored_name'];
        }else{
            unset($input['banner_image']);
            unset($input['image_path']);                
        }
        //Upload Mobile Banner Image - END
        $dateObj = DateTime::createFromFormat('m-d-Y', $input['date']);
        $input['date'] = date('Y-m-d', $dateObj->format('U'));

        if(isset($input['featured'])){
            $input['featured'] = 1;
        }else{
            $input['featured'] = 0;
        }

        if(isset($input['published'])){
            $input['published'] = 1;
        }else{
            $input['published'] = 0;
        }
        if(isset($input['formType'])){
            unset($input['formType']);
        }
        $announcement->update($input);

        return redirect()->route('announcements.index')
                     ->with('success', 'Announcement Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $announcement = $this->announcement->find($id);
        if (\File::exists($this->announcement_image_path . '/' . $announcement->image_path)) {
            \File::delete($this->announcement_image_path . '/' . $announcement->image_path);
        }
        if (\File::exists($this->announcement_image_path . '/thumbnail/' . $announcement->image_path)) {
            \File::delete($this->announcement_image_path . '/thumbnail/' . $announcement->image_path);
        }
        
        $announcement->delete();
        return redirect()->route('announcements.index');
    }

}
