<?php
declare(strict_types=1);

namespace App\Builders;

use App\Models\Item;
use DateTimeImmutable;

/**
 * Class ItemBuilder
 */
class ItemBuilder
{
    private Item $item;

    public function createItem(int $listId, string $itemName): bool
    {
        // todo:
        /*$this->item = new Item();
        $this->item->name = $itemName; // todo check for data if it came from user
        $this->item->created_at = (new DateTimeImmutable)->format(DB_TIME_FORMAT);
        $this->item->updated_at = (new DateTimeImmutable)->format(DB_TIME_FORMAT);
        $this->item->insert();*/

        $createdAt = (new DateTimeImmutable)->format(DB_TIME_FORMAT);
        $this->item = new Item();
        return $this->item->insert([
            'list_id' => $listId,
            'name' => $itemName,
            'status' => Item::STATUS_UNCHECKED,
            'create_at' => $createdAt,
            'updated_at' => $createdAt,
        ]);
    }

    public function getItem(): Item
    {
        return $this->item;
    }

    /**
     * @return bool|array
     */
    public function findAll(): bool|array
    {
        return (new Item())->findAll();
    }
}