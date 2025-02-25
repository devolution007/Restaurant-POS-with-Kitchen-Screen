<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceTable extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'is_booked'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_booked' => 'boolean',
    ];

    /**
     * Sales on this table
     *
     * @return     HasMany  The has many.
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class, 'table_id');
    }

    public function scopeAvailible($query)
    {
        return $query->where('is_booked', false);
    }

    public function scopeBooked($query)
    {
        return $query->where('is_booked', true);
    }

}
