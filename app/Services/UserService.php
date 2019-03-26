<?php

namespace App\Services;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;
use App\User;

class UserService
{
    /**
     * UserService constructor.
     *
     */
    public function __construct() {}

    /**
     * @param CreateUserRequest $request
     * @return User|bool
     */
    public function createUser(CreateUserRequest $request)
    {
        $userData = [
             'name' => $request->input('name'),
             'email' => $request->input('email'),
             'password' => bcrypt($request->input('password'))
        ];

        /** @var User $user */
        $user = User::create($userData);

        return $user;
    }

    /**
     * @param EditUserRequest $request
     * @param User $user
     * @return bool
     */
    public function updateUser(EditUserRequest $request, User $user)
    {
        $updateFields['name'] = $request->input('name');

        if ($user->email !== $request->input('email')) {
            $userWithSameEmail = User::where('id', '!=', $user->id)->where('email', $request->input('email'))
                ->first();

            if (!empty($userWithSameEmail)) {
                session()->flash('customerror', __('lagarto.same_email'));
                return false;
            } else {
                $updateFields['email'] = $request->input('email');
            }
        }

        if ($request->input('password') && $user->password !== bcrypt($request->input('password'))) {
            $updateFields['password'] =  bcrypt($request->input('password'));
        }

        $user->update($updateFields);
    }

    /**
     * @param User $user
     * @throws \Exception
     */
    public function deleteUser(User $user)
    {
        $user->delete();
    }
}