<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Wishlist extends Controller
{

    public function action_add()
    {
        if (!($customer_id = Customer::logged_in()))
        {
            Message::set(__('need_log_in'), 'notice');
            Request::instance()->redirect(LANGPATH . '/customer/login?redirect=' . URL::current(TRUE));
        }
        
        $return = Arr::get($_GET, 'return', '');
        if($return == 'cart')
        {
            $key = $this->request->param('id');
            $cart_product = Cart::product($key);
            Cart::delete($key);
            $product = Product::instance($cart_product['id'])->get();
           // DB::delete('cartcookies')->where('customer_id', '=', $customer_id)->and_where('key', '=', $key)->execute();//cartcookie
            DB::delete('carts_cartitem')->where('customer_id', '=', $customer_id)->and_where('item_id', '=', $cart_product['id'])->and_where('key', '=', $cart_product['attributes']['Size'])->execute();//cartcookie
        }
        else
        {
            $product = Product::instance($this->request->param('id'))->get();
        }

        $data = array();
        $data['site_id'] = Site::instance()->get('id');
        $data['customer_id'] = $customer_id;
        $data['product_id'] = $product['id'];
        $data['created'] = time();
		//获取产品 link1
		$link = DB::query(Database::SELECT, 'select link FROM products_product where id = "'.$product['id'].'"')->execute()->current();
        if (Wishlist::set($data))
        {
            message::set(__('wishlist_add_success'));
            if($return == 'cart')
            {
                $this->request->redirect(LANGPATH . '/cart/view');
            }
            else
            {
                $this->request->redirect(LANGPATH . '/product/'.$link['link'].'_p'.$product['id']);
            }
        }
        else
        {
            message::set(__('wishlist_add_error'), 'error');
            Request::instance()->redirect(URL::current(TRUE));
        }
    }

    public function action_delete()
    {
        $id = $this->request->param('id');
        if (!($customer_id = Customer::logged_in()))
        {
            Message::set(__('need_log_in'), 'notice');
            Request::instance()->redirect(LANGPATH . '/customer/login?redirect=' . URL::current(TRUE));
        }
        $customer = Customer::instance($customer_id)->get();

        if (Wishlist::instance($id)->delete())
        {
            message::set(__('wishlist_delete_success'));
            $this->request->redirect(LANGPATH . '/customer/wishlist');
        }
        else
        {
            message::set(__('wishlist_delete_error'), 'error');
            $this->request->redirect(LANGPATH . '/customer/wishlist');
        }
    }
    
    public function action_add_more()
    {
        if (!($customer_id = Customer::logged_in()))
        {
            Message::set(__('need_log_in'), 'notice');
            Request::instance()->redirect(LANGPATH . '/customer/login?redirect=' . URL::current(TRUE));
        }
        
        $ids = $this->request->param('id');
        if($ids)
        {
            $site_id = Site::instance()->get('id');
            $idArr = explode('-', $ids);
            foreach($idArr as $id)
            {
                $data = array();
                $data['site_id'] = $site_id;
                $data['customer_id'] = $customer_id;
                $data['product_id'] = (int) $id;
                $data['created'] = time();
                Wishlist::set($data);
            }
        }
        message::set(__('wishlist_add_success'));
        $this->request->redirect(LANGPATH . '/customer/wishlist');
    }

    //cartcookie
    public function action_cookie_add()
    {
        if (!($customer_id = Customer::logged_in())){
            Message::set(__('need_log_in'), 'notice');
            Request::instance()->redirect(LANGPATH . '/customer/login?redirect=' . URL::current(TRUE));
        }
        $return = Arr::get($_GET, 'return', '');
        $data = array();
        $data['site_id'] = Site::instance()->get('id');
        if($return == 'cart'){
            $key = $this->request->param('id');
            $cookie_date = DB::select('data')
                ->from('cartcookies')
                ->where('site_id', '=', $data['site_id'])
                ->where('customer_id','=',$customer_id)
                ->where('key','=',$key)
                ->execute()->current();
            $c_product = unserialize($cookie_date['data']);
            if(count($cookie_date)>0){
                $product = Product::instance($c_product['id'])->get();
                DB::delete('cartcookies')->where('customer_id', '=', $customer_id)->and_where('key', '=', $key)->execute();
            }else{
                message::set(__('wishlist_add_error'), 'error');
                Request::instance()->redirect(LANGPATH . '/cart/view');
            }
        }else{
            $product = Product::instance($this->request->param('id'))->get();
        }
        $data['customer_id'] = $customer_id;
        $data['product_id'] = $product['id'];
        $data['created'] = time();
        if (Wishlist::set($data)){
            message::set(__('wishlist_add_success'));
            if($return == 'cart'){
                $this->request->redirect(LANGPATH . '/cart/view');
            }else{
                $this->request->redirect(LANGPATH . '/customer/wishlist');
            }
        }else{
            message::set(__('wishlist_add_error'), 'error');
            Request::instance()->redirect(URL::current(TRUE));
        }
    }

    public function action_ajax_add()
    {
        $return = array();
        if (!($customer_id = Customer::logged_in()))
        {
            $return['success'] = 0;
            $return['message'] = __('need_log_in');
        }
        else
        {
			
            $product_id = Arr::get($_REQUEST, 'product_id');
            if(!$product_id){
                $return['success'] = 0;
                $return['message'] = __('wishlist_add_error');   
                echo json_encode($return);
                exit;             
            }
			$id = DB::query(Database::SELECT, 'select id FROM accounts_wishlists where customer_id = "'.$customer_id.'" and product_id="'.$product_id.'"')->execute()->get('id');
			if(!$id){
				$data = array();
            $data['site_id'] = Site::instance()->get('id');
            $data['customer_id'] = $customer_id;
            $data['product_id'] = $product_id;
            $data['created'] = time();
			
            if (Wishlist::set($data))
            {
                $keywishlists = 'site_wishlist/'.$product_id;
                $cache = Cache::instance('memcache');
                $wishlists = $cache->get($keywishlists);
                //设置点击后的数量
                $return['success'] = 1;
                $return['message'] = __('wishlist_add_success');
                $return['wishlists'] = $wishlists;
                $return['firstname'] = Customer::instance($customer_id)->get('firstname');
            }
            else
            {
                $return['success'] = 0;
                $return['message'] = __('wishlist_add_error');
            }
			}else{
				$return['success'] = -1;
				$return['message'] = __('wishlist_add_success');//分类用户没登陆收藏提示
			}
            
        }
        echo json_encode($return);
        exit;
    }

}