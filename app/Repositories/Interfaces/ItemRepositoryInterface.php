<?php

namespace App\Repositories\Interfaces;

interface ItemRepositoryInterface
{
    public function getItem(array $inputs);

    public function findItemByID(int $id);

    public function findItemsByIds(array $id);

    public function create($itemData);

    public function update($id, $updateItemData);

    public function deleteItemByID(int $id);
}
