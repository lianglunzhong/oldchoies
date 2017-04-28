<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Set extends Controller_Admin_Site
{

    public function action_list()
    {
        $data = ORM::factory('set')
            ->where('site_id', '=', $this->site_id)
            ->find_all();

        $content = View::factory('admin/site/set_list')->set('data', $data)->render();

        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_add()
    {

        if($_POST)
        {
            $items = array( );
            $data['name'] = Arr::get($_POST['set'], 'name','');
            $data['brief'] = Arr::get($_POST['set'], 'brief', '');
            $data['label'] = preg_replace('/[^a-zA-Z0-9]+/','_',trim(Arr::get($_POST['set'],'label','')));
            $data['site_id'] = $this->site_id;

            $same_label = DB::query(Database::SELECT,'SELECT id,name FROM sets WHERE site_id = '.$this->site_id." AND label = '".$data['label']."'")->execute('slave')->as_array();
            
            if(count($same_label))
            {
                Message::set('保存出错：Label 与 <a href="/admin/site/set/edit/'.$same_label[0]['id'].'">'.$same_label[0]['name'].'</a> 重复！','error');
                $this->request->redirect('/admin/site/set/add');
            }

            $set = ORM::factory('set')->values($data);
            if($set->check())
            {
                $set->save();
                $attributes = Arr::get($_POST['set'],'attribute',array());
                foreach( $attributes as $key=>$item )
                {
                    $attribute = ORM::factory('attribute', $item);
					//$set->add('attributes', $attribute);
					if($attribute->loaded())
					{
						DB::query(Database::INSERT,'INSERT INTO set_attributes(set_id,attribute_id,position) values('.$set->id.','.$attribute->id.','.$key.')')->execute();
					}
                }

                message::set('添加商品类型成功。');
                Request::instance()->redirect('/admin/site/set/edit/'.$set->id);
            }
            else
            {
                message::set('添加商品类型出错，请重试。','error');
                Request::instance()->redirect('/admin/site/set/add');
            }
        }

        $content_data['attributes_all'] = ORM::factory('attribute')
            ->where('site_id','=',$this->site_id)
            ->find_all();

        $content = View::factory('admin/site/set_add',$content_data)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_edit()
    {
        $id = $this->request->param('id');
        $set = ORM::factory('set')
            ->where('site_id', '=', $this->site_id)
            ->where('id', '=', $id)
            ->find();

        if( ! $set->loaded())
        {
            message::set('商品类型不存在');
            Request::instance()->redirect('/admin/site/set/list');
        }

        if($_POST)
        {
            $items = array( );
            $data['name'] = Arr::get($_POST['set'], 'name', NULL);
            $data['brief'] = Arr::get($_POST['set'], 'brief', NULL);
            $data['label'] = preg_replace('/[^a-zA-Z0-9]+/','_',trim(Arr::get($_POST['set'],'label','')));

            $same_label = DB::query(Database::SELECT,'SELECT id,name FROM sets WHERE site_id = '.$this->site_id.' AND id != '.$id." AND label = '".$data['label']."'")->execute('slave')->as_array();
            
            if(count($same_label))
            {
                Message::set('保存出错：Label 与 <a href="/admin/site/set/edit/'.$same_label[0]['id'].'">'.$same_label[0]['name'].'</a> 重复！','error');
                $this->request->redirect('/admin/site/set/edit/'.$id);
            }

            $set->values($data);
            if($set->check())
            {
                $set->save();
                $attributes = Arr::get($_POST['set'],'attribute',array());
                foreach( $attributes as $key=>$item )
                {
                    $attribute = ORM::factory('attribute', $item);
					if($attribute->loaded())
					{
						if($set->has('attributes', $attribute))
						{
							DB::query(Database::UPDATE,'UPDATE set_attributes set position = '.$key.' WHERE set_id = '.$set->id.' AND attribute_id = '.$attribute->id)->execute();
						}
						else
						{
							DB::query(Database::INSERT,'INSERT INTO set_attributes(set_id,attribute_id,position) values('.$set->id.','.$attribute->id.','.$key.')')->execute();
						}
					}
                }

                //删除没有用到的attribute
                $original_attributes = $set->attributes->find_all();
                foreach($original_attributes as $attribute)
                {
                    if( ! in_array($attribute->id,$attributes))
                    {
                        $set->remove('attributes',$attribute);
                    }
                }

                message::set('修改商品类型成功。');
                Request::instance()->redirect('/admin/site/set/list');
            }
            else
            {
                message::set('修改商品类型出错，请检查数据并重试。','error');
                Request::instance()->redirect('/admin/site/set/edit/'.$id);
            }
        }

        $content_data['data'] = $set;
        $content_data['attributes_current'] = $set->attributes->order_by('position')->find_all();
        $content_data['attributes_all'] = ORM::factory('attribute')->where('site_id', '=', $this->site_id)->find_all();
        $content = View::factory('admin/site/set_edit',$content_data)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_delete()
    {
        $id = $this->request->param('id');

        $set = ORM::factory('set', $id);
        $product = $set->products->find();
        if($product->id !== NULL)
        {
            Message::set('Can not delete a set which has product(s) using it.','error');
        }
        else
        {
            DB::delete('set_attributes')->where('set_id','=',$id)->execute();
            $set->delete();
            Message::set('Product Set deleted successfully.');
        }

        Request::instance()->redirect('/admin/site/set/list');
    }

    public function action_export()
    {
        $set_id = $this->request->param('id');
        $set = ORM::factory('set',$set_id);
        // set not loaded
        if(!$set->loaded())
        {
            $this->request->redirect('/admin/site/set/list');  
        }

        $result = DB::select('attribute_id')->from('set_attributes')->where('set_id','=',$set->id)->order_by('position')->execute('slave');
        $attribute_ids = array();
        foreach($result as $item)
        {
            $attribute_ids[] = $item['attribute_id'];
        }
        
        $filename = $set->label.'.csv';
        
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=".$filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');

        echo 'name,sku,price,market_price,cost,weight,stock,brief,description,';
        foreach($attribute_ids as $item)
        {
            $attribute = ORM::factory('attribute',$item); 
            if(!$attribute->loaded())
            {
                continue;            
            }
            echo  $attribute->label.":";
            if($attribute->type == 0)
            {
                $options = ORM::factory('option')->where('attribute_id','=',$attribute->id)->find_all();
                $tmp = array();
                foreach($options as $option)
                {
                    $tmp[] = $option->label; 
                }
                echo implode($tmp,";");
            }
            echo ',';
        }
        echo "\r\n";
        exit;
    }

    public function action_get_options(){
        $id = $this->request->param('id');

        $return = array();
        $used_for = Arr::get($_REQUEST,'used_for','promotion');
        $flag = $used_for == 'promotion' ? 'promo' : 'searchable';
        
        $attributes = Set::instance($id)->attributes();
        if($attributes)
        {
            foreach($attributes as $aid)
            {
                $attribute = Attribute::instance($aid);
                if(in_array($attribute->get('type'),array(0,1)) AND $attribute->get($flag) == 1 AND $options = $attribute->options())
                {
                    $return[$aid]['name'] = $attribute->get('name');
                    foreach($options as $opt)
                    {
                        $return[$aid]['options'][$opt['id']] = $opt['label'];
                    }
                }
            }
        }

        echo json_encode($return);
    }
}

