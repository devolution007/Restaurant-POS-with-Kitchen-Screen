<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['uuid', 'name', 'email', 'phone', 'address'];

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
     * Sale under customer
     *
     * @return     HasMany  The has many.
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
