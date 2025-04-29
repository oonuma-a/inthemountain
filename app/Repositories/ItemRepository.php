<?php

namespace App\Repositories;

use App\Models\Item;
use App\Repositories\Interfaces\ItemRepositoryInterface;

class ItemRepository implements ItemRepositoryInterface
{
    protected $model;

    public function __construct(Item $model)
    {
        $this->model = $model;
    }

    public function getItem($inputs)
    {
        $query = $this->model->query();

        if (!empty($inputs['item_name_search'])) {
            $query->where('item_name', 'like', '%' . $inputs['item_name_search'] . '%');
        }

        if (!empty($inputs['sale_search'])) {
            $query->whereNotNull('discount_price');
        }

        if (!empty($inputs['category_search'])) {
            $query->where('item_category', 'like', '%' . $inputs['category_search'] . '%');
        }

        $paginateChangeValue = $inputs['paginateChangeValue'] ?? 20;

        return $query->latest('update_at')->paginate($paginateChangeValue);
    }

    public function findItemByID(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function findItemsByIds(array $ids)
    {
        return $this->model->whereIn('id', $ids)->get();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, $updateItemData)
    {
        $item = $this->model->find($id);
        if ($item) {
            $item->update($updateItemData);
        }
        return $item;
    }

    public function deleteItemByID(int $id)
    {
        $item = $this->model->findOrFail($id);
        return $item->delete();
    }
}