<?php

namespace App\Actions\Certification;

use App\Models\Certification;
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
      $validator = $this->validate($input);

      if ($validator->fails()) {
        return $validationFails($validator->errors());
      }

      Certification::find($input['id'])->fill([
        'name' => $input['name'],
        'certification_number' => $input['certification_number'],
        'expiration' => $input['expiration'],
        'memo' => $input['memo'],
        'category' => $input['category'],
        'sub_category' => $input['sub_category'],
      ])->save();

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
