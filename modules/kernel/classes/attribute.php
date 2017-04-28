<?php defined('SYSPATH') or die('No direct script access.');

class Attribute
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

        $cache = Cache::instance();
        $key = $this->site_id."/attribute/".$id;
        if(!($data = $cache->get($key)))
        {
            $data = array( );
            $result = DB::select()->from('attributes')
                ->where('id', '=', $id)
                ->execute()->current();

            if($result['id'] !== NULL)
            {
                $data['id'] = $result['id'];
                $data['name'] = $result['name'];
                $data['label'] = $result['label'];
                $data['brief'] = $result['brief'];
                $data['scope'] = $result['scope'];
                $data['default_value'] = $result['default_value'];
                $data['required'] = $result['required'];
                $data['promo'] = $result['promo'];
                $data['searchable'] = $result['searchable'];
                $data['view'] = $result['view'];
                $data['site_id'] = $result['site_id'];
                $data['type'] = $result['type'];

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

        if($key == 'options')
        {
            return $this->options();
        }
        else
        {
            return isset($this->data[$key]) ? $this->data[$key] : '';
        }
    }

    public function options()
    {
        $cache = cache::instance();
        $key = $this->site_id."/attribute/".$this->data['id'].'/options';
        if( ! ($data = $cache->get($key)))
        {
            $result = DB::select()->from('options')
                ->where('attribute_id', '=', $this->data['id'])
                ->order_by('position', 'ASC')
                ->execute();

            $data = array( );
            foreach( $result as $option )
            {
                $data[$option['id']] = $option;
            }
            $cache->set($key, $data);
        }
        return $data;
    }

    public function get_value($product_id)
    {
        if( ! isset($this->data['id']))
        {
            return FALSE;
        }

        $values = array( );
        if($this->get('type') > 1)
        {
            $value_result = DB::query(1, "SELECT value FROM product_attribute_values WHERE product_id = '".$product_id."' AND attribute_id = '".$this->data['id']."';")->execute()->as_array();
            if(count($value_result))
            {
                return $value_result[0]['value'];
            }
        }
        elseif($this->get('type') <= 1)
        {
            $options = array_keys($this->options());
            if($options)
            {
                $value_result = DB::query(1, "SELECT option_id FROM product_options WHERE product_id = '".$product_id."' AND option_id IN ('".implode("','", $options)."') LIMIT 0,1;")->execute()->as_array();
                if(count($value_result))
                {
                    return Option::instance($value_result[0]['option_id'])->get('label');
                }
            }
        }

        return FALSE;
    }

    public function get_associated_products($_limit = 1, $_offset = 0)
    {
        if( ! isset($this->data['id']))
        {
            return FALSE;
        }

        if(in_array($this->data['type'],array(0,1)))
        {
            $option_ids = DB::select('id')
                ->from('options')
                ->and_where('attribute_id','=',$this->data['id'])
                ->execute()
                ->as_array('id','id');

            if(count($option_ids))
            {
                $result = DB::select('product_id')
                    ->from('product_options')
                    ->where('option_id','in',$option_ids);
            }
        }
        else
        {
            $result = DB::select('product_id')
                ->from('product_attribute_values')
                ->where('attribute_id','=',$this->data['id']);
        }

        if($_limit > 0)
        {
            $result = $result->limit($_limit)->offset($_offset);
        }

        $result = $result->execute();

        $data = array();
        foreach($result as $re)
        {
            $data[] = $re['product_id'];
        }

        return $data;
    }

    public function delete_options()
    {
        if( ! isset($this->data['id']))
        {
            return FALSE;
        }

        if(in_array($this->data['type'],array(0,1)))
        {
            $options = DB::delete('options')
                ->and_where('attribute_id','=',$this->data['id'])
                ->execute();
        }

        return TRUE;
    }

}
