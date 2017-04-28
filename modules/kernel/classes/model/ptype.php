<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ptype extends ORM {

    protected $_filters = array(
        TRUE => array('trim' => NULL)
    );
    protected $_rules = array
        (
            'site_id'				=> array
            (
                'not_empty'			=> NULL,
            ),
            'name'			=> array
            (
                'not_empty'			=> NULL,
                'min_length'		=> array(1),
                'max_length'		=> array(255),
            ),
        );

    public function get()
    {
        $data = array();
        $data['id'] = $this->id;
        $data['site_id'] = $this->site_id;
        $data['properties'] = unserialize($this->properties);
        $data['attributes'] = unserialize($this->attributes);
        $data['parameters'] = unserialize($this->parameters);

        return $data;
    }

}

