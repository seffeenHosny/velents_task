<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public UserService $userService;
    public function __construct()
    {
        $this->userService = app(UserService::class);
    }

    public function index()
    {
        $users =  $this->userService->index();

        return message(resource_collection(UserResource::collection($users)) , __('Users List'));
    }

    public function show($id)
    {
        $user = $this->userService->find($id);
        if($user){
            return message(new UserResource($user) , __('User Details'));
        }

        return message([] , __('Not Fount') , false , 404);
    }

    public function store(UserRequest $request)
    {
        $user = $this->userService->save($request);
        return message(new UserResource($user) , __('User Created'));
    }

    public function update(UserRequest $request, User $user)
    {
        $user = $this->userService->save($request , $user);
        return message(new UserResource($user) , __('User Updated'));
    }

    public function destroy(User $user)
    {
        $this->userService->delete($user);
        return message([] , __('User deleted'));

    }
}
