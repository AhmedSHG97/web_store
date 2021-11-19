<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserAuthenticationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\UserResetPasswordEvent;
use App\Repositories\User\UserRepositoryInterface;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserAuthenticationController extends Controller
{
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function login(){
        if(auth()->user()){
            return redirect('dashboard');
        }
        return view('website.login_page')->with([
            'title' => __("auth.login_title"), 
            'email' => __("auth.text_email"), 
            "password" => __("auth.text_password"),
            "start_exploring" => __("auth.text_start_session"),
            "app_name" => config('app.name'),
        ]);
    }
    //Perform login
    public function signIn(UserAuthenticationRequest $request){
        if(!Auth::attempt($request->only('email','password'),isset($request->remember_me)?true:false)){
            return redirect()->back()->withErrors(['message'=>__("auth.text_not_authorized")]);
        }
        return redirect("dashboard")->with("success", __("website.text_login_success"));
    }

    public function signUp(){
        return view('website.sign_up')->with([
            'title' => __("auth.register_title"), 
            'name' => __("auth.text_name"), 
            'email' => __("auth.text_email"), 
            "password" => __("auth.text_password"),
            'password_confirmation' => __("auth.text_password_confirmation"), 
            "app_name" => config('app.name'),
        ]);
    }

    public function register(UserAuthenticationRequest $request){
        if(session()->has('validation_message')){
            return redirect()->back()->withErrors(['message'=>session("validation_message")]);
        }
        try{
            $this->repository->create($request->validated());
            Auth::attempt($request->only('email', 'password'));
            return redirect("dashboard")->with("success", __("website.text_register_success"));
        }catch(Exception $exception){
            return redirect()->back()->withErrors(['message'=>$exception->getMessage()]);
        }
    }
    public function forgot(){
        return view('website.forgot_password')->with(['title'=>__("auth.text_forgot_password"), "app_name" => config('app.name') ]);
    }

    public function resetPassword(UserAuthenticationRequest $request){
        if(session()->has('validation_message')){
            return redirect()->back()->withErrors(['message'=>session("validation_message")]);
        }
        $user = $this->repository->getUserByEmail($request->email);
        if (!$user) {
            return redirect()->back()->withErrors(['message'=>__("auth.text_not_authorized")]);
        }
        DB::beginTransaction();
        try{
            $token = app('auth.password.broker')->createToken($user);
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);
            $user->token = $token;
            event(new UserResetPasswordEvent($user));
            
        }catch(Exception $exception){
            DB::rollBack();
            return redirect()->back()->withErrors(['message'=>$exception->getMessage()]);
        }
        DB::commit();
            return redirect("login")->with("success", __("auth.text_check_email"));

    }
    public function newPassword(){
        return view("website.reset_password")->with(
            ['title' => __("auth.text_forgot_password"), 
            "app_name" => config('app.name'),
            "token" => request()->token,
        ]);
    }
    public function changePassword(UserAuthenticationRequest $request){
        if(session()->has('validation_message')){
            return redirect()->back()->withErrors(['message'=>session("validation_message")]);
        }
        $user =  $this->repository->getUserByToken($request->token);
        if ($user == null) {
            return redirect()->back()->withErrors(['message'=>__("auth.have_no_token")]);
        }
        $user->update([
            "password" => $request->password,
        ]);
        DB::table('password_resets')->where('token', $user->email)->delete();
        return redirect("login")->with("success", __("auth.text_password_changed"));
    }

    public function logout(){
        session()->flush();
        Auth::logout();
        return redirect("login");
    }
}
