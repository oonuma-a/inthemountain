<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getUser(array $inputs);

    public function findUserByID(int $id);

    public function create($insertUserData);

    public function update($id, $updateUserData);

    public function deleteUserByID(int $id);
}
