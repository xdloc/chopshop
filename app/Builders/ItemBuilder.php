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

    public function createItem(string $itemName): bool
    {
        $createdAt = (new DateTimeImmutable)->format(DB_TIME_FORMAT);
        $this->item = new Item();
        return $this->item->insert([
            'list_id' => 1,
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