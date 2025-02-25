<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;

class IngredientFilter extends ModelFilter
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
     * @param      string          $search  The search
     *
     * @return     IngredientFilter  The category filter.
     */
    public function search($search): IngredientFilter
    {
        return $this->where('name', 'LIKE', '%' . $search . '%');
    }
}
