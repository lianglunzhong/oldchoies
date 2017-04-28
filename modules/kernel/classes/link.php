<?php defined('SYSPATH') or die('No direct script access.');

class Link
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
        $result = DB::select()->from('links')
            ->where('id', '=', $id)
            ->execute()->current();

        if($result['id'] !== NULL)
        {
            $data['id'] = $result['id'];
            $data['name'] = $result['name'];
            $data['email'] = $result['email'];
            $data['subject'] = $result['subject'];
            $data['message'] = $result['message'];
            $data['is_valid'] = $result['is_valid'];
            $data['level'] = $result['level'];
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

        return isset($this->data[$key]) ? $this->data[$key] : '';
    }

    public function set($data)
    {
        $t_data['name'] = Arr::get($data, 'name', '');
        $t_data['email'] = Arr::get($data, 'email', '');
        $t_data['subject'] = Arr::get($data, 'subject', '');
        $t_data['message'] = Arr::get($data, 'message', '');
        $t_data['is_valid'] = Arr::get($data, 'is_valid', 0);
        $t_data['site_id'] = $this->site_id;
        $t_data['level'] = Arr::get($data, 'level', 0);
        $t_data['add_time'] = Arr::get($data, 'add_time', 0);

        $topic = ORM::factory('link');
        $topic->values($t_data);
        if($topic->check())
        {
            $topic->save();
            return intval($topic->id);
        }
        else
        {
            return 'links_data_error';
        }
    }

    public function delete()
    {
        if($this->data['id'])
        {
            DB::delete('links')->where('id','=',$this->data['id'])->execute();
            return TRUE;
        }
        return FALSE;
    }

}
