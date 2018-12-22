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
use Mail;

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
        if ($request->email) {
            $pass = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
            $dados = array('pass' => $pass);

            Audit::create([
                'description' => Input::get('email') . ' requisitou recuperação de senha'
            ]);

            if ($user = Users::where('email', Input::get('email'))->first()) {
                $input['password'] = Hash::make($pass);
                $user->fill($input)->save();

                Mail::send('emails.recuperar-senha', $dados, function ($message) use ($request) {
                    $message
                        ->to(Input::get('email'))
                        ->subject('Resgate de Senha');
                });
                Audit::create([
                    'description' => 'Enviado email de recuperação de senha para ' . Input::get('email')
                ]);
            }

            return response()->json('Se o endereço estiver cadastrado uma mensagem será enviada. ' .
                'Verifique sua caixa de mensagens', 200);
        }
        if (Auth::check() == true) {
            return redirect('/dashboard');
        }
        return view('auth/auth');

    }

    public function login()
    {
        $username = Input::get('username');
        $password = Input::get('password');
        if ($username && $password) {
            if (!strpos($username, '@')) {
                $username = $username . "@bradesco.com.br";
            }
            if (Auth::attempt(['email' => $username, 'password' => $password])) {
                $user = Users::find(Auth::user()->id);
                $input = array();
                $input['last_login'] = date("Y-m-d H:i:s");
                $user->fill($input)->save();

                Audit::create([
                    'description' => 'Autenticou-se no sistema',
                    'user_id' => $user->id
                ]);

                return response()->json([
                    'result' => true,
                    'url' => $this->redirectTo
                ]);
            } else {

                return response()->json([
                    'result' => false,
                    'message' => Lang::get("auth.failed")
                ]);

            }
        }
    }

    public function logout()
    {
        if (Auth::check() == true) {
            Audit::create([
                'description' => 'Saiu do sistema',
                'user_id' => Auth::id()
            ]);
            Auth::logout();
        }

        return redirect('/');
    }

    protected function guard()
    {
        return Auth::guard('address');
    }


}
