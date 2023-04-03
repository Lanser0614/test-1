<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * class Product
 * @property int $id
 * @property string $title
 * @property int $quantity
 * @property float $price
 * @property float $total_price
 *
 */
class Product extends Model
{
    use HasFactory;
}
