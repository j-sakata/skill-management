<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use App\Models\SkillMaster;
use App\Actions\Skill\CreateSkill;
use App\Actions\Skill\UpdateSkill;

class SystemController extends Controller
{

    /**
     * Show the skill management screen.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $skill_master = SkillMaster::all()->toArray();
        return Inertia::render('System/SystemList', ['skill_master' => $skill_master]);
    }

    /**
     * Create a new experience.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function createSkill(Request $request)
    {
        $creator = app(CreateSkill::class);
        $log_massage = "技術要素を登録する [{$request->user_id}]";

        return $creator->create($request->all(),
            function($error) use($log_massage) {
                Log::error($log_massage);
                return Inertia::render('System/SystemList', ['error' => $error]);
            },
            function() use($log_massage) {
                Log::info($log_massage);
                return redirect()->route('admin.system');
            },
        );
    }

    /**
     * Update the given experience.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function updateSkill(Request $request)
    {
        $creator = app(UpdateSkill::class);
        $log_massage = "技術要素を変更する [{$request->user_id}]";

        return $creator->update($request->all(),
            function($error) use($log_massage) {
                Log::error($log_massage);
                return Inertia::render('System/SystemList', ['error' => $error]);
            },
            function() use($log_massage) {
                Log::info($log_massage);
                return redirect()->route('admin.system');
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
