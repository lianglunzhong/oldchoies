<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Model extends Controller_Admin_Site
{

    public function action_list()
    {
        $models = DB::select()->from('models')->order_by('id', 'DESC')->execute()->as_array();
        $content = View::factory('admin/site/model_list')->set('models', $models)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }
    
    public function action_add()
    {
        if($_POST)
        {
            $id = Arr::get($_POST, 'id', 0);
            if($id == 0)
            {
                $data = array(
                    'name' => trim(Arr::get($_POST, 'name', '')),
                    'height' => trim(Arr::get($_POST, 'height', '')),
                    'bust' => trim(Arr::get($_POST, 'bust', '')),
                    'waist' => trim(Arr::get($_POST, 'waist', '')),
                    'hip' => trim(Arr::get($_POST, 'hip', '')),
                    'created' => time(),
                );
                DB::insert('models', array_keys($data))->values($data)->execute();
                Message::set('Add data success', 'success');
            }
            else
            {
                $data = array(
                    'name' => trim(Arr::get($_POST, 'name', '')),
                    'height' => trim(Arr::get($_POST, 'height', '')),
                    'bust' => trim(Arr::get($_POST, 'bust', '')),
                    'waist' => trim(Arr::get($_POST, 'waist', '')),
                    'hip' => trim(Arr::get($_POST, 'hip', '')),
                );
                DB::update('models')->set($data)->where('id', '=', $id)->execute();
                Message::set('Edit data success', 'success');
            }
        }
        $this->request->redirect('/admin/site/model/list');
    }
    
    public function action_delete()
    {
        $id = $this->request->param('id');
        $id = trim($id);
        if($id)
        {
            DB::delete('models')->where('id', '=', $id)->execute();
            Message::set('Delete data success', 'success');
        }
        $this->request->redirect('/admin/site/model/list');
    }

}

?>