<?php
namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Admin\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

    // ログイン画面
	public function showLoginForm()
	{
		return view('admin.auth.login'); 
	}


	//管理者認証のguard指定
	#protected function guard()
	#{
	#	return \Auth::guard('admin');
	#}

	/**
	* Log the user out of the application.
	*
	* @param \Iluminate\Http\Request $request
	* @return \Illuminate\Http\Response
	*/
	public function logout(Request $request)
	{
		$this->guard()->logout();

		$request->session()->invalidate();

		return $this->loggedOut($request) ?: redirect('/admin/'); //ログアウト後のリダイレクト

	}
}
