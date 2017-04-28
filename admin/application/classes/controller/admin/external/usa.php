<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_External_Usa extends Controller
{

	public $_site = '';
	public $_active = array( );

	public function before()
	{
		if(Session::instance()->get('is_login') != 1)
		{
			$this->request->redirect('/external/admin/login');
		}
		$this->_site = Session::instance()->get('site') ? Session::instance()->get('site') : 'geartaker';
		switch( $this->_site )
		{
			case 'geartaker':
				$this->_active = array(
					'geartaker' => 'active',
					'glassesshop' => '',
					'boncyboutique' => '',
				);
				break;
			case 'glassesshop':
				$this->_active = array(
					'geartaker' => '',
					'glassesshop' => 'active',
					'boncyboutique' => '',
				);
				break;
			case 'boncyboutique':
				$this->_active = array(
					'geartaker' => '',
					'glassesshop' => '',
					'boncyboutique' => 'active',
				);
				break;
			default :
				$this->_active = array(
					'geartaker' => 'active',
					'glassesshop' => '',
					'boncyboutique' => '',
				);
				break;
		}
	}

	public function action_index()
	{
		set_time_limit(0);
		$orders = External::instance($this->_site)->orders();
		$this->request->response = View::factory('/admin/external/index')
				->set('orders', $orders)
				->set('active', $this->_active)
				->set('site', $this->_site)
				->render();
	}

	public function action_detail()
	{
		$ordernum = $this->request->param('id');
		$order = External::instance($this->_site)->detail($ordernum);
		$this->request->response = View::factory('/admin/external/detail')
				->set('order', $order)
				->set('active', $this->_active)
				->render();
	}

	public function action_change()
	{
		$site = $this->request->param('id');
		Session::instance()->set('site', $site);
		$this->request->redirect('/external/usa/index');
	}

}
