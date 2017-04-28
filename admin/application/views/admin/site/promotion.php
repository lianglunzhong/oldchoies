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
                                    'current_page' => array('source'        => 'query_string', 'key'           => 'page'),
                                    'total_items'   => $count,
                                    'item_per_page' => 40,
                                    'view'          => 'pagination/basic',
                                    'auto_hide'     => 'FALSE',
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
                                    'current_page' => array('source'                         => 'query_string', 'key'                            => 'page'),
                                    'total_items'                    => $count,
                                    'item_per_page'                  => 40,
                                    'view'                           => 'pagination/basic',
                                    'auto_hide'                      => 'FALSE',
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

                $count = ORM::factory('coupon')
                        ->where('site_id', '=', $this->site_id);
                if ($q)
                        $count->where('code', 'like', "%$q%");

                $count = $count->count_all();

                $pagination = Pagination::factory(
                                array(
                                    'current_page' => array('source'         => 'query_string', 'key'            => 'page'),
                                    'total_items'    => $count,
                                    'items_per_page' => 50,
                                    'view'           => 'pagination/basic',
                                    'auto_hide'      => TRUE,
                                )
                );

                $page_view = $pagination->render();

                $data = ORM::factory('coupon')
                        ->where('site_id', '=', $this->site_id)
                        ->offset($pagination->offset)
                        ->limit($pagination->items_per_page)
                        ->order_by('id', 'DESC');
                if ($q)
                        $data->where('code', 'like', "%$q%");

                $data = $data->find_all();

                $content = View::factory('admin/site/promotion_coupon_list')
                        ->set('data', $data)
                        ->set('page_view', $page_view)
                        ->set('q', $q)
                        ->render();

                $this->request->response = View::factory('admin/template')
                        ->set('content', $content)
                        ->render();
        }

        public function action_coupon_add()
        {
                $content = View::factory('admin/site/promotion_coupon_add')->render();
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
                        $data['condition'] = Arr::get($_POST, 'condition', 0);
                        $data['catalog_limit'] = Arr::get($_POST, 'catalog_limit', '');
                        $data['product_limit'] = Arr::get($_POST, 'product_limit', '');
                        $data['effective_limit'] = Arr::get($_POST, 'effective_limit', '-1');

                        $data['created'] = strtotime(Arr::get($_POST, 'coupon_created', date('d/m/Y')));
                        $data['expired'] = strtotime(Arr::get($_POST, 'coupon_expired', date('d/m/Y', strtotime('+1 month'))));

                        $exists = Coupon::instance($data['code'])->get('id');
                        if ($exists)
                        {
                                message::set('该折扣号已经存在，请重新输入折扣号', 'error');
                                Request::instance()->redirect('/admin/site/promotion/coupon_add');
                        }
                        
                        //add on_show, customer_id
                        if(isset($_POST['on_show']) AND $_POST['on_show'] == 'on')
                                $data['on_show'] = 1;

                        $rs = Coupon::instance()->add($data);
                        if ($rs)
                        {
                                $emails = Arr::get($_POST, 'emails', '');
                                if($emails)
                                {
                                        $coupon_id = $rs;
                                        $emailArr = explode("\n", $emails);
                                        foreach($emailArr as $email)
                                        {
                                                $customer_id = Customer::instance()->is_register(trim($email));
                                                $insert = array(
                                                    'customer_id' => $customer_id,
                                                    'coupon_id' => $coupon_id,
                                                    'site_id' => $this->site_id
                                                );
                                                DB::insert('carts_customercoupons', array_keys($insert))->values($insert)->execute();
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
                $content = View::factory('admin/site/promotion_coupon_edit')->set('coupon', $coupon)->render();
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
                        $coupon->condition = Arr::get($_POST, 'condition', 0);
                        $coupon->catalog_limit = Arr::get($_POST, 'catalog_limit', '');
                        $coupon->product_limit = Arr::get($_POST, 'product_limit', '');
                        $coupon->effective_limit = Arr::get($_POST, 'effective_limit', '-1');
                        $coupon->created = strtotime(Arr::get($_POST, 'coupon_created', date('d/m/Y')));
                        $coupon->expired = strtotime(Arr::get($_POST, 'coupon_expired', date('d/m/Y', strtotime('+1 month'))));
                        
                        //add on_show, customer_id
                        if(isset($_POST['on_show']) AND $_POST['on_show'] == 'on')
                                $coupon->on_show = 1;
                        else
                                $coupon->on_show = 0;
                        
                        $coupon->save();

                        if ($coupon->saved() == true)
                        {
                                $emails = Arr::get($_POST, 'emails', '');
                                if($emails)
                                {
                                        $emailArr = explode("\n", $emails);
                                        foreach($emailArr as $email)
                                        {
                                                $customer_id = Customer::instance()->is_register(trim($email));
                                                if ($customer_id)
                                                {
                                                        $has = DB::select('id')->from('carts_customercoupons')
                                                                        ->where('site_id', '=', $this->site_id)
                                                                        ->and_where('coupon_id', '=', $coupon_id)
                                                                        ->and_where('customer_id', '=', $customer_id)
                                                                        ->execute()->get('id');
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
                        message::set('删除折扣号成功');
                }
                else
                {
                        message::set('删除折扣号失败', 'error');
                }

                $this->request->redirect('/admin/site/promotion/coupon_list');
        }

        public function action_new_product()
        {
                $content = View::factory('admin/site/promotion_new_product');
                $this->request->response = View::factory('admin/template')->set('content', $content)->render();
        }
        
        public function action_new_relate()
        {
                if($_POST)
                {
                        $catalog_id = DB::select('id')->from('products_category')->where('link', '=', 'new-product')->execute('slave')->get('id');
                        $today = time();
                        $_2Weekslater = $today - 1209600; //两周前
                        $new_products = DB::query(Database::SELECT, 'SELECT id FROM products WHERE visibility = 1 AND created >= '.$_2Weekslater . ' AND created < '.$today)->execute('slave');
                        $products = array( );
                        foreach($new_products as $idx => $p)
                        {
                                DB::insert('catalog_products', array('catalog_id', 'product_id', 'position'))
                                        ->values(array($catalog_id, $p['id'], $idx))
                                        ->execute();
                        }
                        Message::set('Relate new product Success!');
                }
                $this->request->redirect('/admin/site/promotion/new_product');
        }
        
        public function action_new_delete()
        {
                if($_POST)
                {
                        $catalog_id = DB::select('id')->from('products_category')->where('link', '=', 'new-product')->execute('slave')->get('id');
                        $result = DB::delete('catalog_products')->where('catalog_id', '=', $catalog_id)->execute();
                        if($result)
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
                                if($item->field == 'email')
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
                $count = DB::query(Database::SELECT, 'SELECT count(o.id) AS count FROM carts_customercoupons o LEFT JOIN accounts_customers c ON o.customer_id = c.id 
                                WHERE o.site_id=' . $this->site_id . ' AND o.coupon_id = ' . $coupon_id . $filter_sql)
                                ->execute()->get('count');
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
                                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute();

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
                if($id)
                {
                        $coupon_id = DB::select('coupon_id')->from('carts_customercoupons')->where('id', '=', $id)->execute()->get('coupon_id');
                        $delete = DB::delete('carts_customercoupons')->where('id', '=', $id)->execute();
                        if($delete)
                                Message::set('Delete coupon customer Success!');
                        else
                                Message::set('Delete coupon customer Failed!');
                }
                Request::instance()->redirect('/admin/site/promotion/coupon_edit/' . $coupon_id);
        }
}

