<?php

namespace App\Repositories;

use App\Models\Item;
use App\Repositories\Interfaces\ItemRepositoryInterface;

class ItemRepository implements ItemRepositoryInterface
{
    public function getItem($inputs)
    {
        $query = Item::query();

        if (!empty($inputs['item_name_search'])) {
            $query->where('item_name', 'like', '%' . $inputs['item_name_search'] . '%');
        }

        if (!empty($inputs['sale_search'])) {
            $query->whereNotNull('discount_price');
        }

        if (!empty($inputs['category_search'])) {
            $query->where('item_category', 'like', '%' . $inputs['category_search'] . '%');
        }

        //ページネーションを使用した場合、ページ件数を変更
        if(!empty($inputs['paginateChangeValue'])){
            $paginateChangeValue = $inputs['paginateChangeValue'];
        }else{
            $paginateChangeValue = 20;
        }

        return $query->latest('update_at')->paginate($paginateChangeValue);
    }
}
