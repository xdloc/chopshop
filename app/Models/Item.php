<?php
declare(strict_types=1);

namespace App\Models;

use App\Framework\Model;

/**
 * Class Item
 * @package App\Models
 *
 * @property int id
 * @property string name
 * @property string status
 * @property string created_at
 * @property string updated_at
 */
class Item
{
    use Model;

    public const STATUS_UNCHECKED = 0;
    public const STATUS_CHECKED = 1;

    protected string $table = 'items';

    protected array $allowedColumns = [
        'id',
        'name',
        'status',
        'created_at',
        'updated_at',
    ];

}