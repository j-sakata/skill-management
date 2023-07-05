<?php

namespace App\Actions\Experience;

use App\Models\Experience;
use App\Models\ExperienceSummary;
use App\Models\KnowledgeSummary;
use App\Models\ExperienceContent;
use App\Models\TechnicalSkill;
use Illuminate\Support\Facades\Validator;

class UpdateExperience
{

    /**
     * Update registered certification.
     *
     * @param  array  $input
     * @return $validationFails, $success
     */
    public function update(array $input, $validationFails, $success)
    {
      $edit_type = $input['edit_type'];
      $validator = $this->validate($input, $edit_type);

      if ($validator->fails()) {
        return $validationFails($validator->errors());
      }

      if($edit_type === 0) {
        Experience::find($input['experience_content']['experience_id'])->fill([
        'company_name' => $input['company_name']
      ])->save();
        ExperienceContent::find($input['experience_content']['id'])->fill([
          'project_name' => $input['experience_content']['project_name'],
          'industry' => $input['experience_content']['industry'],
          'started_at' => $input['experience_content']['started_at'],
          'ended_at' => $input['experience_content']['ended_at'],
          'member_count' => $input['experience_content']['member_count'],
          'position' => $input['experience_content']['position'],
          'contract_type' => $input['experience_content']['contract_type'],
          'company_name' => $input['experience_content']['company_name'],
        ])->save();
      } elseif($edit_type === 1) {
        ExperienceContent::find($input['id'])->fill([
          'project_summary' => $input['project_summary'],
          'phase' => $input['phase'],
          'description' => $input['description'],
          'achievement' => $input['achievement']
        ])->save();
      } else {
        $list = array_merge($input['skill_api'], $input['skill_fw'], $input['skill_os'], $input['skill_nw'], $input['skill_pj']);
        foreach($list as $value) {
          $target = TechnicalSkill::where('experience_id', $input['id'])->where('skill_id', $value);
          if(!($target->exists())) {
            TechnicalSkill::create([
              'experience_id' => $input['id'],
              'skill_id' => $value
            ]);
          }
        }
      }

      return $success();
    }

    function validate(array $input)
    {
      return Validator::make($input, [
        // 'user_id' => ['required'],
        // 'name' => ['required', 'max:30'],
        // 'email' => ['required', 'email', 'max:255'],
      ],
      [
        // 'name.required' => '名前を入力してください',
        // 'name.max' => '30字以内で入力してください',
        // 'email.required' => 'メールアドレスを入力してください',
        // 'email.max' => '255字以内で入力してください',
      ]);
    }
}
