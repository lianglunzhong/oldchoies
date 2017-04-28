<?php 

class ORM extends Kohana_ORM
{
    public function list_columns()
    {
        $main_tables = array(
            'users', 
            'sites', 
            'lines', 
            'roles', 
            'roletasks', 
            'tasks', 
        );

        if (in_array($this->_table_name, $main_tables))
        {
            // use default database
            return $this->_db->list_columns($this->_table_name);
        }

        $site_id = Session::instance()->get('SITE_ID', 0);
        return Database::instance($site_id)->list_columns($this->_table_name);
    }
}
