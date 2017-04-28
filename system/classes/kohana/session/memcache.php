<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Cookie-based session class.
 *
 * @package    Kohana
 * @category   Session
 * @author     Kohana Team
 * @copyright  (c) 2008-2009 Kohana Team
 * @license    http://kohanaphp.com/license
 */
class Kohana_Session_Memcache extends Session
{

        protected function _read($id = NULL)
        {
                return Cache::instance('memcache')->get($this->_name, NULL);
        }

        protected function _regenerate()
        {
                // Cookie sessions have no id
                return NULL;
        }

        protected function _write()
        {
                return Cache::instance('memcache')->set($this->_name, $this->__toString(), $this->_lifetime);
        }

        protected function _destroy()
        {
                return Cache::instance('memcache')->delete($this->_name);
        }

}

// End Session_Cookie
