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
    protected $redirectTo = 'painel';


    public function index(Request $request)
    {
        if ($request->email) {
            $pass = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);

            Audit::create([
                'description' => Input::get('email') . ' requisitou recuperação de senha'
            ]);

            if ($user = Users::where('email', Input::get('email'))->first()) {
                $dados = array('pass' => $pass, 'username' => $user->name);
                $input['password'] = Hash::make($pass);
                $input['last_login'] = null;
                $user->fill($input)->save();

                Mail::send('emails.recuperar-senha', $dados, function ($message) use ($request) {
                    $message
                        ->to(Input::get('email'))
                        ->subject('Sistema de Rastreamento de Envelopes');
                });
                Audit::create([
                    'description' => 'Enviado email de recuperação de senha para ' . Input::get('email')
                ]);
            }

            return response()->json('Se o endereço estiver cadastrado uma mensagem será enviada. ' .
                'Verifique sua caixa de mensagens', 200);
        }
        if (Auth::check() == true) {
            return redirect('/home');
        }
        return view('auth/auth');

    }

    public function login(Request $request)
    {
        $username = Input::get('username');
        $password = Input::get('password');
        if ($username && $password) {
            if (!strpos($username, '@')) {
                $username = $username . "@bradesco.com.br";
            }
            if (Auth::attempt(['email' => $username, 'password' => $password])) {
                $user = Users::find(Auth::user()->id);
                if ($user->last_login != null) {
                    $input = ['last_login' => date("Y-m-d H:i:s")];
                    $user->fill($input)->save();
                } else {
                    $request->session()->flash('alert-warning',
                        'Você deve alterar sua senha neste momento. Por favor preencha o formulário exibido.');
                    $this->redirectTo = route('users.my_profile');
                }

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
