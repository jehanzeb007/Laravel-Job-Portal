<?php
namespace App\Http\Controllers\Auth;

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

class AuthController extends Controller
{

    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function login() {
        //die('here');
        return view('login');
    }

    public function loginPost(LoginRequest $request) {
        //die('here');
        $email_address = $request->input('email_address');
        $password = $request->input('password');
        $remember = $request->input('remember',0);
        $user = User::where('email_address', '=', $email_address)->first();
        //echo "<pre>";print_r($user);exit;
        if(!$user == ''){
        $attempts = $user->no_of_attempts;
        \Session::flash('attempts', $attempts);
        /*if($attempts>3){
            //die('here');
                $this->validate($request, [
                    'g-recaptcha-response'=>'required|captcha',
                ]);
        } */
            // Not authenticated
            if (!Auth::attempt(['email_address' => $email_address, 'password' => $password, 'active' => 1, 'is_admin'=>1],$remember)) {
                //$response['status'] = 'error';
                //$response['message'] = 'The username or password is incorrect. Please try again.';
                 
                    $attempts++;
                    $user->no_of_attempts = $attempts;
                    $user->save();
                    \Session::flash('attempts', $attempts);
                    return redirect()->back()->with('error', 'Invalid Password or email.');
            }     
        }else{
                    return redirect()->back()->with('error', 'Invalid Email Address.');
                }  
        
        $user = User::where('email_address', '=', $email_address)->first();

        $user->no_of_attempts = 0;
        $user->save();
        $user = Auth::user();
        //die('login');
        /*if ($user->hasRole('admin')) {*/
            return redirect()->intended('admin/users');
/*        }else{
            return redirect()->intended('admin');
        }
*/    }

    public function forgotPassword(){
        return view('forgot_password');
    }

    public function sendMail(Request $request){
        //die('h');
        $allData = $request->all();
        $validationArray = array(
            'email_address'=>  'required|email|max:255'
        );
        $this->validate($request, $validationArray);

        $user = User::where('email_address','=',$allData['email_address'])->first();
        if(empty($user)){
            return redirect('admin/login')->with('warning', 'Invalid Email Address.');
        }
        if($user->active == '0'){
            return redirect('admin/login')->with('warning', 'Email Address is not verified.');
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

        return redirect('admin/login')->with('status', 'We have send you an email for password reset. Check your email.');
    }

    public function passwordVerification($token){
       $user = User::where('reset_token','=',$token)->first();
        if ($user == '') {
            return redirect('admin/login')->with('warning', 'Invalid token.');
        }
        return view('reset_password',array('token' => $token));
    }

    public function resetPassword(Request $request){
        $allData = $request->all();
        $validationArray = array(
            'password'=> 'required',
            'confirm_password'=> 'required|same:password'
        );
        $this->validate($request, $validationArray);
        //echo "<pre>";print_r($allData);exit;
        $user = User::where('reset_token','=',$allData['token'])->first();
        $currentDate = date("Y-m-d H:i:s");
        if ($user == '' || $currentDate >= $user->reset_token_expiry) {
            return redirect('/login')->with('warning', 'Invalid token or token expired.');
        }
        $user->reset_token = null;
        $user->reset_token_expiry = null;
        $user->password = bcrypt($allData['password']);
        $user->save();

        return redirect('admin/login')->with('status', 'Password changed successfully');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('admin_login');
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
}
