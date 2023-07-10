<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Type\AuthorityType;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use App\Models\User;
use App\Actions\User\CreateUser;

class UserController extends Controller
{
    /**
     * CookieAuthenticationController constructor.
     * @param AuthFactory $auth
     */
    public function __construct(
        private Auth $auth,
    ) {
    }

    /**
     * Show the user register screen.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('User/UserRegister');
    }

    /**
     * Create a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function check(Request $request)
    {
        $count_user = User::count();
        if ($count_user == 0) {
            return response()->json(['status' => true]);
        }

        $authority = AuthorityType::Admin->name;
        $is_admin_user = User::where('user_id', $request->user_id)->where('authority', $authority)->exists();
        if ($is_admin_user) {
            $log_massage = "ログイン [{$request->user_id}]";
            if ($this->getGuard()->attempt(['user_id' => $request->user_id, 'password' => $request->password])) {
                $request->session()->regenerate();
                Log::info($log_massage);
                return response()->json(['status' => true]);
            }
            Log::error($log_massage);
            return response()->json(['status' => false]);
        }

    }

    /**
     * @return StatefulGuard
     */
    private function getGuard(): StatefulGuard
    {
        return $this->auth->guard(config('auth.defaults.guard'));
    }

    /**
     * Create a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function create(Request $request)
    {
        $creator = app(CreateUser::class);
        $log_massage = "利用者を登録する [{$request->user_id}]";

        return $creator->create($request->all(),
            function($error) use($log_massage) {
                Log::error($log_massage);
                return Inertia::render('User/UserRegister', ['error' => $error]);
            },
            function() use($log_massage) {
                Log::info($log_massage);
                return redirect()->route('login');
            },
        );
    }
}
