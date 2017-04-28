<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Description of file
 *
 * @package
 * @author    FangHao
 * @copyright    © 2010 Cofree Development Group
 */
class Controller_Forum_Topic extends Controller_Webpage
{

	public function action_view()
	{
        $id = $this->request->param('id');
        
		$topic = Topic::instance($id);
		$content['topic'] = $topic->get();

		if(empty($content['topic']))
		{
			$this->request->redirect(LANGPATH . '/');
		}
		$product_id = $topic->get('product_id');

		if(!empty($product_id))
		{
			$product = Product::instance($product_id)->get();
			$content['product'] = $product;
		}

		$limit = Site::instance()->get('per_page');
		$count = $topic->count_posts();

		if((isset($_GET['page']) AND $_GET['page'] == 'last'))
		{
			$_GET['page'] = ceil($count/$limit);
		}
		$pagination = Pagination::factory(array(
				'current_page' => array( 'source' => 'query_string', 'key' => 'page' ),
				'total_items' => $count,
				'items_per_page' => $limit,
				//            'uri_segment' => 'catalog/1?orderby='.$orderby.'&desc='.$desc,
				'view' => '/pagination',
				'auto_hide' => FALSE
				)
		);
		$content['group'] = Group::instance($topic->get('group_id'))->get();
		$content['posts'] = $topic->posts($pagination->offset,$pagination->items_per_page);
		$content['pagination'] = $pagination->render();

        View::set_global('meta_title', $topic->get('subject').' - '.URLSTR);
        View::set_global('meta_description', htmlspecialchars(preg_replace('/<[^>]*>/','',Post::instance($content['posts'][0])->get('content'))));
        View::set_global('page_type','topic');

        $content['is_moderator'] = FALSE;
        if(($content['customer_id'] = Customer::instance()->logged_in()) AND Customer::instance($content['customer_id'])->is_forum_moderator())
        {
            $content['is_moderator'] = TRUE;
        }

		//TODO put SEO meta information into $content
		$content['topic']['views'] += 1;
		$topic->add_views();
		$this->request->response = View::factory('/topic',$content)->render();
	}

	public function action_add()
    {
        if($_POST)
        {
            if($user_id = Customer::instance()->logged_in())
            {
                $data = $_POST;
                $data['user_id'] = $user_id;
                $topic_re = Topic::instance()->set($data);
                if(is_int($topic_re))
                {
                    Message::set(__('topic_add_success'));
                    $this->request->redirect(LANGPATH . '/forum/topic/'.$topic_re);
                }
                else
                {
                    Message::set(__('topic_data_error'),'error');
                    if(!empty($data['product_id']))
                    {
                        $this->request->redirect(LANGPATH . '/forum/product/'.$data['product_id']);
                    }
                    elseif(!empty($data['group_id']))
                    {
                        $this->request->redirect(LANGPATH . '/forum/'.$data['group_id']);
                    }
                    else
                    {
                        $this->request->redirect(LANGPATH . '/');
                    }
                }
            }
            else
            {
                Message::set(__('need_log_in'),'notice');
                $this->request->redirect(LANGPATH . '/customer/login');
            }         
        }
        else
        {
            $this->request->redirect(LANGPATH . '/');
        }  
    }

    public function action_reply()
    {
        if($_POST)
        {
            if($user_id = Customer::instance()->logged_in())
            {
                $data = $_POST;
                $data['user_id'] = $user_id;
                $post_re = Post::instance()->set($data);
                if(is_int($post_re))
                {
                    Message::set(__('topic_reply_success'));
                    $this->request->redirect(LANGPATH . '/forum/topic/'.$data['topic_id'].'/?page=last');
                }
                else
                {
                    Message::set(__('topic_data_error'),'error');
                    if(!empty($data['topic_id']))
                    {
                        $this->request->redirect(LANGPATH . '/forum/topic/'.$data['topic_id']);
                    }
                    else
                    {
                        $this->request->redirect(LANGPATH . '/');
                    }
                }
            }
            else
            {
                Message::set(__('need_log_in'),'notice');
                $this->request->redirect(LANGPATH . '/customer/login');
            }
        }
        else
        {
            $this->request->redirect(LANGPATH . '/');
        }
    }

    public function action_delete()
    {
        $id = $this->request->param('id');
        $post = Post::instance($id);
        $topic = Topic::instance($post->get('topic_id'));

        if($topic->get('id') AND ($user_id = Customer::instance()->logged_in()) AND Customer::instance($user_id)->is_forum_moderator())
        {
            if($id == $topic->get('top_post'))
            {
                $redirect = 'forum/'.($topic->get('product_id') ? 'product/'.$topic->get('product_id') : $topic->get('group_id'));
                $topic->delete();
                Message::set(__('topic_deleted'));
                $this->request->redirect($redirect);
            }
            else
            {
                DB::delete('topic_posts')->where('post_id','=',$id)->execute();
                DB::delete('posts')->where('id','=',$id)->execute();

                Message::set(__('post_deleted'));
            }
        }
        else
        {
            Message::set(__('invalid_request'),'error');
        }
        $this->request->redirect(LANGPATH . '/forum/topic/'.$topic->get('id'));
    }

    public function action_sticky()
    {
        $id = $this->request->param('id');
        $topic = ORM::factory('topic',$id);

        if($topic->loaded() AND ($user_id = Customer::instance()->logged_in()) AND Customer::instance($user_id)->is_forum_moderator())
        {
            $topic->sticky = !$topic->sticky;
            $topic->save();
            Message::set(__('topic_'.($topic->sticky ? 'sticky' : 'unsticky').'_successfully'));
        }
        else
        {
            Message::set(__('invalid_request'),'error');
        }
        $this->request->redirect(LANGPATH . '/forum/topic/'.$id);
    }
}
