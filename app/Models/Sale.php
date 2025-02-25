<?php

namespace App\Models;

use App\Models\Customer;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'tracking', 'uuid',
        'took_at', 'order_taker_id', 'order_type',
        'cart_total_cost',
        'cart_total_items',
        'cart_total_price',
        'items',
        'profit_after_all',
        'payable_after_all',
        'tax',
        'tax_amount',
        'discount_rate',
        'discount_amount',
        'table_id',
        'is_preparing',
        'chef_id',
        'prepared_at',
        'customer_id',
        'ordered_online',
        'biller_id',
        'completed_at',
        'payment_note', 'progress',
        'staff_note', 'payment_method_id', 'note_for_chef',
    ];

    /**
     * Setting default route key
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'items' => 'json',
        'tax' => 'json',
        'is_preparing' => 'boolean',
    ];

    public function serviceTable(): BelongsTo
    {
        return $this->belongsTo(ServiceTable::class, 'table_id');
    }

    public function scopeOrderForKitchen($query)
    {
        return $query->whereNull('prepared_at');
    }

    public function scopeSubmittedOrder($query)
    {
        return $query->whereNull('completed_at');
    }

    public function scopeOrderForBilling($query)
    {
        return $query->where('is_preparing', true)
            ->whereNull('biller_id')
            ->whereNull('completed_at')
            ->whereNotNull('prepared_at')
            ->whereNotNull('chef_id');
    }

    /**
     * Customer info for current sale
     *
     * @return     BelongsTo  The belongs to.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function taker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'order_taker_id');
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function biller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'biller_id');
    }

    public function chef(): BelongsTo
    {
        return $this->belongsTo(User::class, 'chef_id');
    }
}
