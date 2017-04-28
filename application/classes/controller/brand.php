<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Brand extends Controller_Webpage
{

	public function action_list()
	{
		$id = $this->request->param('id');

        $id = intval($id);
        if($id>=221 || $id<=21)
        {
            Request::Instance()->redirect(LANGPATH . '/');      
        }

		if(!$id)
		{
			Request::Instance()->redirect(LANGPATH . '/404');
		}
		// if (Arr::get($_SERVER, 'HTTPS', 'off') == 'on')
  //       {
  //           $redirects = isset($_GET['redirect']) ? '?redirect=' . $_GET['redirect'] : '';
  //           Request::Instance()->redirect(URL::site(Request::Instance()->uri . $redirects, 'https'));
  //       }
        $gets = array(
            'page' => (int) Arr::get($_GET, 'page', 0),
            'limit' => (int) Arr::get($_GET, 'limit', 0),
            'sort' => (int) Arr::get($_GET, 'sort', 0),
            'pick' => (int) Arr::get($_GET, 'pick', 0),
        );

        if(isset($_GET['currency'])){
            $currency = strtoupper(trim($_GET['currency']));
            if(Site::instance()->get('currency') != '' AND
             array_search($currency, explode(',', Site::instance()->get('currency'))) !== FALSE){
                Site::instance()->currency_set($currency);
            }
        }

        $gi = geoip_open(APPPATH . "classes/GeoIP.dat", GEOIP_STANDARD);
        $country_code = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);
        $country_area = 'EUR';
        if($country_code == 'US')
        {
            $country_area = 'US';
        }
        elseif($country_code == 'GB' OR $country_code == 'UK')
        {
            $country_area = 'UK';
        }
        
        $cache_key = "2brands_" . Request::instance()->uri() . '_' . implode('_', $gets)  . "_" . $country_area;
        $cache_key = preg_replace('/[^A-Za-z0-9_\/\-]+/i', '', $cache_key);
        $cache_content = Cache::instance('memcache')->get($cache_key);

        if (strlen($cache_content) > 100 AND !isset($_GET['cache']))
        {
            $this->template = $cache_content;
        }
        else
        {
            //产品过滤
            $sql = '';
            $join_sql = '';
            $join_key = 0;
            $paramprice = $this->request->param('price');
            $priceFilter = explode('-', $paramprice);
            if (isset($priceFilter[0]) AND isset($priceFilter[1]))
            {
                $pricefrom = (int) $priceFilter[0];
                $priceto = (int) $priceFilter[1];
                $custom_filter['price_range'][] = $pricefrom;
                $custom_filter['price_range'][] = $priceto;
            }
            $filter = $this->request->param('filter');

            $matchsql = array();
            if($filter)
            {
                $custom_filter['filter_attirbutes'] = array();
                $custom_filters = array();
                $filters = explode('__', $filter);
                foreach ($filters as $f)
                {
                    $f = mysql_real_escape_string($f);
                    $fil = explode('_', $f);
                        if(isset($fil[1]))
                        {
                            $fil[1] = strtolower($fil[1]);
                            if(!is_numeric($fil[1]))
                            {
                                $label = str_replace(' ', '-', $fil[1]);
                                $attr_id = DB::select('id')->from('attributes')->where('label', '=', $label)->execute()->get('id');
                                $fil[1] = (int) $attr_id;
                            }
                            $custom_filters[$fil[0]] = $fil[1];
                            $custom_filter['filter_attirbutes'][] = $fil[1];
                            $join_key ++;
                            $join_sql .= " INNER JOIN  `product_attribute_values` a$join_key ON ( p.`id` = a$join_key.`product_id` ) ";
                            $matchsql[] = "a$join_key.`attribute_id` IN ( $fil[1] )";
                        }
                }
                $sql .= " AND (" . implode(' ', $matchsql) . ") ";
            }
           
            $size_filter = array();

			//产品排序
            $sort_key = (int) Arr::get($_GET, 'sort', 0);
            $sorts = Kohana::config('catalog.sorts');
            $sortcolor = Kohana::config('catalog.colors');
            if (isset($_GET['pick']))
            {
                $orderby = 'has_pick';
                $queue = 'desc';
            }
            else
            {
                
					$orderby = $sorts[$sort_key]['field'];
					$queue = $sorts[$sort_key]['queue'];
            }                 

            if($id == 220)
            {
                $count_products = DB::query(Database::SELECT, 'SELECT COUNT(*) AS counts FROM products_product WHERE brand_id = "" AND visibility = 1 AND status = 1 AND set_id NOT IN (340,365,374,378,390)')->execute()->get('counts');
            }
            else
            {
                $count_products = DB::query(Database::SELECT, 'SELECT COUNT(*) AS counts FROM products_product WHERE brand_id = ' . $id . ' AND visibility = 1 AND status = 1 AND set_id NOT IN (340,365,374,378,390)')->execute()->get('counts');
            }


            //产品显示个数
            $limit_key = (int) Arr::get($_GET, 'limit', 1);
            $limits = Kohana::config('catalog.limits');
            $limit = $limits[$limit_key];

            $pagination = Pagination::factory(array(
                    'current_page' => array('source' => 'query_string', 'key' => 'page'),
                    'total_items' => $count_products,
                    'items_per_page' => $limit,
                    'view' => '/pagination_r'));
            
            if($id == 220)
            {
                $products = DB::query(Database::SELECT, 'SELECT id FROM products_product WHERE brand_id ="" AND visibility = 1 AND status = 1 AND set_id NOT IN (340,365,374,378,390)
					ORDER BY ' . $orderby . ' ' . $queue . ',display_date desc, id desc LIMIT ' . $pagination->items_per_page . ' OFFSET ' . $pagination->offset)
					->execute()->as_array();  
            }
            else
            {
				$products = DB::query(Database::SELECT, 'SELECT id FROM products_product WHERE brand_id = ' . $id . ' AND visibility = 1 AND status = 1 AND set_id NOT IN (340,365,374,378,390)
					ORDER BY ' . $orderby . ' ' . $queue . ',display_date desc, id desc LIMIT ' . $pagination->items_per_page . ' OFFSET ' . $pagination->offset)
					->execute()->as_array();
            }
            $brands = DB::select()->from('products_brands')->where('id', '=', $id)->execute()->current();
            $this->template->content = View::factory('/brand_list')
                ->set('brands', $brands)
                ->set('products', $products)
                ->set('sorts', $sorts)
                ->set('limit', $limit)
                ->set('pagination', $pagination->render());
	        Cache::instance('memcache')->set($cache_key, $this->template, 7200);
	    }
	}

    public function action_brandpage()
    {
        $cache_key = "brandpage_" . Request::instance()->uri();
        $cache_key = preg_replace('/[^A-Za-z0-9_\/\-]+/i', '', $cache_key);
        $cache_content = Cache::instance('memcache')->get($cache_key);

        if (strlen($cache_content) > 100 AND !isset($_GET['cache']))
        {
            $this->template = $cache_content;
        }
        else
        {
            $brands = DB::select('id','name','label')->from('products_brands')->where('id', '>', 33)->execute()->as_array();
            foreach($brands as $key =>$value)
            {
                $brands[$key]['label'] = substr($value['label'],0,1);
            }

            $newarr = array();
            foreach($brands as $key => $value)
            {
                if($value['id'] !=71)
                {
                    $sname = $value['name'];
                    $snameFirst = $this->getoneword($sname);
                    if($snameFirst == strtoupper($value['label']))
                    {
                        if(empty($newarr[$snameFirst]))
                        {
                            $newarr[$snameFirst][0] = array('id'=>$value['id'],'name'=>$value['name']);
                        }
                        else
                        {
                            $arr = array('id'=>$value['id'],'name'=>$value['name']);
                            array_push($newarr[$snameFirst],$arr);
                        }
                    }
                }
            }

            ksort($newarr);

            $this->template->content = View::factory('brand_page')->set('brands', $newarr);
            Cache::instance('memcache')->set($cache_key, $this->template, 7200);
        }
    }

    public function getoneword($str)
    {
        if(empty($str)){return '';}  
        $fchar=ord($str{0});  
        if($fchar>=ord('A')&&$fchar<=ord('z')) return strtoupper($str{0});  
        $s1=iconv('UTF-8','gb2312',$str);  
        $s2=iconv('gb2312','UTF-8',$s1);  
        $s=$s2==$str?$s1:$str;  
        $asc=ord($s{0})*256+ord($s{1})-65536;  
        if($asc>=-20319&&$asc<=-20284) return 'A';  
        if($asc>=-20283&&$asc<=-19776) return 'B';  
        if($asc>=-19775&&$asc<=-19219) return 'C';  
        if($asc>=-19218&&$asc<=-18711) return 'D';  
        if($asc>=-18710&&$asc<=-18527) return 'E';  
        if($asc>=-18526&&$asc<=-18240) return 'F';  
        if($asc>=-18239&&$asc<=-17923) return 'G';  
        if($asc>=-17922&&$asc<=-17418) return 'H';  
        if($asc>=-17417&&$asc<=-16475) return 'J';  
        if($asc>=-16474&&$asc<=-16213) return 'K';  
        if($asc>=-16212&&$asc<=-15641) return 'L';  
        if($asc>=-15640&&$asc<=-15166) return 'M';  
        if($asc>=-15165&&$asc<=-14923) return 'N';  
        if($asc>=-14922&&$asc<=-14915) return 'O';  
        if($asc>=-14914&&$asc<=-14631) return 'P';  
        if($asc>=-14630&&$asc<=-14150) return 'Q';  
        if($asc>=-14149&&$asc<=-14091) return 'R';  
        if($asc>=-14090&&$asc<=-13319) return 'S';  
        if($asc>=-13318&&$asc<=-12839) return 'T';  
        if($asc>=-12838&&$asc<=-12557) return 'W';  
        if($asc>=-12556&&$asc<=-11848) return 'X';  
        if($asc>=-11847&&$asc<=-11056) return 'Y';  
        if($asc>=-11055&&$asc<=-10247) return 'Z';  
        return null;  
   }  

}
?>