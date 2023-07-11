<?php

namespace App\Actions\Certification;

use App\Models\Certification;
use Illuminate\Support\Facades\Validator;

class CreateCertification
{

    /**
     * Create a newly registered certification.
     *
     * @param  array  $input
     * @return $validationFails, $success
     */
    public function create(array $input, $validationFails, $success)
    {
      $validator = $this->validateCreate($input);

      if ($validator->fails()) {
        return $validationFails($validator->errors());
      }

      $certification = Certification::create([
          'user_id' => $input['user_id'],
          'certification_name' => $input['certification_name'],
          'certification_code' => $input['certification_code'],
          'certification_expiration' => $input['certification_expiration'],
          'certification_memo' => $input['certification_memo'],
          'certification_category' => $input['certification_category'],
          'certification_sub_category' => $input['certification_sub_category'],
      ]);
      $certification->acquisition()->create([
        'acquisition_date' => $input['acquisition']['acquisition_date'],
        'score'=> $input['acquisition']['score']
      ]);

      return $success();
    }

    /**
     * Add a newly registered certification.
     *
     * @param  array  $input
     * @return $validationFails, $success
     */
    public function add(array $input, $validationFails, $success)
    {
      $validator = $this->validateAdd($input);

      if ($validator->fails()) {
        return $validationFails($validator->errors());
      }

      $certification = Certification::find($input['id']);
      $certification->acquisition()->create([
        'acquisition_date' => $input['acquisition']['acquisition_date'],
        'score'=> $input['acquisition']['score']
      ]);

      return $success();
    }

    function validateCreate(array $input)
    {
      return Validator::make($input, [
        'user_id' => ['required'],
        'certification_name' => ['required'],
        'certification_code' => [],
        'certification_expiration' => ['integer'],
        'certification_memo' => [],
        'certification_category' => ['required'],
        'certification_sub_category' => ['required'],
        'acquisition.acquisition_date' => ['required', 'date'],
        'acquisition.score' => ['nullable', 'integer']
      ]);
    }

    function validateAdd(array $input)
    {
      return Validator::make($input, [
        'acquisition.acquisition_date' => ['required', 'date'],
        'acquisition.score' => ['nullable', 'integer']
      ]);
    }
}
