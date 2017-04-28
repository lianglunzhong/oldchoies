<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Report extends Controller_Admin_Site
{
	public function action_list()
	{
		$items_per_page = kohana::config('default.items_per_page');

		$count = ORM::factory('attribute')
			->where('is_active','=', 1)
			->count_all();

		$pagination = Pagination::factory(
			array(
			'current_page' => array( 'source' => 'query_string' , 'key' => 'page'),
			'total_items' => $count,
			'items_per_page' => $items_per_page,
			'view' => 'pagination/basic',
			'auto_hide' => 'FALSE',
			)
		);
		$page_view = $pagination->render();

		$data = ORM::factory('attribute')
			->where('site_id','=',$this->site_id)
			->where('is_active','=',1)
			->limit($pagination->items_per_page)
			->offset($pagination->offset)
			->find_all();

		$content = View::factory('admin/site/attribute_list')
			->set('data',$data)
			->set('count',$count)
			->set('page_view',$page_view)->render();

		$this->request->response = View::factory('admin/template')->set('content',$content)->render();
	}
} 
