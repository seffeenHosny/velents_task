<?php

namespace App\Repositories;

use App\Helpers\FileHelper;
use App\Http\Requests\Api\UserRequest;
use App\Models\User;

class UserRepository
{

    public $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function index(){
        return $this->model->simplePaginate(20);
    }

    public function find($id){
        return $this->model->find($id);
    }

    public function save(UserRequest $request, $user = null){
        $data = $request->only('email' , 'first_name' , 'last_name');

        $data['password'] = bcrypt($request->password);

        if($user){
            $data = $request->only('email' , 'first_name' , 'last_name');

            $data['password'] = bcrypt($request->password);
    
            if($request->hasFile('image')){
                $data['image'] = FileHelper::update_file('users' , $request->image , $user->image);
            }
    
            $user->update($data);
        }else{
            if($request->hasFile('image')){
                $data['image'] = FileHelper::upload_file('users' , $request->image);
            }
    
            $user = User::create($data);
        }

        return $user;

    }

    public function delete(User $user)
    {
        FileHelper::delete_file($user->image);

        return $user->delete();

    }
}
