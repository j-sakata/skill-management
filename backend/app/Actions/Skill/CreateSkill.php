<?php

namespace App\Actions\Skill;

use App\Models\SkillMaster;
use Illuminate\Support\Facades\Validator;

class CreateSkill
{
    /**
     * Create a newly registered skill.
     *
     * @param  array  $input
     * @return $success
     */
    public function create(array $input, $validationFails, $success)
    {
        $validator = $this->validate($input);

        if ($validator->fails()) {
            return $validationFails($validator->errors());
        }

        $user = new SkillMaster();
        $user->skill_name = $input['skill_name'];
        $user->skill_status = $input['skill_status'];
        $user->skill_category = $input['skill_category'];
        $user->save();

        return $success();
    }

    public function validate(array $input)
    {
        return Validator::make($input, [
            'skill_name' => ['required'],
            'skill_status' => ['required', 'boolean'],
            'skill_category' => ['required', 'integer'],
        ]);
    }
}
