<?php

namespace App\Http\Controllers;

use App\models\Index\Goods;
use App\models\Index\Objects;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    /**
     * @var int
     */
    const PER_PAGE = 50;


    public function index(Request $request)
    {
        $page  = (int) abs($request->get('start', 1)) ?: 1;
        $query = trim(clean($request->get('search')));

        $result = [];
        if ( ! empty($query)) {

            $result['goods'] = Goods::search([
                'query' => [
                    'query_string' => [
                        'query'  => sprintf('%s*', $query),
                        //find in selected fields
                        'fields' => [
                            'goods_name',
                            'goods_cod',
                            'goods_description',
                            'goods_description2',
                            'goods_title',
                            'goods_keywords',
                            'goods_cod_name',
                            'model_name',
                        ],
                    ],
                ],
                'min_score' => 1,//only relevance results with score more than `1`
                'from' => ($page <= 1) ? 0 : (self::PER_PAGE * ($page-1)),//offset
                'size' => self::PER_PAGE,//limit
                'sort' => [
                    '_score'     => ['order' => 'desc'],//sorting (relevance)
                    'goods_sort' => ['order' => 'desc']//sorting
                ],
            ]);


            $result['objects'] = Objects::search([
                'query' => [
                    'query_string' => [
                        'query'  => sprintf('%s*', $query),
                        //find in selected fields
                        'fields' => [
                            'object_name_name',
                            'object_name_description',
                            'object_name_description2',
                            'object_name_title',
                            'object_name_keywords',
                            'object_name_page_description',
                        ],
                    ]
                ],
                'from' => ($page <= 1) ? 0 : (self::PER_PAGE * ($page-1)),//offset
                'size' => self::PER_PAGE,//limit
                'sort' => [
                    '_score' => ['order' => 'desc']//sorting (relevance)
                ],
            ]);

            dump($result);
        }

        return view('search');
    }
}
