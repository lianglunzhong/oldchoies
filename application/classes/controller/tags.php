<?php defined('SYSPATH') or die('No direct script access.');

class Controller_tags extends Controller_Webpage
{
	public function action_index()
	{
		$link = $this->request->param('link');
		if($link!='')
		{
			$label=ORM::factory('label')
					->where('site_id','=',Site::instance()->get('id'))
					->where('url','=',$link)
					->find();
			//tag page
			if($label->loaded())
			{
				$this->set_meta('niche',$label->niche);
				if($label->meta_title!='')
				{
					$meta_title=str_replace('{WORD}',strtoupper($label->niche),str_replace('{Word}',ucfirst($label->niche),str_replace('{word}',strtolower($label->niche),$label->meta_title)));
					View::set_global('meta_title',$meta_title);
				}
				if($label->meta_keywords!='')
				{
					$meta_keywords=str_replace('{WORD}',strtoupper($label->niche),str_replace('{Word}',ucfirst($label->niche),str_replace('{word}',strtolower($label->niche),$label->meta_keywords)));
					View::set_global('meta_keywords',$meta_keywords);
				}
				if($label->meta_description!='')
				{
					$meta_description=str_replace('{WORD}',strtoupper($label->niche),str_replace('{Word}',ucfirst($label->niche),str_replace('{word}',strtolower($label->niche),$label->meta_description)));
					View::set_global('meta_description',$meta_description);					
				}
				if($label->description!='')
				{
					$label->description=str_replace('{WORD}',strtoupper($label->niche),str_replace('{Word}',ucfirst($label->niche),str_replace('{word}',strtolower($label->niche),$label->description)));
				}
				$product_ids=explode(',',$label->product_ids);
				foreach ($product_ids as $key=>$product_id)
				{
					$product=ORM::factory('product')
								->where('id','=',$product_id)
								->where('visibility','=',1)
								->find();
					if(!$product->loaded())
						unset($product_ids[$key]);
				}
				if($label->catalog_id!='')
				{
					$search_column='catalog_id';
					$search_value=$label->catalog_id;
				}
				else 
				{
					$search_column='defined_catalog_link';
					$search_value=$label->defined_catalog_link;
				}
				$related_labels=ORM::factory('label')
								->where('site_id','=',Site::instance()->get('id'))
								->where($search_column,'=',$search_value)
								->order_by('id','ASC')
								->find_all();
				$related=array();
				foreach ($related_labels as $r)
				{
					if($r->id<=$label->id)
						continue;
					$related[]=$r;
				}
				if(!empty($related))
				{
					$related=array_chunk($related,10);
					$related=$related[0];
				}
				$this->request->response =  View::factory('/tags_display')
													->set('label', $label)
													->set('product_ids', $product_ids)
													->set('related', $related)
													->render();		
			}
			else 
			{
				$this->request->redirect(LANGPATH . '/404');
			}
		}
		else
		{
			//All tags
			$labels=ORM::factory('label')
						->where('site_id','=',Site::instance()->get('id'))
						->where('is_active','=',1)
						->order_by('created','DESC')
						->limit(40)
						->find_all();
			$data['latest']=$labels;
			$data['catalogs']=array();
			//get catalogs link and number
			$cats=DB::query(Database::SELECT, 'SELECT distinct catalog_id FROM labels WHERE site_id='.Site::instance()->get('id').' AND is_active=1')
						->execute()
						->as_array();
			foreach ($cats as $cat)
			{
				$catalog=ORM::factory('catalog')
							->where('site_id','=',Site::instance()->get('id'))
							->where('id','=',$cat['catalog_id'])
							->find();
				if($catalog->loaded())
				{
					$num=DB::query(Database::SELECT, 'SELECT count(*) as num FROM labels WHERE site_id='.Site::instance()->get('id').' AND catalog_id='.$catalog->id.' AND is_active=1')
						->execute()
						->current();
					$data['catalogs'][]=array(
												'name'=>$catalog->name,
												'link'=>$catalog->link,
												'num'=>$num['num']
											 );
				}
			}
			//get defined_catalogs link and number
			$cats=DB::query(Database::SELECT, 'SELECT distinct defined_catalog,defined_catalog_link FROM labels WHERE site_id='.Site::instance()->get('id').' AND is_active=1 AND defined_catalog<>\'null\' AND defined_catalog<>\'\'')
						->execute()
						->as_array();
			foreach ($cats as $cat)
			{
				$num=DB::query(Database::SELECT, 'SELECT count(*) as num FROM labels WHERE site_id='.Site::instance()->get('id').' AND defined_catalog=\''.$cat['defined_catalog'].'\' AND is_active=1')
					->execute()
					->current();
				$data['catalogs'][]=array(
											'name'=>$cat['defined_catalog'],
											'link'=>$cat['defined_catalog_link'],
											'num'=>$num['num']
										 );
			}
			$this->set_meta('list');
			$this->request->response =  View::factory('/tags_list')
								->set('data', $data)
								->set('labels', $labels)
								->render();	
		}
	}
	
	public function action_catalog()
	{
		$link = $this->request->param('link');
		$cat=ORM::factory('catalog')
					->where('site_id','=',Site::instance()->get('id'))
					->where('link','=',$link)
					->find();
		if($cat->loaded())
		{
			$labels=ORM::factory('label')
						->where('site_id','=',Site::instance()->get('id'))
						->where('catalog_id','=',$cat->id)
						->where('is_active','=',1)
						->find_all();
			$per_page=120;
			$pagination = Pagination::factory(array(
						                'total_items' => count($labels),
						                'items_per_page' => $per_page,
						                'view' => '/pagination',
						                'auto_hide' => True ))
										->render();
			$labels=ORM::factory('label')
						->where('site_id','=',Site::instance()->get('id'))
						->where('is_active','=',1)
						->where('catalog_id','=',$cat->id)
						->order_by('created','DESC')
						->offset($per_page * (Arr::get($_GET,'page',1)-1))
						->limit($per_page)
						->find_all();
			$this->set_meta("catalog",$cat->name);
			$this->request->response =  View::factory('/tags_catalog')
											->set('catalog', $cat->name)
											->set('labels', $labels)
											->set('page_view',$pagination)
											->render();		
		}
		else 
		{
			$this->request->redirect(LANGPATH . '/404');
		}
	}
	
	public function action_defined_catalog()
	{
		$link = $this->request->param('link');
		$labels=ORM::factory('label')
					->where('site_id','=',Site::instance()->get('id'))
					->where('is_active','=',1)
					->where('defined_catalog_link','=',$link)
					->find_all();
		$per_page=120;
		$pagination = Pagination::factory(array(
					                'total_items' => count($labels),
					                'items_per_page' => $per_page,
					                'view' => '/pagination',
					                'auto_hide' => True ))
									->render();
		$labels=ORM::factory('label')
					->where('site_id','=',Site::instance()->get('id'))
					->where('is_active','=',1)
					->where('defined_catalog_link','=',$link)
					->order_by('created','DESC')
					->offset($per_page * (Arr::get($_GET,'page',1)-1))
					->limit($per_page)
					->find_all();
		$this->set_meta("catalog",$labels[0]->defined_catalog);
		$this->request->response =  View::factory('/tags_catalog')
										->set('catalog', urldecode($link))
										->set('labels', $labels)
										->set('page_view',$pagination)
										->render();		
	}
	
	public function action_alpha($key)
	{
		if($key=='0-9')
		{
			$sign=">";
			$terms=0;
		}
		else 
		{
			$sign="like";
			$terms=$key."%";
		}
		$labels=ORM::factory('label')
					->where('site_id','=',Site::instance()->get('id'))
					->where('niche',$sign,$terms)
					->where('is_active','=',1)
					->find_all();
		$per_page=120;
		$pagination = Pagination::factory(array(
					                'total_items' => count($labels),
					                'items_per_page' => $per_page,
					                'view' => '/pagination',
					                'auto_hide' => True ))
									->render();
		//tags catalog
		$labels=ORM::factory('label')
					->where('site_id','=',Site::instance()->get('id'))
					->where('is_active','=',1)
					->where('niche',$sign,$terms)
					->order_by('created','DESC')
					->offset($per_page * (Arr::get($_GET,'page',1)-1))
					->limit($per_page)
					->find_all();
		$this->set_meta("catalog",$key);
		$this->request->response =  View::factory('/tags_catalog')
										->set('catalog', $key)
										->set('labels', $labels)
										->set('page_view',$pagination)
										->render();
											
	}
	
	public function set_meta($type,$word='')
	{
		$meta=ORM::factory("labelmeta")
				->where('site_id','=',Site::instance()->get('id'))
				->find();
		if(!$meta->loaded())
			return;
		$meta_title='';
		$meta_keywords='';
		$meta_description='';
		switch ($type)	{
			case 'list':
				$meta_title=$meta->list_meta_title;
				$meta_keywords=$meta->list_meta_keywords;
				$meta_description=$meta->list_meta_description;
				break;
			case 'catalog':
				$meta_title=str_replace('{WORD}',strtoupper($word),str_replace('{Word}',ucfirst($word),str_replace('{word}',strtolower($word),$meta->catalog_meta_title)));
				$meta_keywords=str_replace('{WORD}',strtoupper($word),str_replace('{Word}',ucfirst($word),str_replace('{word}',strtolower($word),$meta->catalog_meta_keywords)));
				$meta_description=str_replace('{WORD}',strtoupper($word),str_replace('{Word}',ucfirst($word),str_replace('{word}',strtolower($word),$meta->catalog_meta_description)));
				break;
			case 'niche':
				$meta_title=str_replace('{WORD}',strtoupper($word),str_replace('{Word}',ucfirst($word),str_replace('{word}',strtolower($word),$meta->niche_meta_title)));
				$meta_keywords=str_replace('{WORD}',strtoupper($word),str_replace('{Word}',ucfirst($word),str_replace('{word}',strtolower($word),$meta->niche_meta_keywords)));
				$meta_description=str_replace('{WORD}',strtoupper($word),str_replace('{Word}',ucfirst($word),str_replace('{word}',strtolower($word),$meta->niche_meta_description)));
				break;
		}
		View::set_global('meta_title',$meta_title);
		View::set_global('meta_keywords',$meta_keywords);
		View::set_global('meta_description',$meta_description);
	}
}