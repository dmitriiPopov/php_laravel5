<?php

namespace App\models;

use App\Model;

/**
 * @mixin   \Eloquent
 * @package App\models
 */
class ObjectNamePage extends Model
{

    /**
     * {@inheritdoc}
     */
    protected $table = 'object_name_page';

    /**
     * {@inheritdoc}
     */
    protected $primaryKey = 'object_name_page_id';

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

    /**
     * @var array
     */
    public $guarded = [];

}
