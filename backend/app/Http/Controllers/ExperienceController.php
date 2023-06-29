<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use App\Models\Experience;
use App\Actions\Experience\CreateExperience;
use App\Actions\Experience\UpdateExperience;
use App\Actions\Experience\DeleteExperience;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{

    /**
     * Show the user management screen.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $experiences = Experience::where('user_id', Auth::id())->with('acquisition')->get()->toArray();
        $user_id = Auth::id();
        return Inertia::render('Experience/ExperienceList', ['experiences' => $experiences, 'user_id' => $user_id]);
    }

    /**
     * Create a new experience.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function create(Request $request)
    {
        $creator = app(CreateExperience::class);
        $log_massage = "取得資格を登録する [{$request->user_id}]";

        return $creator->create($request->all(),
            function($error) use($log_massage) {
                Log::error($log_massage);
                return Inertia::render('Experience/ExperienceList', ['error' => $error]);
            },
            function() use($log_massage) {
                Log::info($log_massage);
                return redirect()->route('experience');
            },
        );
    }

    /**
     * add a new experience.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function add(Request $request)
    {
        $creator = app(CreateExperience::class);
        $log_massage = "取得資格を登録する [{$request->user_id}]";

        return $creator->add($request->all(),
            function($error) use($log_massage) {
                Log::error($log_massage);
                return Inertia::render('Experience/ExperienceList', ['error' => $error]);
            },
            function() use($log_massage) {
                Log::info($log_massage);
                return redirect()->route('experience');
            },
        );
    }


    /**
     * Update the given experience.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function update(Request $request)
    {
        $creator = app(UpdateExperience::class);
        $log_massage = "取得資格を変更する [{$request->user_id}]";

        return $creator->update($request->all(),
            function($error) use($log_massage) {
                Log::error($log_massage);
                return Inertia::render('Experience/ExperienceList', ['error' => $error]);
            },
            function() use($log_massage) {
                Log::info($log_massage);
                return redirect()->route('experience');
            },
        );
    }

    /**
     * Update the given experience.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function change(Request $request)
    {
        $creator = app(UpdateExperience::class);
        $log_massage = "取得資格を変更する [{$request->user_id}]";

        return $creator->change($request->all(),
            function($error) use($log_massage) {
                Log::error($log_massage);
                return Inertia::render('Experience/ExperienceList', ['error' => $error]);
            },
            function() use($log_massage) {
                Log::info($log_massage);
                return redirect()->route('experience');
            },
        );
    }


    /**
     * Delete the given experienceer.
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
                return redirect()->route('experience');
            },
        );
    }
}
