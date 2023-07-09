<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class CreateUser
{
    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return $success
     */
    public function create(array $input, $validationFails, $success)
    {
        $validator = $this->validate($input);

        if ($validator->fails()) {
            return $validationFails($validator->errors());
        }

        $user = new User();
        $user->user_id = $input['user_id'];
        $user->password = Hash::make($input['user_id']);
        $user->authority = $input['authority'];
        $user->created_id = $input['create_user_id'];
        $user->updated_id = $input['create_user_id'];
        $user->fill($input)->save();

        return $success();
    }

    public function validate(array $input)
    {
        return Validator::make($input, [
            'user_id' => ['required', 'max:30'],
            'name' => ['required', 'max:30'],
            'email' => ['required', 'email', 'max:255'],
        ]);
    }
}
