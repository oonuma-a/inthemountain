<?php

namespace App\Repositories;

use App\Models\users;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(users $model)
    {
        $this->model = $model;
    }

    public function getUser($inputs)
    {
        $query = $this->model->query();

        if (!empty($inputs['user_name_search'])) {
            $query->where('user_name', 'like', '%' . $inputs['user_name_search'] . '%');
        }

        if (!empty($inputs['sale_search'])) {
            $query->whereNotNull('discount_price');
        }

        if (!empty($inputs['category_search'])) {
            $query->where('user_category', 'like', '%' . $inputs['category_search'] . '%');
        }

        $paginateChangeValue = $inputs['paginateChangeValue'] ?? 20;

        return $query->latest('update_at')->paginate($paginateChangeValue);
    }

    public function findUserByID(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, $updateUserData)
    {
        $user = $this->model->find($id);
        if ($user) {
            $user->update($updateUserData);
        }
        return $user;
    }

    public function deleteUserByID(int $id)
    {
        $user = $this->model->findOrFail($id);
        return $user->delete();
    }
}