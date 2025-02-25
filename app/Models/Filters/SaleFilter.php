<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;

class SaleFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    /**
     * User dataTable search query
     *
     * @param mixed $search query
     *
     * @return SaleFilter
     */
    public function search($search): SaleFilter
    {
        return $this->where('tracking', 'LIKE', '%' . $search . '%');
    }

    /**
     * Filtering by starting date
     *
     * @param      mixed            $startdate  The startdate
     *
     * @return     SaleFilter  The repair order filter.
     */
    public function startdate($startdate): SaleFilter
    {
        return $this->where('created_at', '>', $startdate);
    }

    /**
     * Filtering by ending date date
     *
     * @param      mixed        $period  The period
     *
     * @return     SaleFilter  The repair order filter.
     */
    public function enddate($enddate): SaleFilter
    {
        return $this->where('created_at', '<', $enddate);
    }

    /**
     * Filtering by by day
     *
     * @param      mixed           $isDuration  The duration
     *
     * @return     SaleFilter  The repair order filter.
     */
    public function isDuration($isDuration): SaleFilter
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

    public function biller($biller): SaleFilter
    {
        return $this->where('biller_id', '=', $biller);
    }

    public function customer($customer): SaleFilter
    {
        return $this->where('customer_id', '=', $customer);
    }

    public function chef($chef): SaleFilter
    {
        return $this->where('chef_id', '=', $chef);
    }

    public function taker($taker): SaleFilter
    {
        return $this->where('order_taker_id', '=', $taker);
    }

    public function table($table): SaleFilter
    {
        return $this->where('table_id', '=', $table);
    }

    public function orderType($type): SaleFilter
    {
        return $this->where('order_type', '=', $type);
    }
}
