<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Hash;
use App\Models\Users;
use App\Models\Audit;

class AuthController extends Controller
{

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = 'dashboard';


    public function index(Request $request)
    {
	if($request->email){
		$pass = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
		$dados = array('pass' => $pass);

		$user = Users::where('email', Input::get('email'))->first();
		if (is_null($user)) {
			return $this->sendError('Informação não encontrada', 404);
		}

		$input['password'] = Hash::make($pass);
		$user->fill($input)->save();

		\Mail::send('emails.recuperar-senha',$dados, function ($message)use($request){
		$message
                ->to(Input::get('email'))
                ->subject('Resgate de Senha');
		});


		Audit::create(array('desc'=>'Forgot Password - '.Input::get('email')));
	}else{
	        return view('auth/auth');
	}
    }
    public function login(){

        $username = Input::get('username');
        $password = Input::get('password');
        $errors = "";
        if ($username && $password)
        {
	    if(!strpos($username, '@')){
		$username = $username."@bradesco.com.br";
	    }

            if (Auth::attempt(['email' => $username, 'password' => $password])) {
		$user = Users::where('id', Auth::user()->id)->first();
		$input = array();
		$input['last_login'] = date("Y-m-d H:i:s");
		$user->fill($input)->save();

		Audit::create(array('desc'=>'Login - email:'.$username));

                return response()->json([
                    'result' => true,
                    'url' => $this->redirectTo
                ]);
            }else{

                return response()->json([
                    'result' => false,
                    'message' => Lang::get("auth.failed")
                ]);

            }
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }

    protected function guard()
    {
        return Auth::guard('address');
    }


}
