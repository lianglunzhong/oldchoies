<?php

class Database_Query extends Kohana_Database_Query
{
    public function execute1($db = 'default')
    {
        // route query to different db with table name in sql
        $site_id = Session::instance()->get('SITE_ID', 0);
        if ($site_id) {
            $sql = $this->_sql ? $this->_sql 
                : $this->compile(Database::instance());
            $table = '';

            switch ($this->_type) {
            case Database::SELECT:
                    $db = 'slave';
            case Database::DELETE:
                $n = preg_match('/from\s+(\S+)/i', $sql, $matches);
                break;
            case Database::INSERT:
                $n = preg_match('/into\s+([^\s\(]+)/i', $sql, $matches);
                break;
            case Database::UPDATE:
                $n = preg_match('/update\s+(\S+)/i', $sql, $matches);
                break;
            }

            if ($n) {
                $table = trim($matches[1], "` \t\n\r\0\x0B");
                $main_tables = array(
                    'users', 
                    'sites', 
                    'lines', 
                    'roles', 
                    'roletasks', 
                    'tasks', 
                );
                if (!in_array($table, $main_tables)) {
//                    $db = Database::instance($site_id);
                        $db = Database::instance($db);
                }
                if ($table=='sites')
                	@parent::execute(Database::instance($site_id));
            }
        }

        return parent::execute($db);
    }
}
