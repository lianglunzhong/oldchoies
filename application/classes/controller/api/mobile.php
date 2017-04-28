<?php
defined('SYSPATH') or die('No direct script access.');
class Controller_Api_Mobile extends Controller_Webpage
{
	/**
	 * 
	 * 注册新用户，提交firstName，lastName，email，password， 
	 *	服务器端返回处理结果，返回对象里面包含token，msg， 
	 *	如果token为空，注册失败，msg为错误信息， 
	 *	如果成功，后续操作带上token即可。
	 *	返回对象为ReturnMessageType
	 */
	public function action_regUser(){
		$return = new com_cofreeonline_services_ReturnMessageType();
				
			$data = array( );
			$data['email'] = Arr::get($_REQUEST, 'email', '');       // email
			$data['firstname'] = Arr::get($_REQUEST, 'fname', '');   //fname
			$data['lastname'] = Arr::get($_REQUEST, 'lname', '');   //lname
			$data['password'] = Arr::get($_REQUEST, 'pwd', '');	     //	pwd	
			if( ! Customer::instance()->is_register($data['email']))
			{	
				if($customer_id = Customer::instance()->set($data))
				{
					$result = $this->login($data['email'], $data['password']);
					if($result!="F"){
						$return->retCode='S';
						$return->token = $result;						
					}else{
						$return->retCode='F';
						$return->msg="Login Failed!";
					}				
				}				
				
			}else{
				$return->retCode='F';
				$return->msg="User email already exists,please choose another email!";
			}
		
		echo json_encode($return);
	}
	/**
	 * 
	 * 用户登录，返回对象跟regUser接口一致
	 */
	public function action_loginUser(){
		
		$return = new com_cofreeonline_services_ReturnMessageType();
		if($_REQUEST){
			$data = array( );
			$data['email'] = Arr::get($_REQUEST, 'email', '');  //email
			$data['password'] = Arr::get($_REQUEST, 'pwd', '');
			
			$result = $this->login($data['email'], $data['password']);
			if($result!="F"){
				$return->retCode='S';
				$return->token = $result;						
			}else{
				$return->retCode='F';
				$return->msg="Login Failed!";
			}
		}else{
			$return->retCode='F';
			$return->msg="Request does not contain any information, please check!";
		}
		echo json_encode($return);
	}
	
	/**
	 * 
	 * 用户登录，返回对象跟regUser接口一致
	 */
	public function action_changePaymentStatus(){
		
		$return = new com_cofreeonline_services_ReturnMessageType();
		if($_REQUEST){
			$data = array();
			$data['token'] = Arr::get($_REQUEST, 'token', '');
			$data['trackingNo'] = Arr::get($_REQUEST, 'trackingNo', '');
			$data['orderId'] = Arr::get($_REQUEST, 'orderId', '');
			$data['status'] =  Arr::get($_REQUEST, 'status', '');
			$order = Order::instance($data['orderId']);
			
			if($result!="F"){
				$return->retCode='S';
				$return->token = $result;						
			}else{
				$return->retCode='F';
				$return->msg="Login Failed!";
			}
		}else{
			$return->retCode='F';
			$return->msg="Request does not contain any information, please check!";
		}
		echo json_encode($return);
	}
	/**
	 * 
	 * 返回最新的10或者20个产品， 
	 * 产品信息包括列表使用的信息， 
	 * 包括产品id， 
	 * sku，主图链接，价格，title，简单desc等
	 * 返回对象为ProductListResultType
	 */
	public function action_listNewArrivals(){
		$offset = arr::get($_REQUEST, "offset");
		$limit = arr::get($_REQUEST, "limit");		
		$currency=  arr::get($_REQUEST, "currency");
		$orderby="created";
		$desc="desc";
		$catalog = Catalog::instance()->loadByLink("new-arrivals");
		echo $this->getProductsByCatalog($catalog,$offset,$limit,$orderby,$desc,$currency);
	}
	/**
	 * 
	 * 取得产品的详细信息，title，sku，价格，描述，图片数组 等
	 */
	public function action_getProductDetail(){
		$data = Product::instance(Arr::get($_REQUEST, 'pid', ''));
		$currency = Arr::get($_REQUEST, 'currency', '');
		$result = new com_cofreeonline_services_ProductDetailType();
		if($data->get("id")==null){
			$result->retCode="F";
			$result->msg="This Product does not exist!";
			echo json_encode($result)	;
			exit;
		}
		$images = $data->images();
		
		$result->detail_desc = $data->get('description');
		$result->freeshipping = $data->get('freeshipping');
		$result->id=$data->get('id');
		$arrayConfig = $data->get('configs');
		$arrayPics=  array();
		foreach ($images as $value) {
			$arrayPics[]=$value['id'];
		}
		if(is_array($arrayConfig) AND isset($arrayConfig['default_image']) AND $arrayConfig['default_image'] != '')
        {
        	
        	$result->main_img_url=$arrayConfig['default_image'];
        }else{
        	$result->main_img_url = $images[0]["id"];
        }
        $result->name = $data->get("name");
        if(isset($currency)){
        	$result->price = Site::instance()->price($data->price(),'code_view',null,Site::instance()->currency_get($currency)) ;
        }else{
        	$result->price =$data->price();
        }
        
		$rules = $arrayConfig['bulk_rules'];    //$rules = $this->data['configs']['bulk_rules'];
		$close_num = 0;
		$_rules = array();
		foreach($rules as $bulk_num=>$bulk_price)
		{
			$_rule = new com_cofreeonline_services_PriceRuleType();
			$_rule->qty=$bulk_num;
			if(isset($currency)){
	        	$_rule->price = Site::instance()->price($data->price($bulk_num),'code_view',null,Site::instance()->currency_get($currency)) ;
	        }else{
	        	$_rule->price = $data->price($bulk_num);
	        }
			$_rules[]=$_rule;        
		}
		$result->pricerule = $_rules;
				
        $result->short_desc = $data->get('brief');
        $result->sku=$data->get('sku');
        $result->pics=$arrayPics;
        $result->retCode="S";
        echo json_encode($result)	;
	}
	/**
	 * 
	 * 获取商品评论内容，review对象包含postby，postDate， 
	 * 评论星级，详细内容
	 * 返回对象为ProductReviewResultType
	 */
	public function action_listReviews(){
		$offset = arr::get($_REQUEST, "offset");
		$limit = arr::get($_REQUEST, "limit");
		$orderby = arr::get($_REQUEST, "orderby");
		$desc = arr::get($_REQUEST, "desc");
		$product_id = Arr::get($_REQUEST, 'pid');	
		echo $this->getReviews($product_id,$offset, $limit, $orderby,$desc);
	}
	
	/**
	 * 
	 * 获取周销售排行产品列表
	 */
	public function action_listWeeklyGadgets(){
		$offset = arr::get($_REQUEST, "offset");
		$limit = arr::get($_REQUEST, "limit");
		$orderby = arr::get($_REQUEST, "orderby",null);
		$desc = arr::get($_REQUEST, "desc",null);
		if($orderby ==null)$orderby='created';
		if($desc==null)$desc='desc';
		$currency=  arr::get($_REQUEST, "currency");
		$catalog = Catalog::instance()->loadByLink("weekly-gadgets");
		echo $this->getProductsByCatalog($catalog,$offset,$limit,$orderby,$desc,$currency);		
	}
	/**
	 * 
	 * 获取分类结构
	 */
	public function action_listCategories(){
		$result = new com_cofreeonline_services_CategoriesResultType();
		$catalog = Catalog::instance()->catalog_tree(Arr::get($_REQUEST, 'parentCategoryId', 0));
		$arrdata = array( );
		if(!is_array($catalog)){
			$result->retCode='F';
			$result->msg='No category founded';
			echo json_encode($result);
			return;
		}
		foreach ($catalog as $item) {
			if($item['on_menu']=='1'){
				$data = new com_cofreeonline_services_CategoryType();
				$data->iconLink = $item['image_link'];
				$data->id=$item['id'];
				$data->name=$item['name'];
				$data->parentId=$item['parent_id'];
				$arrdata[] = $data;
			}
		}
		$result->data = $arrdata;
		$result->retCode='S';
		echo json_encode($result);
	}
	/**
	 * 
	 * 根据分类获取产品
	 */
	public function action_listProducts(){
		$offset = arr::get($_REQUEST, "offset");
		$limit = arr::get($_REQUEST, "limit");
		$orderby = arr::get($_REQUEST, "orderby",null);
		$desc = arr::get($_REQUEST, "desc",null);
		if($orderby ==null)$orderby='created';
		if($desc==null)$desc='desc';
		$category_id = Arr::get($_REQUEST, 'cid');		
		$currency = Arr::get($_REQUEST, 'currency');		
		$catalog = Catalog::instance($category_id);			
		echo $this->getProductsByCatalog($catalog,$offset,$limit,$orderby,$desc,$currency);		
	}
	/**
	 * 
	 * 全文搜索产品
	 */
	public function action_searchProducts(){
		$offset = arr::get($_REQUEST, "offset");
		$limit = arr::get($_REQUEST, "limit");
		$orderby = arr::get($_REQUEST, "orderby");
		$desc = arr::get($_REQUEST, "desc");
		$keywords = Arr::get($_REQUEST, 'keywords');
		$currency = Arr::get($_REQUEST, 'currency');
		$keywords =  str_replace(" "," +",$keywords);
		echo $this->searchProducts($keywords, $offset,$limit,$orderby,$desc,$currency);
	}
	
	/**
	 * 
	 * 获取当前用户的地址信息
	 */
	public function action_listAddresses(){
		$result = new com_cofreeonline_services_AddressResultType();
		$token = Arr::get($_REQUEST, 'token');
		$session= Apisession::instance()->getSessionByToken($token);
		if($session==null){
			$result->retCode="F";
			$result->msg="User has not logged in!";
			echo json_encode($result);
			return;
		}
		$arrayData = Customer::instance($session['user_id'])->addresses();
		$arrayAddress = array();
		if(!is_array($arrayData)){
			$result->retCode="F";
			$result->msg="No addresses founded for current user!";
			echo json_encode($result);
			return;
		}
		foreach ($arrayData as $value) {
			$item = new com_cofreeonline_services_AddressType();
			
			$item->address = $value['address'];
			$item->city= $value['city'];
			$item->country= $value['country'];
			$item->fname= $value['firstname'];
			$item->lname= $value['lastname'];
			$item->mobile= $value['phone'];
			$item->phone= $value['phone'];
			$item->state= $value['state'];
			$item->zip= $value['zip'];
			$item->id = $value['id'];
			$item->customerid = $value['customer_id'];
			$item->otherphone= $value['other_phone'];			
			$arrayAddress[] = $item;
		}
		$result->data = $arrayAddress;
		$result->retCode="S";
		echo json_encode($result);
	}
	
	public function action_payCart(){
		$session = Apisession::instance()->getSessionByToken(Arr::get($_REQUEST, 'token', ''));
		$_oldOrder = json_decode(Arr::get($_REQUEST, 'data', ''));
		if($session==null){
			$_oldOrder->retCode="F";
			$_oldOrder->msg="User has not logged in!";
			echo json_encode($_oldOrder);
			return;
		}
		Cart::clear();
		$customer = Customer::instance($session['user_id']);
		$data = array( );
		$data['id'] = $customer->get('id');
		$data['email'] = $customer->get('email');
		$data['firstname'] = $customer->get('firstname');
		$data['lastname'] = $customer->get('lastname');
		Session::instance()->set("user", $data);
//		Site::instance()->currency_set($_oldOrder->currency);  //++++++++++
		$this->addToCart($_oldOrder);
		$_oldOrder = $this->cartToObject($_oldOrder,$_oldOrder->currencyCode);
		//create a order
//		print_r(Cart::get());exit;
		Site::instance()->currency_set($_oldOrder->currencyCode);  //++++++++++
		$order = Request::factory('order/set')->execute()->response;
		$_oldOrder->orderNumber = $order->get("ordernum");
		$_oldOrder->id = $order->get("id");
		$_oldOrder->customerId = $order->get("customer_id");
		echo json_encode($_oldOrder);
	}
	public function action_addToCart(){	
		$_oldOrder = json_decode(Arr::get($_REQUEST, 'data', ''));
		$_token = Arr::get($_REQUEST, 'token', '');
		if(strlen($_token)>0){
			$session = Apisession::instance()->getSessionByToken($_token);	
			$customer = Customer::instance($session['user_id']);
			$data = array( );
			$data['id'] = $customer->get('id');
			$data['email'] = $customer->get('email');
			$data['firstname'] = $customer->get('firstname');
			$data['lastname'] = $customer->get('lastname');
			Session::instance()->set("user", $data);
		}
		Cart::clear();
		$this->addToCart($_oldOrder);
		$_oldOrder = $this->cartToObject($_oldOrder,$_oldOrder->currencyCode);		
		echo json_encode($_oldOrder);
	}
	public function action_listOrders(){
		$session = Apisession::instance()->getSessionByToken(Arr::get($_REQUEST, 'token', ''));
		$customer =  Customer::instance($session['user_id']);
		$orders = $customer->orders();
		$arrayData = array();
		$result = new com_cofreeonline_services_OrderListResultType();
		if($session==null){
			$result->retCode="F";
			$result->msg="User has not logged in!";
			echo json_encode($result);
			return;
		}
		if(!is_array($orders)){
			$result->retCode="F";
			$result->msg="No Orders founded!";
			echo json_encode($result);
			return;
		}
		foreach ($orders as $value) {
			$data = new com_cofreeonline_services_OrderListType();
			
	        $data->amount = Site::instance()->price($value['amount'],'code_view', $value['currency'],Site::instance()->currency_get($value['currency']));
	        //$data->amount = $value['amount'];

			$data->id=$value['id'];
			$data->orderNumber=$value['ordernum'];
			$data->payment_status=$value['payment_status'];
			$data->shipping_status=$value['shipping_status'];
			$arrayData[] = $data;
		}
		$result->data = $arrayData;
		$result->retCode="S";
		echo json_encode($result);
	}
	
	public function action_getOrderDetail(){
		$order = Order::instance(Arr::get($_REQUEST, 'id'));
		echo json_encode(self::orderToObject($order));
	}
	
	public function action_resetPassword(){
		$result = new com_cofreeonline_services_ReturnMessageType();
		$string = Arr::get($_REQUEST, 'token', '');
		$pwd = Arr::get($_REQUEST, 'pwd', '');
		$array = explode('-', $string);
		$token = $array[0];
		$customer_id = $array[1];
		$return = Customer::instance($customer_id)->check_token($customer_id, $token);
		if($return)
		{
				if(Customer::instance($customer_id)->update_password($pwd))
				{
					Customer::instance($customer_id)->login_action();
					Customer::instance()->delete_token($customer_id, $token);
					$result->retCode="S";
					$result->msg="Update user password successfully!";
					echo json_encode($result);
					return;
				}
				else
				{
					$result->retCode="F";
					$result->msg="Update user password failed!";
					echo json_encode($result);
					return;
				}			
		}
		else
		{
			$result->retCode="F";
			$result->msg="Token is not correct,please check!";
			echo json_encode($result);
			return;
		}
		
	}
	public function action_changePassword(){		
		$result = new com_cofreeonline_services_ReturnMessageType();
		$session = Apisession::instance()->getSessionByToken(Arr::get($_REQUEST, 'token', ''));
		if($session==null){
			$result->retCode="F";
			$result->msg="User has not logged in!";
			echo json_encode($result);
			return;
		}
		$password = Arr::get($_REQUEST, 'pwd', '');
		Customer::instance($session['user_id'])->update_password($password);
		$result->retCode="S";
		$result->msg="User password has been changed!";
		echo json_encode($result);
	}
	public function action_forgetPassword(){
		$result = new com_cofreeonline_services_ReturnMessageType();
		$email = Arr::get($_REQUEST, 'email', '');
		if($customer_id = Customer::instance()->is_register($email))
		{
			$customer = Customer::instance($customer_id)->login_action();
			$token = Customer::instance($customer_id)->reset_password_token();
			$string = $token."-".$customer_id;
			$mail_params['new_password'] = "<a href='".BASEURL."/customer/reset_password?token=".$string."'>".BASEURL."/customer/reset_password?token={$string}</a>";
			$mail_params['firstname'] = Customer::instance($customer_id)->get('firstname');
			$mail_params['email'] = Customer::instance($customer_id)->get('email');
			
            Mail::SendTemplateMail('FOGETPASSWORD', $mail_params['email'], $mail_params);
			$result->retCode='S';	
			$result->msg='An email has been sent to your address,please check!';					
		}
		else
		{
			$result->retCode='F';
			$result->msg="no such user found";				
		}
		echo json_encode($result);
	}
	public function action_addAddress(){
		$result = new com_cofreeonline_services_ReturnMessageType();
		$obj = json_decode(Arr::get($_REQUEST, 'data'));
		$session = Apisession::instance()->getSessionByToken(Arr::get($_REQUEST, 'token', ''));
		if($session==null){
			$result->retCode="F";
			$result->msg="User has not logged in!";
			echo json_encode($result);
			return;
		}
		$data = self::objectToArray($obj);
		$data['customer_id'] = $session['user_id'];
		if(Address::instance()->set($data)){
			$result->retCode='S';
			$result->msg="Address success added";
		}else{
			$result->retCode='F';
			$result->msg="Address add failed ";
		}
		echo json_encode($result);
	}
	
	public function action_updateAddress(){
		$result = new com_cofreeonline_services_ReturnMessageType();
		$session = Apisession::instance()->getSessionByToken(Arr::get($_REQUEST, 'token', ''));
		if($session==null){
			$result->retCode="F";
			$result->msg="User has not logged in!";
			echo json_encode($result);
			return;
		}
		$obj = json_decode(Arr::get($_REQUEST, 'data'));
		$data = self::objectToArray($obj);
		$data['customer_id'] = $session['user_id'];		
		if(Address::instance($obj->id)->set($data)){
			$result->retCode='S';
			$result->msg="Address success updated";
		}else{
			$result->retCode='F';
			$result->msg="Address updated failed ";
		}
		echo json_encode($result);
	}
	
	public function action_deleteAddress(){
		$result = new com_cofreeonline_services_ReturnMessageType();
		$id = Arr::get($_REQUEST, 'id');
		 
		if(Address::instance($id)->delete()){
			$result->retCode='S';
			$result->msg="Address success deleted";
		}else{
			$result->retCode='F';
			$result->msg="Address delete failed";
		}
		echo json_encode($result);
	}
	public function action_getPaypalId(){
		$result = new com_cofreeonline_services_ReturnMessageType();
		$site = Site::instance();
		if($site){
			$result->retCode='S';
			$result->msg=$site->get("pp_payment_id");;
		}else{
			$result->retCode='F';
			$result->msg="failed getting Paypal ID! ";
		}
		echo json_encode($result);
	}
	public function action_paypalPay(){
		$result = new com_cofreeonline_services_ReturnMessageType();
		$session = Apisession::instance()->getSessionByToken(Arr::get($_REQUEST, 'token', ''));
		if($session==null){
			$result->retCode="F";
			$result->msg="User has not logged in!";
			echo json_encode($result);
			return;
		}
		$order_id = Arr::get($_REQUEST,'oid',NULL);	
		$order = Order::instance($order_id)->get();
		$data = json_decode(Arr::get($_REQUEST, 'data', ''),true);
		
		$message = Payment::instance('PPM')->pay($order, $data);
		
		if($message!=null&&$message=='SUCCESS'){
			$result->retCode='S';
			$result->msg="Order Payment has been updated";
		}else{
			$result->retCode='F';
			$result->msg="Order payment status update failed";
		}
		echo json_encode($result);
	}
	
	public function action_creditcardPay(){
		$result = new com_cofreeonline_services_ReturnMessageType();
		$session = Apisession::instance()->getSessionByToken(Arr::get($_REQUEST, 'token', ''));
		if($session==null){
			$result->retCode="F";
			$result->msg="User has not logged in!";
			echo json_encode($result);
			return;
		}
		$order_id = Arr::get($_REQUEST,'oid',NULL);	
		$order = Order::instance($order_id)->get();
		$message = Payment::instance('CC')->pay($order, $data);		
		if($message!=null&&$message=='SUCCESS'){
			$result->retCode='S';
			$result->msg="Order Payment has been updated";
		}else{
			$result->retCode='F';
			$result->msg="Order payment status update failed";
		}
		echo json_encode($result);
	}
	public function action_postReview(){
		$result = new com_cofreeonline_services_ReturnMessageType();
		 $product_id = Arr::get($_REQUEST,'pid',NULL);		 
		 $session = Apisession::instance()->getSessionByToken(Arr::get($_REQUEST,'token',NULL));
		if($session==null){
			$result->retCode="F";
			$result->msg="User has not logged in!";
			echo json_encode($result);
			return;
		}
		 $user_id = $session['user_id'];
		 $_obj = json_decode(Arr::get($_REQUEST,'data',NULL));
		 $data = array();
		 $data['product_id']=	$product_id;
		 $data['user_id'] = $user_id;
		 $data['grade'] = $_obj->star;
		 $data['content']=$_obj->content;
		 $review_re = Review::instance($product_id)->set($data);
		 
		 if(is_int($review_re))
         {
            $result->retCode='S';
             $result->msg = 'review add success';
         	
         }else{
             $result->retCode='F';
             $result->msg = 'review add failed';
         }
         echo json_encode($result);
	}
	
	public function action_listCarriers(){
		$_oldOrder = json_decode(Arr::get($_REQUEST, 'data', ''));		
		$_token = Arr::get($_REQUEST, 'token', '');
		$iso = Arr::get($_REQUEST,'country');    
		if(strlen($_token)>0){
			$session = Apisession::instance()->getSessionByToken($_token);	
			$customer = Customer::instance($session['user_id']);
			$data = array( );
			$data['id'] = $customer->get('id');
			$data['email'] = $customer->get('email');
			$data['firstname'] = $customer->get('firstname');
			$data['lastname'] = $customer->get('lastname');
			Session::instance()->set("user", $data);
		}
		Cart::clear();
		$cart = $this->addToCart($_oldOrder);    //++++++++++++
		
		$_carriers = Site::instance()->carriers();
		$result = new com_cofreeonline_services_CarriesResultType();
		if(!is_array($_carriers)){
			$result->retCode='F';
			$result->msg='No carriers founded';
			echo json_encode($result);
			return;
		}
		
		$carriers = Site::instance()->carriers($iso);
		$cart = Cart::get();
	
		$carrier_param = array(
			'weight' => '',
			'shipping_address' => '',
			'amount' => array( )
		);
		$carrier_param['weight'] =  $cart['weight'];
		$carrier_param['amount'] = $cart['amount'];

		foreach( $carriers as $key => $carrier )
		{
			$carrier_shipping_address['country'] = $iso;
			$carrier_param['shipping_address'] = $carrier_shipping_address;
			$carrier_price = Carrier::instance($carrier['id'])->get_price($carrier_param);
			if($carrier_price !== FALSE)
			{
				$carriers[$key]['price'] = Site::instance()->price($carrier_price, 'code_view');
			}
			else
			{
				unset($carriers[$key]);
			}
		}
		$data = array();
		foreach ($_carriers as $key => $value) {
			
								
			if($value['carrier'] =='HKPT-Free-for-15' ){				
				continue;
			}
			
							
			if($cart['amount']['total'] >= 30 ){				
				if($value['carrier'] =='HKPF')continue;
				$row = new com_cofreeonline_services_CarrierType();		
				$row->name = $value['carrier_name'];
				$row->id = $value['id'];			
				$row->price = $carriers[$key]['price'] ;
				$row->carrier = $value['carrier'];
				if($value['carrier']=='HKPT'){
					$row->carrier ='HKPT-Free-for-15';
					$row->price =0;
				}								
			}else{
				$row = new com_cofreeonline_services_CarrierType();		
				$row->name = $value['carrier_name'];
				$row->id = $value['id'];			
				$row->price = $carriers[$key]['price'] ;
				$row->carrier = $value['carrier'];
			}			 			                      
			$data[]=$row;
		}
		$result->retCode='S';
		$result->data=$data;
		echo json_encode($result);
	}
	
	public function action_getUserProfile(){
		$result = new com_cofreeonline_services_UserProfileType();
		$session = Apisession::instance()->getSessionByToken(Arr::get($_REQUEST, 'token', ''));
		if($session==null){
			$result->retCode="F";
			$result->msg="User has not logged in!";
			echo json_encode($result);
			return;
		}
		$cutomer = Customer::instance($session['user_id']);
		$result->birthday = date('Ymd',$cutomer->get('birthday'));
		$result->country=$cutomer->get('country');
		$result->email=$cutomer->get('email');
		$result->fname=$cutomer->get('firstname');
		$result->lname=$cutomer->get('lastname');
		$result->gender=$cutomer->get('gender');
		$result->password = $cutomer->get('password');
		$result->retCode="S";
		$result->msg="User has update!"; 
		echo json_encode($result);
	}
	
	public function action_updateUserProfile(){
		$result = new com_cofreeonline_services_ReturnMessageType();
		$_newProfile = json_decode(Arr::get($_REQUEST, 'data', ''),true);
		$session = Apisession::instance()->getSessionByToken(Arr::get($_REQUEST, 'token', ''));
	if($session==null){
			$result->retCode="F";
			$result->msg="User has not logged in!";
			echo json_encode($result);
			return;
		}
		$cutomer = Customer::instance($session['user_id']);
		$data = array();
		
		$data['email'] = $_newProfile['email'];
		$data['firstname'] = $_newProfile['fname'];
		$data['lastname'] = $_newProfile['lname'];
		$data['birthday'] = strtotime($_newProfile['birthday']);
//		$data['birthday'] = date('Ymd',strtotime($_newProfile['birthday']));//strtotime($_newProfile['birthday'])
		$data['gender'] = $_newProfile['gender'];
		$data['country'] = $_newProfile['country'];
		$cutomer->profile($data);
		
		$result->retCode="S";
		$result->msg="User Profile Update Success";
		echo json_encode($result);
	}
	
	static function login($email,$password){
		Apisession::instance()->removeExpiredSession();
		
		$item = Apisession::instance()->getSessionByMail($email);
		
//		if($item!=null){
//			
//			return $item['token'];
//		}else{
			
			$data = array();
			$data['email'] = $email;
			$data['password'] = $password;
			$data['hashed'] = null;              //++++++++后增加$data['hashed'] =null;
			if($customer_id = Customer::instance()->login($data))
			{		
					
				$data['user_id'] = $customer_id;
				if($item==null)
				return Apisession::instance()->set($data);
				else return $item['token'];
			}else{
				
				return 'F';
			}
//		}		 
	}
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $_catalog
	 * @param unknown_type $_offset
	 * @param unknown_type $_limit
	 * @param unknown_type $_orderby
	 */
	static function getProductsByCatalog(Catalog $_catalog,$_offset=null,$_limit=null,$_orderby=null,$_desc=null,$_currency=null){	
		$result = new com_cofreeonline_services_ProductListResultType();
		if($_catalog->get("id")==null){
			$result->retCode="F";
			$result->totalCnt=0;
			$result->msg="This catalog does not exits";
			return json_encode($result);
		}	
		$cnt = $_catalog->count_products(null);
		if($cnt==0){
			$result->retCode="F";
			$result->totalCnt=0;
			$result->msg="This catalog does not have any products";
			return json_encode($result);
		}
		if(isset($offset))
		if($offset>=$cnt){
			$result->retCode="F";
			$result->totalCnt=0;
			$result->msg="offset cannot larger than total count";
			return json_encode($result);
		}
		
		$ids = $_catalog->products($_offset,$_limit,$_orderby,$_desc);
		
		$products = DB::select()->from('products_product')->where('id','IN',$ids)->order_by($_orderby,$_desc)->execute();
		
		$images = DB::select('obj_id',array('min("id")', 'mid'))->from('images')->where('obj_id','IN',$ids)->group_by("obj_id")->execute();
		$productImage = array();
		foreach ($images as $item) {
			$productImage[$item['obj_id']] = $item['mid'];
		}
		$arrayProduct= array( );
		foreach ($products as $item) {
			$data = new com_cofreeonline_services_ProductListType();
			$data->freeshipping = $item['freeshipping'];
			$data->id = $item['id'];
			
			$arrayConfig  = (($item['configs'] != '') ? unserialize($item['configs']) : '');
			if(is_array($arrayConfig) AND isset($arrayConfig['default_image']) AND $arrayConfig['default_image'] != '')
	        {
	        	$data->main_img_url=$arrayConfig['default_image'];
	        }else{
	        	$data->main_img_url=$productImage[$item['id']];
	        }
	        if($_currency){
	        	$data->price= Site::instance()->price(Product::instance($item['id'])->price(),'code_view',null,Site::instance()->currency_get($_currency)) ;  //+++++++++++++++++++	        	
	        	$data->mprice = Site::instance()->price($item['price'],'code_view',null,Site::instance()->currency_get($_currency)) ;
	        }else{
	        	$data->price=Product::instance($item['id'])->price();          //++++$data->price=$item['price'];
	        	$data->mprice = $item['price'];         //++++$data->mprice = $item['price'];
	        }
			
			$data->sku=$item['sku'];
			$data->name=$item['name'];
			$data->short_desc = $item['brief'];			
			$arrayProduct[]= $data; 
		}
		
		$result->data = $arrayProduct;
		$result->retCode="S";
		$result->totalCnt=$cnt;
		return json_encode($result);
	}
	
	/**
	 * 
	 * 检索产品
	 * @param string $_keywords
	 * @param int $_offset
	 * @param int $_limit
	 * @param string $_orderby
	 */
	static function searchProducts($_keywords,$_offset,$_limit,$_orderby,$_desc=null,$_currency=null){
		$result = new com_cofreeonline_services_ProductListResultType();
		$sql="SELECT count(distinct products.id) as num FROM products where MATCH (name,sku,keywords,description) AGAINST ('+".$_keywords."' IN BOOLEAN MODE) and visibility = 1 and site_id=".Site::instance()->get('id');
		$cntResult = DB::query(Database::SELECT, $sql)->execute()->current();
		$result->totalCnt = $cntResult['num'];
		if($result->totalCnt==0){
			$result->retCode="F";
			$result->msg="No matched Result";
			return json_encode($result);
		}
		$sql="select id,name,sku,price,weight,brief,freeshipping,configs,market_price from products where MATCH (name,sku,keywords,description) AGAINST ('+".$_keywords."' IN BOOLEAN MODE) and visibility = 1 and site_id=".Site::instance()->get('id') ;
		if($_orderby!=null){
			$sql = $sql." order by ".$_orderby;
		}
		
		if($_desc!=null){
			$_desc == 'desc' ? $desc = ' DESC' : $desc = ' ASC';
			$sql = $sql.' '.$desc;
		}
		if($_offset!=null&& $_limit!=null){
			$sql = $sql." limit ".$_offset.",".$_limit;
		}
		$arrData = DB::query(Database::SELECT, $sql)->execute();
		$ids = array();
		foreach ($arrData as $value) {
			$ids[]=$value['id'];
		}
		$images = DB::select('obj_id',array('min("id")', 'mid'))->from('images')->where('obj_id','IN',$ids)->group_by("obj_id")->execute();
		$productImage = array();
		foreach ($images as $item) {
			$productImage[$item['obj_id']] = $item['mid'];
		}
		
		$arrResult = array();
		foreach ($arrData as $item) {
			$data = new com_cofreeonline_services_ProductListType();
			$data->freeshipping = $item['freeshipping'];
			$data->id = $item['id'];
			$arrayConfig  = (($item['configs'] != '') ? unserialize($item['configs']) : '');
			if(is_array($arrayConfig) AND isset($arrayConfig['default_image']) AND $arrayConfig['default_image'] != '')
	        {
	        	$data->main_img_url=$arrayConfig['default_image'];
	        }else{
	        	$data->main_img_url=$productImage[$item['id']];
	        }				
			if($_currency){
	        	$data->price=Site::instance()->price(Product::instance($item['id'])->price(),'code_view',null,Site::instance()->currency_get($_currency)) ;//++++++;        //+++++++++++
	        	$data->mprice = Site::instance()->price($item['price'],'code_view',null,Site::instance()->currency_get($_currency)) ;//++++++
	        }else{
	        	$data->price=Product::instance($item['id'])->price();                       //+++++++++++
	        	$data->mprice =$item['price'] ;//++++++
	        }
			$data->sku=$item['sku'];
			$data->name=$item['name'];
			$data->short_desc = $item['brief'];
			$data->mprice = Site::instance()->price($item['price'],'code_view',null,Site::instance()->currency_get($_currency)) ;//++++++
			$arrResult[]= $data; 
		}
		$result->data = $arrResult;
		$result->retCode="S";
		return json_encode($result);
	}
	/**
	 * 
	 * 取得产品的review
	 * @param int $_productId
	 * @param int $_offset
	 * @param int $_limit
	 * @param string $_orderby
	 */
	static function getReviews($_productId,$_offset,$_limit,$_orderby,$_desc){
		$result = new com_cofreeonline_services_ProductReviewResultType();
		$sql="SELECT count(id) as num FROM reviews where product_id =".$_productId;
		$cntResult = DB::query(Database::SELECT, $sql)->execute()->current();
		$result->totalCnt = $cntResult['num'];
		if($result->totalCnt==0){
			$result->retCode="F";
			$result->msg="This product has no reviews";
			return json_encode($result);
		}
		$sql = "select rv.*,concat(cus.firstname,'.',cus.lastname) as user_name from reviews rv,customers cus where rv.product_id=".$_productId." and cus.id=rv.user_id ";
		if($_orderby!=null){
			$sql = $sql." order by ".$_orderby;
		}
		if($_desc!=null){
			$_desc == 'desc' ? $desc = ' DESC' : $desc = ' ASC';
			$sql = $sql.' '.$desc;
		}
		if($_offset!=null&& $_limit!=null){
			$sql = $sql." limit ".$_offset.",".$_limit;
		}
		$arrayData = DB::query(Database::SELECT, $sql)->execute();
		$arrayResult = array();
		foreach ($arrayData as $item) {
			$data = new com_cofreeonline_services_ProductReviewType();
			$data->postBy= $item['user_id'];
			$data->content=$item['content'];
			$data->postDate=date("Y-m-d H:i:s",$item['time']);
			$data->star=$item['grade'];
			$data->postByName=$item['user_name'];
			$data->id = $item['id'];
			$arrayResult[] = $data;
		}
		$result->data = $arrayResult;
		$result->retCode="S";
		return json_encode($result);
	}

	/**
	 * 
	 * 将接口传递过来的订单按购物车的形式进行重新加入购物车，由购物车生成价格
	 * @param OrderType $_data
	 */
	static function addToCart($_data){
		
		//产品加入购物车
		foreach ($_data->orderLines as $value) {
			$itemArray = array();
			$itemArray['id'] = $value->product_id;
			$itemArray['quantity'] = $value->quantity;			
			$itemArray['items'] = explode(",", $value->items);
			$itemArray['type'] = 0;			
			Cart::add2cart($itemArray);
		}
		$shipping= array();
		if(isset($_data->shipping_method))
		if($_data->shipping_method){
			$shipping['']= $_data->shipping_method;
			$cart = Cart::get();
			$carrier_param = array(
				'weight' => Cart::weight(),
				'shipping_address' => array( 'country' => $_data->shipping_country),
				'amount' => $cart['amount']
			);
			$shipping = Carrier::instance($_data->shipping_method)->get($carrier_param);
			
			Cart::shipping($shipping);
			$shipping_address = array(
				'shipping_address_id' => $_data->shipping_address_id,
				'shipping_firstname' => $_data->shipping_fname,
				'shipping_lastname' => $_data->shipping_lname,
				'shipping_address' => $_data->shipping_address,
				'shipping_city' => $_data->shipping_city,
				'shipping_state' => $_data->shipping_state,
				'shipping_country' => $_data->shipping_country,
				'shipping_zip' => $_data->shipping_zip,
				'shipping_phone' => $_data->shipping_phone,
			);
			Cart::shipping_address($shipping_address);
			$billing = array(
					'payment_method' => $_data->payment_method,
					'cc_type' => $_data->cc_type,
					'cc_num' => $_data->cc_num,
					'cc_cvv' => $_data->cc_cvv,
					'cc_exp_month' => $_data->cc_exp_month,
					'cc_exp_year' => $_data->cc_exp_year,
					'cc_issue' => $_data->cc_issue,
					'cc_valid_month' => $_data->cc_valid_month,
					'cc_valid_year' => $_data->cc_valid_year,
				);
			$billing_address = array(
				'billing_firstname' => $_data->billing_fname,
				'billing_lastname' => $_data->billing_lname,
				'billing_address' => $_data->billing_address,
				'billing_city' => $_data->billing_city,
				'billing_state' => $_data->billing_state,
				'billing_country' => $_data->billing_country,
				'billing_zip' => $_data->billing_zip,
				'billing_phone' => $_data->billing_phone,
			);
			Cart::billing($billing);
			Cart::billing_address($billing_address);
			
		}
		
		Cart::coupon($_data->coupon_code);
		
		return Cart::get();
	}
	static function timeToDateString($_time){
		return date("Y-m-d H:i:s",$_time);
	}
	static function cartToObject($_obj,$_currency){
		$_cart = Cart::get();		
		
		$_obj->amount = Site::instance()->price($_cart['amount']['total'],'code_view', null,Site::instance()->currency_get($_currency)); 
		$_obj->amount_coupon = Site::instance()->price($_cart['amount']['save'],'code_view', null,Site::instance()->currency_get($_currency));
		$_obj->amount_order = Site::instance()->price($_cart['amount']['total'],'code_view', null,Site::instance()->currency_get($_currency));
		$_obj->amount_products = Site::instance()->price($_cart['amount']['items'],'code_view', null,Site::instance()->currency_get($_currency));
		$_obj->amount_shipping = Site::instance()->price($_cart['amount']['shipping'],'code_view', null,Site::instance()->currency_get($_currency));
		$_i=0;
		$ids = array();
		$cartPriceMap = array();
		foreach ($_cart['products'] as $value) {
			$cartPriceMap[$value['id']]=Site::instance()->price($value['price'],'code_view', null,Site::instance()->currency_get($_currency));			
			$ids[] = $value['id'];
			$_i++;
		}
	
		$products = DB::select()->from('products_product')->where('id','IN',$ids)->execute();
		$productMap = array();
		foreach ($products as $item) {
			$productMap[$item['id']] =$item;
		}
		$images = DB::select('obj_id',array('min("id")', 'mid'))->from('images')->where('obj_id','IN',$ids)->group_by("obj_id")->execute();
		$productImage = array();
		foreach ($images as $item) {
			$productImage[$item['obj_id']] = $item['mid'];
		}
		
		foreach ($_obj->orderLines as $value) {
			$value->name=$productMap[$value->product_id]['name'];
			$value->sku=$productMap[$value->product_id]['sku'];
			$value->shipping=$productMap[$value->product_id]['freeshipping'];
			$value->main_img=$productImage[$value->product_id];	
			$value->price = $cartPriceMap[$value->product_id];	
		}		
		return $_obj;
	}
	
	/**
	 * 
	 * cola中的订单类型转成接口OrderType类型对象
	 * @param Order $_order
	 */
	static function orderToObject(Order $_order){
		$result = new com_cofreeonline_services_OrderType();
		$result->id=$_order->get('id');
		$result->parentId=$_order->get('parent_id');
		$result->customerId=$_order->get('customer_id');
		$result->customerEmail=$_order->get('email');
		$result->orderNumber=$_order->get('ordernum');		
		$result->amount_products= Site::instance()->price($_order->get('amount_products'),'code_view', $_order->get('currency'),Site::instance()->currency_get($_order->get('currency')));
		$result->amount_shipping= Site::instance()->price($_order->get('amount_shipping'),'code_view', $_order->get('currency'),Site::instance()->currency_get($_order->get('currency')));
		$result->amount_order= Site::instance()->price($_order->get('amount_order'),'code_view', $_order->get('currency'),Site::instance()->currency_get($_order->get('currency')));
//		$result->amount_products=$_order->get('amount_products');
//		$result->amount_shipping=$_order->get('amount_shipping');
//		$result->amount_order=$_order->get('amount_order');
		$result->coupon_code=$_order->get('coupon_code');
		
		if($_order->get('amount_coupon')==null){
			$result->amount_coupon= $_order->get('amount_coupon');
		}else{
			$result->amount_coupon= Site::instance()->price($_order->get('amount_coupon'),'code_view', $_order->get('currency'),Site::instance()->currency_get($_order->get('currency')));
		}
//		$result->amount_coupon=$_order->get('amount_coupon');          //改？？+++++++
		
		$result->amount= Site::instance()->price($_order->get('amount'),'code_view', $_order->get('currency'),Site::instance()->currency_get($_order->get('currency')));
		$result->amount_payment= Site::instance()->price($_order->get('amount_payment'),'code_view', $_order->get('currency'),Site::instance()->currency_get($_order->get('currency')));
		$result->rate_payment= Site::instance()->price($_order->get('rate_payment'),'code_view', $_order->get('currency'),Site::instance()->currency_get($_order->get('currency')));
//		$result->amount=$_order->get('amount');
		$result->currencyCode=$_order->get('currency');
//		$result->amount_payment=$_order->get('amount_payment');
		$result->currency_payment=$_order->get('currency_payment');
//		$result->rate_payment=$_order->get('rate_payment');
		$result->payment_status=$_order->get('payment_status');
		$result->payment_date=$_order->get('payment_date');
		$result->payment_method=$_order->get('payment_method');
		$result->shipping_stauts=$_order->get('shipping_stauts');
		$result->shipping_method=$_order->get('shipping_method');
		$result->shipping_code=$_order->get('shipping_code');
		$result->shipping_url=$_order->get('shipping_url');
		$result->shipping_comment=$_order->get('shipping_comment');
		$result->shipping_date=$_order->get('shipping_date');
		$result->created=$_order->get('created');
		$result->shipping_address_id=$_order->get('shipping_address_id');
		$result->shipping_fname=$_order->get('shipping_firstname');    //_fname
		$result->shipping_lname=$_order->get('shipping_lastname');      //_lname  
		$result->shipping_country=$_order->get('shipping_country');
		$result->shipping_state=$_order->get('shipping_state');
		$result->shipping_city=$_order->get('shipping_city');
		$result->shipping_address=$_order->get('shipping_address');
		$result->shipping_zip=$_order->get('shipping_zip');
		$result->shipping_phone=$_order->get('shipping_phone');
		$result->shipping_mobile=$_order->get('shipping_mobile');
		$result->payment_method=$_order->get('payment_method');
		$result->cc_type=$_order->get('cc_type');
		$result->cc_num=$_order->get('cc_num');
		$result->cc_cvv=$_order->get('cc_cvv');
		$result->cc_exp_month=$_order->get('cc_exp_month');
		$result->cc_exp_year=$_order->get('cc_exp_year');
		$result->cc_issue=$_order->get('cc_issue');
		$result->cc_valid_month=$_order->get('cc_valid_month');
		$result->cc_valid_year	=$_order->get('cc_valid_year');
		$result->billing_fname=$_order->get('billing_fname');
		$result->billing_lname=$_order->get('billing_lname');
		$result->billing_country=$_order->get('billing_country');
		$result->billing_state=$_order->get('billing_state');
		$result->billing_city=$_order->get('billing_city');
		$result->billing_address=$_order->get('billing_address');
		$result->billing_zip=$_order->get('billing_zip');
		$result->billing_phone=$_order->get('billing_phone');
		$result->billing_mobile=$_order->get('billing_mobile');
		
		$arrLines = $_order->getitems();                      
		$arrayData = array();
		foreach ($arrLines as $value) {
			$data = new com_cofreeonline_services_OrderLineType();
			$data->id= $value['id'];
			$data->orderId= $value['order_id'];
			$data->product_id= $value['product_id'];
			$data->item_id= $value['item_id'];
			$data->name= $value['name'];
			$data->sku= $value['sku'];
			$data->link= $value['link'];
			
			$data->price = Site::instance()->price($value['price'],'code_view', $_order->get('currency'),Site::instance()->currency_get($_order->get('currency')));
//			$data->price= $value['price'];     
			$data->quantity= $value['quantity'];
			$data->weight= $value['weight'];
			$data->created= self::timeToDateString($value['created']);
			$arrayData[] = $data;
		}
		$result->orderLines = $arrayData;
		return $result;
	}
	
	
	static function objectToArray($_obj){
			$data = array();
//			$data['customer_id'] = $_obj->customerid;
            $data['firstname'] = $_obj->fname;
            $data['lastname'] = $_obj->lname;
            $data['address'] = $_obj->address;
            $data['city'] = $_obj->city;
            $data['zip'] = $_obj->zip;
            $data['state'] = $_obj->state;
            $data['country'] = $_obj->country;
            $data['phone'] = $_obj->phone;
            $data['other_phone'] = $_obj->otherphone;            
            return $data;
	}
}
