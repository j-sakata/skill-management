<?php

namespace App\Actions\Experience;

use App\Models\ExperienceSummary;
use Illuminate\Support\Facades\Validator;

class CreateExperienceSummary
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

      ExperienceSummary::create([
        'title' => $input['title'],
        'status' => $input['status'],
        'summary' => $input['summary']
      ]);

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
