<?php

namespace App\models;

use App\Model;

/**
 * @mixin   \Eloquent
 * @package App\models
 */
class ObjectName extends Model
{

    /**
     * {@inheritdoc}
     */
    protected $table = 'object_name';

    /**
     * {@inheritdoc}
     */
    protected $primaryKey = 'object_name_id';

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

    /**
     * @var array
     */
    public $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function page ()
    {
        return $this->hasOne(ObjectNamePage::class, 'object_name_id');
    }

}
