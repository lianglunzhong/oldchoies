<?php defined('SYSPATH') or die('No direct script access.');

class Taobao
{
        public static function get_item_status($id)
        {
                if($id)
                {
                        require $_SERVER['DOCUMENT_ROOT'] . '/application/classes/taobaoSdk/' . 'TopSdk.php';
                        $c = new TopClient;
                        $c->appkey = '21379024';
                        $c->secretKey = '2e52da2eb8a7aae697d56e0b2cf9501c';
                        $req = new ItemGetRequest;
                        $req->setFields("approve_status");
                        $req->setNumIid($id);
                        $resp = $c->execute($req);
                        $status = $resp->item->approve_status;
                        if($status == 'onsale')
                        {
                                return 'instock';
                        }
                        else
                        {
                                return 'outstock';
                        }
//                        return (string)($status);
                }
                else
                        return '';
                
        }
}