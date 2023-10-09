<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use App\Models\Experience;
use App\Models\SkillMaster;
use App\Models\ExperienceSummary;
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
        $experiences = Experience::where('user_id', Auth::id())->with(['experience_content', 'technical_skill', 'experience_phase'])->get()->toArray();
        $experience_summaries = ExperienceSummary::where('user_id', Auth::id())->get()->toArray();
        $skill_master = SkillMaster::all()->toArray();
        $user_id = Auth::id();
        return Inertia::render('Experience/ExperienceList', ['experiences' => $experiences, 'experience_summaries' => $experience_summaries, 'skill_master' => $skill_master, 'user_id' => $user_id]);
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
        $log_massage = "職務履歴を登録する [{$request->user_id}]";

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
