<?php

defined('SYSPATH') or die('No direct script access.');
class Controller_Admin_Site_Pla extends Controller_Admin_Site
{
	public function action_index(){
		$languages = Kohana::config('sites.'.$this->site_id.'.language');
        $lang = Arr::get($_GET, 'lang');
        if(!in_array($lang, $languages))
        {
            $lang = '';
        }
       
	        $list=DB::query(Database::SELECT, "SELECT * FROM pla ")->execute('slave')->as_array();
	   
	        $content = View::factory('admin/site/pla')
	            ->set('languages', $languages)
	            ->set('lang', $lang)
	            ->set('lists',$list)
	            ->render();
	        
			$this->request->response = View::factory('admin/template')->set('content', $content)->render();
        
	}

	public function action_add(){
		$pla=Arr::get($_POST,'pla');
		$data['feed']=trim(Arr::get($_POST,'feed'));
		$data['uid']=trim(Arr::get($_POST,'uid'));
		if(Arr::get($_POST,'id')){$id=Arr::get($_POST,'id');};	
		$data['custom_label_0']=Arr::get($_POST,'custom_label_0');
		$data['custom_label_1']=Arr::get($_POST,'custom_label_1');
		$data['custom_label_2']=Arr::get($_POST,'custom_label_2');
		$data['custom_label_3']=Arr::get($_POST,'custom_label_3');
		$data['custom_label_4']=Arr::get($_POST,'custom_label_4');
		$data['promotion']=trim(Arr::get($_POST,'promotion'));
		$data['country']=Arr::get($_POST,'country');
		$data['title']=trim(Arr::get($_POST,'title1')).'++++'.trim(Arr::get($_POST,'title2'));
		$data['description']=trim(Arr::get($_POST,'description1')).'++++'.trim(Arr::get($_POST,'description2'));
		$data['custom_label']=trim(Arr::get($_POST,'zdy'));
		$data['status']=0;
		$data['lang']=trim(Arr::get($_POST,'lang'));
		//custom_label_4
		if(trim(Arr::get($_POST,'title1'))){
			$data['position']='1-';
		}else{
			$data['position']='0-';
		}
		if(trim(Arr::get($_POST,'title2'))){
			$data['position'].='1=';
		}else{
			$data['position'].='0=';
		}

		if(trim(Arr::get($_POST,'description1'))){
			$data['position'].='1-';
		}else{
			$data['position'].='0-';
		}
		if(trim(Arr::get($_POST,'description2'))){
			$data['position'].='1';
		}else{
			$data['position'].='0';
		}
		
		
		if($pla=='add'){
			$sql='';
			$feed=$data['feed'];
			//$sql="select * from pla where feed='$feed' and uid='$uid' and  title = '$title' and  description = '$description' and  custom_label_0 = '$custom_label_0' and  custom_label_1 = '$custom_label_1' and  custom_label_2 = '$custom_label_2' and  custom_label_3 = $custom_label_3  and  custom_label_4 = '$custom_label_4'	and  promotion = '$promotion' and  country = '$country' and position={$position}";
		$sql="select * from pla where feed='$feed' and country='{$data['country']}'";
			//$sql="select * from pla where country='{$data['country']}' ";
			$res=DB::query(Database::SELECT,$sql);
			$row=$res->execute()->as_array();
		
			if(!$row){	
					$query=DB::insert('pla',array('feed','uid','custom_label_0','custom_label_1','custom_label_2','custom_label_3','custom_label_4','promotion','country','title','description','custom_label','status','lang','position'))->values($data);
					$query->execute();
					Request::instance()->redirect('admin/site/pla/index');	
						
			}else{		
				$query=DB::update('pla')->set($data)->where('id','=',$row[0]['id']);
				$query->execute();
				Request::instance()->redirect('admin/site/pla/index');
			}
		}elseif($pla=='edit'){

			$query=DB::update('pla')->set($data)->where('id','=',$id);
			$query->execute();
			Request::instance()->redirect('admin/site/pla/index');
		}
	}

	public function action_edit(){
		$languages = Kohana::config('sites.'.$this->site_id.'.language');
        $lang = Arr::get($_GET, 'lang');
        if(!in_array($lang, $languages))
        {
            $lang = '';
        }
		$id=Arr::get($_GET,'id');
		if($id){
			$list=DB::query(Database::SELECT, "SELECT * FROM pla where id={$id}")->execute('slave')->as_array();

			$explode0= explode('=',$list[0]['position']);
			$explode1= explode('-',$explode0[0]);
			$explode2= explode('-',$explode0[1]);
			$title=explode('++++',$list[0]['title']);
			$description=explode('++++',$list[0]['description']);
			$list[0]['checkbox1']=$explode1;
			$list[0]['checkbox2']=$explode2;
			$list[0]['title']=$title;
			$list[0]['description']=$description;
		}else{
			$list[0]=array();
		}
        	 $content = View::factory('admin/site/pla_edit')
	            ->set('languages', $languages)
	            ->set('lang', $lang)
	            ->set('lists',$list)
	            ->render();
	        
			$this->request->response = View::factory('admin/template')->set('content', $content)->render();
	}

/*	public function action_delete(){
		$id=Arr::get($_GET,'id');
		$data['deleted']=1;
        	$query=DB::update('pla')->set($data)->where('id','=',$id);
			$query->execute();
	        Request::instance()->redirect('admin/site/pla/index');
	}*/

	public function action_get(){
		$id=Arr::get($_GET,'id');
		$country=Arr::get($_GET,'c');
	    $list=DB::query(Database::SELECT, "SELECT * FROM pla where id=$id")->execute('slave')->as_array();
	    //将脚本不使用的数据，status=0
	    $data['status']=0;
	    $query=DB::update('pla')->set($data)->where('country','=',"$country");
		$query->execute();
		//脚本要使用的数据，status设置成1
		$data['status']=1;
		$query=DB::update('pla')->set($data)->where('id','=',"$id");
		$query->execute();
	 	$country=$list[0]['country'];
	    if($country=='US'){
	    	$country='';
	    }
	   
	    $country=strtolower($country);
	    if($country=="ca"){
	    	$country='Txtca';
	    }

	    Request::instance()->redirect("http://www.choies.com/webpowerfor/mihqtgylls{$country}"); 
	}

}

