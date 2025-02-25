<?php

namespace App\Models;

use App\Models\FoodCategory;
use App\Models\Ingredient;
use App\Models\Modifier;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Storage;

class FoodItem extends Model
{
    use Filterable, HasFactory;

    protected $fillable = [
        'name', 'image', 'food_category_id', 'description',
        'sku', 'price', 'cost', 'uuid',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
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

    public function getModifiers()
    {
        return Modifier::get();
    }

    /**
     * Product category
     *
     * @return     BelongsTo  The belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(FoodCategory::class, 'food_category_id');
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'food_items_ingredients')->withPivot('quantity');
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
        : asset('images/default/product.png');
    }
}
