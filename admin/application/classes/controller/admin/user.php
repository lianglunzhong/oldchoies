<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_User extends Controller
{

        public function action_edit()
        {
                if (!$user = User::instance()->logged_in())
                {
                        $this->request->redirect('/admin/user/login');
                }
                else
                {
                        if($user['role_id'] > 0)
                        {
                                Message::set('You do not have permission to access','notice');
                                $this->request->redirect('/admin/site/product/list');
                        }
                }
                $id = $this->request->param('id');
                $user = User::instance($id)->get();

                if ($_POST)
                {
                        $id = Arr::get($_POST, 'id', '');
                        $password = Arr::get($_POST, 'password', '');

                        $data['email'] = Arr::get($_POST, 'email', '');
                        $data['name'] = Arr::get($_POST, 'name', '');
                        $data['password'] = toolkit::hash($password);
                        $data['role_id'] = Arr::get($_POST, 'role_id', '');
                        $data['lang'] = Arr::get($_POST, 'lang', '');

                        $user = User::instance()->edit($id, $data);
                        if ($user)
                                message::set('edit user success');
                        else
                                message::set('error', 'error');
                        Request::instance()->redirect('/admin/user/edit');
                }

                $content = View::factory('admin/sys/user_edit')
                        ->set('data', $user)
                        ->render();

                $this->request->response = View::factory('admin/template')->set('content', $content)->render();
        }

        public function action_login()
        {
                if ($_POST)
                {
                        if (empty($_POST['email']) || empty($_POST['password']))
                        {
                                message::set('login', 'Account number and password can not be empty!');
                        }
                        $data = array();
                        $data['email'] = Arr::get($_POST, 'username', '');
                        $data['password'] = Arr::get($_POST, 'password', '');

                        if ($user_id = User::instance()->login($data))
                        {
                                message::set('login success!');
                                $session = Session::instance();
                                $session->set('user_id', $user_id);
                                $session->set('manager_active_time', time()); //用户最后操作时间
                                if (!$redirect = Arr::get($_REQUEST, 'redirect', 0) OR !Toolkit::is_our_url($redirect))
                                {
                                        if (!$redirect = Arr::get($_REQUEST, 'referer', 0) OR !Toolkit::is_our_url($redirect))
                                        {
                                                $redirect = 'admin/site/product/list';
                                        }
                                }
                                Request::instance()->redirect($redirect);
                        }
                        else
                        {
                                message::set('login error,try again', 'error');
                        }
                }

                $content['referer'] = (isset($_SERVER['HTTP_REFERER']) AND toolkit::is_our_url($_SERVER['HTTP_REFERER'])) ?
                        $_SERVER['HTTP_REFERER'] : 0;
                $content['redirect'] = Arr::get($_GET, 'redirect', 0);
                $this->request->response = View::factory('admin/login', $content)->render();
        }

        public function action_password()
        {
                $id = $this->request->param('id');
                $user = User::instance($id)->get();
                if ($_POST)
                {
                        $id = Arr::get($_POST, 'id', '');
                        $password = Arr::get($_POST, 'password', '');
                        if (!empty($password))
                        {
                                $data['password'] = toolkit::hash($password);
                        }
                        $data['name'] = Arr::get($_POST, 'name', '');
                        $data['email'] = Arr::get($_POST, 'email', '');

                        $user = User::instance()->edit($id, $data);
                        if ($user)
                                message::set('edit user success');
                        else
                                message::set('error', 'error');
                        Request::instance()->redirect('/admin/user/password/' . $id);
                }

                $content = View::factory('admin/sys/user_password')
                        ->set('data', $user)
                        ->render();

                $this->request->response = View::factory('admin/template')->set('content', $content)->render();
        }

        public function action_logout()
        {
                Session::instance()->delete('user_id');
                Request::instance()->redirect('/admin/user/login');
        }

}

