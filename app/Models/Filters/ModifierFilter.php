<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;

class ModifierFilter extends ModelFilter
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
     * @return     ModifierFilter  The category filter.
     */
    public function search($search): ModifierFilter
    {
        return $this->where('title', 'LIKE', '%' . $search . '%');
    }
}
