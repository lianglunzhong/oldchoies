<?php
defined('SYSPATH') OR die('No direct script access.');

class Controller_Admin_Site_Group extends Controller_Admin_Site
{
    public function action_list()
    {
        $content = View::factory('admin/site/group_list')->render();
        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
    }

    public function action_add()
    {
        if($_POST)
        {
            $data['name'] = htmlspecialchars(Arr::get($_POST,'name',''));
            $data['description'] = htmlspecialchars(Arr::get($_POST,'description',''));
            $data['type'] = Arr::get($_POST,'type',0);
            $data['site_id'] = $this->site_id;
            $group = ORM::factory('group');
            $group->values($data);
            if($group->check())
            {
                $group->save();
                Message::set(__('group_add_success'));
                $this->request->redirect('/admin/site/group/edit/'.$group->id);
            }
            else
            {
                Message::set(__('group_data_error'));
            }
        }
        $content = View::factory('admin/site/group_add')->render();
        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
    }

    public function action_edit()
    {
        $id = $this->request->param('id');

        $group = ORM::factory('group',$id);
        if($group->loaded())
        {
            if($_POST)
            {
                $data['name'] = htmlspecialchars(Arr::get($_POST,'name',''));
                $data['type'] = Arr::get($_POST,'type',0);
                $data['description'] = htmlspecialchars(Arr::get($_POST,'description',''));
                $group->values($data);
                if($group->check())
                {
                    $group->save();
                    Message::set(__('group_edit_success'));
                }
                else
                {
                    Message::set(__('group_data_error'),'error');
                }
                $this->request->redirect('admin/site/group/edit/'.$group->id);
            }
            $content_data['group'] = $group;
            $content = View::factory('admin/site/group_edit',$content_data)->render();
            $this->request->response = View::factory('admin/template')->set('content',$content)->render();
        }
        else
        {
            Message::set(__('group_does_not_exist'),'error');
            $this->request->redirect('/admin/site/group/list');
        }
    }

    public function action_delete()
    {
        $id = $this->request->param('id');

        $specifics = kohana::config('sites.'.Site::instance()->get('id').'.specific_groups');
        if(is_array($specifics))
        {
            $key = array_search($id,$specifics);
            if($key !== FALSE)
            {
                Message::set(__('Can not delete specific groups!'),'error');
                $this->request->redirect('/admin/site/group/list');
            }
        }

        $group = ORM::factory('group',$id);

        if($group->loaded())
        {
            $topics = DB::query(1,"SELECT id FROM topics WHERE group_id = ".$id)->execute('slave')->as_array('id','id');
            if(count($topics))
            {
                $posts = DB::query(1,"SELECT id,post_id FROM topic_posts WHERE topic_id in (".implode(',',$topics).")")->execute('slave')->as_array('id','post_id');
                DB::delete('posts')->where('id','in',$posts)->execute();
                DB::delete('topics')->where('id','in',$topics)->execute();
                DB::delete('topic_posts')->where('id','in',array_keys($posts))->execute();
            }
            $group->delete($id);
            Message::set(__('group_delete_success'));
        }
        else
        {
            Message::set(__('group_does_not_exist'),'error');
        }
        $this->request->redirect('/admin/site/group/list');
    }

    public function action_data()
    {
        $page = $_REQUEST['page']; // get the requested page
        $limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
        $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
        $sord = $_REQUEST['sord']; // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array( ));

        if($filters)
        {
            $filters = json_decode($filters);
        }

        $filter_sql = "";

        if($filters)
        {
            foreach( $filters->rules as $item )
            {
                $filter_sql .= " AND ".$item->field."='".$item->data."'";
            }
        }

        if( ! $sidx) $sidx = 1;

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if($totalrows) $limit = $totalrows;

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM groups WHERE site_id='.$this->site_id.$filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if($page > $total_pages) $page = $total_pages;
		if($limit < 0) $limit = 0;

		$start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if($start < 0) $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM groups WHERE site_id='.$this->site_id.' '.
            $filter_sql.' order by '.$sidx.' '.$sord.' limit '.$limit.' offset '.$start)->execute('slave');

        $response = array( );
		$response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        foreach( $result as $review )
        {
            $response['rows'][$i]['id'] = $review['id'];
            $response['rows'][$i]['cell'] = array(
                $review['id'],
                $review['name'],
                $review['description'],
            );
            $i++;
        }
        echo json_encode($response);
    }

    function action_topic()
    {
        $content = View::factory('admin/site/group_list_topic')->render();
        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
    }

    function action_data_topic()
    {
        $page = $_REQUEST['page']; // get the requested page
        $limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
        $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
        $sord = $_REQUEST['sord']; // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array( ));

        if($filters)
        {
            $filters = json_decode($filters);
        }

        $filter_sql = "";

        if($filters)
        {
            foreach( $filters->rules as $item )
            {
                $filter_sql .= " AND ".$item->field."='".$item->data."'";
            }
        }

        if( ! $sidx) $sidx = 1;

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if($totalrows) $limit = $totalrows;

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM topics WHERE site_id='.$this->site_id.$filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if($page > $total_pages) $page = $total_pages;
		if($limit < 0) $limit = 0;

		$start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if($start < 0) $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM topics WHERE site_id='.$this->site_id.' '.
            $filter_sql.' order by '.$sidx.' '.$sord.' limit '.$limit.' offset '.$start)->execute('slave');

        $response = array( );
		$response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        foreach( $result as $review )
        {
            $response['rows'][$i]['id'] = $review['id'];
            $response['rows'][$i]['cell'] = array(
                $review['id'],
                Group::instance($review['group_id'])->get('name'),
                Product::instance($review['product_id'])->get('sku'),
                $review['subject'],
                $review['content'],
                $review['top_post'],
                $review['last_post'],
                $review['sticky']==1?'Yes':'No',
                $review['locked']==1?'Locked':'Unlocked',
                $review['started_by'],
                $review['created'],
                $review['moderators'],
                date('Y-m-d',$review['mod_time']),
            );
            $i++;
        }
        echo json_encode($response);
    }

    function action_edit_topic()
    {
        $id = $this->request->param('id');

        $topic = ORM::factory('topic',$id);
        if($topic->loaded())
        {
            if($_POST)
            {
                $data['group_id'] = Arr::get($_POST,'group_id','');
                $product_sku = Arr::get($_POST,'product','');
                $product = $product_sku == ''? 0 : DB::query(DATABASE::SELECT,'SELECT id FROM products WHERE site_id = '.$this->site_id.' AND sku = "'.$product_sku.'"')->execute('slave')->current();
                $data['product_id'] = !$product ? '' : $product['id'];
                $data['subject'] = htmlspecialchars(Arr::get($_POST,'subject',''));
                $data['content'] = Arr::get($_POST,'content','');
                $data['top_post'] = Arr::get($_POST,'top_post',0);
                $data['last_post'] = Arr::get($_POST,'last_post',0);
                $data['sticky'] = Arr::get($_POST,'sticky','');
                $data['locked'] = Arr::get($_POST,'locked','');
                $started_by = Arr::get($_POST,'started_by','');
                $started = DB::query(DATABASE::SELECT,'SELECT id FROM customers WHERE site_id = '.$this->site_id.' AND email = "'.$started_by.'"')->execute('slave')->current();
                if(empty($started)) Message::set(__('topic_data_error'),'error');
                $data['started_by'] = $started['id'];
                $data['created'] = Arr::get($_POST,'created',0);
                $moderators = Arr::get($_POST,'moderators','');
                $data['mod_time'] = $data['sticky'] == $topic->sticky ? $topic->mod_time : time();
                if($moderators)
                {
                    $data['moderators'] = $topic->moderators;
                    if(preg_match("/^[0-9]+$/",$moderators))
                    {
                        if($data['moderators'])
                        {
                            $data['moderators'] .= ','.$moderators;
                        }
                        else
                        {
                            $data['moderators'] = $moderators;
                        }
                    }
                    elseif (preg_match( '/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/',$moderators))
                    {
                        $moderators_id = DB::select('id')->from('accounts_customers')->where('email','=',$moderators)->execute('slave')->current();
                        if(!empty($moderators_id))
                        {
                            if($data['moderators'])
                            {
                                $data['moderators'] .= ','.$moderators_id['id'];
                            }
                            else
                            {
                                $data['moderators'] = $moderators_id['id'];
                            }
                        }
                    }
                }
                
                $topic->values($data);
                if($topic->check())
                {
                    $topic->save();
                    Message::set(__('topic_edit_success'));
                }
                else
                {
                    Message::set(__('topic_data_error'),'error');
                }
                $this->request->redirect('admin/site/group/edit_topic/'.$topic->id);
            }
            $content_data['topic'] = $topic;
            $content = View::factory('admin/site/group_edit_topic',$content_data)->render();
            $this->request->response = View::factory('admin/template')->set('content',$content)->render();
        }
        else
        {
            Message::set(__('Topic does not exist!'),'error');
            $this->request->redirect('/admin/site/group/topic');
        }
    }

    function action_delete_topic()
    {
        $id = $this->request->param('id');

        $topic = ORM::factory('topic',$id);

        if($topic->loaded())
        {
            $posts = DB::query(1,"SELECT id,post_id FROM topic_posts WHERE topic_id =".$id)->execute('slave')->as_array('id','post_id');
            if(!empty($posts)) 
            {
                DB::delete('posts')->where('id','in',$posts)->execute();
                DB::delete('topic_posts')->where('id','in',array_keys($posts))->execute();
            }
            $topic->delete($id);
            Message::set(__('group_delete_success'));
        }
        else
        {
            Message::set(__('group_does_not_exist'),'error');
        }
        $this->request->redirect('/admin/site/group/topic');
    }

    function action_post()
    {
        $content = View::factory('admin/site/group_list_post')->render();
        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
    }

    function action_data_post()
    {
        $page = $_REQUEST['page']; // get the requested page
        $limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
        $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
        $sord = $_REQUEST['sord']; // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array( ));

        if($filters)
        {
            $filters = json_decode($filters);
        }

        $filter_sql = "";

        if($filters)
        {
            foreach( $filters->rules as $item )
            {
                $filter_sql .= " AND ".$item->field."='".$item->data."'";
            }
        }

        if( ! $sidx) $sidx = 1;

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if($totalrows) $limit = $totalrows;

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM posts WHERE site_id='.$this->site_id.$filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if($page > $total_pages) $page = $total_pages;
		if($limit < 0) $limit = 0;

		$start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if($start < 0) $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT t.*,p.topic_id FROM posts t left join topic_posts p ON(t.id = p.post_id) WHERE t.site_id='.$this->site_id.' '.
            $filter_sql.' order by '.$sidx.' '.$sord.' limit '.$limit.' offset '.$start)->execute('slave');

        $response = array( );
		$response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        foreach( $result as $review )
        {
            $response['rows'][$i]['id'] = $review['id'];
            $response['rows'][$i]['cell'] = array(
                $review['id'],
                $review['topic_id'],
                Customer::instance($review['user_id'])->get('email'),
                $review['title'],
                $review['content'],
                $review['video_url'],
                date('Y-m-d',$review['pub_time']),
            );
            $i++;
        }
        echo json_encode($response);
    }

    function action_edit_post()
    {
        $id = $this->request->param('id');

        $post = ORM::factory('post',$id);
        if($post->loaded())
        {
            if($_POST)
            {
                $data['title'] = Arr::get($_POST,'title','');
                $data['content'] = Arr::get($_POST,'content','');
                $data['video_url'] = htmlspecialchars(Arr::get($_POST,'video_url',''));
                $post->values($data);
                if($post->check())
                {
                    $post->save();
                    Message::set(__('post_edit_success'));
                }
                else
                {
                    Message::set(__('post_data_error'),'error');
                }
                $this->request->redirect('admin/site/group/edit_post/'.$post->id);
            }
            $content_data['post'] = $post;
            $content = View::factory('admin/site/group_edit_post',$content_data)->render();
            $this->request->response = View::factory('admin/template')->set('content',$content)->render();
        }
        else
        {
            Message::set(__('Post does not exist!'),'error');
            $this->request->redirect('/admin/site/group/post');
        }
    }

    function action_delete_post()
    {
        $id = $this->request->param('id');

        $post = ORM::factory('post',$id);

        if($post->loaded())
        {
            DB::delete('topic_posts')->where('post_id','=',$id)->execute();
            $post->delete($id);
            Message::set(__('post_delete_success'));
        }
        else
        {
            Message::set(__('post_does_not_exist'),'error');
        }
        $this->request->redirect('/admin/site/group/post');
    }

}

