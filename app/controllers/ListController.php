<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Framework\Controller;
use App\Models\Item;
use ItemBuilder;

/**
 * Class ListController
 * @package App\Controllers
 */
class ListController
{
    use Controller;

    public function index()
    {
        $this->view('index');
    }

    public function addItem(int $listId, string $itemName): bool
    {
        //todo check User access here
        return (new ItemBuilder())->createItem($listId, $itemName);
    }

    public function removeItem(int $listId, int $itemId): bool
    {
        // todo check User access here
        return (new Item())->delete($itemId);
    }

    public function editItem(int $listId, int $itemId, string $itemName): bool
    {
        // todo check User access here
        return (new Item())->update($listId, ['name' => $itemName]);
    }

    public function markItem(int $listId, int $itemId, int $status): bool
    {
        // todo check User access here
        return (new Item())->update($itemId, ['status' => $status]);
    }
}