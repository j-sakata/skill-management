<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use App\Models\Certification;
use App\Actions\Certification\CreateCertification;
use App\Actions\Certification\UpdateCertification;
use App\Actions\Certification\DeleteCertification;
use Illuminate\Support\Facades\Auth;

class CertificationController extends Controller
{

    /**
     * Show the user management screen.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $certifications = Certification::where('user_id', Auth::id())->with('acquisition')->get()->toArray();
        $user_id = Auth::id();
        return Inertia::render('Certification/CertificationList', ['certifications' => $certifications, 'user_id' => $user_id]);
    }

    /**
     * Create a new certification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function create(Request $request)
    {
        $creator = app(CreateCertification::class);
        $log_massage = "取得資格を登録する [{$request->user_id}]";

        return $creator->create($request->all(),
            function($error) use($log_massage) {
                Log::error($log_massage);
                return Inertia::render('Certification/CertificationList', ['error' => $error]);
            },
            function() use($log_massage) {
                Log::info($log_massage);
                return redirect()->route('certification');
            },
        );
    }

    /**
     * add a new certification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function add(Request $request)
    {
        $creator = app(CreateCertification::class);
        $log_massage = "取得資格を登録する [{$request->user_id}]";

        return $creator->add($request->all(),
            function($error) use($log_massage) {
                Log::error($log_massage);
                return Inertia::render('Certification/CertificationList', ['error' => $error]);
            },
            function() use($log_massage) {
                Log::info($log_massage);
                return redirect()->route('certification');
            },
        );
    }


    /**
     * Update the given certification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function update(Request $request)
    {
        $creator = app(UpdateCertification::class);
        $log_massage = "取得資格を変更する [{$request->user_id}]";

        return $creator->update($request->all(),
            function($error) use($log_massage) {
                Log::error($log_massage);
                return Inertia::render('Certification/CertificationList', ['error' => $error]);
            },
            function() use($log_massage) {
                Log::info($log_massage);
                return redirect()->route('certification');
            },
        );
    }

    /**
     * Update the given certification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function change(Request $request)
    {
        $creator = app(UpdateCertification::class);
        $log_massage = "取得資格を変更する [{$request->user_id}]";

        return $creator->change($request->all(),
            function($error) use($log_massage) {
                Log::error($log_massage);
                return Inertia::render('Certification/CertificationList', ['error' => $error]);
            },
            function() use($log_massage) {
                Log::info($log_massage);
                return redirect()->route('certification');
            },
        );
    }


    /**
     * Delete the given certificationer.
     *
     * @param  string  $id
     * @return \Inertia\Response
     */
    public function delete($id)
    {
        $creator = app(DeleteUser::class);
        $log_massage = "取得資格を削除する [$id]";

        return $creator->delete($id,
            function($error) use($log_massage) {
                Log::error($log_massage);
                return Inertia::render('User', ['error' => $error]);
            },
            function() use($log_massage) {
                Log::info($log_massage);
                return redirect()->route('certification');
            },
        );
    }
}
