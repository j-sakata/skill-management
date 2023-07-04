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

      $certification = Experience::create([
          'user_id' => $input['user_id'],
          'company_name' => $input['company_name']
      ]);
      $certification->experience_content()->create([
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
        // 'user_id' => ['required', 'max:30'],
        // 'name' => ['required', 'max:30'],
        // 'email' => ['required', 'email', 'max:255'],
      ],
      [
        // 'user_id.required' => 'IDを入力してください',
        // 'user_id.max' => '30字以内で入力してください',
        // 'name.required' => '名前を入力してください',
        // 'name.max' => '30字以内で入力してください',
        // 'email.required' => 'メールアドレスを入力してください',
        // 'email.max' => '255字以内で入力してください',
      ]);
    }
}
