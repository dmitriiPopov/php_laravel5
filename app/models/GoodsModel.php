<?php

namespace App\models;

use App\Model;

class GoodsModel extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'model';

    /**
     * {@inheritdoc}
     */
    protected $primaryKey = 'model_id';

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function modelsGoods()
    {
        return $this->hasMany('App\models\GoodsModelGoods', 'model_id', 'model_id');
    }
}
