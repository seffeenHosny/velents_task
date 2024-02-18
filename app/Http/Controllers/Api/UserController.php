<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users =  User::simplePaginate(20);

        return message(resource_collection(UserResource::collection($users)) , __('Users List'));
    }

    public function show(User $user)
    {
        return message(new UserResource($user) , __('User Details'));
    }

    public function store(UserRequest $request)
    {
        $data = $request->only('email' , 'first_name' , 'last_name');

        $data['password'] = bcrypt($request->password);

        if($request->hasFile('image')){
            $data['image'] = FileHelper::upload_file('users' , $request->image);
        }

        $user = User::create($data);

        return message(new UserResource($user) , __('User Created'));
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->only('email' , 'first_name' , 'last_name');

        $data['password'] = bcrypt($request->password);

        if($request->hasFile('image')){
            $data['image'] = FileHelper::update_file('users' , $request->image , $user->image);
        }

        $user->update($data);

        return message(new UserResource($user) , __('User Updated'));
    }

    public function destroy(User $user)
    {
        FileHelper::delete_file($user->image);

        $user->delete();

        return message([] , __('User deleted'));

    }
}
