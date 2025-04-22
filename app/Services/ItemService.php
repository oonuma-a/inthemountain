<?php

namespace App\Services;

use App\Repositories\Interfaces\ItemRepositoryInterface;

class ItemService
{
    protected $itemRepo;

    public function __construct(ItemRepositoryInterface $itemRepo)
    {
        $this->itemRepo = $itemRepo;
    }

    public function get($inputs)
    {
        return $this->itemRepo->getItem($inputs);
    }
}
