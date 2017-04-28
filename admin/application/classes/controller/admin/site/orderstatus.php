<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Orderstatus extends Controller_Admin_Site
{
    /**
     * order status list.
     * @return unknown_type
     */
    public function action_list()
    {
    	$content = View::factory('admin/site/order/status_list')->render();
    	$this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    /**
     * order status json data.
     * @return unknown_type
     */
    public function action_data()
    {
    	//TODO fixed the post
		$page = Arr::get($_REQUEST, 'page', 0); // get the requested page
		$limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
		$sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
		$sord = Arr::get($_REQUEST, 'sord', 0); // get the direction

		//filter
		$filters = Arr::get($_REQUEST, 'filters', array( ));

		if($filters) $filters = json_decode($filters);

		if( ! $sidx) $sidx = 1;

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

		if($totalrows) $limit = $totalrows;

		$filter_sql = "1";
		if($filters)
		{
			$_filter_sql = array();
			foreach( $filters->rules as $item )
			{
				//TODO add filter items
				if ($item->data)
					$_filter_sql[] = $item->field."='".$item->data."'";
			}
			if (!empty($_filter_sql))
				$filter_sql = implode(' AND ', $_filter_sql);
		}

		$result = DB::query(DATABASE::SELECT, 'SELECT COUNT(`order_statuses`.`id`) AS num FROM `order_statuses` WHERE  '
				.$filter_sql)->execute('slave');
		$count = $result[0]['num'];
		$total_pages = 0;
		if($count > 0)
			$total_pages = ceil($count / $limit);

		if($page > $total_pages) $page = $total_pages;
		if($limit < 0) $limit = 0;

		$start = $limit * $page - $limit; // do not put $limit*($page - 1)
		if($start < 0) $start = 0;

		$result = DB::query(DATABASE::SELECT, 'SELECT `order_statuses`.* FROM `order_statuses` WHERE '
				.$filter_sql.' ORDER BY '.$sidx.' '.$sord.' LIMIT '.$limit.' OFFSET '.$start)->execute('slave');

    	$response = array();
		$response['page'] = $page;
		$response['total'] = $total_pages;
		$response['records'] = $count;

		$k = 0;
		foreach($result as $s)
		{
			switch($s['type']){
				case 1:
					$s['_type'] = 'Payment';
					break;
				case 2:
					$s['_type'] = 'Shipment';
					break;
				case 3:
					$s['_type'] = 'Issue';
					break;
				case 4:
				    $s['_type'] = 'Refund';
				    break;
				default:
					$s['_type'] = 'Payment';
					break;
			}
			$response['rows'][$k]['id'] = $s['id'];
			$response['rows'][$k]['cell'] = array(
				$s['id'],
				$s['_type'],
				$s['name'],
				$s['description'],
			);
			$k++;
		}
		echo json_encode($response);
    }

    /**
     * Add or edit order status.
     * @return unknown_type
     */
    public function action_edit()
    {
    	// TODO optimize code.
    	$id = $this->request->param('id');
    	if ($id){
    		$data = Order::instance()->get_orderstatus($id);
    	} else {
    		$data = array();
    	}
    	$errors = array();
    	if ($_POST){
    		// validate post values.
    		$post = Validate::factory($_POST)
    			->filter(TRUE, 'trim')
    			->filter('description', 'trim')
    			->filter('show_onfront', 'trim')
    			->filter('send_email', 'trim')
    			->filter('mailcategory_id', 'trim')
    			->filter('type', 'trim')
    			->rule('name','not_empty');

            if($post->check())
            {
	    		// save post status.
	    		$data['name'] = $post['name'];
    			$data['description'] = $post['description'];

                if ($post['type'])
                {
    				$data['type'] = $post['type'];
    			}

                if (isset($post['show_onfront']))
                {
    				$data['show_onfront'] = 1;
                }
                else
                {
    				$data['show_onfront'] = 0;
    			}

                if(isset($post['send_email']))
                {
    				$data['send_email'] = 1;
                }
                else
                {
    				$data['send_email'] = 0;
    			}

    			$data['mailcategory_id'] = $post['mailcategory_id'];

                if(($id = Order::instance()->save_orderstatus($data)) != FALSE)
                {
    				$data = Order::instance()->get_orderstatus($id);
		    		// TODO show success messages.
		    		// redirect to different urls by different submit button.
		    		$_save = Arr::get($_POST, '_save', '');

		    		if($_save) $_uri = '/admin/site/orderstatus/list';

		    		$_addanother = Arr::get($_POST, '_addanother', '');

		    		if ($_addanother) $_uri = '/admin/site/orderstatus/edit/';

		    		$_continue = Arr::get($_POST, '_continue', '');

		    		if ($_continue) $_uri = '/admin/site/orderstatus/edit/'.$data['id'];

		    		Request::factory($_uri)->redirect($_uri);

                }
                else
                {
    				$errors = array('Save status failed.');
    			}
    		}
    		$errors = $post->errors('orderstatus');
    	}

    	$content = View::factory('admin/site/order/status_edit')->set('data', $data)->set('errors', $errors)->render();
    	$this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

}
