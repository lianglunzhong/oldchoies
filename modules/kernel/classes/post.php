<?php
defined('SYSPATH') or die('No direct script access.');

class Post
{

    private static $instances;
    private $data;
    private $site_id;

    public static function & instance($id = 0)
    {
        if( ! isset(self::$instances[$id]))
        {
            $class = __CLASS__;
            self::$instances[$id] = new $class($id);
        }
        return self::$instances[$id];
    }

    public function __construct($id)
    {
        $this->site_id = Site::instance()->get('id');
        $this->data = NULL;
        $this->_load($id);
    }

    public function _load($id)
    {
        if( ! $id)
        {
            return FALSE;
        }

        $cache = Cache::instance();
        $key = $this->site_id."/post/".$id;
        if( ! ($data = $cache->get($key)))
        {
            $data = array( );
            $result = DB::select()->from('posts')
                ->where('id', '=', $id)
                ->execute()->current();

            if($result['id'] !== NULL)
            {
                $data['id'] = $result['id'];
                $data['user_id'] = $result['user_id'];
                $data['title'] = $result['title'];
                $data['content'] = $result['content'];
                $data['video_url'] = $result['video_url'];
                $data['pub_time'] = $result['pub_time'];
                $data['add_ip'] = $result['add_ip'];

                $cache->set($key, $data);
            }
        }
        if(count($data))
        {
            $this->data = $data;
        }
    }

    public function get($key = NULL)
    {
        if(empty($key))
        {
            return $this->data;
        }

        if($key ==  'content')
        {
            return Toolkit::format_html($this->data['content']);
        }

        if($key == 'topic_id')
        {
            $result = DB::select('topic_id')->from('topic_posts')->where('post_id','=',$this->data['id'])->execute()->current();
            return $result['topic_id'] ?  $result['topic_id'] : NULL;
        }

        return isset($this->data[$key]) ? $this->data[$key] : '';
    }

    public function set($p_data,$is_reply = 1)
    {
        $data['topic_id'] = Arr::get($p_data,'topic_id',NULL);
        $data['user_id'] = Arr::get($p_data, 'user_id', 0);
        $data['title'] = Arr::get($p_data,'title',NULL);
        $data['content'] = Arr::get($p_data, 'content', '');
        $data['video_url'] = Arr::get($p_data, 'video_url', NULL);
        $data['pub_time'] = time();
        // $data['site_id'] = $this->site_id;
        $data['add_ip'] = Arr::get($p_data, 'add_ip', 0);

        $topic = ORM::factory('topic', $data['topic_id']);
        if($topic->loaded())
        {
            if($topic->locked == 1)
            {
                return 'topic_locked';
            }
        }
        else
        {
            return 'topic_does_not_exist';
        }

        $post = ORM::factory('post');
        $post->values($data);
        if($post->check())
        {
            $post->save();
            $topic->add('posts',$post);
            if($is_reply)
            {
                $topic->last_post = $post->id;
                $topic->save();
            }
            return intval($post->id);
        }
        else
        {
            return 'post_data_error';
        }
    }
}
