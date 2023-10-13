<?php

namespace App\Actions\Experience;

use App\Models\ExperienceSummary;
use Illuminate\Support\Facades\Validator;

class UpdateExperienceSummary
{

    /**
     * Update registered experience.
     *
     * @param  array  $input
     * @return $validationFails, $success
     */
    public function update(array $input, $validationFails, $success)
    {
      $validator = $this->validate($input);

      if ($validator->fails()) {
        return $validationFails($validator->errors());
      }

      ExperienceSummary::find($input['id'])->fill([
        'title' => $input['title'],
        'status' => $input['status'],
        'summary' => $input['summary']
      ])->save();

      return $success();
    }

    function validate(array $input)
    {
      return Validator::make($input, [
        'title' => ['required'],
        'status' => ['required'],
        'summary' => [''],
      ]);
    }
}
