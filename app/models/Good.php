<?php

namespace App\models;

use App\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Good
 * @package App\models
 * @mixin \Eloquent
 */
class Good extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'goods';

    /**
     * {@inheritdoc}
     */
    protected $primaryKey = 'goods_id';

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

    /**
     * @var {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * @return string
     */
    public function url()
    {
        return '/' . $this->tech->{'tech_url'.prefix()} . '/' . $this->detail->{'detail_url'.prefix()} . '/' . $this->{'goods_url'.prefix()} . '.html';
    }

    /**
     * @param Builder $builder
     * @param string  $query
     *
     * @return void
     */
    public function scopeByCode(Builder $builder, $query)
    {
        $code = strtr($query, [' ' => '', ',' => '.']);

        $builder
            ->where('goods_cod', $query)
            ->orWhere('goods_cod', $code);
    }

    /**
     * @param Builder $builder
     * @param string  $query
     *
     * @return void
     */
    public function scopeByName(Builder $builder, $query)
    {
        $builder
            ->where('goods_description2'.prefix(), 'like', "%{$query}%")
            ->orWhere('goods_cod', 'like', "%{$query}%")
            ->orWhere('goods_name'.prefix(), 'like', "%{$query}%")
            ->orWhere('goods_description'.prefix(), 'like', "%{$query}%");
    }

    /**
     * @param Builder $builder
     * @param array   $words
     *
     * @return void
     */
    public function scopeByWords(Builder $builder, array $words)
    {
        $columns = ['goods_description2'.prefix(), 'goods_name'.prefix(), 'goods_description'.prefix()];

        foreach ($columns as $column) {
            $builder->orWhere(function($query) use ($column, $words) {
                foreach ($words as $word) {
                    $query->where($column, 'like', "%{$word}%");
                }
            });
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function codes()
    {
        return $this->hasMany('App\models\GoodsCod', 'goods_id', 'goods_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function modelsGoods()
    {
        return $this->hasMany('App\models\GoodsModelGoods', 'goods_id', 'goods_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function models()
    {
        return $this->belongsToMany('App\models\GoodsModel', 'model_goods', 'goods_id', 'model_id', 'model_id');
    }
}
