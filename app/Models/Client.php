<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * Client
 *
 * @mixin Builder
 * @property int $id
 * @property string $fio
 * @property string $email
 * @property string $phone
 * @property string $telegram
 * @property string $email_verify_hashcode
 * @property int $email_verify
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @method static \Database\Factories\ClientFactory factory($count = null, $state = [])
 * @method static Builder|Client newModelQuery()
 * @method static Builder|Client newQuery()
 * @method static Builder|Client query()
 * @method static Builder|Client whereCreatedAt($value)
 * @method static Builder|Client whereEmail($value)
 * @method static Builder|Client whereEmailVerify($value)
 * @method static Builder|Client whereEmailVerifyHashcode($value)
 * @method static Builder|Client whereFio($value)
 * @method static Builder|Client whereId($value)
 * @method static Builder|Client wherePhone($value)
 * @method static Builder|Client whereTelegram($value)
 * @method static Builder|Client whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'fio',
        'email',
        'phone',
        'telegram',
        'email_verify_hashcode',
        'email_verify'
    ];
    protected $appends = [
        'orders_count'
    ];

    public function orders(): HasMany {
        return $this->hasMany(Order::class, 'client_id');
    }

    public function getOrdersCountAttribute($var = null)
    {
        return count($this->orders);
//        return Attribute::make(
//            get: fn (int $orders_count) => count($this->orders())
//        );
    }
}
