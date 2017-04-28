<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Elastic Search.
 *
 * @category   Liabrary
 * @author     jimmy 
 * @copyright  (c) 2012-2016 'In Vogue'
 * @license    shijiangming09@gmail.com
 */

require(dirname(__FILE__) . '/elastic/' . 'vendor/autoload.php');

class Elastic
{

    /**
     * @var  string  default Elastic adapter
     */
    public static $default = 'product';

    // Elastic instances
    public static $instances;

    public $elastic_type;
    public $elastic_index;

    public $_client;

    /**
     * Creates a new Elastic Search of the given type. 
     *
     *     $elastic = Elastic::instance('product', 'basic', 'de');
     *
     * @param   string   type of elasticsearch (product, catalog, etc)
     * @param   string   index of elasticsearch (basic, attribute, etc)
     * @param   string   language of elasticsearch (de, es, fr, etc)
     * @return  array
     */
    public static function instance($type = NULL, $index = 'basic', $language = '')
    {
        if ($type === NULL)
        {
            // Use the default type
            $type = self::$default;
        }

        $instance_key = $type . '_' . $index . '_' . $language;

        if ( ! isset(self::$instances[$instance_key]))
        {
            // Set the Elastic class name
            $class =  __CLASS__;

            // Create a new Elastic instance
            self::$instances[$instance_key] = new $class($type, $index, $language);
        }

        return self::$instances[$instance_key];
    }

    /**
     *
     * @param   string   type of elasticsearch (product, catalog, etc)
     * @param   string   index of elasticsearch (basic, attribute, etc)
     * @param   string   language of elasticsearch (de, es, fr, etc)
     * @return  void
     *
     */
    protected function __construct($type, $index, $language)
    {
        require(dirname(__FILE__) . '/elastic/config.php');
        if(!isset($elastic_host))
            $elastic_host = 'localhost:9200';
        $host_params = array(
            'hosts' => array($elastic_host),
        );
        $this->elastic_type = $type . '_' . $language;
        $this->elastic_index = $type . '_' . $index . '_' . $language;
        $this->_client = new Elasticsearch\Client($host_params);

        // Initial index
        $index_params = array('index' => $this->elastic_index);
        if(!$this->_client->indices()->exists($index_params))
        {
            $params = array();
            $params['index'] = $this->elastic_index;
            $params['type'] = $this->elastic_type;
            $params['body'] = array('test' => 'test');
            $this->_client->index($params);
        }
    }

    /**
     * Create Elastc Search index data
     *
     *     $datas = array(
     *         0 => array('name' => 'test11', 'title' => 'test12'),
     *         1 => array('name' => 'test21', 'title' => 'test22'),
     *         ...
     *     );
     *
     * @param   array   data for body
     * @return  array   response for create_index
     *
     */
    public function create_index($datas = array())
    {
        $responses = array();
        if(!empty($datas))
        {
            $params = array();
            $params['index'] = $this->elastic_index;
            $params['type'] = $this->elastic_type;
            foreach($datas as $key => $data)
            {
                // if exists continue
                $has = self::search((string)($data['id']), array('id'));
                if(isset($has['hits']) && $has['hits']['total'] > 0)
                {
                    self::update(array('id' => $data['id']), $data);
                    $responses[$key] = 2;
                    #continue;
                }
                else
                {
                    foreach($data as $name => $val)
                    {
                        // Coding charactor utf8
                        if(!is_numeric($val))
                        {
                            $data[$name] = trim($val);
                        }
                        else
                        {
                            $data[$name] = (float) $val;
                        }
                    }
                    $params['body'] = $data;
                    try
                    {
                        $params['id'] = $data['id'];
                        $this->_client->index($params);
                        $responses[$key] = 1;

                    }
                    catch (Excption $e)
                    {
                        $responses[$key] = 0;
                    }
                }
            }
        }
        return $responses;
    }

    /**
     * Search
     *
     *      $fields = array('name', 'title', 'description', ... );
     *      $filter = array(
     *          'term' => array(
     *              'visibility' => '1',
     *              'has_pick' => '1',
     *              ...
     *           ),
     *          'match' => array(
     *              'attributes' => 'SizeL',
     *              ...
     *           ),
     *          'range' = array(
     *              'price' => array(100, 150),
     *              'created' => array(1002334234, 124350345),
     *              ...
     *          )
     *      )
     *      
     *      $order_by = array(
     *          'name' => 'desc',
     *          'price' => 'asc',
     *          ...
     *      )
     *      
     *
     * @param   string  search keywords
     * @param   array   search fields
     * @param   int     count per page
     * @param   int     page num
     * @param   array   filter
     * @param   array   order by
     * @return  array   response for search
     *
     */
    public function search($keywords = '', $fields = array(), $size = 10, $from = 0, $filter = array(), $order_by = array())
    {
        if($size > 10000)
        {
            $size = 10000;
        }
        $responses = array();

        $params = array();
        $params['index'] = $this->elastic_index;
        $params['type'] = $this->elastic_type;
        $params['size'] = $size;
        $params['from'] = $from;
        $params['body'] = array(
            'query' => array(
                'filtered' => array()
            )
        );

        if($keywords)
        {
            $keywords = trim(htmlspecialchars($keywords));
            $params['body']['query']['filtered']['query'] = array(
                'multi_match' => array(
                    'query' => $keywords,
                    'fields' => $fields,
                )
            );
        }
        // order by
        $sorts = array();
        if(!empty($order_by))
        {
            foreach($order_by as $field => $queue)
            {
                if(strtolower($queue) == 'desc')
                {
                    $sorts[$field] = array('order' => 'desc');
                }
                else
                {
                    $sorts[$field] = array('order' => 'asc');
                }
            }
            
        }
        if(!empty($sorts))
        {
            $params['body']['sort'] = $sorts;
        }

        //filter
        $filter_must_should = array();
        if(!empty($filter))
        {
            $musts = array();
            if(!empty($filter['term']))
            {
                foreach($filter['term'] as $name => $term)
                {
                    $musts[] = array('term' => array($name => $term));
                }
            }
            if(!empty($filter['range']))
            {
                foreach($filter['range'] as $name => $range)
                {
                    if(isset($range[1]))
                    {
                        $musts[] = array(
                            'range' => array($name => array('gte' => $range[0], 'lte' => $range[1]))
                        );
                    }
                    else
                    {
                        $musts[] = array(
                            'range' => array($name => array('gte' => $range[0]))
                        );
                    }
                }
            }
            if(!empty($filter['match']))
            {
                $shoulds = array();
                foreach($filter['match'] as $name => $match)
                {
                    $shoulds[] = array('query' => 
                        array('match' => array($name => $match))
                    );
                }
            }
            if(!empty($musts))
            {
                $filter_must_should['must'] = $musts;
            }
            if(!empty($shoulds))
            {
                $filter_must_should['should'] = $shoulds;
            }
        }
        
        if(!empty($filter_must_should))
        {
            $params['body']['query']['filtered']['filter'] = array(
                "bool" => $filter_must_should,
            );
        }

        try
        {
            $responses = $this->_client->search($params);
        }
        catch (Excption $e)
        {
            $responses['error'] = $e;
        }
        return $responses;
    }

    /**
     * Search One
     *
     * $elastic->update(array('id' => '123') OR array('sku' => 'ADKKF'));
     *
     * @param   array   search data
     * @return  array   search result
     *
     */
    public function search_one($search_data = array())
    {
        if(!empty($search_data))
        {
            $params = array();
            $params['index'] = $this->elastic_index;
            $params['type'] = $this->elastic_type;
            $params['body']['query']['match'] = $search_data;
            $search_result = $this->_client->search($params);
            return $search_result;
        }
        else
        {
            return array();
        }
    }

    /**
     * Update
     *
     * $elastic->update(array('sku' => 'EXA2VB'), array('name' => 'Test1'));
     *
     * @param   array   search data
     * @param   array   update data
     * @return  int     update success count
     *
     */
    public function update($search_data = array(), $update_data = array())
    {
        $success = 0;
        if(!empty($search_data) && !empty($update_data))
        {
            $params = array();
            $params['index'] = $this->elastic_index;
            $params['type'] = $this->elastic_type;
            $params['body']['query']['match'] = $search_data;
            $search_result = $this->_client->search($params);
            if(!empty($search_result['hits']['hits']))
            {
                $search_array = $search_result['hits']['hits'];
                foreach($search_array as $array)
                {
                    if(!empty($array['_index']) && !empty($array['_type']) && !empty($array['_id']))
                    {
                        $this->do_update($array['_index'], $array['_type'], $array['_id'], $update_data);
                        $success += 1;
                    }
                }
            }
        }
        
        return $success;
    }

    /**
     * DO Update STATIC
     *
     * @param   string  _index
     * @param   string  _type
     * @param   string  _id
     * @param   array   update data
     * @return  array
     *
     */
    public function do_update($_index, $_type, $_id = '', $update_data = array())
    {
        $params = array();
        $params['index'] = $_index;
        $params['type'] = $_type;
        $params['id'] = $_id;
        $params['body'] = array(
            'doc' => $update_data,
        );
        try
        {
            $client = $this->_client;
            $res = $client->update($params);
        }
        catch (Exception $e)
        {
            $res['error'] = $e;
        }
        return $res;
    }

    /**
     * Update
     *
     * $elastic->delete(array('sku' => 'EXA2VB'));
     *
     * @param   array   search data
     * @return  int     update success count
     *
     */
    public function delete($search_data = array())
    {
        $success = 0;
        if(!empty($search_data))
        {
            $params = array();
            $params['index'] = $this->elastic_index;
            $params['type'] = $this->elastic_type;
            $params['body']['query']['match'] = $search_data;
            $search_result = $this->_client->search($params);
            if(!empty($search_result['hits']['hits']))
            {
                $search_array = $search_result['hits']['hits'];
                foreach($search_array as $array)
                {
                    if(!empty($array['_index']) && !empty($array['_type']) && !empty($array['_id']))
                    {
                        $this->do_delete($array['_index'], $array['_type'], $array['_id']);
                        $success += 1;
                    }
                }
            }
        }
        
        return $success;
    }

    /**
     * Do Delete STATIC
     *
     * @param   string  _index
     * @param   string  _type
     * @param   string  _id
     * @return  array
     *
     */
    public function do_delete($_index, $_type, $_id = '')
    {
        $params = array();
        $params['index'] = $_index;
        $params['type'] = $_type;
        $params['id'] = $_id;
        try
        {
            $client = $this->_client;
            $res = $client->delete($params);
        }
        catch (Exception $e)
        {
            $res['error'] = $e;
        }
        return $res;
    }


    /**
     * Delete All
     *
     * @param   string  _index
     * @param   string  _type
     * @return  array
     *
     */
    public function delete_all()
    {
        $delete_params = array(
            'index' => $this->elastic_index,
        );
        try
        {
            $client = $this->_client;
            $res = $client->indices()->delete($delete_params);
        }
        catch (Exception $e)
        {
            $res['error'] = $e;
        }
        return $res;
    }

}