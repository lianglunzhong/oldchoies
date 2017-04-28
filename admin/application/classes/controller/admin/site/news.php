<?php  defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_News extends Controller_Admin_Site
{
    public function action_list()
    {
		$count = ORM::factory('new')
				->count_all();

		$pagination = Pagination::factory(
				array(
					'current_page' => array( 'source' => 'query_string', 'key' => 'page' ),
					'total_items' => $count,
					'item_per_page' => 10,
					'view' => 'pagination/basic',
					'auto_hide' => 'FALSE',
				)
		);
		$page_view = $pagination->render();

		$data = ORM::factory('new')
				->where('site_id', '=', $this->site_id) ->order_by('id','DESC')
				->find_all($pagination->items_per_page, $pagination->offset);

		$content = View::factory('admin/site/news_list')
				->set('data', $data)
				->set('page_view', $page_view)->render();
		$this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function  action_add()
    {
        $content = View::factory('admin/site/news_add');
        $this->request->response = view::factory('admin/template')->set('content',$content)->render();
    }

    public function action_add_go()
    {
        if( $_POST)
        {
             $data = array();
            $data['title'] =  Arr::get($_POST, 'title', '');
            $data['content'] =  Arr::get($_POST, 'content', '');

            $rs = News::instance()->add($data);
            if( $rs == TRUE)
            {
                message::set("新闻添加成功！");
                Request::instance()->redirect('/admin/site/news/list');
            }
            else
            {
                message::set('新闻添加失败，请重新添加;');
            }
        }
    }

    public function action_edit()
    {
          $news_id = $this->request->param('id');
           $news = ORM::factory('new')->where('id','=',$news_id)->find();
           $content = View::factory('admin/site/news_edit')->set('news',$news);
        $this->request->response = view::factory('admin/template')->set('content',$content)->render();
    }

    public function action_edit_go()
    {
          if( $_POST)
        {
             $news_id =  Arr::get($_POST, 'id', '');
             $news = ORM::factory('new')->where('id','=',$news_id)->find();
            $news->title  =  Arr::get($_POST, 'title', '');
            $news->content =  Arr::get($_POST, 'content', '');
            $news->create_date = time();
            $news->save();
            if( $news->saved() == TRUE)
            {
                message::set("新闻修改成功！");
                Request::instance()->redirect('/admin/site/news/list');
            }
            else
            {
                message::set('新闻修改失败，请重新尝试;');
            }
        }
    }

    public function action_del()
    {
        $news_id = $this->request->param('id');
        $news_del = ORM::factory('new')->where('id','=',$news_id)->delete_all();
        message::set('新闻删除成功');
        Request::instance()->redirect('/admin/site/news/list');

    }

    public function action_elastic()
    {
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $sku = Arr::get($_GET, 'sku', '');
        $id = Product::get_productId_by_sku($sku);
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        // $res = $elastic->delete_all();
        // print_r($res);exit;
        
        // $products = DB::select('id', 'name', 'sku', 'description', 'keywords')
        //     ->from('products_product')
        //     ->where('visibility', '=', 1)
        //     ->where('status', '=', 1)
        //     ->order_by('id', 'desc')
        //     ->limit(10)->offset(30)
        //     ->execute('slave')->as_array();
        // $responses = $elastic->create_index($products);
        // print_r($responses);

        // /* SEARCH */

        //$res = $elastic->search($sku, array('name', 'sku', 'description'), 5, 0);
        $res = $elastic->search((string)($id), array('id'));
        // /* UPDATE */
        // // $res = $elastic->update(array('sku' => 'EXA2VB'), array('name' => 'Golden Faux Pearl Embellished Through Hook Earrings Test'));

        // /* DELETE */
        // // $res = $elastic->delete(array('sku' => 'EXA2VB'));
        echo '<pre>';
        print_r($res);
        exit;
    }

    public function action_action_elastic_delete()
    {
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $sku = Arr::get($_GET, 'sku', '');
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        $array = array(
                'sku'=>$sku,
            );
        $res = $elastic->delete($array);
        print_r($res);
        die;
    }

    public function action_product_url_status()
    {
        $products = DB::select('id', 'link')->from('products_product')
            ->where('visibility', '=', 1)
            ->limit(10)
            ->execute();
        $domain = Site::instance()->get('domain');
        foreach($products as $p)
        {
            $url = 'http://' . $domain . '/product/' . $p['link'] . '_p' . $p['id'];
            echo $url . '--------' . $this->GetHttpStatusCode($url) . '<br>' . "\n";
        }
    }

    function GetHttpStatusCode($url){   
        $curl = curl_init();  
        curl_setopt($curl,CURLOPT_URL,$url);//获取内容url  
        curl_setopt($curl,CURLOPT_HEADER,1);//获取http头信息  
        curl_setopt($curl,CURLOPT_NOBODY,1);//不返回html的body信息  
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);//返回数据流，不直接输出  
        curl_setopt($curl,CURLOPT_TIMEOUT,30); //超时时长，单位秒  
        curl_exec($curl);  
        $rtn= curl_getinfo($curl,CURLINFO_HTTP_CODE);  
        curl_close($curl);  
        return  $rtn;  
    }  

    public function action_test_mysql()
    {
        $link = @mysql_connect('192.168.186.157', 'clothes', 'choiesnewpass123123') OR die(mysql_error());
        mysql_select_db('clothes',$link);
        $sql = 'SELECT id FROM sites WHERE id = 1';
        $query = mysql_query($sql);
        $array = mysql_fetch_array($query);
        print_r($array);exit;
    }
}

?>
