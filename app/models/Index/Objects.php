<?php

namespace App\models\Index;


/**
 * Class Object
 * @package App\models\Index
 *
 * Class for work with elasticsearch index data
 */
class Objects extends ElasticsearchIndex
{
    /**
     * @return string
     */
    public static function getIndexName()
    {
        return strtolower((new \ReflectionClass(new self))->getShortName());//`objects`
    }

    /**
     * @return array
     */
    protected static function getMappingsProperties()
    {
        return [
            'object_id' => [
                'type'  => 'integer',
                'index' => 'not_analyzed',
            ],
            'object_name_name' => [
                'type'  => 'text',

            ],
            'object_name_title' => [
                'type' => 'text',
            ],
            'object_name_keywords' => [
                'type' => 'text',//array
            ],
            'object_name_description' => [
                'type'  => 'text',
            ],
            'object_name_description2' => [
                'type'  => 'text',
            ],
            'object_name_page_description' => [
                'type' => 'text',
            ],
        ];
    }

    /**
     * Returns array of mapping properties with associated values (by keys) from input array.
     *
     * @param array $propertiesKeysValues
     * @return array  Returns associative array of ONLY mapping properties and their values
     */
    public static function mapPropertiesKeysValues(array $propertiesKeysValues)
    {
        $properties = parent::mapPropertiesKeysValues($propertiesKeysValues);
        //chunk keywords string to array format
        if (!empty($properties) && isset($properties['object_name_keywords'])) {
            $properties['object_name_keywords'] = explode(',', $properties['object_name_keywords']);
            $properties['object_name_keywords'] = array_map(function ($value) {
                return trim($value);
            }, $properties['object_name_keywords']);
        }
        return $properties;
    }
}