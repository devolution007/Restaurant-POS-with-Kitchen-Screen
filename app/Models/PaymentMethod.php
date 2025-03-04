<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    /**
     * Sales under payment methods
     *
     * @return     HasMany  The has many.
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
