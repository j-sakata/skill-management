<?php

namespace App\Actions\Experience;

use App\Models\Experience;
use App\Models\ExperienceContent;
use App\Models\TechnicalSkill;
use Illuminate\Support\Facades\Validator;

class UpdateExperience
{

    /**
     * Update registered experience.
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
      // 基本情報
      if ($edit_type === 0) {
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
        // 活動内容
      } elseif ($edit_type === 1) {
        ExperienceContent::find($input['id'])->fill([
          'project_summary' => $input['experience_content']['project_summary'],
          'description' => $input['experience_content']['description'],
          'achievement' => $input['experience_content']['achievement']
        ])->save();
        // 開発環境
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
        $db_register_skill_id = array_column(TechnicalSkill::where('experience_id', $input['id'])->get()->toArray(), 'skill_id');
        $diff_list = array_diff($db_register_skill_id, $list);
        if(!empty($diff_list)) {
          foreach($diff_list as $skill_id) {
            // チェックが外されたスキルを削除する
            TechnicalSkill::where('experience_id', $input['id'])->where('skill_id', $skill_id)->delete();
          }
        }
      }

      return $success();
    }

    function validate(array $input, int $edit_type)
    {
      $list = [];
      switch($edit_type) {
        case 0:
          $list = [
            'company_name' => ['required'],
            'experience_content.project_name' => ['required'],
            'experience_content.industry' => ['required'],
            'experience_content.started_at' => ['required'],
            'experience_content.ended_at' => [],
            'experience_content.member_count' => ['required', 'integer'],
            'experience_content.position' => [],
            'experience_content.contract_type' => ['required'],
            'experience_content.company_name' => ['required'],
          ];
          break;
        case 1:
          $list = [
            'experience_content.project_summary' => [],
            'experience_content.description' => [],
            'experience_content.achievement' => []
          ];
          break;
      };
      return Validator::make($input, $list);
    }
}
