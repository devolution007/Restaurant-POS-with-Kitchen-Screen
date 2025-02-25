<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;

class FoodItemFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    /**
     * Searches for the first match.
     *
     * @param      string         $search  The search
     *
     * @return     FoodItemFilter  The product filter.
     */
    public function search($search): FoodItemFilter
    {
        return $this->where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('sku', 'LIKE', '%' . $search . '%');
    }

    /**
     * Filtter by category
     *
     * @param      string       $category  The category
     *
     * @return     FoodItemFilter  The product filter.
     */
    public function category($category): FoodItemFilter
    {
        return $this->where('food_category_id', $category);
    }
}
