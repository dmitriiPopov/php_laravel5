<?php

namespace App\models;

use App\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin   \Eloquent
 * @package App\models
 */
class Object extends Model
{

    /**
     * {@inheritdoc}
     */
    protected $table = 'object';

    /**
     * {@inheritdoc}
     */
    protected $primaryKey = 'object_id';

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

    /**
     * @var array
     */
    public $guarded = [];

}
