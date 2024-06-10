<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * 
 *
 * @property int $id
 * @property int $order_id
 * @property int $sum
 * @property int $paid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order|null $Order
 * @method static \Illuminate\Database\Eloquent\Builder|Payments newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payments newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payments query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payments whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payments whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payments whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payments wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payments whereSum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payments whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'sum',
        'paid'
    ];

    public function Order(): HasOne
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
}
