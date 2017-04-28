<?php defined('SYSPATH') or die('No direct script access.');

class Model_Role extends ORM
{
	protected $_filters = array(
		TRUE => array('trim' => NULL)
	);

	protected $_rules = array
	(
		'name'			=> array
		(
			'not_empty'			=> NULL,
		),
		'brief'			=> array
		(
			'not_empty'			=> NULL,
		),
        'parent_id'			=> array
		(
			'not_empty'			=> NULL,
		),
        'tasks' => array 
        (
            'not_empty' => NULL, 
        ), 
	);


    public function tasks($recursive=TRUE)
    {
        /*
        if($this->id == 1)
        {
            $task_template = kohana::config('task')->as_array();
            foreach($task_template as $key => $value)
            {
                foreach($value as $k => $v)
                {
                    $task_value[] = $v;
                }
            }
            return array_fill_keys($task_value,1);
        }
         */

        $tasks = $this->get_tasks($recursive);

        $task_template = kohana::config('task')->as_array();
        foreach($task_template as $key => $value)
        {
            foreach($value as $k => $v)
            {
                $task_value[] = $v;
            }
        }
        $task_template = array_fill_keys($task_value,0);

        if(!$tasks)
        {
            $tasks = $task_template;
        }
        else
        {
            foreach($tasks as $key=>$value)
            {
                if(isset($task_template[$key]))
                {
                    $task_template[$key] = $value; 
                } 
            }
            $tasks = $task_template;
        }
        $array = kohana::config('task_always_allowed')->as_array();
        $tasks = array_merge($tasks,$array);
        return $tasks;
    }

    public function lines()
    {
        $lines = trim($this->lines) ? explode(',', $this->lines) : array();
        if ($this->parent_id) {
            $parent_lines = ORM::factory('role', $this->parent_id)->lines();
            $lines = array_merge($lines, array_diff($parent_lines, $lines));
        }

        return $lines;
    }

    public function get_tasks($recursive=TRUE)
    {
        $tasks = DB::select('tasks')
            ->from('roles')
            ->where('id', '=', $this->id)
            ->execute()
            ->get('tasks');

        $tasks = $tasks ? unserialize($tasks) : array();

        if ($recursive && $this->parent_id) {
            $parent = ORM::factory('role', $this->parent_id);
            $tasks = array_merge($parent->get_tasks($recursive), $tasks);
        }

        return $tasks;
    }
}
