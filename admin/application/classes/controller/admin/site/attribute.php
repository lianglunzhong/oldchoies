<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Attribute extends Controller_Admin_Site
{

    public function action_list()
    {
        $data = ORM::factory('attribute')
            ->where('site_id', '=', $this->site_id)
            ->find_all();

        $content = View::factory('admin/site/attribute_list')
            ->set('data', $data)
            ->render();

        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_add()
    {
        if ($_POST)
        {
            $attribute = ORM::factory('attribute');
            $attribute->site_id = $this->site_id;
            $attribute->name = htmlspecialchars(Arr::get($_POST, 'name', NULL));
            $attribute->label = htmlspecialchars(Arr::get($_POST, 'label', NULL));
            $attribute->brief = htmlspecialchars(Arr::get($_POST, 'brief', NULL));
            $attribute->scope = Arr::get($_POST, 'scope', 0);
            $attribute->required = Arr::get($_POST, 'required', 0);
            $attribute->promo = Arr::get($_POST, 'promo', 0);
            $attribute->view = Arr::get($_POST, 'view', 0);
            $attribute->searchable = Arr::get($_POST, 'searchable', 0);
            $attribute->type = Arr::get($_POST, 'type', 0);
            $attribute->default_value = htmlspecialchars(Arr::get($_POST, 'default_value_' . $attribute->type, ''));

            if (in_array($attribute->type, array(0, 1)))
            {
                $labels = $_POST['option_label'];
                $positions = $_POST['option_position'];
                $defaults = 0; //TODO $_POST['option_default'];
                foreach ($labels as $key => $label)
                {
                    if ($label === '')
                    {
                        unset($labels[$key]);
                    }
                }
                if (!$labels)
                {
                    message::set('at_lease_one_option', 'error');
                    Request::instance()->redirect('admin/site/attribute/add');
                }
            }

            if ($attribute->check())
            {
                $attribute->save();

                if (in_array($attribute->type, array(0, 1)))
                {
                    foreach ($labels as $key => $label)
                    {
                        $option = ORM::factory('option');
                        $option->site_id = $this->site_id;
                        $option->label = htmlspecialchars($label);
                        $option->position = $positions[$key];
                        $option->attribute_id = $attribute->id;
                        $option->save();
                    }
                }

                message::set('添加产品规格成功');
                Request::instance()->redirect('admin/site/attribute/list');
            }
            else
            {
                message::set('数据未通过验证。', 'error');
                Request::instance()->redirect('admin/site/attribute/add');
            }
        }

        $content = View::factory('admin/site/attribute_add')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_edit()
    {
        $id = $this->request->param('id');
        $attribute = ORM::factory('attribute')
            ->where('site_id', '=', $this->site_id)
            ->where('id', '=', $id)
            ->find();

        if (!$attribute->loaded())
        {
            message::set('产品规格不存在。', 'notice');
            Request::instance()->redirect('admin/site/attribute/list');
        }
        if ($_POST)
        {
            $new_type = Arr::get($_POST, 'type', 0);
            if ((in_array($attribute->type, array(0, 1)) AND !in_array($new_type, array(0, 1))) OR (!in_array($attribute->type, array(0, 1)) AND in_array($new_type, array(0, 1))))
            {
                $attribute_obj = Attribute::instance($id);
                if (count($attribute_obj->get_associated_products()))
                {
                    Message::set('Can not change type of an attribute which has already been used by product(s).', 'error');
                    $this->request->redirect('admin/site/attribute/edit/' . $id);
                }
                else
                {
                    $attribute_obj->delete_options();
                }
            }

            $attribute->site_id = $this->site_id;
            $attribute->name = htmlspecialchars(Arr::get($_POST, 'name', NULL));
            $attribute->label = htmlspecialchars(Arr::get($_POST, 'label', NULL));
            $attribute->brief = htmlspecialchars(Arr::get($_POST, 'brief', NULL));
            $attribute->scope = Arr::get($_POST, 'scope', 0);
            $attribute->required = Arr::get($_POST, 'required', 0);
            $attribute->promo = Arr::get($_POST, 'promo', 0);
            $attribute->view = Arr::get($_POST, 'view', 0);
            $attribute->searchable = Arr::get($_POST, 'searchable', 0);
            $attribute->type = Arr::get($_POST, 'type', 0);
            $attribute->default_value = htmlspecialchars(Arr::get($_POST, 'default_value_' . $attribute->type, ''));
            if ($attribute->check())
            {
                $attribute->save();

                if (in_array($attribute->type, array(0, 1)))
                {
                    $labels = Arr::get($_POST, 'option_label', array());
                    $positions = Arr::get($_POST, 'option_position', array());
                    $labels_update = Arr::get($_POST, 'option_label_update', array());
                    $positions_update = Arr::get($_POST, 'option_position_update', array());

                    $current_options = $attribute->options->where('site_id', '=', $this->site_id)->find_all();
                    $origin_labels = array();
                    foreach ($current_options as $current_option)
                    {
                        $origin_labels[$current_option->id] = $current_option->as_array();
                    }

                    //update existing labels
                    foreach ($labels_update as $label_id => $label_label)
                    {
                        if (isset($origin_labels[$label_id]) AND isset($positions_update[$label_id]) AND ($origin_labels[$label_id]['label'] != $label_label OR $origin_labels[$label_id]['position'] != $positions_update[$label_id]))
                        {
                            DB::update('options')
                                ->set(array('label' => $label_label, 'position' => $positions_update[$label_id]))
                                ->where('id', '=', $label_id)
                                ->and_where('site_id', '=', $this->site_id)
                                ->execute();
                        }
                    }

                    //delete existing labels
                    $deleted_options = array_diff(array_keys($origin_labels), array_keys($labels_update));
                    foreach ($deleted_options as $oid)
                    {
                        $option_obj = Option::instance($oid);
                        if (!count($option_obj->get_associated_products()))
                        {
                            $option_obj->delete();
                        }
                        else
                        {
                            Message::set('Error on deleting option "' . $option_obj->get('label') . '"(#' . $oid . ') - Can not delete an option associated with product(s).', 'error');
                            $this->request->redirect('admin/site/attribute/edit/' . $id);
                        }
                    }

                    //add new labels
                    foreach ($labels as $key => $label)
                    {
                        if ($label != '')
                        {
                            $data = array();
                            $data['site_id'] = $this->site_id;
                            $data['label'] = htmlspecialchars($label);
                            $data['position'] = $positions[$key];
                            $data['attribute_id'] = $attribute->id;
                            $option = ORM::factory('option');
                            $option->values($data);
                            $option->save();
                        }
                    }
                }

                message::set('修改产品规格成功。');
                $this->request->redirect('admin/site/attribute/edit/' . $id);
            }
            else
            {
                message::set('数据不合法。', 'error');
                $this->request->redirect('admin/site/attribute/edit/' . $id);
            }
        }

        $content_data['attribute'] = $attribute;
        $content_data['options'] = $content_data['attribute']->options->order_by('position')->find_all();
        $content = View::factory('admin/site/attribute_edit', $content_data)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_delete()
    {
        $id = $this->request->param('id');

        $attribute = ORM::factory('attribute', $id);

        if (!$attribute->loaded())
        {
            Message::set('The attribute doesn\'t exist or has been deleted already.', 'error');
        }
        else
        {
            $set = $attribute->sets->find();
            if ($set->id === NULL)
            {
                $attribute_obj = Attribute::instance($id);
                if (count($attribute_obj->get_associated_products()))
                {
                    Message::set('Can not delete an attribute which has already been used by product(s).', 'error');
                    $this->request->redirect('admin/site/attribute/list');
                }

                $attribute_obj->delete_options();
                $attribute->delete();
                Message::set('Attribute delete successfully.');
            }
            else
            {
                Message::set('Can not delete an attribute which has set(s) using it.');
            }
        }

        $this->request->redirect('admin/site/attribute/list');
    }

    public function action_data()
    {
        $type = $this->request->param('id');

        $page = $_REQUEST['page']; // get the requested page
        $limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
        $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
        $sord = $_REQUEST['sord']; // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        $filter_sql = "";

        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                if (in_array($item->field, array('name', 'label', 'brief')))
                {
                    $filter_sql .= " AND " . $item->field . " LIKE '%" . $item->data . "%'";
                }
                else
                {
                    //TODO add filter items
                    $filter_sql .= " AND " . $item->field . "='" . $item->data . "'";
                }
            }
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM attributes WHERE site_id=' . $this->site_id . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM attributes WHERE site_id=' . $this->site_id . ' ' .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;
        $i = 0;
        foreach ($result as $attribute)
        {
            $response['rows'][$i]['id'] = $attribute['id'];
            if ($type != 'simple')
            {
                $response['rows'][$i]['cell'] = array(
                    $attribute['id'],
                    $attribute['name'],
                    $attribute['label'],
                    $attribute['scope'],
                    $attribute['brief']
                );
            }
            else
            {
                $response['rows'][$i]['cell'] = array(
                    $attribute['id'],
                    $attribute['name']
                );
            }

            $i++;
        }
        echo json_encode($response);
    }
    
    public function action_small()
    {
        $lang = $this->request->param('id');
        if(!$lang)
            $this->request->redirect('/admin/site/attribute/list');
        $content = View::factory('admin/site/attribute_small')->set('lang', $lang)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }
    
    public function action_small_data()
    {
        $lang = $this->request->param('id');
        $page = $_REQUEST['page']; // get the requested page
        $limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
        $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
        $sord = $_REQUEST['sord']; // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        $filter_sql = "";

        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                if (in_array($item->field, array('name', 'label', 'brief')))
                {
                    $filter_sql .= " AND " . $item->field . " LIKE '%" . $item->data . "%'";
                }
                else
                {
                    //TODO add filter items
                    $filter_sql .= " AND " . $item->field . "='" . $item->data . "'";
                }
            }
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM attributes WHERE site_id=' . $this->site_id . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM attributes WHERE site_id=' . $this->site_id . ' AND id >= 4 ' .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;
        $i = 0;
        foreach ($result as $attribute)
        {
            $small = DB::select($lang)->from('attributes_small')->where('attribute_id', '=', $attribute['id'])->execute('slave')->current();
            $response['rows'][$i]['id'] = $attribute['id'];
            $response['rows'][$i]['cell'] = array(
                $attribute['id'],
                $attribute['name'],
                $attribute['label'],
                $attribute['brief'],
                isset($small[$lang]) ? $small[$lang] : '',
                );
            $i++;
        }
        echo json_encode($response);
    }
    
    public function action_small_edit()
    {
        $id = $id = $this->request->param('id');
        $lang = Arr::get($_GET, 'lang', '');
        $name = Arr::get($_GET, 'name', '');
        try
        {
            if(!$lang)
            {
                exit;
            }
            if (!$name)
            {
                echo 'Name Cannot Be Emtpty';
            }
            else
            {
                $has = DB::select('id')->from('attributes_small')->where('attribute_id', '=', $id)->execute('slave')->get('id');
                if($has)
                {
                    $result = DB::update('attributes_small')->set(array($lang => $name))->where('id', '=', $has)->execute();
                }
                else
                {
                    $result = DB::insert('attributes_small', array('attribute_id', $lang))->values(array('attribute_id' => $id, $lang => $name))->execute();
                }
                echo $result ? 'success' : 'Failed';
            }
        }
        catch (Exception $e)
        {
            echo $e;
        }
    }
    
    public function action_import_small()
    {
        $lang = $this->request->param('id');
        if ($_POST)
        {
            $languages = Kohana::config('sites.' . $this->site_id . '.language');
            if (!in_array($lang, $languages))
            {
                $this->request->redirect('/admin/site/attribute/list');
            }
            $content = Arr::get($_POST, 'content', '');
            if(!$content)
            {
                Message::set('Input Cannot Be Empty!', 'notice');
                $this->request->redirect('/admin/site/product/small_import?lang='.$lang);
            }
            if ($lang)
            {
                $row = 1;
                $head = array();
                $amount = 0;
                $success = '';
                if(strpos($content, '<br />') !== false)
                    $array = explode('<br />', $content);
                else
                    $array = explode("\n", $content);
                foreach($array as $value)
                {
                    $value = str_replace(array('<p>', '</p>'), array('', ''), $value);
                    if(strpos($value, 'white-space:pre') !== false)
                        $data = explode('<span style="white-space:pre"> </span>', $value);
                    elseif(strpos($value, 'white-space: pre') !== false)
                        $data = explode('<span style="white-space: pre;"> </span>', $value);
                    else
                        $data = explode('&nbsp;&nbsp;&nbsp;', $value);
                    foreach ($data as $key => $val)
                    {
                        $val = str_replace('', "\n", $val);
//                    $data[$key] = Security::xss_clean(iconv('gbk', 'utf-8', $val));
//                    $data[$key] = iconv('gbk', 'utf-8', $val);
                    }
                    if ($row > 1)
                    {
                        foreach ($data as $key => $value)
                        {
                            $value = trim($value);
                            if (!$key OR $value == '')
                                continue;
                        }
                        $en_name = trim($data[0]);
                        $attribute_id = DB::select('id')->from('attributes')->where('name', '=', $en_name)->execute('slave')->get('id');
                        $name = trim($data[1]);
                        if ($attribute_id AND $name)
                        {
                            $has = DB::select('id')->from('attributes_small')->where('attribute_id', '=', $attribute_id)->execute('slave')->get('id');
                            if($has)
                            {
                                $result = DB::update('attributes_small')->set(array($lang => $name))->where('id', '=', $has)->execute();
                            }
                            else
                            {
                                $result = DB::insert('attributes_small', array('attribute_id', $lang))->values(array('attribute_id' => $attribute_id, $lang => $name))->execute();
                            }
                            if($result)
                                $amount ++;
                        }
                    }
                    $row++;
                }
                echo $amount . ' products basics import successfully:<a href="/admin/site/attribute/small/'.$lang.'" style="color:red;">Back</a><br>';
                echo $success;
                exit;
            }
        }
    }

}

