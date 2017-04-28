<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Ticket_Blacklist extends Controller_Admin_Ticket
{
	public function action_list()
	{
		 $this->request->response = View::factory('admin/template')
		 		->set('content',View::factory('admin/ticket/blacklist_list')->render())
		 		->render();
	}
	
	public function action_update()
	{
		if($_POST)
		{
			Ticket::instance()->blacklist_update($_POST);
		}
		$this->request->redirect("admin/ticket/blacklist/list");
	}
	
	public function action_delete()
	{
		$id = $this->request->param('id');
		ORM::factory("ticket_blacklist")->delete($id);
		Message::set("Delete this mail domain successfully");
		$this->request->redirect("admin/ticket/blacklist/list");
	}
	
	public function action_data()
	{
		$page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array( ));

        if($filters)
        {
            $filters = json_decode($filters);
        }

        if(!$sidx) $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if($totalrows) $limit = $totalrows;

        $filter_sql = "";

        if($filters)
        {
            foreach( $filters->rules as $item )
            {
                $filter_sql .= " AND ".$item->field."='".$item->data."'";
            }
        }

        $result = DB::query(DATABASE::SELECT, 'SELECT COUNT(`ticket_blacklists`.`id`) AS num FROM `ticket_blacklists` WHERE 1=1'.$filter_sql)->execute();

        $count = $result[0]['num'];
        $total_pages = 0;

        if($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if($page > $total_pages) $page = $total_pages;
        if($limit < 0) $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if($start < 0) $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT `ticket_blacklists`.* FROM `ticket_blacklists` WHERE 1=1'
            .$filter_sql.' ORDER BY is_active DESC,'.$sidx.' '.$sord.' LIMIT '.$limit.' OFFSET '.$start)
            ->execute();
        $lines=ticket::instance()->get_ticket_line_name();
        $response = array( );
        $response['page'] = $page;
		$response['total'] = $total_pages;
		$response['records'] = $count;
		$line=array();
		foreach ($lines as $value)
			$line[$value['id']]=$value['name'];
        foreach( $result as $value )
        {
          	$response['rows'][] = array(
				'id' => $value['id'],
				'cell' => array(
          			$value['id'],
          			$value['domain'],
          			$value['is_active']=='1'?'Yes':'No'
          					)
          	);
        }
        echo json_encode($response);
	}
}
