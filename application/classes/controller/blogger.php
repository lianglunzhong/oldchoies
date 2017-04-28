<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Blogger extends Controller_Webpage
{
	public function action_programme()
        {
                //title
                $lang=LANGUAGE;
                $seoinfo=array(
                        "de"=>array("title"=>"Blogger Werden Wollen"),
                        "es"=>array("title"=>"Blogger de Moda"),
                        "fr"=>array("title"=>"Blogueur Cherché"),
                        "ru"=>array("title"=>"Блоггер Хочет"),
                        );
                if($lang!=""){
                    $this->template->title = $seoinfo[$lang]['title'];
                }else{
                    $this->template->title = "Blogger Wanted";
                }
                $this->template->content = View::factory('/fashion_blogger/programme');
        }
        
        public function action_read_policy()
        {
                $this->template->content = View::factory('/fashion_blogger/read_policy');
        }
        
        public function action_submit_information()
        {
                if(!Customer::logged_in())
                        $this->request->redirect(LANGPATH . '/customer/login?redirect='.$this->language.'/blogger/submit_information');
                if($_POST)
                {
                        $post['email'] = Arr::get($_POST, 'email', '');
                        $post['gender'] = Arr::get($_POST, 'gender', 0);
                        $post['country'] = Arr::get($_POST, 'country', '');
                        if(!$post['email'] OR !$post['country'])
                        {
                                Message::set(__('post_data_error'));
                                $this->request->redirect(LANGPATH . '/blogger/submit_information');
                        }
                        $result = DB::select('id')->from('celebrity_backups')->where('email', '=', $post['email'])->execute()->get('id');
                        if($result)
                        {
                                Message::set(__('newsletter_email_exits'));
                                $this->request->redirect(LANGPATH . '/blogger/submit_information');
                        }
                        $post['comment'] = Arr::get($_POST, 'comment', '');
                        $siteArr = Arr::get($_POST, 'sites', array());
                        $sites = array();
                        if($siteArr['url'][0])
                        {
                                foreach($siteArr['url'] as $key => $url)
                                {
                                        $site = array();
                                        $site['url'] = $url;
                                        $site['type'] = $siteArr['type'][$key];
                                        $site['flow'] = $siteArr['flow'][$key];
                                        $sites[] = $site;
                                }
                        }
                        $post['sites'] = serialize($sites);
                        $post['created'] = time();
                        $result = DB::insert('celebrity_backups', array_keys($post))->values($post)->execute();
                        if($result)
                        {
                                $this->request->redirect(LANGPATH . '/blogger/get_banner');
                        }
                }
                $this->template->content = View::factory('/fashion_blogger/submit_information');
        }
        
        public function action_get_banner()
        {
			if($this->language)
				{
					$result = DB::select()->from('banners_banner')
                    // ->where('site_id', '=', $this->site_id)
                    ->where('visibility', '=', 1)
					->where('type', '=', 'side')
                    ->where('lang', '=', $this->language)
                    ->order_by('position', 'ASC')
                    ->order_by('id', 'DESC')
                    ->execute()->as_array();
				}
            else
            {
					$result = DB::select()->from('banners_banner')
                    // ->where('site_id', '=', $this->site_id)
                    ->where('visibility', '=', 1)
					->where('type', '=', 'side')
                    ->where('lang', '=', '')
                    ->order_by('position', 'ASC')
                    ->order_by('id', 'DESC')
                    ->execute()->as_array();
            }
			
			$index_banners = array();
			foreach($result as $val)
			{
				$index_banners[] = $val;				
			}
                $this->template->content = View::factory('/fashion_blogger/get_banner')->set('index_banners', $index_banners);
        }
        
        public function action_check_email()
        {
                if($_POST)
                {
                        $email = Arr::get($_POST, 'email', '');
                        if(!$email OR !preg_match("/([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[.][a-z]{2,3}([.][a-z]{2})?/i",$email))
                                echo json_encode(1);
                        else
                        {
                                $result = DB::select('id')->from('celebrity_backups')->where('email', '=', $email)->execute()->get('id');
                                if($result)
                                        echo json_encode(1);
                                else
                                        echo json_encode(0);
                        }
                }
                exit;
        }
}