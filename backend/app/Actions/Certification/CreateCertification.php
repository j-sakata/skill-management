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
      $validator = $this->validate($input);

      if ($validator->fails()) {
        return $validationFails($validator->errors());
      }

      $certification = Certification::create([
          'user_id' => $input['user_id'],
          'name' => $input['name'],
          'certification_number' => $input['certification_number'],
          'expiration' => $input['expiration'],
          'memo' => $input['memo'],
          'category' => $input['category'],
          'sub_category' => $input['sub_category'],
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
      $validator = $this->validate($input);

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
