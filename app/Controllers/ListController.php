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

    /**
     * @api /method?=list/list
     *
     * @return bool|array
     */
    public function list(): bool|array
    {
        return (new ItemBuilder())->findAll();
    }

    /**
     * @api /method?=list/addItem
     *
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
     * @api /method?=list/removeItem
     *
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
     * Edit item's name
     * @api /method?=list/editItem
     *
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
     * Mark as completed or unmark it back
     * @api /method?=list/markItem
     *
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