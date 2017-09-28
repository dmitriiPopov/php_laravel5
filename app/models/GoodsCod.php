<?php

namespace App\models;

use App\Model;
use Illuminate\Database\Eloquent\Builder;

class GoodsCod extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'goods_cod';

    /**
     * {@inheritdoc}
     */
    protected $primaryKey = 'goods_cod_id';

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

    /**
     * @param Builder $builder
     * @param string  $query
     *
     * @return Builder
     */
    public function scopeSearch(Builder $builder, $query)
    {
        $name = str_replace([
            ' ',
            '(',
            ')',
            'X',
            'x',
            '.',
            ',',
            '-',
            '/',
            '\\'
            ], '%', $query);

        /* плата управления => модуль */
        $name = str_replace(trans('search.board'), trans('search.module'), $name);

        /* насос асколл | асколл | аскол => Askoll */
        $name = str_replace([
            trans('search.replacement_askol_from'),
            trans('search.replacement_2'),
            trans('search.replacement_3')
        ], trans('search.replacement_askol_to'), $name);

        return $builder
                ->where('goods_cod_name', 'like', "%{$query}%")
                ->orWhere('goods_cod_name', 'like', "%{$name}%");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function good()
    {
        return $this->belongsTo('App\models\Good', 'goods_id');
    }
}
