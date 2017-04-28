<?php
/**
*产品后台操作记录,修改产品price，filter_attributes时会记录
*zpz
*20160125
*/
defined('SYSPATH') or die('No direct script access.');

class operlog
{
	public static function add($product_id,$operate,$data,$admin)
	{
        $arr = array(
            'product_id' => $product_id,
            'oper' => $operate,
            'data' => $data,
            'admin' => $admin,
            'create' => time(),

        );
        $result = DB::insert('operlog', array_keys($arr))->values($arr)->execute();
        return $result;

	}
    public static function select($product_id)
    {
        $res = DB::query(Database::SELECT, 'SELECT o.oper oper, o.data data,FROM_UNIXTIME(o.`create`,"%Y年%m月%d日") `create`,u.name
        FROM operlog o LEFT JOIN users u ON o.admin=u.id
        WHERE o.product_id='.$product_id)->execute('slave')->as_array();
        return $res;
    }



}