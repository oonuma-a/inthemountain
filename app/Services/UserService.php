<?php

namespace App\Services;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use App\Repositories\Interfaces\UserRepositoryInterface;

class UserService
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function get($inputs = null)
    {
        return $this->userRepo->getUser($inputs);
    }

    public function findUserByID(int $id)
    {
        return $this->userRepo->findUserByID($id);
    }

    public function createUser($insertUserData)
    {
        try {
            unset($insertUserData['_token']);
            $insertUserData['password'] = Hash::make($insertUserData['password']);

            return $this->userRepo->create($insertUserData);
        } catch (Exception $e) {
            throw new Exception('ユーザー登録エラー: ' . $e->getMessage());
        }
    }

    public function updateUser($id, $updateUserData)
    {
        $user = $this->userRepo->findUserByID($id);

        if (!$user) {
            throw new Exception('ユーザーが見つかりません。');
        }

        try {
            // データ更新
            return $this->userRepo->update($id, $updateUserData);

        } catch (\Exception $e) {
            throw new \Exception('ユーザー更新エラー: ' . $e->getMessage());
        }
    }

    public function deleteUserByID(int $id)
    {
        try {
            $this->userRepo->deleteUserByID($id);
        } catch (Exception $e) {
            logger()->error('ユーザー削除エラー', ['error' => $e->getMessage()]);

            throw new Exception('ユーザー削除に失敗しました。');
        }
    }
}
