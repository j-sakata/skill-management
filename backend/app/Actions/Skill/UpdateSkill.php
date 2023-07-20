<?php

namespace App\Actions\Skill;

use App\Models\SkillMaster;
use Illuminate\Support\Facades\Validator;

class UpdateSkill
{
    /**
     * Update a registered skill.
     *
     * @param  array  $input
     * @return $success
     */
    public function update(array $input, $validationFails, $success)
    {
        $validator = $this->validate($input);

        if ($validator->fails()) {
            return $validationFails($validator->errors());
        }

        SkillMaster::find($input['id'])->fill([
        'skill_name' => $input['skill_name'],
        'skill_status' => $input['skill_status'],
        'skill_category' => $input['skill_category'],
        ])->save();

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
