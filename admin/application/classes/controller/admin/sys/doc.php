<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Doc extends Controller_Admin_Site
{
	public function action_list()
	{
		$docs=ORM::factory('doc')
				->where('site_id','=',$this->site_id)
				->find_all();
		$sites=ORM::factory('site')
				->find_all();
		$content = View::factory('admin/site/docs_list')
					->set('docs', $docs)
					->set('sites',$sites)
					->render();
		$this->request->response = View::factory('admin/template')->set('content', $content)->render();
	}	
}
?>