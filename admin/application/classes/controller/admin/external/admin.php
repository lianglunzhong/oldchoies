<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_External_Admin extends Controller
{

	public function action_login()
	{
		if($_POST)
		{
			if($_POST['username'] == 'cofreeadmin' && $_POST['password'] == 'cofree2011')
			{
				Session::instance()->set('is_login', 1);
				$this->request->redirect('/external/usa/index');
			}
		}

		$this->request->response = View::factory('/admin/external/login')->render();
	}

	public function action_logout()
	{
		Session::instance()->delete('is_login');
		$this->request->redirect('/external/admin/login');
	}

}