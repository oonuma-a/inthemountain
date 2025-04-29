<?php

namespace App\Services;
use Exception;
use Illuminate\Support\Facades\Storage;

use App\Repositories\Interfaces\ItemRepositoryInterface;

class ItemService
{
    protected $itemRepo;

    public function __construct(ItemRepositoryInterface $itemRepo)
    {
        $this->itemRepo = $itemRepo;
    }

    public function get($inputs = null)
    {
        return $this->itemRepo->getItem($inputs);
    }

    public function findItemByID(int $id)
    {
        return $this->itemRepo->findItemByID($id);
    }

    public function findItemsByIds(array $ids)
    {
        return $this->itemRepo->findItemsByIds($ids);
    }

    public function createItem($itemData)
    {
        try {
            // 商品画像 投稿処理
            if (isset($itemData['image'])) {
                $image = $itemData['image'];
                $path = $image->store('public/image');
                $itemData['image'] = $path;
            }
            return $this->itemRepo->create($itemData);
        } catch (Exception $e) {
            throw new Exception('商品登録エラー: ' . $e->getMessage());
        }
    }

    public function updateItem($id, $updateItemData)
    {
        $item = $this->itemRepo->findItemByID($id);

        if (!$item) {
            throw new Exception('商品が見つかりません。');
        }

        try {
            if (isset($updateItemData['image'])) {
                // 古い画像が存在する場合、古い画像を削除
                if (!empty($item->image)) {
                    Storage::disk('public')->delete($updateItemData['image']);
                }

                $image = $updateItemData['image'];
                $path = $image->store('public/image');
                $updateItemData['image'] = $path;
            } else {
                // 画像更新がない場合、元の画像を保持
                $updateItemData['image'] = $item->image;
            }

            // データ更新
            return $this->itemRepo->update($id, $updateItemData);

        } catch (\Exception $e) {
            throw new \Exception('商品更新エラー: ' . $e->getMessage());
        }
    }

    public function deleteItemByID(int $id)
    {
        try {
            $this->itemRepo->deleteItemByID($id);

            // 商品に画像が存在する場合、画像をストレージから削除
            if(isset($deleteData->image)){
                Storage::delete('public/image', $deleteData->image);
            }
        } catch (Exception $e) {
            // ログに記録したり、独自例外を投げてもOK
            logger()->error('アイテム削除エラー', ['error' => $e->getMessage()]);

            // ここで例外を投げなおす
            throw new Exception('削除に失敗しました。');
        }
    }
}
