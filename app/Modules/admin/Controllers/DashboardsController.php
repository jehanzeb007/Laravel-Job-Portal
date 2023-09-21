<?php 

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Req;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class DashboardsController extends Controller {

	    public function index() {
        return view('admin::admin.dashboards.dashboard');
    }

}