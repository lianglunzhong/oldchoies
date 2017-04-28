<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Sys_Task extends Controller_Admin_Site {
 
    public function action_task_list()
    {
	$task = Kohana::config('task');

	$role = Acl::instance()->role_find();

	$content = View::factory('admin/sys/task_lists')
			->set('task_key', $task['task_key'])
			->set('field_key', $task['field_key'])
			->set('role',$role)
			->render();

	$this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_addrolle()
    {
	$data['role_id'] = $_POST['role_id'];
	$data['role_task']['add'] = $_POST['add'];
	$data['role_task']['edit'] = $_POST['edit'];
	$data['role_task']['delete'] = $_POST['delete'];
	$data['role_task']['list'] = $_POST['list'];
	if (Acl::instance()->set_role_task($data))
	{
	    message::set('add role success');
	    Request::instance()->redirect('admin/sys/task/task_list');
	}
	else
	{
	    message::set('error');
	    Request::instance()->redirect('admin/sys/task/task_list');
	}
    }

    public function action_list()
    {
	$count = ORM::factory('task')->count_all();

	$pagination = Pagination::factory(
			array(
			    'current_page' => array('source' => 'query_string', 'key' => 'page'),
			    'total_items' => $count,
			    'items_per_page' => 50,
			    'view' => 'pagination/basic',
			    'auto_hide' => 'FALSE',
			)
	);

	$page_view = $pagination->render();

	$data = ORM::factory('task')
			->limit($pagination->items_per_page)
			->offset($pagination->offset)
			->find_all();

	$content = View::factory('admin/sys/task_list')
			->set('data', $data)
			->set('count', $count)
			->set('page_view', $page_view)
			->render();

	$this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_delete()
    {
	$id = $this->request->param('id');
	$line = ORM::factory('customer', $id)->delete();
	message::set('删除客户成功！');
	Request::instance()->redirect('/adminsite/customer/list');
    }

    public function action_edit()
    {
	$id = $this->request->param('id');

	$customer = ORM::factory('customer')
			->where('id', '=', $id)
			->where('site_id', '=', $this->site_id)
			->find();
	if ( ! $customer->loaded())
	{
	    message::set('客户不存在或者已经被删除');
	    Request::instance()->redirect('admin/site/customer/list');
	}
	else
	{
	    if ($_POST)
	    {
		$customer = ORM::factory('customer', $id);
		// TODO validate post values.
		$post = Validate::factory($_POST)
				->filter(TRUE, 'trim')
				->filter('firstname', 'trim')
				->filter('lastname', 'trim')
				->filter('birthday', 'strtotime')
				->filter('country', 'trim');
		if ($post->check())
		{
		    $customer->values($post);
		    if ($customer->save())
		    {
			message::set('客户修改成功');
			Request::instance()->redirect('/admin/site/customer/list/');
		    }
		    else
		    {
			message::set('Update customer information failed.');
		    }
		}
		else
		{
		    message::set(implode(',', $post->errors()));
		}
	    }
	    $countries = ORM::factory('country')->where('site_id', '=', $this->site_id)->find_all();
	    $orders = ORM::factory('order')
			    ->where('site_id', '=', $this->site_id)
			    ->where('customer_id', '=', $id)
			    ->find_all();
	    $content = View::factory('admin/site/customer_edit')
			    ->set('id', $id)
			    ->set('data', $customer->as_array())
			    ->set('countries', $countries)
			    ->set('orders', $orders)
			    ->render();

	    $this->request->response = View::factory('admin/template')->set('content', $content)->render();
	}
    }

    public function action_add()
    {
	if ($_POST)
	{
	    $customer = ORM::factory('customer');
	    $customer->email = $_POST['email'];
	    $customer->firstname = $_POST['firstname'];
	    $customer->lastname = $_POST['lastname'];
	    $customer->password = $_POST['password'];
	    $customer->country = $_POST['country'];
	    $customer->created = time();
	    $customer->save();
	    message::set('客户添加成功！');
	    Request::instance()->redirect('/admin/site/customer/list');
	}
	else
	{
	    $countries = ORM::factory('country')->where('site_id', '=', $this->site_id)->find_all();
	    $view = View::factory('admin/site/customer_add')->set('countries', $countries);
	    $this->request->response = View::factory('admin/template')->set('content', $view)->render();
	}
    }

    public function action_select()
    {
	$count = ORM::factory('customer')
			->where('site_id', '=', $this->site_id)
			->where('firstname', 'like', '%'.$_POST['firstname'].'%')
			->where('lastname', 'like', '%'.$_POST['lastname'].'%')
			->count_all();

	$pagination = Pagination::factory(
			array(
			    'current_page' => array('source' => 'query_string', 'key' => 'page'),
			    'total_items' => $count,
			    'items_per_page' => 50,
			    'view' => 'pagination/basic',
			    'auto_hide' => 'FALSE',
			)
	);

	$page_view = $pagination->render();

	$data = ORM::factory('customer')
			->where('site_id', '=', $this->site_id)
			->where('firstname', 'like', '%'.$_POST['firstname'].'%')
			->where('lastname', 'like', '%'.$_POST['lastname'].'%')
			->order_by("id", "asc")
			->limit($pagination->items_per_page)
			->offset($pagination->offset)
			->find_all();

	$content = View::factory('admin/site/customer_list')
			->set('data', $data)
			->set('count', $count)
			->set('page_view', $page_view)
			->render();

	$this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_data()
    {
	//TODO fixed the post
	$page = Arr::get($_REQUEST, 'page', 0); // get the requested page
	$limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
	$sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
	$sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
	//filter
	$filters = Arr::get($_REQUEST, 'filters', array());

	if ($filters)
	{
	    $filters = json_decode($filters);
	}

	if ( ! $sidx)
	    $sidx = 1;

	$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

	if ($totalrows)
	    $limit = $totalrows;

	$filter_sql = "";
	if ($filters)
	{
	    foreach ($filters->rules as $item)
	    {
		//TODO add filter items
		// TODO optimize name filter.
		if ($item->field == 'firstname')
		    $filter_sql .= " AND CONCAT(firstname, ' ', lastname) LIKE '%".$item->data."%'";
		else
		    $filter_sql .= " AND ".$item->field."='".$item->data."'";
	    }
	}

	$result = DB::query(DATABASE::SELECT, 'SELECT COUNT(`customers`.`id`) AS num FROM `customers` WHERE `customers`.site_id='.$this->site_id.' '
			.$filter_sql)->execute();
	$count = $result[0]['num'];
	$total_pages = 0;
	if ($count > 0)
	{
	    $total_pages = ceil($count / $limit);
	}

	if ($page > $total_pages)
	    $page = $total_pages;
	if ($limit < 0)
	    $limit = 0;

	$start = $limit * $page - $limit; // do not put $limit*($page - 1)
	if ($start < 0)
	    $start = 0;

	$result = DB::query(DATABASE::SELECT, 'SELECT `customers`.* FROM `customers` WHERE `customers`.site_id='.$this->site_id.' '
			.$filter_sql.' ORDER BY '.$sidx.' '.$sord.' LIMIT '.$limit.' OFFSET '.$start)->execute();
	$responce = array();
	$responce['page'] = $page;
	$responce['total'] = $total_pages;
	$responce['records'] = $count;

	$k = 0;
	foreach ($result as $customer)
	{
	    $responce['rows'][$k]['id'] = $customer['id'];
	    $responce['rows'][$k]['cell'] = array(
		$customer['id'],
		$customer['email'],
		$customer['firstname'].' '.$customer['lastname'],
		date('Y-m-d', $customer['created']),
	    );
	    $k ++;
	}
	echo json_encode($responce);
    }

}

