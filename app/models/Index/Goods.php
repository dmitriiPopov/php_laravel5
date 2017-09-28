<?php

namespace App\models\Index;


/**
 * Class Goods
 * @package App\models\Index
 *
 * Class for work with elasticsearch index data
 */
class Goods extends ElasticsearchIndex
{
    /**
     * @return string
     */
    public static function getIndexName()
    {
        return strtolower((new \ReflectionClass(new self))->getShortName());//`goods`
    }

    /**
     * @return array
     */
    protected static function getMappingsProperties()
    {
        return [
            'goods_id' => [
                'type'  => 'integer',
                'index' => 'not_analyzed',
            ],
            'goods_cod' => [
                'type'  => 'text',
                'index' => 'not_analyzed',
            ],
            'goods_name' => [
                'type' => 'text',
            ],
            'goods_description' => [
                'type' => 'text',
            ],
            'goods_description2' => [
                'type' => 'text',
            ],
            //'goods_shablon' => [
            //    'type' => 'text',
            //],
            'goods_title' => [
                'type' => 'text',
            ],
            'goods_keywords' => [
                'type' => 'text',//array
            ],
            'goods_seo' => [
                'type' => 'text',
            ],
            'goods_sort' => [
                'type'  => 'integer',
                'index' => 'not_analyzed',
            ],
            //
            'goods_cod_name' => [
                'type'  => 'text',//array
                //'index' => 'not_analyzed',
            ],
            //
            'model_name' => [
                'type'  => 'text',//array
                //'index' => 'not_analyzed',
            ],
        ];
    }

    /**
     * Returns array of mapping properties with associated values (with the same keys) from input array.
     *
     * @param array $propertiesKeysValues
     * @return array  Returns associative array of ONLY mapping properties and their values
     */
    public static function mapPropertiesKeysValues(array $propertiesKeysValues)
    {
        $properties = parent::mapPropertiesKeysValues($propertiesKeysValues);
        //chunk `goods_keywords` string to array format
        if (!empty($properties) && isset($properties['goods_keywords'])) {
            $properties['goods_keywords'] = array_filter(explode(',', $properties['goods_keywords']));
            $properties['goods_keywords'] = array_map(function ($value) {
                return trim($value);
            }, $properties['goods_keywords']);
        }
        //chunk `goods_cod_name` string to array format
        if (!empty($properties) && isset($properties['goods_cod_name'])) {
            $properties['goods_cod_name'] = array_filter(explode(',', $properties['goods_cod_name']));
            $properties['goods_cod_name'] = array_map(function ($value) {
                return trim($value);
            }, $properties['goods_cod_name']);
        }
        //chunk `model_name` string to array format
        if (!empty($properties) && isset($properties['model_name'])) {
            $properties['model_name'] = array_filter(explode(',', $properties['model_name']));
            $properties['model_name'] = array_map(function ($value) {
                return trim($value);
            }, $properties['model_name']);
        }
        return $properties;
    }
}