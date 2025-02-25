<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Storage;

class FoodCategory extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['name', 'image'];

    /**
     * Prodcuts under category
     *
     * @return     HasMany  The has many.
     */
    public function products(): HasMany
    {
        return $this->hasMany(FoodItem::class);
    }

    /**
     * User avatar url
     *
     * @return string
     */
    public function getImage(): string
    {
        return $this->image
        ? Storage::disk('public')->url($this->image)
        : asset('images/default/category.png');
    }
}
