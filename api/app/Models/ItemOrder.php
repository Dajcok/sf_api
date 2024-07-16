<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 *  @mixin Eloquent
 */
class ItemOrder extends Pivot
{
    protected $table = 'item_order';

    protected $fillable = [
        'qty',
        'item_id',
        'order_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($pivot) {
            $pivot->order->calculateTotal();
        });

        static::updated(function ($pivot) {
            $pivot->order->calculateTotal();
        });

        static::deleted(function ($pivot) {
            $pivot->order->calculateTotal();
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * {@inheritdoc}
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'item_id' => 'integer',
            'order_id' => 'integer',
            'qty' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
