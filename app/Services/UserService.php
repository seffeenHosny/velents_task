<?php

namespace App\Services;

use App\Http\Requests\Api\UserRequest;
use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    public $repo;

    /**
     * Create a new Repository instance.
     *
     * @param UserRepository $repository
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        $this->repo = $repository;
    }

    /**
     * Use id to find from Repository
     *
     * @param Int $id
     * @return Question
     */
    public function index()
    {
        return $this->repo->index();

    }

    public function find($id)
    {
        return $this->repo->find($id);

    }

      /**
     * Use save data into Repository
     *
     * @param Request $request
     * @param Int $id
     * @return Boolean
     */
    public function save(UserRequest $request, User $user = null)
    {

        return $this->repo->save($request, $user);
    }


    public function delete(User $user)
    {
        return $this->repo->delete($user);
    }

}
