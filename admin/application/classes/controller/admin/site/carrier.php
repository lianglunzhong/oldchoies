<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Carrier extends Controller_Admin_Site
{

    //设置站点默认物流
    public function action_default()
    {

        if ($_POST)
        {
            $tam = 0;
            $data = array();
            $data['site_id'] = $this->site_id;
            $data['isocode'] = 0;
            $data['carrier'] = $_POST['carrier'];
            $data['carrier_name'] = $_POST['carrier_name'];
            $interval = $_POST['intervals'];

            //判断价格区间
            if (isset($_POST['price']))
            {
                $price = $_POST['price'];
                if (isset($_POST['prices']))
                {
                    array_unshift($price, $_POST['prices'][0]);
                }
            }
            else
            {
                $price = $_POST['prices'];
            }

            //循环重量区间及价格赋值给数组
            for ($i = 0; $i < count($interval); $i++)
            {
                $type = $tam . '-' . $interval[$i];
                $tam = $interval[$i];
                $arr[$type] = $price[$i];
            }
            $data['interval'] = serialize($arr);
            $data['formula'] = Kohana::config('carrier.' . $data['carrier'] . '.formula');

            //添加数据库
            $carrier = ORM::factory('carrier')->values($data);

            if ($carrier->check())
            {
                $carrier->save();
                message::set('add success');
                Request::instance()->redirect('/admin/site/carrier/default');
            }
            else
            {
                message::set('error' . kohana::debug($carrier->validate()->errors()));
                Request::instance()->redirect('/admin/site/carrier/default');
            }
            exit;
        }
        $carrier = Site::instance()->carriers();
        $carrier_defaults = Kohana::config('carrier');
        $content = View::factory('admin/site/carrier_default')->set('carrier_defaults', $carrier_defaults)->set('data', $carrier)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_united()
    {
        $code = $this->request->param('id');

        if ($_POST)
        {
            $tam = 0;
            $data = array();
            $data['site_id'] = $this->site_id;
            $data['isocode'] = $code;
            $data['carrier'] = $_POST['carrier'];
            $data['carrier_name'] = $_POST['carrier_name'];
            $interval = $_POST['intervals'];

            //判断价格区间
            if (isset($_POST['price']))
            {
                $price = $_POST['price'];
                if (isset($_POST['prices']))
                {
                    array_unshift($price, $_POST['prices'][0]);
                }
            }
            else
            {
                $price = $_POST['prices'];
            }

            //循环重量区间及价格赋值给数组
            for ($i = 0; $i < count($interval); $i++)
            {
                $type = $tam . '-' . $interval[$i];
                $tam = $interval[$i];
                $arr[$type] = $price[$i];
            }
            $data['interval'] = serialize($arr);

            //添加数据库
            $carrier = ORM::factory('carrier')->values($data);
            $is_carrier = ORM::factory('carrier')
                ->where('isocode', '=', $code)
                ->where('site_id', '=', $this->site_id)
                ->where('carrier', '=', $_POST['carrier'])
                ->find();
            if ($is_carrier->loaded())
            {
                message::set('Countries there', 'error');
                Request::instance()->redirect('/admin/site/carrier/united/' . $code);
            }
            else
            {
                if ($carrier->check())
                {
                    $carrier->save();
                    message::set('add success');
                    Request::instance()->redirect('/admin/site/carrier/united/' . $code);
                }
                else
                {
                    message::set('error' . kohana::debug($carrier->validate()->errors()));
                    Request::instance()->redirect('/admin/site/carrier/united/' . $code);
                }
            }
            exit;
        }
        $country = ORM::factory('country')
            ->where('site_id', '=', $this->site_id)
            ->where('isocode', '=', $code)
            ->find()
            ->as_array();


        $carrier = Site::instance()->carriers($code);
        $carrier_defaults = Kohana::config('carrier');
        $content = View::factory('admin/site/carrier_default')->set('carrier_defaults', $carrier_defaults)->set('data', $carrier)->set('country', $country)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_delete()
    {
        $id = $this->request->param('id');
        $carrier = ORM::factory('carrier', $id);
        if ($carrier->loaded())
        {
            message::set('delete success');
            $carrier->delete();
        }
        else
            message::set('error', 'error');

        Request::instance()->redirect('/admin/site/carrier/default');
    }

}

?>
