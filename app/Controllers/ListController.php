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
     * @api /method?=list/add
     *
     * @param  int  $listId
     * @param  string  $itemName
     * @return bool
     */
    public function add(int $listId, string $itemName): bool
    {
        //todo check User access here
        return (new ItemBuilder())->createItem($listId, $itemName);
    }

    /**
     * @api /method?=list/remove
     *
     * @param  int  $listId
     * @param  int  $itemId
     * @return bool
     */
    public function remove(int $listId, int $itemId): bool
    {
        // todo check User access here
        return (new Item())->delete($itemId);
    }

    /**
     * Edit item's name
     * @api /method?=list/edit
     *
     * @param  int  $listId
     * @param  int  $itemId
     * @param  string  $itemName
     * @return bool
     */
    public function edit(int $listId, int $itemId, string $itemName): bool
    {
        // todo check User access here
        return (new Item())->update($listId, ['name' => $itemName]);
    }

    /**
     * Mark as completed or unmark it back
     * @api /method?=list/mark
     *
     * @param  int  $listId
     * @param  int  $itemId
     * @param  int  $status
     * @return bool
     */
    public function mark(int $listId, int $itemId, int $status): bool
    {
        // todo check User access here
        return (new Item())->update($itemId, ['status' => $status]);
    }
}