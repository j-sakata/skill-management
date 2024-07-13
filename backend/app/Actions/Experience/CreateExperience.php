<?php

namespace App\Actions\Experience;

use App\Models\Experience;
use Illuminate\Support\Facades\Validator;

class CreateExperience
{

    /**
     * Create a newly registered experience.
     *
     * @param  array  $input
     * @return $validationFails, $success
     */
    public function create(array $input, $validationFails, $success)
    {
      $validator = $this->validate($input);

      if ($validator->fails()) {
        return $validationFails($validator->errors());
      }

      $experience = Experience::create([
          'user_id' => $input['user_id'],
          'company_name' => $input['company_name']
      ]);
      $experience->experience_content()->create([
        'project_name' => $input['experience_content']['project_name'],
        'industry'=> $input['experience_content']['industry'],
        'started_at'=> $input['experience_content']['started_at'],
        'ended_at'=> $input['experience_content']['ended_at'],
        'member_count'=> $input['experience_content']['member_count'],
        'position'=> $input['experience_content']['position'],
        'contract_type'=> $input['experience_content']['contract_type'],
        'company_name'=> $input['experience_content']['company_name'],
      ]);

      return $success();
    }

    function validate(array $input)
    {
      return Validator::make($input, [
        'company_name' => ['required'],
        'experience_content.project_name' => ['required'],
        'experience_content.industry' => ['required'],
        'experience_content.started_at' => ['required'],
        'experience_content.ended_at' => [],
        'experience_content.member_count' => ['required', 'integer'],
        'experience_content.position' => [],
        'experience_content.contract_type' => ['required'],
        'experience_content.company_name' => ['required'],
      ]);
    }
}
