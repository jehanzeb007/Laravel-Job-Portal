<?php
namespace App\Modules\Client\Controllers;

use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
//use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use App\Models\Role;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Sub_City;

class LoginController extends Controller
{

    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function login() {
        return view('client::login');
    }

    public function loginStore(LoginRequest $request) {
        $allData = $request->all();
        //echo "<pre>";print_r($allData);exit;
        $email_address = $request->input('email_address');
        $password = $request->input('password');
        $remember = $request->input('remember',0);
        $user = User::where('email_address', '=', $email_address)->first();
        //echo "<pre>";print_r($user->id);exit;
        if(!$user == ''){
        $attempts = $user->no_of_attempts;
        \Session::flash('attempts', $attempts);
        /*if($attempts>3){
            //die('here');
            $this->validate($request, [
                'g-recaptcha-response'=>'required|captcha',
            ]);
        }*/
            // Not authenticated
            if (!Auth::attempt(['email_address' => $email_address, 'password' => $password, 'active' => 1, 'is_admin'=>0],$remember)) {
                $response['status'] = 'error';
                $response['message'] = 'The username or password is incorrect. Please try again.';
                
                $attempts++;
                $user->no_of_attempts = $attempts;
                $user->save();
                \Session::flash('attempts', $attempts);
                return redirect()->back()->with('error','Invalid Password or email.');
            }      
        }else{
            return redirect()->back()->with('error', 'Invalid Email Address.');
        }  
        
        $user = User::where('email_address', '=', $email_address)->first();

        $user->no_of_attempts = 0;
        $user->save();
        $user = Auth::user();
            return redirect()->intended('dashboard/profile');

    }

    public function register(){

        $defaultCountry = Input::old("country", 41);
        $defaultState = Input::old("states", '');
        $defaultCity = Input::old("city", '');
        $defaultSubCity = Input::old("sub_city", '');

        $country = Country::orderBy("name","ASC")->pluck('name','id');
        $states = State::where("country_id","=",$defaultCountry)->orderBy("name","ASC")->pluck('name','id');

        $city = [];
        $sub_city = [];
        if(!empty($defaultState)){
            $city = City::where("state_id","=", $defaultState)->pluck("name","id");
        }

        if(!empty($defaultCity)){
            $sub_city = Sub_City::where("city_id","=", $defaultCity)->pluck("name","id");
        }

        return view('client::register',['country' => $country,'defaultCountry'=>$defaultCountry,'states' => $states,'sub_city' => $sub_city, 'city' => $city]);
    }

    public function registerStore(Request $request){
        
        $allData = $request->all();

        $validationArray = array(
            'first_name' => 'required', 
            'last_name' => 'required',
            'email_address'=>  'required|email|max:255|unique:users',
            'mobile_number' => 'required',
            'registration_type' => 'required',
            'country' => 'required',
            'states' => 'required',
            'city' => 'required',
            'sub_city' => 'required',
            'password'=> 'required',
            'confirm_password'=> 'required|same:password'
        );
        $this->validate($request, $validationArray);
        $length = 32;
        $token = bin2hex(random_bytes($length));
        //echo "<pre>";print_r($token);exit;
        Mail::send('email_templates/register_email', ['token'=>$token,'first_name'=>$request->first_name,'last_name'=>$request->last_name], function($message) {
            $message->to(Input::get('email_address'))
                ->from(\Config::get('mail.from.address'), \Config::get('mail.from.name'))
                ->subject('Verify your Email Address');
        });

        $register = new User;
        $register->first_name = $allData['first_name'];
        $register->last_name = $allData['last_name'];
        $register->email_address = $allData['email_address'];
        $register->phone = $allData['mobile_number'];

        $register->country = $allData['country'];
        $register->state = $allData['states'];
        $register->city = $allData['city'];
        $register->sub_city = $allData['sub_city'];

        $sub_city = Sub_City::where("id","=", $allData['sub_city'])->first();
        if(!empty($sub_city)){
            $register->latitude = $sub_city->latitude;
            $register->longitude = $sub_city->longitude;
        }

        $register->user_type = $allData['registration_type'];

        $register->password = bcrypt($allData['password']);
        $register->active = 0;
        $register->is_admin = 0;
        $register->reset_token = $token;
        $register->save();

       return redirect('/login')->with('status', 'We have send you an activation code. Check your email.'); 
        
    }

    public function verification($token){

        $user = User::where('reset_token','=',$token)->first();
        if ($user == '') {
            return redirect('/login')->with('warning', 'Invalid token.');
        }
        /*$role = Role::where('name','=','Demographic Manager')->first();
        $user->attachRole($role); */
        
        $user->active = 1;
        $user->save();

        return redirect('/login')->with('status', 'Your email has been verified.');
    }

    public function forgotPassword(){
        return view('client::forgot_password');
    }

    public function sendMail(Request $request){
        $allData = $request->all();
        $validationArray = array(
            'email_address'=>  'required|email|max:255'
        );
        $this->validate($request, $validationArray);

        $user = User::where('email_address','=',$allData['email_address'])->first();
        if(empty($user)){
            return redirect('/forgot_password')->with('warning', 'Invalid Email Address.');
        }
        if($user->active == '0'){
            return redirect('/forgot_password')->with('warning', 'Email Address is not verified.');
        }

        $token = bin2hex(random_bytes(32));
        $expiryDate = date("Y-m-d H:i:s", strtotime("+1 day"));

        $user->reset_token = $token;
        $user->reset_token_expiry = $expiryDate;
        
       
        $user->save();

        Mail::send('email_templates/reset_password', ['token'=>$token,'user' => $user], function($message) {
            $message->to(Input::get('email_address'))
                ->from(\Config::get('mail.from.address'), \Config::get('mail.from.name'))
                ->subject('Reset password instructions');
        });

        return redirect('/login')->with('status', 'We have send you an email for password reset. Check your email.');
    }

    public function passwordVerification($token){
       $user = User::where('reset_token','=',$token)->first();
        if ($user == '') {
            return redirect('/login')->with('warning', 'Invalid token.');
        }
        return view('client::reset_password',array('token' => $token));
    }

    public function resetPassword(Request $request){
        $allData = $request->all();
        $validationArray = array(
            'password'=> 'required',
            'confirm_password'=> 'required|same:password'
        );
        $this->validate($request, $validationArray);
        $currentDate = date("Y-m-d H:i:s");
        //echo "<pre>";print_r($allData);exit;
        $user = User::where('reset_token','=',$allData['token'])->first();
        if ($user == '' || $currentDate >= $user->reset_token_expiry) {
            return redirect('/login')->with('warning', 'Invalid token or token expired.');
        }
        $user->reset_token = null;
        $user->reset_token_expiry = null;
        $user->password = bcrypt($allData['password']);
        $user->save();

        return redirect('/login')->with('status', 'Password changed successfully');
    }

    public function logout() {
        Auth::logout();
        return redirect('home');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'email_address' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'email_address' => $data['email_address'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function get_list(){
        $type = \Input::get('type','');
        $id = \Input::get('id','');

        $data = array();
        if ($type == "country"){
            $data = State::where("country_id","=", $id)->pluck("name","id");
        }else if($type == "states" && !empty($id)){
            $data = City::where("state_id","=", $id)->pluck("name","id");
        }else if($type == "city" && !empty($id)){
            $data = Sub_City::where("city_id","=", $id)->pluck("name","id");
        }

        if( !empty($data) ){
            $name = '';
            if ($type == "country"){
                $name = "State";
            }else if($type == "states"){
                $name = "City";
            }else if( $type == "city"){
                $name = "Sub City";
            }
            $select = '<option selected="selected" value="">Select '.$name.'</option>';
            foreach ($data as $key => $value) {
                $select .= '<option value="'.$key.'">'.$value.'</option>';
            }
            echo $select;
            exit;
        }
        echo "";
        exit;
    }
}
