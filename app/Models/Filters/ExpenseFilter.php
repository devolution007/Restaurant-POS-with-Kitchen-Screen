<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;

class ExpenseFilter extends ModelFilter
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
     * @return     ExpenseFilter  The product filter.
     */
    public function search($search): ExpenseFilter
    {
        return $this->where('title', 'LIKE', '%' . $search . '%')
            ->orWhere('amount', 'LIKE', '%' . $search . '%');
    }

    /**
     * Filtter by category
     *
     * @param      string       $category  The category
     *
     * @return     ExpenseFilter  The product filter.
     */
    public function category($category): ExpenseFilter
    {
        return $this->where('expense_type_id', $category);
    }

    /**
     * Filtering by by day
     *
     * @param      mixed           $isDuration  The duration
     *
     * @return     ExpenseFilter  The repair order filter.
     */
    public function isDuration($isDuration): ExpenseFilter
    {
        if ('day' == $isDuration) {
            return $this->whereDay('created_at', '=', date('d'));
        }
        if ('month' == $isDuration) {
            return $this->whereMonth('created_at', '=', date('m'));
        }
        if ('year' == $isDuration) {
            return $this->whereYear('created_at', '=', date('Y'));
        }
        return $this;
    }
}
