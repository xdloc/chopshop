<?php
declare(strict_types=1);

namespace App\Models;

use App\Framework\Model;

/**
 * Class ListItem
 * @package App\Models
 *
 * @property int id
 * @property string user_id
 * @property string name
 * @property int status
 * @property string created_at
 * @property string updated_at
 */
class ItemList
{
    use Model;

}