<?php defined('SYSPATH') or die('No direct script access.');

class Topic
{

    private static $instances;
    private $data;
    private $site_id;

    public static function & instance($id = 0)
    {
        if(!isset(self::$instances[$id]))
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
        if(!$id)
        {
            return FALSE;
        }

        $data = array( );
        $result = DB::select()->from('topics')
            ->where('id', '=', $id)
            ->execute()->current();

        if($result['id'] !== NULL)
        {
            $data['id'] = $result['id'];
            $data['group_id'] = $result['group_id'];
            $data['product_id'] = $result['product_id'];
            $data['subject'] = htmlspecialchars($result['subject']);
            $data['content'] = $result['content'];
            $data['top_post'] = $result['top_post'];
            $data['last_post'] = $result['last_post'];
            $data['views'] = $result['views'];
            $data['sticky'] = $result['sticky'];
            $data['locked'] = $result['locked'];
            $data['started_by'] = $result['started_by'];
            $data['created'] = $result['created'];
            $data['moderators'] = $result['moderators'];
            $data['mod_time'] = $result['mod_time'];
            $data['add_ip'] = $result['add_ip'];
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

        return isset($this->data[$key]) ? $this->data[$key] : '';
    }

    public function posts($_offset = NULL, $_limit = NULL)
    {
        if(!$this->get('id'))
        {
            return array( );
        }

        $_limit ? $limit = ' LIMIT '.($_offset ? $_offset.',' : '').$_limit : $limit = '';

        $results = DB::query(1, "SELECT post_id FROM topic_posts WHERE topic_id = '".$this->get('id')."' ORDER BY post_id ".$limit)->execute();
        $data = array( );
        foreach( $results as $re )
        {
            $data[] = $re['post_id'];
        }

        return $data;
    }

    public function count_posts()
    {
        if(!$this->get('id'))
        {
            return array( );
        }
        $data = DB::query(1, "SELECT count(post_id) AS count FROM topic_posts WHERE topic_id = '".$this->get('id')."';")->execute()->current();

        return $data['count'];
    }

    public function set($data)
    {
        $t_data['group_id'] = Arr::get($data, 'group_id', NULL);
        $t_data['product_id'] = Arr::get($data, 'product_id', 0);
        $t_data['subject'] = Arr::get($data, 'subject', 'No Subject');
        $t_data['content'] = Arr::get($data, 'content', 'No Content');
        $t_data['top_post'] = $t_data['last_post'] = 0;
        // $t_data['site_id'] = $this->site_id;
        $t_data['started_by'] = Arr::get($data, 'started_by', 0);
        $t_data['created'] = Arr::get($data, 'created', 0);
        $t_data['add_ip'] = Arr::get($data, 'add_ip', 0);

        $topic = ORM::factory('topic');
        $topic->values($t_data);
        if($topic->check())
        {
            $topic->save();
            return intval($topic->id);
        }
        else
        {
            return 'topic_data_error';
        }
    }

    public function add_views()
    {
        DB::query(3,"UPDATE topics SET views = views + 1 WHERE id = ".$this->data['id'])->execute();
    }


    public function delete()
    {
        if($this->data['id'])
        {
            $posts = $this->posts();
            DB::delete('posts')->where('id','in',$posts)->execute();
            DB::delete('topic_posts')->where('topic_id','=',$this->data['id'])->execute();
            DB::delete('topics')->where('id','=',$this->data['id'])->execute();
            return TRUE;
        }
        return FALSE;
    }

}
