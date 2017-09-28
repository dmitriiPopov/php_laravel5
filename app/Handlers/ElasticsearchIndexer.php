<?php
namespace App\Handlers;

use App\models\Good;
use App\models\GoodsCod;
use App\models\GoodsModel;
use App\models\GoodsModelGoods;
use App\models\Index\Goods;
use App\models\Index\Objects;
use App\models\Object;
use App\models\ObjectName;
use App\models\ObjectNamePage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Psy\Util\Json;

/**
 * Handler for data indexing to elasticsearch
 *
 * Class ElasticsearchIndexer
 * @package App\Handlers
 *
 * Handler with high-level interface for indexing data (mysql ---> elasticsearch)
 */
class ElasticsearchIndexer
{
    /**
     * @var int
     */
    public static $defaultIterateLimit = 1000;

    /**
     * @var int
     */
    public static $defaultOffset       = 0;


    /**
     * Index Goods and related data
     *
     * @param array $params
     * @return void
     *
     * @note Should run ONLY on backend!
     */
    public static function indexGoods($params = [])
    {
        //prepare input params
        $skip         = array_get($params, 'offset', self::$defaultOffset);
        $limit        = array_get($params, 'limit', null);
        $iterateLimit = array_get($params, 'iterateLimit', self::$defaultIterateLimit);
        if ($limit && $limit < $iterateLimit) {$iterateLimit = $limit;}

        //instantiate used models
        $goods       = new Good();
        $goodsCod    = new GoodsCod();
        $modelsGoods = new GoodsModelGoods();
        $models      = new GoodsModel();

        //init aliases for query (did it for code readability)
        $goodsAlias       = $goods->getTable();
        $goodsCodAlias    = $goodsCod->getTable();
        $modelsGoodsAlias = $modelsGoods->getTable();
        $modelsAlias      = $models->getTable();
        /**@var $query \Illuminate\Database\Query\Builder*/
        //prepare query for getting data for indexing (native SQL request for speed)
        $query = DB::table($goods->getTable())
            ->selectRaw(new \Illuminate\Database\Query\Expression("
                $goodsAlias.goods_id,
                $goodsAlias.*,
                GROUP_CONCAT(DISTINCT $goodsCodAlias.goods_cod_name) as goods_cod_name,
                GROUP_CONCAT(DISTINCT $modelsAlias.model_name) as model_name
            "))
            ->leftJoin(
                $goodsCod->getTable(),
                $goodsCodAlias . '.' . $goods->getKeyName(),//goods_id
                '=',
                $goodsAlias . '.' . $goods->getKeyName()//goods_id
            )
            ->leftJoin(
                $modelsGoods->getTable(),
                $modelsGoodsAlias . '.' . $goods->getKeyName(),//goods_id
                '=',
                $goodsAlias . '.' . $goods->getKeyName()//goods_id
            )
            ->leftJoin(
                $models->getTable(),
                $modelsAlias . '.' . $models->getKeyName(),//model_id
                '=',
                $modelsGoodsAlias . '.' . $models->getKeyName()//model_id
            )
            ->whereNotNull($goods->getTable() .'.'. $goods->getKeyName())
            ->groupBy('goods_id')
        ;

        //set start offset/limit marks and get first portion of data
        /**@var $batchData \Illuminate\Support\Collection*/
        $batchData = $query->skip($skip)->take($iterateLimit)->get();

        //rebuild index
        Goods::rebuildIndex();

        $countOfIndexedRecords = 0;
        //if data for index has been found...
        while (!$batchData->isEmpty()) {
            //batch insert data to index
            Goods::bulkInsert($batchData->toArray(), ['_id' => 'goods_id']);
            //increment counter
            $countOfIndexedRecords += $batchData->count();
            self::log('Skip: ' . $skip . '; Total count of indexed records: ' . $countOfIndexedRecords);
            //check max limit of indexed records if it's set
            if ($limit && $countOfIndexedRecords >= $limit) {
                break;
            }
            //change skip index
            $skip += $iterateLimit;
            //set start offset/limit marks and get firs protion of data
            $batchData = $query->skip($skip)->take($iterateLimit)->get();
        }
    }

    /**
     * Index Objects and related data
     *
     * @param array $params
     * @return void
     *
     * @note Should run ONLY on backend!
     */
    public static function indexObjects($params = [])
    {
        //prepare input params
        $skip         = array_get($params, 'offset', self::$defaultOffset);
        $limit        = array_get($params, 'limit', null);
        $iterateLimit = array_get($params, 'iterateLimit', self::$defaultIterateLimit);
        if ($limit && $limit < $iterateLimit) {$iterateLimit = $limit;}

        //instantiate used models
        $object         = new Object();
        $objectName     = new ObjectName();
        $objectNamePage = new ObjectNamePage();

        //init aliases for query (did it for code readability)
        $objectAlias         = $object->getTable();
        $objectNameAlias     = $objectName->getTable();
        $objectNamePageAlias = $objectNamePage->getTable();
        /**@var $query \Illuminate\Database\Query\Builder*/
        //prepare query for getting data for indexing (native SQL request for speed)
        $query = DB::table($object->getTable())
            ->selectRaw(new \Illuminate\Database\Query\Expression("
                $objectAlias.object_id,
                $objectNameAlias.object_name_name,
                $objectNameAlias.object_name_title,
                $objectNameAlias.object_name_keywords,
                $objectNameAlias.object_name_descriptions,
                $objectNameAlias.object_name_name,
                $objectNamePageAlias.object_name_page_description
            "))
            ->leftJoin(
                $objectName->getTable(),
                $objectNameAlias . '.' . $object->getKeyName(),//object_id
                '=',
                $objectAlias . '.' . $object->getKeyName()//object_id
            )
            ->leftJoin(
                $objectNamePage->getTable(),
                $objectNamePageAlias . '.' . $objectName->getKeyName(),//object_name_id
                '=',
                $objectNameAlias . '.' . $objectName->getKeyName()//object_name_id
            )
            ->whereNotNull($object->getTable() .'.'. $object->getKeyName())
            ->groupBy('object_id')
        ;

        //set start offset/limit marks and get first portion of data
        /**@var $batchData \Illuminate\Support\Collection*/
        $batchData = $query->skip($skip)->take($iterateLimit)->get();

        //rebuild index
        Objects::rebuildIndex();

        $countOfIndexedRecords = 0;
        //if data for index has been found...
        while (!$batchData->isEmpty()) {
            //batch insert data to index
            Objects::bulkInsert($batchData->toArray(), ['_id' => 'object_id']);
            //increment counter
            $countOfIndexedRecords += $batchData->count();
            self::log('Skip: ' . $skip . '; Total count of indexed records: ' . $countOfIndexedRecords);
            //check max limit of indexed records if it's set
            if ($limit && $countOfIndexedRecords >= $limit) {
                break;
            }
            //change skip index
            $skip += $iterateLimit;
            //set start offset/limit marks and get firs protion of data
            $batchData = $query->skip($skip)->take($iterateLimit)->get();
        }
    }

    /**
     * Log result
     * @param $message
     */
    protected static function log($message)
    {
        if (App::runningInConsole()) {
            print($message . PHP_EOL);
        }
    }
}