<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Type\AuthorityType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use App\Models\User;
use App\Actions\User\CreateUser;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
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
    public function check_user(Request $request)
    {
        $has_user = User::first()->exists();
        $is_admin_user = User::where('user_id', $request->create_user_id)->where('password', Hash::make($request->password))->where('authority', AuthorityType::Admin->name)->exists();
        if (!$has_user || $is_admin_user) {
            return response()->json(['status' => 'true']);
        } else {
            return response()->json(['status' => 'false']);;
        }
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
