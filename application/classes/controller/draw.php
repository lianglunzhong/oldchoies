<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Draw extends Controller_Webpage
{

    //抽奖页面
    public function action_luck_draw()
    {
        if($customer_id = Customer::logged_in()){
            $draw_from = Customer::instance($customer_id)->get('draw_from');//查询用户来源
        }
        echo View::factory('/luck_draw')->set('draw', $draw_from);exit;
    }   
    
    //执行抽奖
    public function action_chkdraw()
    {
        if($_POST)
        {
            $customer_id = Arr::get($_POST, 'customer_id');
            if($customer_id)
            {
                $res = array();
                $draw_state = Customer::instance($customer_id)->get('draw_state');//查询用户抽奖状态
                $draw_from = Customer::instance($customer_id)->get('draw_from');//查询用户抽奖来源
                if(empty($draw_from)){
                    echo trim('drawerror');exit;
                }
                if($draw_state == 1){
                    echo trim('nochange');exit;
                }
                //查询参与奖项
                $draw_row = DB::query(Database::SELECT, 'select draw_name,probability,coupon_id from customer_bability order by id desc')->execute()->as_array();
                if(count($draw_row)>=1){
                    $i=1;
                    foreach ($draw_row as $key => $val) {
                        $arr[$i] = $val['probability'];
                        $i++;
                    }
                    $rid = $this->get_rand($arr); //根据概率获取奖项id
                    $res['yes'] = $draw_row[$rid-1]['coupon_id']; //折扣券ID
                    echo $res['yes'];exit;
                }
            }
        }
    }
    
    //发放奖项
    public function action_senddraw()
    {
        $coupon_id = Arr::get($_POST, 'coupon_id');
        $customer_id = Arr::get($_POST, 'customer_id');
        //更改当前用户抽奖状态
        $upstate = DB::query(Database::UPDATE, 'update accounts_customers set draw_state = 1 where id = "'.$customer_id.'"')->execute();
        if($upstate){
            //将中得折扣券奖项录入coupons表与customer_draw表
            $coupon_arr = array(
                    'customer_id' => $customer_id,
                    'coupon_id'   => $coupon_id,
                    'site_id'     => 1
            );
            $draw_name = DB::query(Database::SELECT, 'select draw_name from customer_bability where coupon_id = "'.$coupon_id.'"')->execute()->current();
            if($draw_name){
                DB::insert('carts_customercoupons', array_keys($coupon_arr))->values($coupon_arr)->execute();
                DB::query(Database::INSERT, 'insert into carts_customercoupons(customer_id,coupon_id,site_id)values("'.$customer_id.'","'.$coupon_id.'",1)')->execute();
                DB::query(Database::INSERT, 'insert into customer_draw(email,draw_name,created)values("'.$email.'","'.$draw_name['draw_name'].'",now())')->execute();
            }
        }
    }
    
    public function action_chkmail()
    {
        if($_POST)
        {
            $email = Arr::get($_POST, 'email');
            $email_state = DB::query(Database::SELECT, 'select email from customers where email = "'.$email.'"')->execute()->current();
            echo $email_state ? trim('isset') : trim('error');exit;
        }
    }
    
    function get_rand($proArr) {
        $result = '';
        //概率数组的总概率精度
        $proSum = array_sum($proArr);
        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset ($proArr);
        return $result;
    }

}
