<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Builders\ItemBuilder;
use App\Framework\Controller;
use App\Models\Item;

/**
 * Class ListController
 * @package App\Controllers
 */
class ListController
{
    use Controller;

    public function index(): void
    {
        $this->view('index');
    }

    public function list(): bool|array
    {
        /*$listId = 1; //todo one list for now
        $items = [
            (new ItemBuilder())->createItem($listId, 'Feathers of Dust'),
            (new ItemBuilder())->createItem($listId, 'Gloves of Infinite Fingers'),
            (new ItemBuilder())->createItem($listId, 'Broken bottle'),
        ];*/
        return (new ItemBuilder())->findAll();
    }

    /**
     * @param  int  $listId
     * @param  string  $itemName
     * @return bool
     */
    public function addItem(int $listId, string $itemName): bool
    {
        //todo check User access here
        return (new ItemBuilder())->createItem($listId, $itemName);
    }

    /**
     * @param  int  $listId
     * @param  int  $itemId
     * @return bool
     */
    public function removeItem(int $listId, int $itemId): bool
    {
        // todo check User access here
        return (new Item())->delete($itemId);
    }

    /**
     * @param  int  $listId
     * @param  int  $itemId
     * @param  string  $itemName
     * @return bool
     */
    public function editItem(int $listId, int $itemId, string $itemName): bool
    {
        // todo check User access here
        return (new Item())->update($listId, ['name' => $itemName]);
    }

    /**
     * @param  int  $listId
     * @param  int  $itemId
     * @param  int  $status
     * @return bool
     */
    public function markItem(int $listId, int $itemId, int $status): bool
    {
        // todo check User access here
        return (new Item())->update($itemId, ['status' => $status]);
    }
}