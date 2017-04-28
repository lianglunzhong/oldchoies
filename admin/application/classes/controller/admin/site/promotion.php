<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Promotion extends Controller_Admin_Site
{

    public function action_list()
    {
        $count = ORM::factory('promotion')
            ->where('is_active', '=', '1')
            ->count_all();

        $pagination = Pagination::factory(
                array(
                    'current_page' => array('source' => 'query_string', 'key' => 'page'),
                    'total_items' => $count,
                    'item_per_page' => 40,
                    'view' => 'pagination/basic',
                    'auto_hide' => 'FALSE',
                )
        );
        $page_view = $pagination->render();

        $data = ORM::factory('promotion')
            ->where('site_id', '=', $this->site_id)
            ->where('is_active', '=', 1)
            ->find_all($pagination->items_per_page, $pagination->offset);

        $content = View::factory('admin/site/promotion_list')
                ->set('data', $data)
                ->set('page_view', $page_view)->render();

        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_add()
    {
        $promotion = ORM::factory('promotion');

        if ($_POST)
        {
            $data = $_POST;
            $data['site_id'] = $this->site_id;
            $data['admin'] = Session::instance()->get('user_id');
            $promotion_id = Promotion::instance()->set($data);
            if (is_int($promotion_id))
            {
                // set memcache --- sjm 2015-12-14
                $cache = Cache::instance('memcache');
                $cache_key = 'promotions_product';
                $promotions = DB::select('id', 'filter', 'from_date', 'to_date')
                    ->from('promotions')
                    ->and_where('is_active', '=', 1)
                    ->and_where('from_date', '<=', time())
                    ->and_where('to_date', '>=', time())
                    ->order_by('from_date', 'desc')
                    ->execute()
                    ->as_array();
                $cache->set($cache_key, $promotions, 30 * 86400);

                Message::set(__('添加促销成功！'));
                Request::instance()->redirect('admin/site/promotion/edit/' . $promotion_id);
            }
            else
            {
                Message::set(__($promotion_id), 'error');
                Request::instance()->redirect('admin/site/promotion/add');
            }
        }

        //TODO get original catalog
        $content_data['sets'] = ORM::factory('set')->where('site_id', '=', $this->site_id)->find_all();
        $content_data['attributes'] = ORM::factory('attribute')
            ->where('site_id', '=', $this->site_id)
            ->and_where('scope', '!=', 2)
            ->and_where('type', 'in', DB::expr("('0','1')"))
            ->and_where('promo', '=', 1)
            ->find_all();

        $name_template = '<input type="checkbox" id="catalog_check_{id}" name="condition[catalogs][]" value="{id}"/><label for="catalog_check_{id}">{name}</label>';
        $content_data['catalog_checkboxes_tree'] = Controller_Admin_Site_Catalog::get_left_tree($this->site_id, $name_template);

        $content = View::factory('admin/site/promotion_add', $content_data)->render();

        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_edit()
    {
        $id = $this->request->param('id');
        $promotion = ORM::factory('promotion')
            ->where('site_id', '=', $this->site_id)
            ->where('id', '=', $id)
            ->find();

        if (!$promotion->loaded())
        {
            message::set('产品促销不存在');
            Request::instance()->redirect('/admin/site/promotion/list');
        }

        if ($_POST)
        {
            $data = $_POST;
            $data['site_id'] = $this->site_id;
            $promotion_id = Promotion::instance()->set($data, $id);
            if (is_int($promotion_id))
            {
                // set memcache --- sjm 2015-12-14
                $cache = Cache::instance('memcache');
                $cache_key = 'promotions_product';
                $promotions = DB::select('id', 'from_date', 'to_date')
                    ->from('promotions')
                    ->and_where('is_active', '=', 1)
                    ->and_where('from_date', '<=', time())
                    ->and_where('to_date', '>=', time())
                    ->order_by('from_date', 'desc')
                    ->execute()
                    ->as_array();
                $cache->set($cache_key, $promotions, 30 * 86400);

                Message::set('修改促销成功！');
                Request::instance()->redirect('admin/site/promotion/list');
            }
            else
            {
                Message::set(__($promotion_id), 'error');
                Request::instance()->redirect('admin/site/promotion/edit/' . $id);
            }
        }

        $content_data['sets'] = ORM::factory('set')->where('site_id', '=', $this->site_id)->find_all();
        $content_data['attributes'] = ORM::factory('attribute')
            ->where('site_id', '=', $this->site_id)
            ->and_where('scope', '!=', 2)
            ->and_where('type', 'in', DB::expr("('0','1','2')"))
            ->and_where('promo', '=', 1)
            ->find_all();
        $content_data['filter'] = ORM::factory('filter', $promotion->filter);

        $name_template = '<input type="checkbox" id="catalog_check_{id}" name="condition[catalogs][]" value="{id}"/><label for="catalog_check_{id}">{name}</label>';
        //TODO
        $content_data['catalog_checkboxes_tree'] = Controller_Admin_Site_Catalog::get_left_tree($this->site_id, $name_template);

        $content_data['promotion'] = $promotion;

        $content = View::factory('admin/site/promotion_edit', $content_data)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_delete()
    {
        //TODO 促销的删除机制。。
        $id = $this->request->param('id');
        $promotion = ORM::factory('promotion', $id);
        $promotion->is_active = 0;
        $promotion->save();

        // set memcache --- sjm 2015-12-14
        $cache = Cache::instance('memcache');
        $cache_key = 'promotions_product';
        $promotions = DB::select('id', 'from_date', 'to_date')
            ->from('promotions')
            ->and_where('is_active', '=', 1)
            ->and_where('from_date', '<=', time())
            ->and_where('to_date', '>=', time())
            ->order_by('from_date', 'desc')
            ->execute()
            ->as_array();
        $cache->set($cache_key, $promotions, 30 * 86400);

        message::set('成功删除促销。');
        Request::instance()->redirect('/admin/site/promotion/list');
    }

    public function action_cart_list()
    {
        $count = ORM::factory('cpromotion')
            ->where('is_active', '=', 1)
            ->count_all();

        $pagination = Pagination::factory(
                array(
                    'current_page' => array('source' => 'query_string', 'key' => 'page'),
                    'total_items' => $count,
                    'item_per_page' => 40,
                    'view' => 'pagination/basic',
                    'auto_hide' => 'FALSE',
                )
        );
        $content_data['page_view'] = $pagination->render();
        $content_data['cart_promotions'] = ORM::factory('cpromotion')->where('is_active', '=', 1)->find_all();

        $content = View::factory('admin/site/promotion_cart_list', $content_data)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_cart_add()
    {
        if ($_POST)
        {
            $data = $_POST;
            $data['site_id'] = $this->site_id;
            $data['admin'] = Session::instance()->get('user_id');
            $cpromotion_id = Cartpromotion::instance()->set($data);
            if (is_int($cpromotion_id))
            {
                Message::set('成功添加了购物车促销。');
                Request::instance()->redirect('admin/site/promotion/cart_edit/' . $cpromotion_id);
            }
            else
            {
                Message::set(__($cpromotion_id), 'error');
                Request::instance()->redirect('admin/site/promotion/cart_add');
            }
        }
        $content = View::factory('admin/site/promotion_cart_add')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_cart_edit()
    {
        $id = $this->request->param('id');
        $cart_promotion = ORM::factory('cpromotion', $id);
        if (!$cart_promotion->loaded())
        {
            message::set('购物车促销不存在');
            Request::instance()->redirect('admin/site/promotion/cart_list');
        }
        if ($_POST)
        {
            $data = $_POST;
            $data['site_id'] = $this->site_id;
            $cpromotion_id = Cartpromotion::instance()->set($data, $id);
            if (is_int($cpromotion_id))
            {
                Message::set('成功修改了购物车促销。');
                Request::instance()->redirect('admin/site/promotion/cart_edit/' . $id);
            }
            else
            {
                Message::set(__($cpromotion_id), 'error');
                Request::instance()->redirect('admin/site/promotion/cart_edit/' . $id);
            }
        }
        $content_data['cart_promotion'] = $cart_promotion;
        $content = View::factory('admin/site/promotion_cart_edit', $content_data)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_cart_delete()
    {
        //TODO 购物车促销的删除机制。。
        $id = $this->request->param('id');
        $promotion = ORM::factory('cpromotion', $id);
        $promotion->is_active = 0;
        $promotion->save();
        message::set('成功删除购物车促销。');
        Request::instance()->redirect('/admin/site/promotion/cart_list');
    }

    public function action_coupon_list()
    {
        $q = Arr::get($_POST, 'search_code', '');
        $email = trim(Arr::get($_POST, 'email', ''));
        $coupon_set = trim(Arr::get($_GET, 'type', ''));

        $count = ORM::factory('coupon')
            ->where('site_id', '=', $this->site_id);
        if ($q)
            $count->where('code', 'like', "%$q%");
        if($coupon_set)
            $count->where('usedfor', '=', $coupon_set);

        $coupons = array();
        if ($email)
        {
            $customer_id = DB::select('id')->from('accounts_customers')->where('email', '=', $email)->execute('slave')->get('id');
            if ($customer_id)
            {
                $result = DB::select('coupon_id')->from('carts_customercoupons')->where('customer_id', '=', $customer_id)->execute('slave')->as_array();
                foreach ($result as $c)
                {
                    $coupons[] = $c['coupon_id'];
                }
            }
        }
//        print_r($coupons);exit;
        if (!empty($coupons))
            $count->where('id', 'IN', $coupons);
        $count = $count->count_all();

        $pagination = Pagination::factory(
                array(
                    'current_page' => array('source' => 'query_string', 'key' => 'page'),
                    'total_items' => $count,
                    'items_per_page' => 50,
                    'view' => 'pagination/basic',
                    'auto_hide' => TRUE,
                )
        );

        $page_view = $pagination->render();

        $data = ORM::factory('coupon')
            ->where('site_id', '=', $this->site_id)
//                        ->where('expired', '>', time())
            ->offset($pagination->offset)
            ->limit($pagination->items_per_page)
            ->order_by('id', 'DESC');
        if ($q)
            $data->where('code', 'like', "%$q%");
        if($coupon_set)
            $data->where('usedfor', '=', $coupon_set);

        if (!empty($coupons))
            $data->where('id', 'IN', $coupons);
        $data = $data->find_all();
        $coupons_sets=DB::select('*')
                ->from('coupons_sets')
                ->execute('slave')->as_array();

        $content = View::factory('admin/site/promotion_coupon_list')
            ->set('data', $data)
            ->set('page_view', $page_view)
            ->set('q', $q)
            ->set('coupons_sets', $coupons_sets)
            ->set('email', $email)
            ->render();

        $this->request->response = View::factory('admin/template')
            ->set('content', $content)
            ->render();
    }

    public function action_coupon_add()
    {
        $coupons_sets=DB::select('*')
                ->from('coupons_sets')
                ->execute('slave')->as_array();
        $content = View::factory('admin/site/promotion_coupon_add')->set('coupons_sets', $coupons_sets)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_coupon_add_go()
    {
        if ($_POST)
        {
            $data = array();

            $data['site_id'] = $this->site_id;
            $data['code'] = Arr::get($_POST, 'coupon_number', '');
            $data['type'] = Arr::get($_POST, 'coupon_type', '');
            $data['value'] = Arr::get($_POST, 'coupon_value', '');
            $data['limit'] = Arr::get($_POST, 'coupon_limit', '');
            $data['item_sku'] = Arr::get($_POST, 'item_sku', '');
            $data['coupon_set'] = Arr::get($_POST, 'coupon_set', '');
            $data['set_name'] = Arr::get($_POST, 'set_name', '');
            $data['condition'] = Arr::get($_POST, 'condition', 0);
            $data['catalog_limit'] = Arr::get($_POST, 'catalog_limit', '');
            $data['product_limit'] = Arr::get($_POST, 'product_limit', '');
            $data['effective_limit'] = Arr::get($_POST, 'effective_limit', '-1');
            if (isset($_POST['global']) AND $_POST['global'] == 'on')
                $data['target'] = 'global';

            $data['created'] = strtotime(Arr::get($_POST, 'coupon_created', date('d/m/Y')));
            $data['expired'] = strtotime(Arr::get($_POST, 'coupon_expired', date('d/m/Y', strtotime('+1 month'))));
            $data['admin'] = Session::instance()->get('user_id');

            $exists = Coupon::instance($data['code'])->get('id');
            if ($exists)
            {
                message::set('该折扣号已经存在，请重新输入折扣号', 'error');
                Request::instance()->redirect('/admin/site/promotion/coupon_add');
            }

            //add on_show, customer_id
            if (isset($_POST['on_show']) AND $_POST['on_show'] == 'on')
                $data['on_show'] = 1;
            //添加其他折扣用途
            if(isset($data['set_name']) AND $data['coupon_set'] == 0){
                $result=DB::insert('coupons_sets', array('id', 'name'))
                    ->values(array('', $data['set_name']))
                    ->execute();
                if($result){
                    $data['coupon_set']=$result[0];
                }else{
                    message::set('添加折扣用途失败', 'error');
                    Request::instance()->redirect('/admin/site/promotion/coupon_add');
                }
            }

            $rs = Coupon::instance()->add($data);
            if ($rs)
            {
                $emails = Arr::get($_POST, 'emails', '');
                if ($emails)
                {
                    $coupon_id = $rs;
                    $emailArr = explode("\n", $emails);
                    foreach ($emailArr as $email)
                    {
                        $customer_id = Customer::instance()->is_register(trim($email));
                        if ($customer_id)
                        {
                            $insert = array(
                                'customer_id' => $customer_id,
                                'coupon_id' => $coupon_id,
                                'site_id' => $this->site_id
                            );
                            DB::insert('carts_customercoupons', array_keys($insert))->values($insert)->execute();
                        }
                    }
                }
                message::set('添加折扣成功');
                Request::instance()->redirect('/admin/site/promotion/coupon_list');
            }
            else
            {
                message::set('添加折扣失败，请重新添加');
                Request::instance()->redirect('/admin/site/promotion/coupon_add');
            }
        }
    }

    public function action_coupon_code_create()
    {
        $result = Coupon::instance()->create();
        if ($result)
        {
            echo $result;
        }
        else
        {
            $result = Coupon::instance()->create();
        }
    }

    public function action_coupon_edit()
    {
        $coupon_id = $this->request->param('id');
        $coupon = ORM::factory('coupon')->where('id', '=', $coupon_id)->find();
        $coupons_sets=DB::select('*')
                ->from('coupons_sets')
                ->execute('slave')->as_array();
        $content = View::factory('admin/site/promotion_coupon_edit')->set('coupon', $coupon)->set('coupons_sets',$coupons_sets)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_coupon_edit_go()
    {
        if ($_POST)
        {
            $coupon_id = Arr::get($_POST, 'id', '');
            $coupon = ORM::factory('coupon')->where('id', '=', $coupon_id)->find();
            $coupon->code = Arr::get($_POST, 'coupon_number', '');
            $coupon->type = Arr::get($_POST, 'coupon_type', '');
            $coupon->value = Arr::get($_POST, 'coupon_value', '');
            $coupon->limit = Arr::get($_POST, 'coupon_limit', '');
            $coupon->item_sku = Arr::get($_POST, 'item_sku', '');
            $coupon->usedfor = Arr::get($_POST, 'coupon_set', '');
            $coupon->condition = Arr::get($_POST, 'condition', 0);
            $coupon->catalog_limit = Arr::get($_POST, 'catalog_limit', '');
            $coupon->product_limit = Arr::get($_POST, 'product_limit', '');
            $coupon->effective_limit = Arr::get($_POST, 'effective_limit', '-1');
            $coupon->created = strtotime(Arr::get($_POST, 'coupon_created', date('d/m/Y')));
            $coupon->expired = strtotime(Arr::get($_POST, 'coupon_expired', date('d/m/Y', strtotime('+1 month'))));

            if (isset($_POST['global']) AND $_POST['global'] == 'on')
                $coupon->target = 'global';
            else
                $coupon->target = NULL;


            //add on_show, customer_id
            if (isset($_POST['on_show']) AND $_POST['on_show'] == 'on')
                $coupon->on_show = 1;
            else
                $coupon->on_show = 0;

            $coupon->save();

            if ($coupon->saved() == true)
            {
                $emails = Arr::get($_POST, 'emails', '');
                if ($emails)
                {
                    $emailArr = explode("\n", $emails);
                    foreach ($emailArr as $email)
                    {
                        $customer_id = Customer::instance()->is_register(trim($email));
                        if ($customer_id)
                        {
                            $has = DB::select('id')->from('carts_customercoupons')
                                    ->where('site_id', '=', $this->site_id)
                                    ->and_where('coupon_id', '=', $coupon_id)
                                    ->and_where('customer_id', '=', $customer_id)
                                    ->execute('slave')->get('id');
                            if (!$has)
                            {
                                $insert = array(
                                    'customer_id' => $customer_id,
                                    'coupon_id' => $coupon_id,
                                    'site_id' => $this->site_id
                                );
                                DB::insert('carts_customercoupons', array_keys($insert))->values($insert)->execute();
                            }
                        }
                    }
                }
                message::set("折扣修改成功");
            }
            else
            {
                message::set("修改失败!");
            }
            Request::instance()->redirect('/admin/site/promotion/coupon_edit/' . $coupon_id);
        }
    }

    public function action_coupon_del($id)
    {
        $coupon = ORM::factory('coupon', $id);
        if ($coupon->delete())
        {
            DB::delete('carts_customercoupons')->where('coupon_id', '=', $id)->execute();
            message::set('删除折扣号成功');
        }
        else
        {
            message::set('删除折扣号失败', 'error');
        }

        $this->request->redirect('/admin/site/promotion/coupon_list');
    }

    public function action_coupon_sinup_del()
    {
        $signup15off = DB::select('id', 'code')
                ->from('carts_coupons')
                ->where('code', 'LIKE', 'SIGNUP15OFF%')
                ->and_where('limit', '=', 0)
                ->execute('slave')->as_array();
        DB::delete('carts_customercoupons')->where('coupon_id', 'IN', $signup15off);
        DB::delete('carts_coupons')
            ->where('code', 'LIKE', 'SIGNUP15OFF%')
            ->and_where('limit', '=', 0)
            ->execute();
        $signup15off = DB::select('id', 'code')
                ->from('carts_coupons')
                ->where('code', 'LIKE', 'SIGNUP15OFF%')
                ->and_where('expired', '<', time())
                ->execute('slave')->as_array();
        DB::delete('carts_customercoupons')->where('coupon_id', 'IN', $signup15off);
        DB::delete('carts_coupons')
            ->where('code', 'LIKE', 'SIGNUP15OFF%')
            ->and_where('expired', '<', time())
            ->execute();
        Message::set("Delete Register Coupon Success!", 'success');
        $this->request->redirect('/admin/site/promotion/coupon_list');
    }

    public function action_new_product()
    {
        $content = View::factory('admin/site/promotion_new_product');
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    /* 1 weeks new products */
    public function action_new_relate()
    {
        if ($_POST)
        {
            $catalog_id = DB::select('id')->from('products_category')->where('link', '=', 'new-product')->execute('slave')->get('id');
            $today = time();
            $_2Weekslater = $today - 1209600 / 2; //一周前
            $no_set = Arr::get($_REQUEST, 'no_set', 0);
            if($no_set)
                $sql = ' AND set_id <> ' . $no_set;
            else
                $sql = '';
            $new_products = DB::query(Database::SELECT, 'SELECT id FROM products WHERE visibility = 1 AND display_date >= ' . $_2Weekslater . ' AND display_date < ' . $today . $sql)->execute('slave');
            $products = array();
            foreach ($new_products as $idx => $p)
            {
                DB::insert('catalog_products', array('catalog_id', 'product_id', 'position'))
                    ->values(array($catalog_id, $p['id'], $idx))
                    ->execute();
            }
            Message::set('Relate 1 week new product Success!');
        }
        $this->request->redirect('/admin/site/promotion/new_product');
    }

    /* 2 weeks new products */
    public function action_new_relate1()
    {
        if ($_POST)
        {
            $catalog_id = DB::select('id')->from('products_category')->where('link', '=', 'new-product')->execute('slave')->get('id');
            $today = time();
            $_2Weekslater = $today - 1209600; //两周前
            $no_set = Arr::get($_REQUEST, 'no_set', 0);
            if($no_set)
                $sql = ' AND set_id <> ' . $no_set;
            else
                $sql = '';
            $new_products = DB::query(Database::SELECT, 'SELECT id FROM products WHERE visibility = 1 AND display_date >= ' . $_2Weekslater . ' AND display_date < ' . $today . $sql)->execute('slave');
            $products = array();
            foreach ($new_products as $idx => $p)
            {
                DB::insert('catalog_products', array('catalog_id', 'product_id', 'position'))
                    ->values(array($catalog_id, $p['id'], $idx))
                    ->execute();
            }
            Message::set('Relate 2 weeks new product Success!');
        }
        $this->request->redirect('/admin/site/promotion/new_product');
    }

    public function action_new_delete()
    {
        if ($_POST)
        {
            $catalog_id = DB::select('id')->from('products_category')->where('link', '=', 'new-product')->execute('slave')->get('id');
            $result = DB::delete('catalog_products')->where('catalog_id', '=', $catalog_id)->execute();
            if ($result)
                Message::set('Delete new product Success!');
            else
                Message::set('Delete new product Failed!');
        }
        $this->request->redirect('/admin/site/promotion/new_product');
    }
    
    public function action_coupon_data()
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
                if ($item->field == 'email')
                    $filter_sql .= " AND c." . $item->field . "='" . $item->data . "'";
                else
                    $filter_sql .= " AND o." . $item->field . "='" . $item->data . "'";
            }
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $coupon_id = $_REQUEST['coupon_id'];
        $count = DB::query(Database::SELECT, 'SELECT count(o.id) AS count FROM carts_customercoupons o LEFT JOIN customers c ON o.customer_id = c.id 
                                WHERE o.site_id=' . $this->site_id . ' AND o.coupon_id = ' . $coupon_id . $filter_sql)
                ->execute('slave')->get('count');
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT o.id, o.customer_id, c.email FROM carts_customercoupons o LEFT JOIN accounts_customers c ON o.customer_id = c.id 
                                WHERE o.site_id=' . $this->site_id . ' AND o.coupon_id = ' . $coupon_id .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        foreach ($result as $data)
        {
            $response['rows'][$i]['id'] = $data['id'];
            $response['rows'][$i]['cell'] = array(
                $data['id'],
                $data['customer_id'],
                $data['email'],
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_coupon_customer_delete($id)
    {
        if ($id)
        {
            $coupon_id = DB::select('coupon_id')->from('carts_customercoupons')->where('id', '=', $id)->execute('slave')->get('coupon_id');
            $delete = DB::delete('carts_customercoupons')->where('id', '=', $id)->execute();
            if ($delete)
                Message::set('Delete coupon customer Success!');
            else
                Message::set('Delete coupon customer Failed!');
        }
        Request::instance()->redirect('/admin/site/promotion/coupon_edit/' . $coupon_id);
    }

    public function action_expired_coupon_delete()
    {
        $delete = DB::delete('coupons')->where('expired', '<', time())->execute();
        if ($delete)
            Message::set('Delete expired coupons Success!');
        else
            Message::set('Delete expired coupons Failed!');
        Request::instance()->redirect('/admin/site/promotion/coupon_list');
    }

    public function action_coupon_orders()
    {
        if ($_POST)
        {
            $code = trim(Arr::get($_POST, 'search_code', ''));
            if ($code)
            {
                echo '<table cellspacing="0" cellpadding="0" border="0">';
                echo '<tr><td width="120px">Ordernum</td><td width="120px">Amount</td><td width="120px">Currency</td><td width="120px">Created</td><td width="120px">Payment_status</td></tr>';
                $result = DB::select('ordernum', 'created', 'payment_status', 'amount', 'currency')->from('orders_order')->where('coupon_code', '=', $code)->order_by('created', 'desc')->execute('slave');
                foreach ($result as $order)
                {
                    echo '<tr><td>' . $order['ordernum'] . '</td><td>' . $order['amount'] . '</td><td>' . $order['currency'] . '</td><td>' . date('Y-m-d', $order['created']) . '</td><td>' . $order['payment_status'] . '</td></tr>';
                }
                echo '</table>';
            }
        }
    }

    public function action_special()
    {

        $content = View::factory('admin/site/promotion_special_list');
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_special_data()
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
        $_filter_sql = array();

        if ($filters)
        {
            foreach ($filters->rules as $item)
            {

                if ($item->field == 'created')
                {
                    $date = explode(' to ', $item->data);
                    $dcount = count($date);
                    $from = strtotime($date[0]);
                    if ($dcount == 1)
                    {
                        $to = strtotime($date[0] . ' +1 day -1 second');
                    }
                    else
                    {
                        $to = strtotime($date[1] . ' +1 day -1 second');
                    }
                    $_filter_sql[] = "s." . $item->field . " between " . $from . " and " . $to;
                }
                elseif ($item->field == 'admin')
                {
                    $user = ORM::factory('user')->where('name', '=', $item->data)->find();
                    $_filter_sql[] = "s." . $item->field . "='" . $user->id . "'";
                }
                elseif ($item->field == 'sku')
                {
                    $_filter_sql[] = "p." . $item->field . "='" . $item->data . "'";
                }
                elseif ($item->field == 'orig_price')
                {
                    $_filter_sql[] = "p.price='" . $item->data . "'";
                }
                else
                {
                    $_filter_sql[] = "s." . $item->field . "='" . $item->data . "'";
                }
            }
        }
        if (!empty($_filter_sql))
            $filter_sql = " AND " . implode(' AND ', $_filter_sql);
        $filter_type = Arr::get($_REQUEST, 'type', '');
        if($filter_type != '')
        {
            $filter_sql .= ' AND s.type = ' . $filter_type;
        }
        else
        {
            $filter_sql .= ' AND s.type >= 0 ';
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $count = DB::query(Database::SELECT, 'SELECT count(s.id) AS count FROM spromotions s LEFT JOIN products p ON s.product_id=p.id WHERE s.price > 0 ' . $filter_sql)->execute('slave')->get('count');
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT s.*, p.sku, p.price AS orig_price, p.total_cost, p.weight FROM spromotions s LEFT JOIN products p ON s.product_id=p.id ' .
                ' WHERE s.price > 0 ' . $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $userArr = DB::select('id', 'name')->from('auth_user')->execute('slave')->as_array();
        $users = array();
        foreach ($userArr as $user)
        {
            $users[$user['id']] = $user['name'];
        }
        $i = 0;
        $types = Kohana::config('promotion.types');
        $usd_rate = 6.1;
        foreach ($result as $data)
        {
            if(!$data['orig_price'])
            {
                continue;
            }
            $orig_profit = ($data['orig_price'] * $usd_rate - $data['total_cost'] - $data['weight'] * 120) / ($data['orig_price'] * $usd_rate);
            $sale_profit = ($data['price'] * $usd_rate - $data['total_cost'] - $data['weight'] * 120) / ($data['price'] * $usd_rate);
            $response['rows'][$i]['id'] = $data['id'];
            $response['rows'][$i]['cell'] = array(
                '',
                $data['id'],
                $data['sku'],
                $data['orig_price'],
                round($orig_profit, 4),
                $data['price'],
                round($sale_profit, 4),
                $data['catalog'],
                isset($types[$data['type']]) ? $types[$data['type']] : '',
                date("Y-m-d H:i:s", $data['created']),
                date("Y-m-d H:i:s", $data['expired']),
                isset($users[$data['admin']]) ? $users[$data['admin']] : '',
                $data['position']
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_special_update()
    {

        $result = DB::query(DATABASE::SELECT, 'SELECT id,expired from spromotions')->execute();  
        foreach($result as $v){
            $data['expired']  = $v['expired'] + 10*3600;
            $sql =  DB::update('spromotions')
                ->set($data)
                ->where('id', '=', $v['id'])
                ->execute();
        } 
    }

    public function action_special_add()
    {
        if ($_POST)
        {
            // print_r($_POST);exit;
            $types = Kohana::config('promotion.types');
            $sku = Arr::get($_POST, 'sku', '');
            $product_id = Product::get_productId_by_sku($sku);
            $data = array();
            if ($product_id)
            {
                $type = Arr::get($_POST, 'type', 1);
                if (array_key_exists($type, $types))
                    $data['type'] = $type;
                else
                    $data['type'] = 1;
                $s_id = Arr::get($_POST, 'id', 0);
                if ($s_id)
                {
                    $has = DB::select('id', 'type')->from('spromotions')->where('id', '=', $s_id)->execute('slave')->current();
                    $data['price'] = Arr::get($_POST, 'price', 0);
                    $price = Product::instance($product_id)->get('price');
                    if($data['price'] > $price)
                    {
                       $message = 'sku:'.$sku.'促销价格大于原价'; 
                        echo json_encode($message);
                        exit;
                    }
                    $data['catalog'] = Arr::get($_POST, 'catalog', '');
                    $expired = Arr::get($_POST, 'expired', 0);
                    if ($data['price'] AND $expired)
                    {
                        $data['expired'] = strtotime($expired);
                     //   $data['expired']  = $data['expired'] + 10*3600;
                        if(isset($_POST['created']))
                            $data['created'] = strtotime($_POST['created']);
                        else
                            $data['created'] = time();
                        $data['admin'] = Session::instance()->get('user_id');
                        $update = DB::update('spromotions')->set($data)->where('id', '=', $s_id)->execute();
                        if ($update)
                        {
                            $message = 'success';

                            // set memcache --- sjm 2015-12-14
                            $spromotion_key = 'spromotion_' . $product_id;
                            $cache = Cache::instance('memcache');
                            $cache_data = $cache->get($spromotion_key);
                            if(isset($cache_data[$has['type']]))
                                unset($cache_data[$has['type']]);
                            $cache_data[$data['type']] = array('price' => $data['price'], 'created' => $data['created'], 'expired' => $data['expired']);
                            $cache->set($spromotion_key, $cache_data, 30 * 86400);

                        }
                        else
                            $message = 'Add promotion product failed!';
                    }
                    else
                        $message = 'Input param error!';
                }
                else
                {
                    $has = DB::select('id', 'type')->from('spromotions')->where('product_id', '=', $product_id)->execute('slave')->as_array();
                    if(!empty($has))
                    {
                        $has_over_0 = 0;
                        $has_is_0 = 0;
                        $has_below_0 = 0;
                        foreach($has as $h)
                        {
                            if($h['type'] > 0)
                            {
                                $has_over_0 = 1;
                            }
                            elseif($h['type'] == 0)
                            {
                                $has_is_0 = 1;
                            }
                            else
                            {
                                $has_below_0 = 1;
                            }
                        }

                        if($data['type'] > 0)
                        {
                            if($has_over_0)
                            {
                                $message = 'Failed! This product is in promotion now!';
                                echo json_encode($message);
                                exit;
                            }
                        }
                        elseif($data['type'] == 0)
                        {
                            if($has_is_0)
                            {
                                $message = 'Failed! This product is in promotion now!';
                                echo json_encode($message);
                                exit;
                            }
                        }
                        else
                        {
                            if($has_below_0)
                            {
                                $message = 'Failed! This product is in promotion now!';
                                echo json_encode($message);
                                exit;
                            }
                        }
                    }
                    $data['product_id'] = $product_id;
                    $price = Product::instance($product_id)->get('price');
                    $data['price'] = Arr::get($_POST, 'price', 0);
                    if($data['price'] > $price)
                    {
                       $message = 'sku:'.$sku.'促销价格大于原价'; 
                        echo json_encode($message);
                        exit;
                    }
                    $data['catalog'] = Arr::get($_POST, 'catalog', '');
                    $expired = Arr::get($_POST, 'expired', 0);
                    if ($data['price'] AND $expired)
                    {
                        $data['expired'] = strtotime($expired);
                        $data['expired']  = $data['expired'] + 10*3600;
                        if(isset($_POST['created']))
                            $data['created'] = strtotime($_POST['created']);
                        else
                            $data['created'] = time();
                        $data['admin'] = Session::instance()->get('user_id');
                        $insert = DB::insert('spromotions', array_keys($data))->values($data)->execute();
                        if ($insert)
                        {
                            $message = 'success';

                            // set memcache --- sjm 2015-12-14
                            $spromotion_key = 'spromotion_' . $data['product_id'];
                            $cache = Cache::instance('memcache');
                            $cache_data = $cache->get($spromotion_key);
                            $cache_data[$data['type']] = array('price' => $data['price'], 'created' => $data['created'], 'expired' => $data['expired']);
                            asort($cache_data);
                            $cache->set($spromotion_key, $cache_data, 30 * 86400);

                        }
                        else
                            $message = 'Add promotion product failed!';
                    }
                    else
                        $message = 'Input param error!';
                }
            }
            else
            {
                $message = 'Please Input Correct SKU!';
            }
            echo json_encode($message);
            exit;
        }
    }

    public function action_special_bulk()
    {
        $file_types = array(
            "application/vnd.ms-excel",
            "text/csv",
            "application/csv",
            "text/comma-separated-values",
            "application/octet-stream",
            "application/oct-stream"
        );
        if (!isset($_FILES) || (!in_array($_FILES["file"]["type"], $file_types)))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        $admin = Session::instance()->get('user_id');
        $success = array();
        $rongsku = array();
        $types = Kohana::config('promotion.types');
        $cache = Cache::instance('memcache');
        while ($data = fgetcsv($handle))
        {
            try
            {
                if ($data[0] == 'SKU' OR $data[0] == 'sku')
                {
                    $row++;
                    continue;
                }
                $array = array();
                if ($data[0])
                {
                    $sku = $data[0];
                    $product_id = Product::get_productId_by_sku($sku);
                    if ($product_id)
                    {
                        $array['price'] = $data[1];
                        $price = Product::instance($product_id)->get('price');
                        if($price < $array['price'])
                        {
                            $rongsku[] = $sku;
                        }
                        else
                        {
                            $array['catalog'] = $data[2];
                            $array['expired'] = $data[3] ? strtotime($data[3]) : time() + 2592000;
                            $array['expired']  = $array['expired'] + 10*3600;
                            $type = strtolower(trim($data[4]));
                            $key = array_keys($types, $type);
                            if (!empty($key))
                                $array['type'] = $key[0];
                            else
                                $array['type'] = 1;
                            $array['admin'] = $admin;
                            $array['created'] = time();
                            if($array['type']=='0'){
                                $has = DB::select('id', 'type')->from('spromotions')
                                    ->where('product_id', '=', $product_id)
                                    ->where('type', '=', 0)
                                    ->order_by('id', 'desc')
                                    ->execute('slave')->current();
                            }else{
                                $has = DB::select('id', 'type')->from('spromotions')
                                    ->where('product_id', '=', $product_id)
                                    ->where('type', '<>', 0)
                                    ->order_by('id', 'desc')
                                    ->execute('slave')->current();
                            }
                            if (!empty($has))
                            {
                                $update = DB::update('spromotions')->set($array)->where('id', '=', $has['id'])->execute();
                                if ($update)
                                {
                                    $success[] = $sku;

                                    // set memcache --- sjm 2015-12-14
                                    $spromotion_key = 'spromotion_' . $product_id;
                                    $cache_data = $cache->get($spromotion_key);
                                    if(isset($cache_data[$has['type']]))
                                        unset($cache_data[$has['type']]);
                                    $cache_data[$array['type']] = array('price' => $array['price'], 'created' => $array['created'], 'expired' => $array['expired']);
                                    $cache->set($spromotion_key, $cache_data, 30 * 86400);
                                }
                            }
                            else
                            {
                                $array['product_id'] = $product_id;
                                $insert = DB::insert('spromotions', array_keys($array))->values($array)->execute();
                                if ($insert)
                                {
                                    $success[] = $sku;

                                    // set memcache --- sjm 2015-12-14
                                    $spromotion_key = 'spromotion_' . $product_id;
                                    $cache_data = $cache->get($spromotion_key);
                                    $cache_data[$array['type']] = array('price' => $array['price'], 'created' => $array['created'], 'expired' => $array['expired']);
                                    asort($cache_data);
                                    $cache->set($spromotion_key, $cache_data, 30 * 86400);
                                }
                            }                            
                        }

                    }
                    $row++;
                }
            }
            catch (Exception $e)
            {
                $error[] = "Add Row " . $row . " Fail: " . $e->getMessage();
                $row++;
            }
        }
        if (isset($error))
            echo(implode("<br/>", $error));
        echo '<br/>';
        $successes = implode("<br/>", $success);
        $rongskues = implode("<br/>", $rongsku);
        echo "price error SKU：".$rongskues;
        echo '<br />';
        die("Success skus:<br/>" . $successes);
    }

    public function action_special_delete()
    {
        $id = $this->request->param('id');

        $spromotion_value = DB::select('type', 'product_id')->from('spromotions')->where('id', '=', $id)->execute('slave')->current();
        $delete = DB::delete('spromotions')->where('id', '=', $id)->execute();
        if ($delete)
        {
            // delete memcache --- sjm 2015-12-14
            $spromotion_key = 'spromotion_' . $spromotion_value['product_id'];
            $cache = Cache::instance('memcache');
            $cache_data = $cache->get($spromotion_key);
            unset($cache_data[$spromotion_value['type']]);
            if(!empty($cache_data))
                $cache->set($spromotion_key, $cache_data, 30 * 86400);
            else
                $cache->delete($spromotion_key);
            echo 'success';
        }
        else
        {
            echo (__('id_does_not_exist'));
        }
    }

    public function action_special_bulk_delete()
    {
        if ($_POST)
        {
            $ids = Arr::get($_POST, 'ids', array());
            if (!empty($ids))
            {
                $spromotion_values = DB::select('type', 'product_id')->from('spromotions')->where('id', 'IN', $ids)->execute('slave')->as_array();
                $delete = DB::delete('spromotions')->where('id', 'IN', $ids)->execute();
                if ($delete)
                {
                    // bulk delete memcache --- sjm 2015-12-14
                    $cache = Cache::instance('memcache');
                    foreach($spromotion_values as $s_value)
                    {
                        $spromotion_key = 'spromotion_' . $s_value['product_id'];
                        $cache_data = $cache->get($spromotion_key);
                        unset($cache_data[$s_value['type']]);
                        if(!empty($cache_data))
                            $cache->set($spromotion_key, $cache_data, 30 * 86400);
                        else
                            $cache->delete($spromotion_key);
                    }
                    Message::set('Delete special promotion success!', 'success');
                }
                else
                    Message::set('Delete special promotion failed!', 'error');
            }
            else
                Message::set('Please select ids!', 'notice');
            $this->request->redirect('admin/site/promotion/special');
        }
    }

    public function action_special_top()
    {
        if ($_POST)
        {
            if (!$_POST['SKUARR'])
            {
                Message::set('请输入产品的sku', 'notice');
                $this->request->redirect('/admin/site/product/product_onstock');
            }
            $productArr = explode("\n", $_POST['SKUARR']);
            foreach ($productArr as $sku)
            {
                $product_id = Product::get_productId_by_sku($sku);
                $catalog = DB::select('catalog')->from('spromotions')->where('product_id', '=', $product_id)->execute('slave')->get('catalog');
                $position = DB::select(DB::expr('MAX(position) AS pos'))->from('spromotions')->where('catalog', '=', $catalog)->execute('slave')->get('pos');
                DB::update('spromotions')->set(array('position' => $position + 1))->where('product_id', '=', $product_id)->execute();
            }
            Message::set('批量置顶产品成功', 'success');
            $this->request->redirect('admin/site/promotion/special');
        }
    }

    public function action_special_edit()
    {
        $id = $this->request->param('id');
        $price = Arr::get($_GET, 'price', 0);
        try
        {
            if (!$price)
            {
                echo 'Fee Cannot Be Zero';
            }
            else
            {
                $result = DB::update('spromotions')->set(array('price' => round($price, 2)))->where('id', '=', $id)->execute();
                echo $result ? 'success' : 'Failed';
            }
        }
        catch (Exception $e)
        {
            echo $e;
        }
    }

    public function action_searchwords()
    {
        $lang=trim(Arr::get($_GET, 'lang', ''));
        $lang=$lang?$lang:"en";
        $searchwords=DB::select()->from('search_hotword')->where('active', '=', 1)->where('lang', '=', $lang)->execute();
        $content = View::factory('admin/site/searchwords_list')
                ->set('searchwords', $searchwords)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_searchwords_add()
    {
        if($_POST){
            $data=array();
            $data['lang']=trim(Arr::get($_POST, 'lang', ''));
            $data['type']=trim(Arr::get($_POST, 'type', ''));
            $data['name']=trim(Arr::get($_POST, 'title', ''));
            $data['href']=trim(Arr::get($_POST, 'href', ''));
            $data['created']=time();
            $data['admin']=Session::instance()->get('user_id');
            $data['site_id']=1;
            $data['active']=1;
            if($data['name']&&$data['href']&&$data['type']){
                $insert=DB::insert('search_hotword', array_keys($data))->values($data)->execute();
            }
            if($insert){
               Message::set('添加成功', 'success'); 
           }else{
                Message::set('添加失败', 'error');
           }
           $this->request->redirect('admin/site/promotion/searchwords');
        }else{
            $content = View::factory('admin/site/searchwords_add')->render();
            $this->request->response = View::factory('admin/template')->set('content', $content)->render();
        }
    }

    public function action_searchwords_del()
    {
        $id = $this->request->param('id');
        if($id){
            $result = DB::update('search_hotword')->set(array('active' => 0))->where('id', '=', $id)->execute();
            if($result){
                Message::set('删除成功', 'success');
            }else{
                Message::set('删除失败', 'success');
            }
            $this->request->redirect('admin/site/promotion/searchwords');
        }else{
          Message::set('删除失败', 'success');
          $this->request->redirect('admin/site/promotion/searchwords');
      }
    }

    public function action_export_activity_products()
    {
        if($_POST)
        {
            $string = trim(Arr::get($_POST, 'skus', ''));
            $skus = explode("\n", $string);
            $outsku = DB::select('args')->from('promotions')->where('id', '=', 41)->execute()->get('args');
            $outsku = explode("\n",$outsku);
        //    $i = 0;
            echo 'array<br>(';
            foreach($skus as $sku)
            {
/*                if(!in_array($sku,$outsku) && $i<=99)
                {*/
                    $product = DB::query(Database::SELECT, 'SELECT id, sku, name, link, attributes FROM products WHERE sku = "' . $sku . '"')
                        ->execute('slave')->current();
                    if(!empty($product))
                    {
                        $de_name = DB::select('name')->from('products_de')->where('id', '=', $product['id'])->execute('slave')->get('name');
                        $es_name = DB::select('name')->from('products_es')->where('id', '=', $product['id'])->execute('slave')->get('name');
                        $fr_name = DB::select('name')->from('products_fr')->where('id', '=', $product['id'])->execute('slave')->get('name');
                        $ru_name = DB::select('name')->from('products_ru')->where('id', '=', $product['id'])->execute('slave')->get('name');
                        // $replace = array("'", '"', "\n", '<p>', '</p>', '<br>', '<br/>',);
                        // $des = str_replace($replace, array(" "), $product['description']);
                        // $brief = str_replace($replace, array(" "), $product['brief']);
                        // $keywords = str_replace($replace, array(" "), $product['keywords']);
                        $cover = Product::instance($product['id'])->cover_image();
                        $cover_image = Image::link($cover, 1);
                        echo "'".$sku."' => array('id' => ".$product['id'].",
                        'sku' => '".$product['sku']."', 'name' => '".$product['name']."', 
                        'de_name' => '".str_replace("'", "\'", $de_name)."', 'es_name' => '".str_replace("'", "\'", $es_name)."', 
                        'fr_name' => '".str_replace("'", "\'", $fr_name)."', 'ru_name' => '".str_replace("'", "\'", $ru_name)."', 
                        'link' => '".$product['link']."', 'attributes' => '".$product['attributes']."', 
                        'brief' => '".$brief."', 'description' => '".$des."', 
                        'keywords' => '".$keywords."', 'cover_image' => '".$cover_image."'),<br>";
                    }
/*                }
                $i++;*/

            }
            echo ');';
        }
        else
        {
            echo '
            <h3>活动页面获取产品数据</h3>
            <form action="" method="post">
            输入sku:<br>
            <textarea name="skus" cols="40" rows="20"></textarea><br/>
            <input type="submit" value="Submit" />
            </form>
            ';
        }
    }

    //设置活动页面下架产品
    public function action_set_activity_outsale()
    {
        $out_sale = DB::select('id', 'args')->from('promotions')->where('id', '=', 41)->execute('slave')->current();
        if($_POST)
        {
            $string = trim(Arr::get($_POST, 'skus', ''));
            DB::update('promotions')->set(array('args' => $string))->where('id', '=', $out_sale['id'])->execute();
            $this->request->redirect('/admin/site/promotion/set_activity_outsale');
        }

        echo '<h3 style="margin-bottom:-10px;">活动页面产品下架</h3><br>
            <h4><span style="color:red;">已下架产品:</span><br><br>';
        echo str_replace("\n", "<br>", $out_sale['args']);
        echo '</h4><br>
        <form action="" method="post">
        输入要下架的sku:<br>
        <textarea name="skus" cols="40" rows="20"></textarea><br/>
        <input type="submit" value="Submit" />
        </form>
        ';
    }

    public function action_from_csv_get_array()
    {
        if($_POST)
        {
            $string = trim(Arr::get($_POST, 'comments', ''));
            $array1 = explode("\n", $string);
            echo 'array<br>(';
            foreach($array1 as $a1)
            {
                $array2 = explode("\t", $a1);
                foreach($array2 as $key => $a2)
                {
                    if($key == 0)
                        echo "'".$a2."' => array(";
                    else
                        echo "'".$a2."',";
                }
                echo "),<br>";
            }
            
            echo ');';
        }
        else
        {
            echo '
            <h3>复制表格内容生成数组(第一列为主键)</h3>
            <form action="" method="post">
            输入表格复制的内容:<br>
            <textarea name="comments" cols="40" rows="20"></textarea><br/>
            <input type="submit" value="Submit" />
            </form>
            ';
        }
    }

    //折扣过期产品导出
    public function action_export_special_expired()
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="spromotions_expired.csv"');
        echo "SKU,Orig_Price,Sale_Price,Created_Time,Expired_Time,Admin\n";
        //结果集
        $results = DB::query(DATABASE::SELECT, "SELECT s.id,p.sku,p.price AS orig_price,s.price,date_add(FROM_UNIXTIME(s.created, '%Y-%m-%d %H:%i:%S'),interval 8 hour) AS 'Created_Time',date_add(FROM_UNIXTIME(s.expired, '%Y-%m-%d %H:%i:%S'),interval 8 hour) AS 'Expired_Time',s.admin FROM spromotions s LEFT JOIN products p ON s.product_id=p.id WHERE s.price > 0 and p.status =  1 and p.visibility = 1 and s.expired<UNIX_TIMESTAMP(now())")->execute();
        foreach ($results as $product)
        {
            $user_name = ORM::factory('user')->where('id','=',$product['admin'])->find()->name;
            echo $product['sku'], ',';
            echo '"' . $product['orig_price'] . '"', ',';
            echo '"' . $product['price'] . '"', ',';
            echo '"' . $product['Created_Time'] . '"', ',';
            echo '"' . $product['Expired_Time'] . '"', ',';
            echo '"' . $user_name . '"', PHP_EOL;
        }
    }


}

