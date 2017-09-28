<?php

namespace App\models;

use App\Lang;
use App\Model;
use Illuminate\Database\Eloquent\Builder;

class Search extends Model
{

    /**
     * {@inheritdoc}
     */
    protected $table = 'search';

    /**
     * {@inheritdoc}
     */
    protected $primaryKey = 'search_id';

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeListing(Builder $query)
    {
        return $query->select([
            'search_id',
            'search_url',
            'search_name',
            'search_text',
            'search_time'
        ])
        ->withLanguage()
        ->sortByTime();
    }

    /**
     * @param Builder  $query
     * @param null|int $language
     *
     * @return Builder
     */
    public function scopeWithLanguage(Builder $query, $language = null)
    {
        if (null === $language) {
            $language = Lang::current_id();
        }

        return $query->where('search_lang', $language);
    }

    /**
     * @param Builder $query
     * @param string  $order
     *
     * @return Builder
     */
    public function scopeSortByTime(Builder $query, $order = null)
    {
        if (false === in_array($order, ['ASC', 'DESC'])) {
            $order = 'DESC';
        }

        return $query->orderBy('search_time', $order);
    }

}
