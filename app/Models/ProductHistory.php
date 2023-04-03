<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *Class ProductHistory
 * @property string $title
 * @property string $status
 * @property int $quantity
 * @property float $price
 * @property float $total_price
 * @property int $user_id
 * @property int $product_id
 */
class ProductHistory extends Model
{
    use HasFactory;

    CONST PRODUCT_CREATED = 'PRODUCT_CREATED';
    CONST PRODUCT_UPDATED = 'PRODUCT_UPDATED';
    CONST PRODUCT_DELETED = 'PRODUCT_DELETED';

    protected $table = 'product_history';
}
