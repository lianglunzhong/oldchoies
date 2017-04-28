<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Ptype extends Controller_Admin_Site
{

	public function action_list()
	{
		$items_per_page = kohana::config('default.items_per_page');
		$count = ORM::factory('ptype')
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
		$data = ORM::factory('ptype')
			->where('site_id','=',$this->site_id)
			->find_all($pagination->items_per_page,$pagination->offset);

		$content = View::factory('admin/site/ptype_list')
			->set('data',$data)
			->set('page_view',$page_view)->render();

		$this->request->response = View::factory('admin/template')->set('content',$content)->render();
	}

	public function action_add()
	{
		if($_POST)
		{
			$items = array();
			$data['name'] = $_POST['name'];
			$data['site_id'] = $this->site_id;
			$data['brief'] = $_POST['brief'];

			//获取属性、规格、参数
			$data = array_merge($data, $this->get_post_serialized());

			$ptype = ORM::factory('ptype')->values($data);

			if($ptype->check())
			{
				$ptype->save();
				message::set('添加商品类型成功。');
				Request::instance()->redirect('admin/site/ptype/list');
			}
			else
			{
				message::set('添加商品类型出错，请重试:'.kohana::debug($ptype->validate()->errors()));
				Request::instance()->redirect('/admin/site/ptype/add');
			}
		}

		$attributes = ORM::factory('attribute')
			->where('site_id' , '=' , $this->site_id)
			->where('is_active' , '=' , 1)
			->find_all();

		$content = View::factory('admin/site/ptype_add')
			->set('attributes',$attributes)
			->render();

		$this->request->response = View::factory('admin/template')->set('content',$content)->render();
	}

	public function action_edit()
	{
		$id = $this->request->param('id');
		$ptype = ORM::factory('ptype')
			->where('site_id', '=', $this->site_id)
			->where('id','=',$id)
			->find();

		if(!$ptype->loaded())
		{
			message::set('商品类型不存在');
			Request::instance()->redirect('/admin/site/ptype/list');
		}

		if($_POST)
		{
			$items = array();
			$data['name'] = $_POST['name'];
			$data['brief'] = $_POST['brief'];

			//获取属性、规格、参数
			$data = array_merge($data, $this->get_post_serialized());

			$ptype->values($data);
			if($ptype->check())
			{
				$ptype->save();
				message::set('修改商品类型成功。');
				Request::instance()->redirect('/admin/site/ptype/list');
			}
			else
			{
				message::set('修改商品类型出错，请重试:'.kohana::debug($ptype->validate()->errors()));
				Request::instance()->redirect('/admin/site/ptype/edit/'.$id);
			}
		}

		$data = $ptype->as_array();

		$attributes = ORM::factory('attribute')
			->where('site_id' , '=' , $this->site_id)
			->where('is_active' , '=' , 1)
			->find_all();
		$content = View::factory('admin/site/ptype_edit')->set('data',$data)->set('attributes',$attributes)->render();
		$this->request->response = View::factory('admin/template')->set('content',$content)->render();
	}

	private function get_post_serialized()
	{
		$data = array();

		// get properties
		$properties = array();
		if(isset($_POST['property']))
		{
			foreach($_POST['property']['name'] as $key => $item)
			{
				if($item != '')
				{
					$properties[] = array(
						'name'=>$item,
						'type'=>$_POST['property']['type'][$key],
						'items'=>$_POST['property']['items'][$key],
						'view'=>$_POST['property']['view'][$key],
					);
				}
			}
		}
		$data['properties'] = serialize($properties);

		// get attributes
		$attributes = array();
		if(isset($_POST['attribute']))
		{
			foreach($_POST['attribute'] as $key => $item)
			{
				if($item == '1')
				{
					$attribute = ORM::factory('attribute')
						->where('id','=',$key)
						->where('is_active','=',1)
						->find();
					if($attribute->loaded())
					{
						$attributes[$key] = array(
							'name' => $attribute->name,
							'type' => $attribute->type,
							'view' => $attribute->view,
							'items' => unserialize($attribute->items)
						);
					}
				}
			}
		}
		$data['attributes'] = serialize($attributes);

		// get parameters
		$parameters = array();
		if(isset ($_POST['param_group']))
		{
			foreach($_POST['param_group'] as $item)
			{
				$parameters[] = array(
					'name' => $item['name'],
					'items' => $item['param'],
				);
			}
		}
		$data['parameters'] = serialize($parameters);

		return $data;
	}

	public function action_delete()
	{
		$id = $this->request->param('id');
		$ptype = ORM::factory('ptype',$id)->delete();
		message::set('删除商品类型成功。');
		Request::instance()->redirect('/admin/site/ptype/list');
	}
} 
