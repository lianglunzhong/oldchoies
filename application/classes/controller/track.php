<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_track extends Controller_Webpage
{

    public function action_track_order()
    {
        $this->template->content = View::factory('/track');
    }

    public function action_ajax_orderdata()
    {
        $lang = Arr::get($_GET, 'lang', '');
        if (!($customer_id = Customer::logged_in()))
        {
            echo json_encode(array('result' => 'login', 'msg' => 'login please'));
            exit;
        }
        $code = trim($_POST['code']);
        if ($code && strlen($code) < 20)
        {
            $data = DB::query(DATABASE::SELECT, "SELECT O.ordernum,O.created,O.currency,O.amount_order,O.amount_shipping,O.refund_status,O.payment_status,O.shipping_status,O.shipping_address,O.shipping_zip,O.shipping_phone
                FROM `orders_order` O left join `orders_ordershipments` P ON O.id=P.order_id
                WHERE O.customer_id=" . $customer_id . "  
                AND (O.ordernum='" . $code . "' OR P.tracking_code='" . $code . "')")->execute('slave')->as_array();
            if (count($data) > 0){
                foreach ($data as $key => $value)
                {
                    $tmp = array();
                    $tmp['ordernum'] = $value['ordernum'];
                    $tmp['created'] = date("Y-m-d H:i:s", $value['created']);
                    $currency = Site::instance()->currencies($value['currency']);
                    $tmp['shipping'] = $currency['code'] . round($value['amount_shipping'], 2);
                    $tmp['amount'] =  $currency['code'] . round($value['amount_order'], 2);
                    if($value['refund_status']){
                        $status = str_replace('_', ' ', $value['refund_status']);
                    }else{
                        $status = kohana::config('order_status.payment.' . $value['payment_status'] . '.name');
						$shipstatus = kohana::config('order_status.shipment.' . $value['shipping_status'] . '.name');
                        if ($status == 'New' OR $status == 'new'){
                            $status = 'Unpaid(New)';
						}elseif($shipstatus == 'processing' OR $shipstatus == 'Processing'){
								$status = $shipstatus;
						}elseif($shipstatus == 'partial shipped' OR $shipstatus == 'Partial Shipped'){
								$status = $shipstatus;
						}elseif($shipstatus == 'shipped' OR $shipstatus == 'Shipped'){
								$status = $shipstatus;
						}elseif($shipstatus == 'delivered' OR $shipstatus == 'Delivered'){
								$status = $shipstatus;
						}
                    }
					
                    $tmp['order_status'] = ucfirst($status);
                }
                echo json_encode(array('result' => 'has_order','data' => $tmp));
            }
        }
        exit;
    }
	
    public function action_ajax_pagedata()
    {
        $lang = Arr::get($_GET, 'lang', '');
        if (!($customer_id = Customer::logged_in()))
        {
            echo json_encode(array('result' => 'login', 'msg' => 'login please'));
            exit;
        }
        $code = trim($_POST['code']);
        if ($code && strlen($code) < 20)
        {
            $country_arr = kohana::config('17track.track-country');
            $data = DB::query(DATABASE::SELECT, "SELECT O.ordernum,O.created,O.currency,O.amount_order,O.amount_shipping,O.refund_status,O.payment_status,P.tracking_code,P.tracking_link,O.shipping_country,O.shipping_state,O.shipping_city,
                O.shipping_address,O.shipping_zip,O.shipping_phone,P.carrier 
                FROM `orders_ordershipments` P LEFT JOIN `orders_order` O ON P.order_id=O.id
                WHERE O.customer_id=" . $customer_id . " AND O.payment_status='verify_pass' 
                AND (P.ordernum='" . $code . "' OR P.tracking_code='" . $code . "')")->execute('slave')->as_array();
            if (count($data) > 0)
            {
                $datas = array();
                foreach ($data as $key => $value)
                {
                    $tmp = array();
                    $tmp['ordernum'] = $value['ordernum'];
                    $tmp['created'] = date("Y-m-d H:i:s", $value['created']);
                    $tmp['tracking_code'] = $value['tracking_code'];
                    $tmp['tracking_link'] = $value['tracking_link'];
                    $tmp['shipping_country'] = $value['shipping_country'];
                    $tmp['shipping_state'] = $value['shipping_state'];
                    $tmp['shipping_city'] = $value['shipping_city'];
                    $tmp['shipping_address'] = $value['shipping_address'];
                    $tmp['shipping_zip'] = $value['shipping_zip'];
                    $tmp['shipping_phone'] = $value['shipping_phone'];
                    //api
                    $et_list = kohana::config('17track.et_list');
                    $url = kohana::config('17track.url');
                $a = 'dhl';
                if(array_key_exists(strtolower($value['carrier']),$et_list)){
                    $et = $et_list[strtolower($value['carrier'])];//国际快递
                }else{
						$et = 0;
                    if(strpos(strtolower($value['carrier']),$a) != false){
                        $et = $et_list[$a];
                    }else{
                    $et = 0;//国际邮政
                    }
                }

                    $post = array(
                        "num" => $value['tracking_code'],
                        "et" => $et,
                        "pt" => 0,
                    );
                    $response = Toolkit::curl_pay($url, $post);
                    if ($response)
                    {
                        $resp_arr = json_decode($response, TRUE);
                        if ($resp_arr['ret'] == 1)
                        {//查询成功
                            $tmp['send_country'] = "unknow";
                            $tmp['dest_country'] = "unknow";
                            if ($et == 0)
                            {//国际邮政
                                foreach ($country_arr as $ckey => $cvalue)
                                {
                                    if ($cvalue['a'] == $resp_arr['dat']['c'])
                                    {
                                        $tmp['dest_country'] = $cvalue['b'];
                                    }
                                    if ($cvalue['a'] == $resp_arr['dat']['b'])
                                    {
                                        $tmp['send_country'] = $cvalue['b'];
                                    }
                                }
                                $tmp['status'] = $resp_arr['dat']['e'] == 0 ? "Not Found" :
                                        ($resp_arr['dat']['e'] == 10 ? "Transporting" :
                                                ($resp_arr['dat']['e'] == 30 ? "Pick Up" :
                                                        ($resp_arr['dat']['e'] == 40 ? "Delivered" : "unknow")));
                                $tmp['history'] = $resp_arr['dat']['z1'];
                                //$tmp['history_send'] = $resp_arr['dat']['x'];                          
                            }
                            else
                            {
                                $tmp['status'] = $resp_arr['dat']['e'] == 0 ? "Not Found" :
                                        ($resp_arr['dat']['e'] == 10 ? "Transporting" :
                                                ($resp_arr['dat']['e'] == 30 ? "Pick Up" :
                                                        ($resp_arr['dat']['e'] == 40 ? "Delivered" : "unknow")));
                                $tmp['history'] = $resp_arr['dat']['z1'];
                            }
                            $datas[] = $tmp;
                        }
                        else
                        {
                            switch ($lang)
                            {
                                case 'de':
                                    $msg = 'Die Verfolgung Details werden nicht richtig auf unserer Website angezeigt aufgrund technischer Probleme, die durch Website des Kuriers verursacht, Sie können Ihre Bestellung auch <a href="' . $value['tracking_link'] . '">hier</a> mit Ihrem Sendungnummer verfolgen.';
                                    break;
                                case 'es':
                                    $msg = 'Los detalles de seguimiento no se muestran correctamente en nuestro sitio debido a problemas técnicos de el sitio web de soporte, también puede realizar un seguimiento de su pedido <a href="' . $value['tracking_link'] . '">aquí</a> con su No. de seguimiento.';
                                    break;
                                case 'fr':
                                    $msg = 'Les détails de suivi ne s\'affichent pas correctement sur notre site en raison de problèmes techniques causés par le site Internet du transporteur, vous pouvez également suivre votre commande <a href="' . $value['tracking_link'] . '">ici</a> avec votre numéro de suivi.';
                                    break;
                                case 'ru':
                                    $msg = 'Не отображается правильно на наш сайт из-за технacческих проблем, вызванных перевозчика сайте, Вы также можете отслеживать ваш заказ по номеру заказа <a href="' . $value['tracking_link'] . '">здесь</a> .';
                                    break;
                                default:
                                    $msg = 'The tracking details do not display properly on our site due to technical problems caused by carrier\'s website, you can also track your order <a href="' . $value['tracking_link'] . '">here</a> with your tracking No.';
                                    break;
                            }
                            echo json_encode(array('result' => 'noData', 'msg' => $msg));
                        }
                    }
                    else
                    {
                        switch ($lang)
                        {
                            case 'de':
                                $msg = 'Die Verfolgung Details werden nicht richtig auf unserer Website angezeigt aufgrund technischer Probleme, die durch Website des Kuriers verursacht, Sie können Ihre Bestellung auch <a href="' . $value['tracking_link'] . '">hier</a> mit Ihrem Sendungnummer verfolgen.';
                                break;
                            case 'es':
                                $msg = 'Los detalles de seguimiento no se muestran correctamente en nuestro sitio debido a problemas técnicos de el sitio web de soporte, también puede realizar un seguimiento de su pedido <a href="' . $value['tracking_link'] . '">aquí</a> con su No. de seguimiento.';
                                break;
                            case 'fr':
                                $msg = 'Les détails de suivi ne s\'affichent pas correctement sur notre site en raison de problèmes techniques causés par le site Internet du transporteur, vous pouvez également suivre votre commande <a href="' . $value['tracking_link'] . '">ici</a> avec votre numéro de suivi.';
                                break;
                            case 'ru':
                                $msg = 'Не отображается правильно на наш сайт из-за технических проблем, вызванных перевозчика сайте, Вы также можете отслеживать ваш заказ по номеру заказа <a href="' . $value['tracking_link'] . '">здесь</a> .';
                                break;
                            default:
                                $msg = 'The tracking details do not display properly on our site due to technical problems caused by carrier\'s website, you can also track your order <a href="' . $value['tracking_link'] . '">here</a> with your tracking No.';
                                break;
                        }
                        echo json_encode(array('result' => 'noData', 'msg' => $msg));
                    }
                }
                echo json_encode(array('result' => 'success', 'data' => json_encode($datas)));
            }
            else
            {
                switch ($lang)
                {
                    case 'de':
                        $msg = 'Entschuldigung, keine Verfolgungsinformationen von Ihrer Bestellnummer oder Sendungnummer wurde gefunden.';
                        break;
                    case 'es':
                        $msg = 'Lo sentimos, no hay información de seguimiento encontrado por su pedido No. o código de seguimiento.';
                        break;
                    case 'fr':
                        $msg = 'Désolé, il n\'y a pas d\'information de suivi trouvée par votre numéro de commande ou code de suivi.';
                        break;
                    case 'ru':
                        $msg = 'Извините, не существует отслеживая информация, найденную ни по номеру заказа ни по коду отслеживания.';
                        break;
                    default:
                        $msg = 'Sorry, no tracking information found by your order No. or tracking code.';
                        break;
                }
                echo json_encode(array('result' => 'noData', 'msg' => $msg));
            }
        }
        else
        {
            switch ($lang)
            {
                case 'de':
                    $msg = 'Bitte geben Sie eine korrekte Sendungnummer/Bestellnummer ein.';
                    break;
                case 'es':
                    $msg = 'Por favor, ingrese el código de seguimiento / pedido correcto';
                    break;
                case 'fr':
                    $msg = 'Veuillez entrer un code de suivi/commande correct.';
                    break;
                case 'ru':
                    $msg = 'Пожалуйста, введите корректное отслеживание/код заказа.';
                    break;
                default:
                    $msg = 'Please enter a correct tracking/order code.';
                    break;
            }
            echo json_encode(array('result' => 'noData', 'msg' => $msg));
        }
        exit;
    }

    //用户中心查看订单物流详情
    public function action_customer_track(){
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(URL::base() . LANGPATH . 'customer/login?redirect=' . URL::current(TRUE));
        }
        $ordernum= mysql_real_escape_string(Arr::get($_GET, 'id', 0));
        if(!$ordernum){
            Request::instance()->redirect(URL::base() . LANGPATH . 'customer/orders');
        }
        $country_arr = kohana::config('17track.track-country');
        $data = DB::query(DATABASE::SELECT,"SELECT O.ordernum,O.created,P.tracking_code,P.tracking_link,O.shipping_country,O.shipping_state,O.shipping_city,
            O.shipping_address,O.shipping_zip,O.shipping_phone,P.carrier 
            FROM `orders_ordershipments` P LEFT JOIN `orders_order` O ON P.order_id=O.id
            WHERE O.customer_id=".$customer_id." AND O.payment_status='verify_pass' 
            AND P.ordernum='".$ordernum."' ")->execute('slave')->as_array();
        $datas = array();
        if (count($data)>0) {
            foreach ($data as $key => $value) {
                $tmp = array();
                $datas['ordernum'] = $value['ordernum'];
                $datas['created'] = date("Y-m-d H:i:s",$value['created']);
                $tmp['tracking_code'] = $value['tracking_code'];
                $tmp['tracking_link'] = $value['tracking_link'];
                $tmp['shipping_country'] = $value['shipping_country'];
                $tmp['shipping_state'] = $value['shipping_state'];
                $tmp['shipping_city'] = $value['shipping_city'];
                $tmp['shipping_address'] = $value['shipping_address'];
                $tmp['shipping_zip'] = $value['shipping_zip'];
                $tmp['shipping_phone'] = $value['shipping_phone'];
                //api
                $et_list = kohana::config('17track.et_list');
                $url = kohana::config('17track.url');
                $a = 'dhl';

                if(array_key_exists(strtolower($value['carrier']),$et_list)){
                    $et = $et_list[strtolower($value['carrier'])];//国际快递
                }else{
					$et = 0;
                    if(strpos(strtolower($value['carrier']),$a) != false){
                        $et = $et_list[$a];
                    }else{
                    $et = 0;//国际邮政
                    }
                }

                $post = array(
                    "num"=>$value['tracking_code'],
                    "et"=>$et,
                    "pt"=>0,
                );
                $response = Toolkit::curl_pay($url,$post);
                if($response){
                    $resp_arr = json_decode($response,TRUE);
                    if($resp_arr['ret'] == 1){//查询成功
                        $tmp['send_country'] = "unknow";
                        $tmp['dest_country'] = "unknow";
                        if($et == 0){//国际邮政
                            foreach ($country_arr as $ckey => $cvalue) {
                                if( $cvalue['a']==$resp_arr['dat']['c']){
                                    $tmp['dest_country'] = $cvalue['b'];
                                }
                                if( $cvalue['a']==$resp_arr['dat']['b']){
                                    $tmp['send_country'] = $cvalue['b'];
                                }
                            }
                            $tmp['status'] = $resp_arr['dat']['e']==0?"Not Found":
                                ($resp_arr['dat']['e']==10?"Transporting":
                                ($resp_arr['dat']['e']==30?"Pick Up":
                                ($resp_arr['dat']['e']==40?"Delivered":"unknow")));
                            $tmp['history'] = $resp_arr['dat']['z1'];
                            $tmp['history_send'] = $resp_arr['dat']['z0'];
                        }else{
                            $tmp['status'] = $resp_arr['dat']['e']==0?"Not Found":
                                ($resp_arr['dat']['e']==10?"Transporting":
                                ($resp_arr['dat']['e']==30?"Pick Up":
                                ($resp_arr['dat']['e']==40?"Delivered":"unknow")));
                            $tmp['history'] = $resp_arr['dat']['z1'];
                        }
                        $datas['tracks'][] = $tmp;
                    }else{
                        //查询失败
                        $datas['tracks'][] = "error";
                    }
                }else{
                    //没有返回信息
                    $datas['tracks'][] = "error";
                }
            }
        }

        $this->template->content = View::factory('/order/track_detail')->set('datas',$datas);
    }
	
	
	
	    //郭测试
    public function action_customer11_track222(){
        if (!($customer_id = Customer::logged_in()))
        {
			
            Request::instance()->redirect(URL::base() . LANGPATH . 'customer/login?redirect=' . URL::current(TRUE));
        }
        $ordernum= mysql_real_escape_string(Arr::get($_GET, 'id', 0));

        if(!$ordernum){
            Request::instance()->redirect(URL::base() . LANGPATH . 'customer/orders');
        }
        $country_arr = kohana::config('17track.track-country');
        $data = DB::query(DATABASE::SELECT,"SELECT O.ordernum,O.created,P.tracking_code,P.tracking_link,O.shipping_country,O.shipping_state,O.shipping_city,
            O.shipping_address,O.shipping_zip,O.shipping_phone,P.carrier 
            FROM `orders_ordershipments` P LEFT JOIN `orders_order` O ON P.order_id=O.id
            WHERE O.customer_id=".$customer_id." AND O.payment_status='verify_pass' 
            AND P.ordernum='".$ordernum."' ")->execute('slave')->as_array();
		
		
        $datas = array();
        if (count($data)>0) {
            foreach ($data as $key => $value) {
                $tmp = array();
                $datas['ordernum'] = $value['ordernum'];
                $datas['created'] = date("Y-m-d H:i:s",$value['created']);
                $tmp['tracking_code'] = $value['tracking_code'];
                $tmp['tracking_link'] = $value['tracking_link'];
                $tmp['shipping_country'] = $value['shipping_country'];
                $tmp['shipping_state'] = $value['shipping_state'];
                $tmp['shipping_city'] = $value['shipping_city'];
                $tmp['shipping_address'] = $value['shipping_address'];
                $tmp['shipping_zip'] = $value['shipping_zip'];
                $tmp['shipping_phone'] = $value['shipping_phone'];
                //api
                $et_list = kohana::config('17track.et_list');
                $url = kohana::config('17track.url');
				$a = 'dhl';
                if(array_key_exists(strtolower($value['carrier']),$et_list)){
                    $et = $et_list[strtolower($value['carrier'])];//国际快递
                }else{		
						$et = 0;
					if(strpos(strtolower($value['carrier']),$a) != false){
						$et = $et_list[$a];						
					}else{
                    $et = 0;//国际邮政
					}
                }
				//	echo $et;
                $post = array(
                    "num"=>$value['tracking_code'],
                    "et"=>$et,
                    "pt"=>0,
                );
                $response = Toolkit::curl_pay($url,$post);

				
                if($response){
                    $resp_arr = json_decode($response,TRUE);
                    if($resp_arr['ret'] == 1){//查询成功
                        $tmp['send_country'] = "unknow";
                        $tmp['dest_country'] = "unknow";
                        if($et == 0){//国际邮政					
                            foreach ($country_arr as $ckey => $cvalue) {
                                if( $cvalue['a']==$resp_arr['dat']['c']){
                                    $tmp['dest_country'] = $cvalue['b'];
                                }
                                if( $cvalue['a']==$resp_arr['dat']['b']){
                                    $tmp['send_country'] = $cvalue['b'];
                                }
                            }
                            $tmp['status'] = $resp_arr['dat']['e']==0?"Not Found":
                                ($resp_arr['dat']['e']==10?"Transporting":
                                ($resp_arr['dat']['e']==30?"Pick Up":
                                ($resp_arr['dat']['e']==40?"Delivered":"unknow")));
                            $tmp['history'] = $resp_arr['dat']['z1'];
                            $tmp['history_send'] = $resp_arr['dat']['z0'];
							 $datas['tracks'][] = $tmp;
                        }else{
                            $tmp['status'] = $resp_arr['dat']['e']==0?"Not Found":
                                ($resp_arr['dat']['e']==10?"Transporting":
                                ($resp_arr['dat']['e']==30?"Pick Up":
                                ($resp_arr['dat']['e']==40?"Delivered":"unknow")));
                            $tmp['history'] = $resp_arr['dat']['z2'];
                        }
				
                        $datas['tracks'][] = $tmp;
                    }else{
                      
                        $datas['tracks'][] = "error";
                    }
                }else{
                   
                    $datas['tracks'][] = "error";
                }

            }	
        }
		
        $this->template->content = View::factory('/order/track_detail')->set('datas',$datas);
    }

    public function action_17track_update_shipstatus(){
        // ignore_user_abort(TRUE);
        set_time_limit(0);
        $time_from = time()-3600*24*90;
        $time_to = time()-3600*24*10;
        $data = DB::query(DATABASE::SELECT,"SELECT O.id,P.tracking_code,P.carrier,O.email,O.shipping_firstname,O.ordernum,O.created,O.points,O.currency,O.amount_payment,O.amount     
            FROM orders_order O LEFT JOIN orders_ordershipments P ON O.id=P.order_id
            WHERE O.shipping_status IN ('shipped','partial_shipped') AND P.carrier NOT IN ('YWS','SF','XRU','SF_EXPRESS') 
            AND P.ship_date>".$time_from." AND P.ship_date<".$time_to." AND P.tracking_code<>'' order by O.id desc limit 0,4000")
            ->execute('slave')->as_array();
        if(count($data)>0){
            $result_arr = array();
            $et = 0;//国际邮政
            $et_list = array(//国际快递
                "dhl"=>"100001",
                "ups"=>"100002",
                "fedex"=>"100003",
                "tnt"=>"100004",
                "gls"=>"100005",
                "aramex"=>"100006",
                "dpd"=>"100007",
                "eshipper"=>"100008",
                "toll"=>"100009",
            );
            // $url = "http://api-r.17track.net:8088/Rest/HandlerTrack.ashx";
            $url = "http://v4-api.17track.net:8044/handlertrack.ashx";
            $i = 1;
            foreach ($data as $key => $value) {
                if($i>4000){
                    break;
                }
                if(array_key_exists(strtolower($value['carrier']),$et_list)){
                    $et = $et_list[strtolower($value['carrier'])];
                }
                $post = array(
                    "num"=>$value['tracking_code'],
                    "et"=>$et,
                    "pt"=>0,
                );
                $response = Toolkit::curl_pay($url,$post);
                if($response){
                    // $email_params = array();
                    $resp_arr = json_decode($response,TRUE);
                    if($et==0){//国际邮政
                        if(isset($resp_arr['dat']['e'])&&$resp_arr['dat']['e']==30){//pick up
                            $update_order = DB::update('orders_order')->set(array('shipping_status' => 'pickup'))
                                // ->where('site_id','=',$this->site_id)
                                ->where('id','=',$value['id'])
                                ->execute();
                        }
                        if(isset($resp_arr['dat']['e'])&&$resp_arr['dat']['e']==40){//delivered
                            $delivery_time = strtotime($resp_arr['dat']['z0']['a']);
                            $ret = DB::update('order_purchase')
                                ->set(array('delivery_time' => $delivery_time, 'updated' => time(), 'update_user' => $this->user_id))
                                // ->where('site_id','=',$this->site_id)
                                ->where('order_id','=',$value['id'])
                                ->where('tracking_code','=',$value['tracking_code'])
                                ->execute();

                            $update_order = DB::update('orders_order')->set(array('deliver_time' => $delivery_time, 'shipping_status' => 'delivered'))
                                // ->where('site_id','=',$this->site_id)
                                ->where('id','=',$value['id'])
                                ->execute();

                            $email_params['firstname'] = $value['shipping_firstname'];
                            $email_params['order_num'] = $value['ordernum'];
                            $email_params['created'] = date("Y-m-d",$value['created']);
                            $email_params['currency'] = $value['currency'];
                            $email_params['points'] = floor($value['amount']);
                            $email_params['amount'] = round($value['amount_payment'],2);
                            $email_params['email'] = $value['email'];
                            if(Mail::SendTemplateMail('CONFIRM_MAIL', $email_params['email'], $email_params)){
                                kohana_log::instance()->add("sendmail", $value['email']);
                            }
                            echo "ID:".$value['id']." success! <br>";
                            $result_arr[] = $value['id'];
                        }
                    }else{//国际快递
                        if(isset($resp_arr['dat']['e'])&&$resp_arr['dat']['e']==30){//pick up
                            $update_order = DB::update('orders_order')->set(array('shipping_status' => 'pickup'))
                                // ->where('site_id','=',$this->site_id)
                                ->where('id','=',$value['id'])
                                ->execute();
                        }
                        if(isset($resp_arr['dat']['e'])&&$resp_arr['dat']['e']==40){//delivered
                            $delivery_time = strtotime($resp_arr['dat']['z0']['a']);
                            $ret = DB::update('order_purchase')
                                ->set(array('delivery_time' => $delivery_time, 'updated' => time(), 'update_user' => $this->user_id))
                                // ->where('site_id','=',$this->site_id)
                                ->where('order_id','=',$value['id'])
                                ->where('tracking_code','=',$value['tracking_code'])
                                ->execute();

                            $update_order = DB::update('orders_order')->set(array('deliver_time' => $delivery_time, 'shipping_status' => 'delivered'))
                                // ->where('site_id','=',$this->site_id)
                                ->where('id','=',$value['id'])
                                ->execute();

                            $email_params['firstname'] = $value['shipping_firstname'];
                            $email_params['order_num'] = $value['ordernum'];
                            $email_params['created'] = date("Y-m-d",$value['created']);
                            $email_params['currency'] = $value['currency'];
                            $email_params['points'] = floor($value['amount']);
                            $email_params['amount'] = round($value['amount_payment'],2);
                            $email_params['email'] = $value['email'];
                            if(Mail::SendTemplateMail('CONFIRM_MAIL', $email_params['email'], $email_params)){
                                kohana_log::instance()->add("sendmail", $value['email']);
                            }
                            echo "ID:".$value['id']." success! <br>";
                            $result_arr[] = $value['id'];
                        }
                    }
                }else{
                    echo "TRACKING CODE: ".$value['tracking_code']."  NO RESPONSE.<br>";
                }
                $i++;
            }
            if(count($result_arr)>0){
                kohana_log::instance()->add("17track", json_encode($result_arr));
            }
        }else{
            echo "All Completed";
        }
        exit;
    }

}