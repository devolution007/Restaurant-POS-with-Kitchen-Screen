<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;

class CustomerFilter extends ModelFilter
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
     * @param      string           $search  The search
     *
     * @return     WarehouseFilter  The warehouse filter.
     */
    public function search($search): CustomerFilter
    {
        return $this->where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('email', 'LIKE', '%' . $search . '%')
            ->orWhere('phone', 'LIKE', '%' . $search . '%')
            ->orWhere('address', 'LIKE', '%' . $search . '%');
    }
}
