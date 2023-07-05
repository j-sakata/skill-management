<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Type\AuthorityType;
use Exception;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Models\User;


final class LoginController extends Controller
{
    /**
     * CookieAuthenticationController constructor.
     * @param AuthFactory $auth
     */
    public function __construct(
        private Auth $auth,
    ) {
    }

    public function index()
    {
        return Inertia::render('Login');
    }


    /**
     * @return bool
     */
    public function check()
    {
        return array("logined" => $this->getGuard()->check());
    }

    /**
     * @param Request $request
     * @return Inertia/Response
     * @throws Exception
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'max:30'],
            'password' => ['required', 'max:255'],
        ],
        [
            'user_id.required' => 'IDを入力してください',
            'user_id.max' => '30字以内で入力してください',
            'password.required' =>  'パスワードを入力してください' ,
            'password.max' => '255字以内で入力してください',
        ]);

        $log_massage = "ログイン [{$request->user_id}]";
        if ($validator->fails()) {
            Log::error($log_massage);
            return Inertia::render('Login', ['error' => $validator->errors()]);
        }

        if ($this->getGuard()->attempt(['user_id' => $request->user_id, 'password' => $request->password, 'authority' => AuthorityType::Admin->name])) {
            $request->session()->regenerate();
            $user = User::select('user_id', 'name', 'init_password')->find($request->user_id);
            Log::info($log_massage);
            return Inertia::render('Login', ['data' => $user]);
        }
        Log::error($log_massage);
        return Inertia::render('Login', ['reply' => "ログインに失敗しました"]);
    }

    /**
     * @param Request $request
     * @return Inertia/Response
     */
    public function logout(Request $request)
    {
        $this->getGuard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return $this->index();
    }

    /**
     * @return StatefulGuard
     */
    private function getGuard(): StatefulGuard
    {
        return $this->auth->guard(config('auth.defaults.guard'));
    }
}
