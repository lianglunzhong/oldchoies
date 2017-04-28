<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Basic extends Controller_Admin_Site
{

    public function action_index()
    {
        if (!$user = User::instance()->logged_in())
        {
            $this->request->redirect('/admin/user/login');
        }
        $site = ORM::factory('site', $this->site_id);
        if (!$site->loaded())
        {
            Message::set('Site doesn\'t exist.', 'error');
            $this->request->redirect('admin/sys/site/404');
        }
        if ($_POST)
        {
            $data['domain'] = Arr::get($_POST, 'domain', '');
            $data['email'] = Arr::get($_POST, 'email', '');
            $data['route_type'] = Arr::get($_POST, 'route_type', '2');
            $data['ssl'] = Arr::get($_POST, 'ssl', '0');
            //$data['product'] = Arr::get($_POST, 'product', 'product');
            //$data['catalog'] = Arr::get($_POST, 'catalog', 'catalog');
            //$data['suffix'] = Arr::get($_POST, 'suffix', '');
            //$data['language'] = Arr::get($_POST, 'lang', 'en');
            $data['per_page'] = Arr::get($_POST, 'per_page', 10);
            $data['forum_moderators'] = Arr::get($_POST, 'forum_moderators', '');
            $data['line_id'] = Arr::get($_POST, 'line', 0);
            $data['ticket_center'] = Arr::get($_POST, 'ticket_center', '');
            $site->values($data);

            if ($site->check())
            {
                $site->save();
                Message::set('Site basic information saved successfully.');
                $this->request->redirect('/admin/site/basic/index');
            }
            else
            {
                Message::set('Please check your input.', 'error');
            }
        }
        $sql = 'select distinct ticket_center from ticket_sites where is_active=1';
        $lines = ORM::factory('line')
            ->find_all()
            ->as_array();

        $content = View::factory('admin/site/basic_index')
            ->set('site', $site)
            ->set('lines', $lines)
            ->render();
        $this->request->response = View::factory('admin/template')
            ->set('content', $content)
            ->render();
    }

    public function action_sns()
    {
        $site = ORM::factory('site', $this->site_id);
        if (!$site->loaded())
        {
            Message::set('Site doesn\'t exist.', 'error');
            $this->request->redirect('admin/sys/site/404');
        }
        if ($_POST)
        {
            $site->fb_login = Arr::get($_POST, 'fb_login', '');
            $site->fb_api_id = Arr::get($_POST, 'fb_api_id', '');
            $site->fb_api_secret = Arr::get($_POST, 'fb_api_secret', '');
            if ($site->check())
            {
                $site->save();
                Message::set('Site Basic SNS saved successfully.');
                $this->request->redirect('/admin/site/basic/sns');
            }
            else
            {
                Message::set('Please check your input.' . kohana::debug($site->validate()->errors()), 'error');
            }
        }
        $content = View::factory('admin/site/basic_sns')->set('site', $site)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_seo()
    {
        $site = ORM::factory('site', $this->site_id);
        if (!$site->loaded())
        {
            Message::set('Site doesn\'t exist.', 'error');
            $this->request->redirect('admin/sys/site/404');
        }
        if ($_POST)
        {
            $site->meta_title = Arr::get($_POST, 'meta_title', '');
            $site->meta_description = Arr::get($_POST, 'meta_description', '');
            $site->meta_keywords = Arr::get($_POST, 'meta_keywords', '');
            $site->robots = Arr::get($_POST, 'robots', '');
            $site->stat_code = Arr::get($_POST, 'stat_code', '');
            if ($site->check())
            {
                $site->save();
                Message::set('Site Basic SEO saved successfully.');
                $this->request->redirect('/admin/site/basic/seo');
            }
            else
            {
                Message::set('Please check your input.' . kohana::debug($site->validate()->errors()), 'error');
            }
        }
        $content = View::factory('admin/site/basic_seo')->set('site', $site)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_payment()
    {
        $site = ORM::factory('site', $this->site_id);
        if (!$site->loaded())
        {
            Message::set('Site doesn\'t exist.', 'error');
            $this->request->redirect('admin/sys/site/404');
        }
        if ($_POST)
        {
            $site->cc_payment_id = Arr::get($_POST, 'cc_payment_id', 0);
            $site->cc_secure_code = Arr::get($_POST, 'cc_secure_code', '');
            $site->cc_payment_url = Arr::get($_POST, 'cc_payment_url', '');
            $site->pp_payment_url = Arr::get($_POST, 'pp_payment_url', '');
            $site->pp_submit_url = Arr::get($_POST, 'pp_submit_url', '');
            $site->pp_sync_url = Arr::get($_POST, 'pp_sync_url', '');
            $site->pp_payment_id = Arr::get($_POST, 'pp_payment_id', '');
            $site->pp_tiny_payment_id = Arr::get($_POST, 'pp_tiny_payment_id', '');
            $site->pp_api_version = Arr::get($_POST, 'pp_api_version', '');
            $site->pp_api_user = Arr::get($_POST, 'pp_api_user', '');
            $site->pp_api_pwd = Arr::get($_POST, 'pp_api_pwd', '');
            $site->pp_api_signa = Arr::get($_POST, 'pp_api_signa', '');
            $site->pp_notify_url = Arr::get($_POST, 'pp_notify_url', '');
            $site->pp_ec_notify_url = Arr::get($_POST, 'pp_ec_notify_url', '');
            $site->pp_return_url = Arr::get($_POST, 'pp_return_url', '');
            $site->pp_ec_return_url = Arr::get($_POST, 'pp_ec_return_url', '');
            $site->pp_cancel_return_url = Arr::get($_POST, 'pp_cancel_return_url', '');
            $site->pp_logo_url = Arr::get($_POST, 'pp_logo_url', '');
//			if($site->check())
//			{
            $site->save();
            Message::set('Site Payment Information saved successfully.');
            $this->request->redirect('/admin/site/basic/payment');
//			}
//			else
//			{
//				Message::set('Please check your input.', 'error');
//			}
        }
        $content = View::factory('admin/site/basic_payment')->set('site', $site)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_currency()
    {
        $sys_currencies = Site::instance()->currencies();

        $site = ORM::factory('site', $this->site_id);

        if (!$site->loaded())
        {
            Message::set('Site doesn\'t exist.', 'error');
            $this->request->redirect('admin/sys/site/404');
        }

        $currencies = $site->currency != '' ? explode(',', $site->currency) : array();

        if ($_POST)
        {
            switch ($_POST['act'])
            {
                case 'add':
                    if (!in_array($_POST['currency_key'], $currencies) AND $_POST['currency_key'] != -1)
                    {
                        $currencies[] = $_POST['currency_key'];
                        $site->currency = implode(',', $currencies);
                        $site->save();
                        message::set('成功添加了货币"' . $_POST['currency_key'] . '"。');
                    }
                    else
                    {
                        message::set('货币"' . $_POST['currency_key'] . '"已在列表中，请勿重复添加。', 'notice');
                    }
                    break;

                case 'remove':
                    $index = array_search($_POST['currency_key'], $currencies);
                    if ($index !== FALSE)
                    {
                        unset($currencies[$index]);
                        $site->currency = implode(',', $currencies);
                        $site->save();
                        message::set('成功删除了货币"' . $_POST['currency_key'] . '"。');
                    }
                    else
                    {
                        message::set('货币"' . $_POST['currency_key'] . '"已被删除，请勿重复操作。', 'notice');
                    }
                    break;

                case 'order':
                    $index = array_search($_POST['currency_key'], $currencies);
                    if ($index !== FALSE)
                    {
                        if ($_POST['moving'] == 'up')
                        {
                            if ($index > 0)
                            {
                                $currencies[$index] = $currencies[$index - 1];
                                $currencies[$index - 1] = $_POST['currency_key'];
                                $site->currency = implode(',', $currencies);
                                $site->save();
                                message::set('成功将货币"' . $_POST['currency_key'] . '"上移。');
                            }
                            else
                            {
                                message::set('货币"' . $_POST['currency_key'] . '"已在最顶端，无法上移。', 'notice');
                            }
                        }
                        elseif ($_POST['moving'] == 'down')
                        {
                            if ($index < count($currencies) - 1)
                            {
                                $currencies[$index] = $currencies[$index + 1];
                                $currencies[$index + 1] = $_POST['currency_key'];
                                $site->currency = implode(',', $currencies);
                                $site->save();
                                message::set('成功将货币"' . $_POST['currency_key'] . '"下移。');
                            }
                            else
                            {
                                message::set('货币"' . $_POST['currency_key'] . '"已在最底端，无法下移。', 'notice');
                            }
                        }
                    }
                    break;
            }
            $this->request->redirect('admin/site/basic/currency');
        }

        $content = View::factory('admin/site/currency')
            ->set('currencies', $currencies)
            ->set('sys_currencies', $sys_currencies)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_currency_ajax_edit($id)
    {
        $data = array();
        if(!$id)
        {
            $data['success'] = 0;
            $data['message'] = 'Currency id not exisit!';
        }
        else
        {
           $uid =  Session::instance()->get('user_id');
           $user = User::instance($uid)->get();
           $log = $user['name'].' '.$user['email'].' update currency';
           $type= 'currencyupdate';


            $rate = Arr::get($_REQUEST, 'rate', 0);
            if($rate)
            {
                $update = DB::update('currencies')->set(array('rate' => $rate))->where('id', '=', $id)->execute();
                if($update)
                {
                    $currencies = DB::select()->from('currencies')->where('id', '=', $id)->execute()->current();
                    //设置汇率缓存
                    $cache_key = 'site_currency1_' . $currencies['name'];
                    Cache::instance('memcache')->set($cache_key, serialize($currencies), 86400);

                    $data['success'] = 1;
                    $data['rate'] = $rate;
                    Kohana_log::instance()->add($type,$log . ': OK');
                }
                else
                {
                    $data['success'] = 0;
                    $data['message'] = 'Edit currency rate failed!';
                }
            }
            else
            {
                $data['success'] = 0;
                $data['message'] = 'Input data cannot be empty!';
            }
        }
        echo json_encode($data);
        exit;
    }

    public function action_memcache_delete()
    {
        if ($_POST)
        {
            $type = Arr::get($_POST, 'type', '');
            if (!$type)
            {
                Message::set('Type cannot be empty', 'notice');
            }
            else
            {
                $cache_key = '';
                if ($type == 'index')
                {
                    $cache_key = 'site_index_choies';
                }
                elseif ($type == 'catalog')
                {
                    $catalog = Arr::get($_POST, 'catalog', '');
                    $catalog = str_replace('/?', '?', $catalog);
                    $urls = parse_url($catalog);
                    if(substr($urls['path'], 0, 1) == '/')
                            $urls['path'] = substr($urls['path'], 1);
                    $gets = array(
                        'page' => 0,
                        'limit' => 0,
                        'sort' => 0,
                        'pick' => 0,
                    );
                    $get = Arr::get($urls, 'query', '');
                    $getsArr = explode('&', $get);
                    foreach($getsArr as $g)
                    {
                        $gs = explode('=', $g);
                        if(count($gs) == 2)
                        {
                            if(array_key_exists($gs[0], $gets))
                            {
                                $gets[$gs[0]] = $gs[1];
                            }
                        }
                    }
                    $cache_key = "catalog_" . $urls['path'] . '_' . implode('_', $gets). "_" . $this->site_id;
                    $cache_key = preg_replace('/[^A-Za-z0-9_\/\-]+/i', '', $cache_key);
                }
                elseif ($type == 'product')
                {
                    $product = Arr::get($_POST, 'product', '');
                    $product = str_replace('/?', '?', $product);
                    $urls = parse_url($product);
                    if(substr($urls['path'], 0, 1) == '/')
                            $urls['path'] = substr($urls['path'], 1);
                    $cache_key = "products_" . $urls['path'] . "_" . $this->site_id;
                    $cache_key = preg_replace('/[^A-Za-z0-9_\/\-]+/i', '', $cache_key);
                }
                if ($cache_key)
                {
                    Cache::instance('memcache')->delete($cache_key);
                    Message::set('Delete memcache success', 'success');
                }
                else
                    Message::set('Delete memcache failed', 'error');
            }
        }
        $content = View::factory('admin/site/basic_memcache')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

}
