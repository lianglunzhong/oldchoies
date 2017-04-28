<?php
defined('SYSPATH') or die('No direct script access.');

class Set
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
		$this->_load($id);
	}

	public function _load($id)
	{
		if( ! $id)
		{
			return FALSE;
		}

		$cache = Cache::instance('memcache');
		$key = $this->site_id."/set1/".$id;
		if( ! ($data = $cache->get($key)))
		{
			$data = array( );
			$result = DB::select()->from('products_set')
					->where('id', '=', $id)
					->execute()->current();

			if($result['id'] !== NULL)
			{
				$data['id'] = $result['id'];
				$data['name'] = $result['name'];
				$data['brief'] = $result['brief'];
				$data['label'] = $result['label'];
				$data['catemanger'] = $result['catemanger'];

				$cache->set($key, $data);
			}
		}

		$this->data = $data;
	}

	/**
	 * 获取set的基本数据
	 * @param <type> $key 数据名称。
	 * @return <type> 如果给出$key，则返回$key指定的数据内容(String Or Integer..)。如不填，则返回产品的所有基本数据(Array)。
	 */
	public function get($key = NULL)
	{
		if(empty($key))
		{
			return $this->data;
		}

		return isset($this->data[$key]) ? $this->data[$key] : '';
	}

	/**
	 * 返回set下的所有attribute
	 * @return array  一维数组，key无意义，value为attribute id(integer)
	 */
	public function attributes()
	{
		$cache = Cache::instance();
		$key = $this->site_id."/set/".$this->data['id'].'/attributes';
		if( ! ($data = $cache->get($key)))
		{
			$result = DB::select('attribute_id')->from('set_attributes')
					->where('set_id', '=', $this->data['id'])
					->order_by('position')
                    ->order_by('id')
					->execute();

			$data = array( );
			foreach( $result as $attribute )
			{
				$data[] = $attribute['attribute_id'];
			}

			$cache->set($key, $data);
		}
		return $data;
	}

	/**
	 * 返回set 的结构
	 * @return array 多维数组，包含set下的每个attributes的详细信息及其可选项或者默认值
	 */
	public function structure()
	{
		$cache = Cache::instance();
		$key = $this->site_id."/set/".$this->data['id'].'/structure';
		if( ! $data = $cache->get($key))
		{
			$data = array( );

			$attribute_ids = $this->attributes();
			foreach( $attribute_ids as $attribute_id )
			{
				$attribute = Attribute::instance($attribute_id);

				if($attribute->get('type') > 1)
				{
					$data[$attribute->get('id')] = $attribute->get();
				}
				elseif($attribute->get('type') <= 1)
				{
					$options = $attribute->options();
					$data[$attribute->get('id')] = $attribute->get();
					$data[$attribute->get('id')]['options'] = $options;
				}
			}

			$cache->set($key, $data);
		}

		return $data;
	}

}
