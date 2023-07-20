<?php

namespace App\Actions\Certification;

use App\Models\Certification;
use App\Models\CertificationAcquisition;
use Illuminate\Support\Facades\Validator;

class UpdateCertification
{

    /**
     * Update registered certification.
     *
     * @param  array  $input
     * @return $validationFails, $success
     */
    public function update(array $input, $validationFails, $success)
    {
      $validator = $this->validateUpdate($input);

      if ($validator->fails()) {
        return $validationFails($validator->errors());
      }

      Certification::find($input['id'])->fill([
        'certification_name' => $input['certification_name'],
        'certification_code' => $input['certification_code'],
        'certification_expiration' => $input['certification_expiration'],
        'certification_memo' => $input['certification_memo'],
        'certification_category' => $input['certification_category'],
        'certification_sub_category' => $input['certification_sub_category'],
      ])->save();

      return $success();
    }

    /**
     * Update registered certification.
     *
     * @param  array  $input
     * @return $validationFails, $success
     */
    public function change(array $input, $validationFails, $success)
    {
      $validator = $this->validateChange($input);

      if ($validator->fails()) {
        return $validationFails($validator->errors());
      }

        CertificationAcquisition::find($input['id'])->fill([
          'acquisition_date' => $input['acquisition']['acquisition_date'],
          'score'=> $input['acquisition']['score']
        ])->save();

      return $success();
    }

    function validateUpdate(array $input)
    {
      return Validator::make($input, [
        'certification_name' => ['required'],
        'certification_code' => [],
        'certification_expiration' => ['nullable', 'integer'],
        'certification_memo' => [],
        'certification_category' => ['required', 'integer'],
        'certification_sub_category' => ['required', 'integer'],
      ]);
    }

    function validateChange(array $input)
    {
      return Validator::make($input, [
        'acquisition.acquisition_date' => ['required', 'date'],
        'acquisition.score' => ['nullable', 'integer']
      ]);
    }
}
