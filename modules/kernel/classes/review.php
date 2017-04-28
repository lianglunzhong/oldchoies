<?php defined('SYSPATH') or die('No direct script access.');

class Review
{
    private static $instances;
    private $product_id;

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
        $this->product_id = NULL;
        $this->_load($id);
    }

    public function _load($id)
    {
        if( !$id)
        {
            return FALSE;
        }

        $product = Product::instance($id)->get();
        if(!empty($product['id']))
        {
            $this->product_id = $id;
        }
    }

    public function set($r_data)
    {
        if($this->product_id)
        {
            $data['product_id'] = $this->product_id;
            $data['site_id'] = $this->site_id;
            $data['firstname'] = Arr::Get($r_data,'firstname','');
            $data['overall'] = Arr::Get($r_data,'overall',5);
            $data['quality'] = Arr::Get($r_data,'quality',5);
            $data['price'] = Arr::Get($r_data,'price',5);
            $data['fitness'] = Arr::Get($r_data,'fitness',5);
            $data['user_id'] = Arr::get($r_data,'user_id','');
            $data['order_id'] = Arr::get($r_data,'order_id',0);
            $data['content'] = htmlspecialchars(Arr::get($r_data,'content',''));
            $data['attribute'] = Arr::get($r_data,'attribute','');
            $data['height'] = Arr::get($r_data,'height','');
            $data['weight'] = Arr::get($r_data,'weight','');
            $data['time'] = time();

            $review = ORM::factory('review');
            $review->values($data);
            if($review->check())
            {
                $review->save();
                return intval($review->id);
            }
            else
            {
                return 'review_data_error';
            }
        }
        else
        {
            return 'product_does_not_exist';
        }
    }

    public function get($_offset = NULL,$_limit = NULL,$_orderby = NULL)
    {

        $where = $this->product_id ? ' WHERE reply_id = 0 AND product_id = '.$this->product_id.' ' : '';

        $limit = $_limit ? ' LIMIT '.($_offset? $_offset.',':'').$_limit : '';

        $orderby = $_orderby ? $_orderby : ' ORDER BY time DESC ';

        $result = DB::query(1,"SELECT * FROM reviews ".$where.$orderby.$limit)->execute()->as_array();

        return $result;
    }
	
    public function overall()
    {
        if(!$this->product_id)
        {
            return FALSE;
        }

        $data = array(
            'count' => 0,
            'rating' => 0
        );

        $result = DB::query(1,"SELECT sum(grade) AS sum,count(id) AS count FROM reviews WHERE product_id = ".$this->product_id)->execute()->current();

        if($result['count'])
        {
            $data['count'] = $result['count'];
            $data['rating'] = round($result['sum']/$result['count']);
        }

        if($data['rating'] < 1)
        {
            $data['rating'] = 5;
        }

        return $data;
    }
}
