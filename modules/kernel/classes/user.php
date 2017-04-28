<?php defined('SYSPATH') or die('No direct script access.');

class User 
{
    private static $instances;
    private $data;

    public static function & instance($id = 0)
    {
        if( !isset(self::$instances[$id])) {
            $class = __CLASS__;
            self::$instances[$id] = new $class($id);
        }
        return self::$instances[$id];
    }

    public function __construct($id)
    {
        $this->_load($id);
    }

    public function _load($id)
    {
        if($id)
        {
            $user = ORM::factory('user', $id);
            if ($user->loaded())
            {
                $data = $user->as_array();
                $data['password'] = '';
                $this->data = $data;
            }
        }
    }

    public function get($key = NULL)
    {
        if(empty($key))
        {
            return $this->data;
        }
        else
        {
            return isset($this->data[$key]) ? $this->data[$key] : '';
        }
    }

    public function login($data)
    {
        $email = $data['email'];
        $password = $data['password'];

        $user = ORM::factory('user')
            ->where('email', '=', $email)
            ->where('password', '=', toolkit::hash($password))
            ->find();

        $user->loaded() ? $user_id = $user->id : $user_id = 0;
        return $user_id;
    }

    public function logged_in()
    {
        $session = Session::instance();
        $user_id = $session->get('user_id');
        if(isset($user_id) AND $user_id != 0)
        {
            $user = User::instance($user_id)->get();
            return $user;
        }
        else
        {
            return FALSE;
        }
    }

    public function register($data)
    {
        $user = ORM::factory('user');
        // hash password
        $data['password'] = toolkit::hash($data['password']);

        $user->values($data);
        if($user->check())
        {
            $user->created = time();
            $user->save();
            return $user->id;
        }
        else
        {
            return FALSE;
        }
    }

    public function is_register($email)
    {
        $user = ORM::factory('user')
            ->where('email', '=', $email)
            ->find();

        $user->loaded() ? $user_id = $user->id : $user_id = 0;
        return $user_id;
    }

    public function delete($id)
    {
        $orm = ORM::factory('user', $id);

        if($orm->loaded())
        {
            return $orm->delete();
        }
        else
            return false;
    }

    public function edit($id,$data)
    {
        $role = ORM::factory('user')
            ->where('id', '=', $id)
            ->find();
        $role->values($data);

        if($role->check())
        {
            $role->save();
            return true;
        }
        else
            return false;
    }
    
    public function get_views()
    {
            $role_id = $this->data['role_id'];
            $role = ORM::factory('role')->where('id', '=', $role_id)->find();
            return unserialize($role->views);
    }
    
    public function get_edits()
    {
            $role_id = $this->data['role_id'];
            $role = ORM::factory('role')->where('id', '=', $role_id)->find();
            return unserialize($role->edits);
    }
}
