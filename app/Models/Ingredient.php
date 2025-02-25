<?php

namespace App\Models;

use App\Models\FoodItem;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['name', 'price', 'cost', 'quantity', 'alert_quantity', 'description', 'unit'];

    public function foodItems(): BelongsToMany
    {
        return $this->belongsToMany(FoodItem::class, 'food_items_ingredients');
    }

    public function modifiers(): BelongsToMany
    {
        return $this->belongsToMany(Modifier::class, 'ingredients_modifiers');
    }

    public function ingredientIsBeingUsed(): Bool
    {
        return $this->modifiers->count() < 1 && $this->foodItems->count() ? true : false;
    }

    public function scopeOutOfStock($query)
    {
        return $query->whereRaw('quantity  < alert_quantity');
    }
}
