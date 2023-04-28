<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Builders\ItemBuilder;
use App\Framework\Controller;
use App\Models\Item;

/**
 * Class ListController
 * @package App\Controllers
 * @api list/
 */
class ListController
{
    use Controller;

    /**
     * @return bool|array
     * @api /method?=list/list
     */
    public function list(): bool|array
    {
        return (new ItemBuilder())->findAll();
    }

    /**
     * @param  string  $itemName
     * @return bool
     * @api /method?=list/add
     */
    public function add(string $itemName): bool
    {
        return (new ItemBuilder())->createItem($itemName);
    }

    /**
     * @param  string  $itemId
     * @return bool
     * @api /method?=list/remove
     *
     */
    public function remove(string $itemId): bool
    {
        return (new Item())->delete((int)$itemId);
    }

    /**
     * Edit item's name
     * @param  string  $itemId
     * @param  string  $itemName
     * @return bool
     * @api /method?=list/edit
     *
     */
    public function edit(string $itemId, string $itemName): bool
    {
        return (new Item())->update((int)$itemId, ['name' => $itemName]);
    }

    /**
     * Mark as completed or unmark it back
     * @param  string  $itemId
     * @param  string  $status
     * @return bool
     * @api /method?=list/mark
     */
    public function mark(string $itemId, string $status): bool
    {
        return (new Item())->update((int)$itemId, ['status' => (int)$status]);
    }
}