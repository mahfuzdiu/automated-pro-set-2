<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait EventFilterable
{
    /**
     * @param $query
     * @param $term
     * @return Builder
     */
    public function scopeSearchByTitle($query, $term): Builder
    {
        return $query->when($term, function ($q, $term) {
            return $q->where('title', 'like', "%{$term}%");
        });
    }

    /**
     * @param $query
     * @param $date
     * @return Builder
     */
    public function scopeFilterByDate($query, $date): Builder
    {
        return $query->when($date, function ($q, $date) {
            return $q->where('date', $date);
        });
    }
}
