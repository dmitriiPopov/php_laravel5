<?php

namespace App;

class Good {

	/**
	 * @param int    $id
	 * @param string $field
	 * @return mixed
	 */
	public static function unit ($id, $field)
	{
		return \DB::table('goods_unit')
			->select([$field.prefix()])
			->where('goods_unit_id', $id)
			->value($field.prefix());
	}

}