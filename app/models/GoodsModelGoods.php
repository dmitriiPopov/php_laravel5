<?php

namespace App\models;

use App\Model;

class GoodsModelGoods extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'model_goods';

    /**
     * {@inheritdoc}
     */
    protected $primaryKey = 'model_goods_id';

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function good()
    {
        return $this->belongsTo('App\models\Good');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function model()
    {
        return $this->belongsTo('App\models\GoodsModel');
    }
}
