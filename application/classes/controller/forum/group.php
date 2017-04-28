<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Description of file
 *
 * @package
 * @author    FangHao
 * @copyright    © 2010 Cofree Development Group
 */
class Controller_Forum_Group extends Controller_Webpage
{

	public function action_view()
	{
		$id = $this->request->param('id');
		$group_id = $id;
        $content['show_sticky'] = 1;
        $magic_param = NULL;
        $allow_new_topic = 1;

		$uri = explode('/', $this->request->uri);
		if(isset($uri[1]) AND $uri[1] == 'product')
		{
			$product_id = $id;
			$product = Product::instance($product_id)->get();
			if(empty ($product['id']))
			{
				$this->request->redirect(LANGPATH . '/404');
			}
			$content['product'] = $product;
            $group_id = Site::instance()->get_specific_group_id('product');
            $magic_param = $product_id;
        }
        elseif($id == Site::instance()->get_specific_group_id('product'))
        {
            $group_id = $id;
            $content['show_sticky'] = 0;
            $allow_new_topic = 0;
        }
        else
        {
            $group_id = $id ? $id : Site::instance()->get_specific_group_id('latest');
        }

        $group = Group::instance($group_id);
        $real_group = $group;

        if(!$real_group->get('id'))
        {
            $this->request->redirect(LANGPATH . '/404');
        }

        if($group_id == Site::instance()->get_specific_group_id('unreplied'))
        {
            $magic_param = 'unreplied';
            $group = Group::instance();
            $content['show_sticky'] = 0;
            $allow_new_topic = 0;
        }
        elseif($group_id == Site::instance()->get_specific_group_id('latest'))
        {
            $group = Group::instance();
            $content['show_sticky'] = 0;
            $allow_new_topic = 0;
            $meta_title = 'Forum: All Latest Posts - '.URLSTR;
            $meta_description = 'You can post your deal posts here, product questions reviews included. We appreciate your valuable opinions.';
        }

		$limit = Site::instance()->get('per_page');
		$count = $group->count_topics($magic_param);

		$pagination = Pagination::factory(array(
				'current_page' => array( 'source' => 'query_string', 'key' => 'page' ),
				'total_items' => $count,
				'items_per_page' => $limit,
				//            'uri_segment' => 'catalog/1?orderby='.$orderby.'&desc='.$desc,
				'view' => '/pagination',
				'auto_hide' => FALSE
				)
		);
		$content['group'] = $real_group->get();
		$content['topics'] = $group->topics($magic_param,$pagination->offset,$pagination->items_per_page,$content['show_sticky']);
        $content['pagination'] = $pagination->render();
        $content['allow_new_topic'] = $allow_new_topic;
	    
        View::set_global('meta_title', isset($meta_title) ? $meta_title : 'Share Your Views about '.((isset($uri[1]) AND $uri[1] == 'product') ? $product['name'] : $real_group->get('name')));
		View::set_global('meta_description', isset($meta_description) ? $meta_description : 'Your opinions are important to us! Share your experience '.((isset($uri[1]) AND $uri[1] == 'product') ? 'with '.$product['name'] :'').' and let more of your friends enjoy its benefits.');
        View::set_global('page_type','group');

		//TODO put SEO meta information into $content
		$this->request->response = View::factory('/group',$content)->render();
	}

}
