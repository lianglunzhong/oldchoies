<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site extends Controller
{
    public $site_id;
    public $currency;

    public function before()
    {
        $user = User::instance()->logged_in();

        if ($user)
        {
            $this->site_id = Session::instance()->get('SITE_ID', 0);
            if ($this->site_id)
            {
                //get default currency
                $site = ORM::factory('site', $this->site_id);
                $site->currency = explode(',', $site->currency);
                $site = Site::instance(0,$site->domain);
                if ( ! $site->get('id'))
                {
                    Message::set(__('need_choose_site'));
                    $this->request->redirect('/admin/sys/site/list');
                }
            }
            elseif ($this->request->directory != 'admin/sys' OR $this->request->controller != 'site' OR !in_array($this->request->action,array('list','go','data')))
            {
                Session::instance()->set('SITE_ID', 1);
                Message::set(__('need_choose_site'));
                $this->request->redirect('/admin/sys/site/list?redirect='.$this->request->uri);
            }
        }
        elseif ($this->request->action != 'login')
        {
            if($this->request->uri != 'admin/site/image/thumbnails1')
                $this->request->redirect('/admin/user/login?redirect='.$this->request->uri);
        }

        /* ACL disabled
        if ($user['id'] != 1) {
            //get action key
            $uri = $this->request->uri();
            $data = explode('/',$uri);
            if (count($data) > 3)
            {
                $key = implode('/',array_slice($data,0,4));
            }
            else
            {
                $key = $uri; 
            }

            // task check
            $role = ORM::factory('role',$user['role_id']);
            $tasks = $role->tasks();
            if(!isset($tasks[$key]) OR !$tasks[$key])
            {
                $this->request->redirect('admin/sys/site/404');
            }

            // line check
            do {
                // anti redirect loop
                if ($key == 'admin/sys/site/404')
                    break;

                $site_id = Session::instance()->get('SITE_ID', 0);
                if (!$site_id) 
                    break;
                $site_line = Site::instance($site_id)->get('line_id');
                if (!$site_line)
                    break;
                $lines = $role->lines();
                if (empty($lines)) 
                {
                    // lines not set means have permission of all lines
                    break;
                }

                if (!in_array($site_line, $lines))
                {
                    $this->request->redirect('admin/sys/site/404');
                }
            } while (0);
        }
         */
    }
}
