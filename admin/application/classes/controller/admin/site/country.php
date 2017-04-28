<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Country extends Controller_Admin_Site
{

    public function action_list()
    {
        $count = ORM::factory('country')
            ->where('is_active', '=', 1)
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

        $data = ORM::factory('country')
            ->where('site_id', '=', $this->site_id)
            ->where('is_active', '=', 1)
            ->order_by("position", "desc")
            ->limit($pagination->items_per_page)
            ->offset($pagination->offset)
            ->find_all();

        $content = View::factory('admin/site/country_list')
            ->set('data', $data)
            ->set('count', $count)
            ->set('page_view', $page_view)
            ->render();

        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_edit()
    {
        $id = $this->request->param('id');

        $country = ORM::factory('country')
            ->where('site_id', '=', $this->site_id)
            ->where('id', '=', $id)
            ->find();

        if (!$country->loaded())
        {
            message::set('不存在此国家');
            Request::instance()->redirect('/admin/site/country/list');
        }

        if ($_POST)
        {
            $country->values($_POST);

            if ($country->check())
            {
                $country->save();
                Request::instance()->redirect('/admin/site/country/list');
            }
        }

        $content = View::factory('admin/site/country_edit')
            ->set('data', $country)
            ->render();

        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_active()
    {
        $id = $this->request->param('id');
        $site = ORM::factory('country')
            ->where('id', '=', $id)
            ->find();

        if ($site->loaded())
        {
            if ($site->is_active)
            {
                $site->is_active = 0;
            }
            else
            {
                $site->is_active = 1;
            }
            $site->save();
            message::set('删除国家成功');
            Request::instance()->redirect('/admin/site/country/list');
        }
        else
        {
            message::set('不存在此国家，删除失败' . kohana::debug($site->validate()->errors()));
            Request::instance()->redirect('/admin/site/country/list');
        }
    }

    public function action_deleteall()
    {
        if ($_POST)
        {
            if (count($_POST['id']) > 0)
            {
                $delids = '(' . implode(',', $_POST['id']) . ')';
                DB::query(Database::UPDATE, 'UPDATE `countries` SET `is_active` = 0 WHERE `id` IN ' . $delids)->execute(); /*
                  $line = ORM::factory('line');
                  $line->is_active = 0;
                  $line->where('id' , 'in' , $delids)->save_all(); */
                message::set('success');
                Request::instance()->redirect('/admin/site/country/list');
            }
        }
    }

    public function action_removeup()
    {
        $id = $this->request->param('id');
        $country = ORM::factory('country')
            ->where('id', '=', $id)
            ->where('site_id', '=', $this->site_id)
//				->where('is_active', '=', 1)
            ->find();
        if ($country->loaded())
        {
            $position = $country->position;
            $country_last = ORM::factory('country')
                ->where('site_id', '=', $this->site_id)
//					->where('is_active', '=', 1)
                ->where('position', '>', $country->position)
                ->order_by('position', 'asc')
                ->limit(1)
                ->find();
            if ($country_last->loaded())
            {
                $position_last = $country_last->position;
                $country_last->position = $position;
                $country->position = $position_last;
                $country_last->save();
                $country->save();
                message::set('移动成功');
                Request::instance()->redirect('/admin/site/country/list');
            }
            else
            {
                message::set('国家已经排在第一位');
                Request::instance()->redirect('/admin/site/country/list');
            }
        }
        else
        {
            message::set('不存在此国家' . kohana::debug($site->validate()->errors()));
            Request::instance()->redirect('/admin/site/country/list');
        }
    }

    public function action_removedown()
    {
        $id = $this->request->param('id');

        $country = ORM::factory('country')
            ->where('id', '=', $id)
            ->where('site_id', '=', $this->site_id)
//				->where('is_active', '=', 1)
            ->find();

        if ($country->loaded())
        {
            $position = $country->position;
            $country_next = ORM::factory('country')
                ->where('site_id', '=', $this->site_id)
//					->where('is_active', '=', 1)
                ->where('position', '<', $country->position)
                ->order_by('position', 'desc')
                ->limit(1)
                ->find();

            if ($country_next->loaded())
            {
                $position_next = $country_next->position;
                $country_next->position = $position;
                $country->position = $position_next;
                $country_next->save();
                $country->save();
                message::set('移动成功');
                Request::instance()->redirect('admin/site/country/list');
            }
            else
            {
                message::set('国家已经是最后一位');
                Request::instance()->redirect('admin/site/country/list');
            }
        }
        else
        {
            message::set('不存在此国家' . kohana::debug($site->validate()->errors()));
            Request::instance()->redirect('/admin/site/country/list');
        }
    }

    public function action_carrier()
    {
        $carrier = Kohana::config('carrier');

        if ($_POST)
        {
            $r = ORM::factory('carrier')
                ->where('site_id', '=', $this->site_id)
                ->where('isocode', '=', '0')
                ->find();
            if (!$r->loaded())
            {
                $data = array(
                    'site_id' => $this->site_id,
                    'isocode' => 0,
//					'carrier_name' => $carrier[$_POST['carrier_id']]['name'],
                    'weight' => $_POST['price'],
                );

                $r->values($data);
                if ($r->check())
                {
                    $r->save();
                }
            }
        }

        //查看物流没有与国家关联的默认运费
        $ca = ORM::factory('carrier')
            ->where('site_id', '=', $this->site_id)
            ->where('isocode', '=', '0')
            ->find_all();

        $shipping_price = '';

        foreach ($ca as $key => $value)
        {
//			$shipping_price[$value->carrier_id] = $value->weight;
        }

        $data = View::factory('admin/site/carrier_list')
            ->set('carrier', $carrier)
            ->set('shipping_price', $shipping_price)
            ->render();

        $this->request->response = View::factory('admin/template')->set('content', $data)->render();
    }

    public function action_carrieredit()
    {
        $carrier_all = Kohana::config('carrier');

        if ($_POST['shipping_price'])
        {
            foreach ($_POST['shipping_price'] as $key => $value)
            {
                $carrier = ORM::factory('carrier')
                    ->where('site_id', '=', $this->site_id)
                    ->where('isocode', '=', 0)
                    ->where('carrier_id', '=', $_POST['carrier_id'][$key])
                    ->find();
                if (!isset($value) || $value == '')
                {
                    $active = 0;
                }
                else
                {
                    $active = 1;
                }
                if (!$carrier->loaded())
                {
                    $data = array(
                        'site_id' => $this->site_id,
                        'isocode' => 0,
                        'carrier_id' => $_POST['carrier_id'][$key],
                        'carrier_name' => $carrier_all[$_POST['carrier_id'][$key]]['name'],
                        'weight' => $value,
                        'is_active' => $active,
                    );
                }
                else
                {
                    $data = array(
                        'weight' => $value,
                        'is_active' => $active,
                    );
                }

                $carrier->values($data);

                if ($carrier->check())
                {
                    $carrier->save();
                }
            }

            Request::instance()->redirect('/admin/site/country/carrier');
        }
    }

    public function action_carrierdel()
    {
        $carrier_id = $this->request->param('id');

        $carrier = ORM::factory('carrier')
            ->where('site_id', '=', $this->site_id)
            ->where('isocode', '=', 0)
            ->where('carrier_id', '=', $carrier_id)
            ->find();

        if ($carrier->loaded())
        {
            $carrier->delete();
            Request::instance()->redirect('/admin/site/country/carrier');
        }
    }

    public function action_change()
    {
        $ids = $this->request->param('id');
        $id = explode("&", $ids);
        $current_id = $id[0];
        $new_position = $id[1];

        $max_position = ORM::factory('country')
            ->where('site_id', '=', $this->site_id)
            ->order_by("position", "desc")
            ->find();

        if ($new_position > $max_position->position || $new_position < 0)
        {
            message::set('请选择0~' . $max_position->position . '之前的数字');
            Request::instance()->redirect('admin/site/country/list');
        }

        $country = ORM::factory('country')
            ->where('site_id', '=', $this->site_id)
            ->where('id', '=', $current_id)
            ->find();
        if ($country->loaded())
        {
            if ($country->position > $new_position)
            {
                DB::query(Database::UPDATE, 'UPDATE `countries` SET `position`=`position`+1 WHERE `site_id` = ' . $this->site_id . ' AND `position`>=' . $new_position . ' AND `position`<' . $country->position)->execute();
            }

            if ($country->position < $new_position)
            {
                DB::query(Database::UPDATE, 'UPDATE `countries` SET `position`=`position`-1 WHERE `site_id` = ' . $this->site_id . ' AND `position`>' . $country->position . ' AND `position`<=' . $new_position)->execute();
            }
            DB::query(Database::UPDATE, 'UPDATE `countries` SET `position`=' . $new_position . ' WHERE `site_id` =' . $this->site_id . ' AND `id`=' . $current_id)->execute();
            message::set('移动成功');
            Request::instance()->redirect('admin/site/country/list');
        }
    }

    public function action_data()
    {
        $page = $_REQUEST['page']; // get the requested page
        $limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
        $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
        $sord = $_REQUEST['sord']; // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        $filter_sql = "";

        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                $filter_sql .= " AND " . $item->field . "='" . $item->data . "'";
            }
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM countries WHERE site_id=' . $this->site_id . ' ' . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM countries WHERE site_id=' . $this->site_id . ' ' .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        foreach ($result as $country)
        {
            $response['rows'][$i]['id'] = $country['id'];
            $response['rows'][$i]['cell'] = array(
                $country['id'],
                $country['name'],
                $country['isocode'],
                $country['position'],
                $country['brief'],
                $country['is_active'],
            );
            $i++;
        }
        echo json_encode($response);
    }

}
