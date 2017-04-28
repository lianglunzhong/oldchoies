<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Activity extends Controller_Admin_Site
{

    public function action_list()
    {
        $content = View::factory('admin/site/activity_list')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_question()
    {
        $content = View::factory('admin/site/activity_question')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_question_data()
    {
        //TODO fixed the post
        $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $filter_sql = "1";
        $order_sql = '';
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                //TODO add filter items
                // TODO optimize name filter.
                if ($item->field == 'created')
                {
                    $date = explode(' to ', $item->data);
                    $count = count($date);
                    $from = strtotime($date[0]);
                    if ($count == 1)
                    {
                        $to = strtotime($date[0] . ' +1 day -1 second');
                    }
                    else
                    {
                        $to = strtotime($date[1] . ' +1 day -1 second');
                    }
                    $_filter_sql[] = '`giveaway_questions`.' . $item->field . " between " . $from . " and " . $to;
                }
                else if ($item->field == 'ip')
                {
                    $_filter_sql[] = 'giveaway_questions.ip=' . ip2long($item->data) . ' ';
                }
                else if ($item->field == 'email')
                {
                    $user_id = DB::select('id')->from('accounts_customers')->where('email', '=', trim($item->data))->execute('slave')->get('id');
                    $_filter_sql[] = 'giveaway_questions.user_id=' . $user_id . ' ';
                }
                else
                {
                    $_filter_sql[] = '`giveaway_questions`.' . $item->field . "='" . $item->data . "'";
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        $result = DB::query(DATABASE::SELECT, 'SELECT COUNT(`giveaway_questions`.`id`) AS num FROM `giveaway_questions` WHERE `giveaway_questions`.site_id=' . $this->site_id . ' AND '
                . $filter_sql)->execute('slave');
        $count = $result[0]['num'];
        $total_pages = 0;
        $limit = 20;
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT `giveaway_questions`.*
		FROM `giveaway_questions` WHERE `giveaway_questions`.site_id=' . $this->site_id . ' AND '
                . $filter_sql . ' GROUP BY id ' . $order_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $responce = array();
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $k = 0;
        foreach ($result as $data)
        {
            $email = Customer::instance($data['user_id'])->get('email');
            $responce['rows'][$k]['id'] = $data['id'];
            $responce['rows'][$k]['cell'] = array(
                $data['id'],
                $email,
                date('Y-m-d', $data['created']),
                long2ip($data['ip']),
                $data['q1'],
                $data['q2'],
                $data['q3'],
                $data['q4'],
                $data['q5'],
                $data['q6'],
                $data['q7'],
                $data['q8'],
                $data['q9'],
                $data['q10'],
            );
            $k++;
        }
        echo json_encode($responce);
    }

    public function action_question_export()
    {
        if ($_POST)
        {
            $start = Arr::get($_POST, 'start', NULL);
            $end = Arr::get($_POST, 'end', NULL);

            $file = 'questionnaire';
            $sql = '';
            if ($start)
            {
                $file .= "-from-$start";
                $sql .= ' AND created >= ' . strtotime($start);
            }

            if ($end)
            {
                $file .= "-to-$end";
                $sql .= ' AND created < ' . strtotime($end);
            }

            $result = DB::query(Database::SELECT, 'SELECT * FROM `giveaway_questions` WHERE site_id=' . $this->site_id . $sql)
                ->execute('slave');

            /** Error reporting */
            error_reporting(E_ALL);

            date_default_timezone_set('America/Chicago');
            header("Content-type:application/vnd.ms-excel; charset=UTF-8");
            header('Content-Disposition: attachment; filename=' . $file . '.csv');
            echo "\xEF\xBB\xBF" . "ID,Email,Created,Ip,Celebrity Id,Question1,Question2,Question3,Question4,Question5,Question6,Question7,Question8,Question9,Question10\n";
            foreach ($result as $data)
            {
                $email = Customer::instance($data['user_id'])->get('email');
                $is_cel = DB::select('id')->from('celebrities_celebrits')->where('email', '=', $email)->execute('slave')->get('id');
                echo $data['id'] . ',';
                echo $email . ',';
                echo date('Y-m-d', $data['created']) . ',';
                echo long2ip($data['ip']) . ',';
                echo $is_cel ? $is_cel . ',' : ',';
                echo '"' . $data['q1'] . '",';
                echo '"' . $data['q2'] . '",';
                echo '"' . $data['q3'] . '",';
                echo '"' . $data['q4'] . '",';
                echo '"' . $data['q5'] . '",';
                echo '"' . $data['q6'] . '",';
                echo '"' . $data['q7'] . '",';
                echo '"' . $data['q8'] . '",';
                echo '"' . $data['q9'] . '",';
                echo '"' . $data['q10'] . '"';
                echo "\n";
            }
        }
    }

    public function action_exprotcsv()
    {
        ob_end_clean();
        ob_start();
        header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition: attachment; filename=Celebrity_fee_' . date('Y-m-d', time()) . '.xls');
        header("Content-Transfer-Encoding: binary ");

        $buffer = $_POST['csvBuffer'];
        $buffer = iconv("utf-8", "gbk", $buffer);
        try
        {
            echo $buffer;
        }
        catch (Exception $e)
        {
            echo 'Sorry, Server is too busy, please try again later,THX.';
        }
    }

    public function action_freetrial()
    {
        $content = View::factory('admin/site/activity_freetrial_list')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_freetrial_data()
    {
        //TODO fixed the post
        $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $filter_sql = "1";
        $order_sql = '';
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                //TODO add filter items
                // TODO optimize name filter.
                if ($item->field == 'created')
                {
                    $date = explode(' to ', $item->data);
                    $count = count($date);
                    $from = strtotime($date[0]);
                    if ($count == 1)
                    {
                        $to = strtotime($date[0] . ' +1 day -1 second');
                    }
                    else
                    {
                        $to = strtotime($date[1] . ' +1 day -1 second');
                    }
                    $_filter_sql[] = $item->field . " between " . $from . " and " . $to;
                }
                else if ($item->field == 'sku')
                {
                    $product_id = Product::get_productId_by_sku($item->data);
                    $_filter_sql[] = 'product_id=' . $product_id . ' ';
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        $count = DB::query(DATABASE::SELECT, 'SELECT COUNT(`id`) AS count FROM `freetrials` WHERE site_id=' . $this->site_id . ' AND '
                . $filter_sql)->execute('slave')->get('count');
        $total_pages = 0;
        $limit = 20;
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT *
		FROM `freetrials` WHERE site_id=' . $this->site_id . ' AND '
                . $filter_sql . ' GROUP BY id ' . $order_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $responce = array();
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $k = 0;
        foreach ($result as $data)
        {
            $responce['rows'][$k]['id'] = $data['id'];
            $responce['rows'][$k]['cell'] = array(
                $data['id'],
                date('Y-m-d H:i:s', $data['created']),
                $data['email'],
                Product::instance($data['product_id'])->get('sku'),
                $data['message']
            );
            $k++;
        }
        echo json_encode($responce);
    }

    public function action_freetrial_export()
    {
        if ($_POST)
        {
            $skuArr = trim(Arr::get($_POST, 'SKUARR', ''));
            if ($skuArr)
            {
                $skus = explode("\n", $skuArr);
                $sql = '';
                foreach ($skus as $key => $sku)
                {
                    if ($key == count($skus) - 1)
                        $sql .= '"' . $sku . '"';
                    else
                        $sql .= '"' . $sku . '",';
                }
                $result = DB::query(Database::SELECT, 'SELECT f.email, p.sku, f.created FROM freetrials f LEFT JOIN products p ON f.product_id=p.id 
                                                WHERE p.sku IN (' . $sql . ') ORDER BY f.email')->execute('slave');
                header("Content-type:application/vnd.ms-excel; charset=UTF-8");
                header('Content-Disposition: attachment; filename="freetrial_' . date('Y-m-d') . '.csv"');
                echo "\xEF\xBB\xBF" . "Email,SKU,Time\n";
                foreach ($result as $data)
                {
                    echo $data['email'] . ',';
                    echo $data['sku'] . ',';
                    echo date('Y-m-d H:i:s', $data['created']) . "\n";
                }
            }
        }
    }

    public function action_freetrial_reports()
    {
        $content = View::factory('admin/site/activity_freetrial_reports')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_freetrial_reports_data()
    {
        //TODO fixed the post
        $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $filter_sql = "1";
        $order_sql = '';
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                //TODO add filter items
                // TODO optimize name filter.
                if ($item->field == 'created')
                {
                    $date = explode(' to ', $item->data);
                    $count = count($date);
                    $from = strtotime($date[0]);
                    if ($count == 1)
                    {
                        $to = strtotime($date[0] . ' +1 day -1 second');
                    }
                    else
                    {
                        $to = strtotime($date[1] . ' +1 day -1 second');
                    }
                    $_filter_sql[] = $item->field . " between " . $from . " and " . $to;
                }
                else if ($item->field == 'sku')
                {
                    $product_id = Product::get_productId_by_sku($item->data);
                    $_filter_sql[] = 'product_id=' . $product_id . ' ';
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        $count = DB::query(DATABASE::SELECT, 'SELECT COUNT(`id`) AS count FROM `freetrial_reports` WHERE site_id=' . $this->site_id . ' AND '
                . $filter_sql)->execute('slave')->get('count');
        $total_pages = 0;
        $limit = 20;
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT *
		FROM `freetrial_reports` WHERE site_id=' . $this->site_id . ' AND '
                . $filter_sql . ' GROUP BY id ' . $order_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $responce = array();
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $k = 0;
        $domain = Site::instance()->get('domain');
        foreach ($result as $data)
        {
            $email = Customer::instance($data['user_id'])->get('email');
            $responce['rows'][$k]['id'] = $data['id'];
            $responce['rows'][$k]['cell'] = array(
                $data['id'],
                Product::instance($data['product_id'])->get('sku'),
                $data['name'],
                $data['age'],
                $data['profession'],
                date('Y-m-d', $data['created']),
                $data['comments'],
                '<img src="http://' . $domain . '/simages/' . $data['image'] . '" height="200" />',
            );
            $k++;
        }
        echo json_encode($responce);
    }

    public function action_freetrial_reports_add()
    {
        if ($_POST)
        {
            $sku = Arr::get($_POST, 'sku', '');
            $product_id = Product::get_productId_by_sku($sku);
            if (!$product_id)
            {
                Message::set('Please enter true sku!', 'error');
                $this->request->redirect('admin/site/activity/freetrial_reports_add');
            }
            $imageArr = explode(',', $_POST['image_src']);
            $imagesRemove = explode(',', $_POST['images_removed']);
            foreach ($imagesRemove as $image)
            {
                if ($image && file_exists($dir . $image))
                {
                    unlink($dir . $image);
                    DB::delete('site_images')->where('filename', '=', $image)->execute();
                }
            }

            foreach ($imageArr as $key => $image)
            {
                if (in_array($image, $imagesRemove))
                {
                    unset($imageArr[$key]);
                }
            }

            if (empty($imageArr))
            {
                Message::set(__('Image upload error'), 'error');
                $this->request->redirect('admin/site/activity/freetrial_reports_add');
            }
            $data['image'] = $imageArr[0];
            $data['product_id'] = $product_id;
            $data['name'] = Arr::get($_POST, 'name', '');
            $data['age'] = Arr::get($_POST, 'age', '');
            $data['profession'] = Arr::get($_POST, 'profession', '');
            $data['comments'] = Arr::get($_POST, 'comments', '');
            $data['created'] = time();
            $data['site_id'] = $this->site_id;
            $insert = DB::insert('freetrial_reports', array_keys($data))->values($data)->execute();
            if ($insert)
            {
                Message::set(__('Report Add Success'), 'success');
                $this->request->redirect('admin/site/activity/freetrial_reports');
            }
            else
            {
                Message::set(__('Report Add Failed'), 'error');
                $this->request->redirect('admin/site/activity/freetrial_reports_add');
            }
        }

        $content = View::factory('admin/site/activity_freetrial_reports_add')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_freetrial_reports_edit()
    {
        $id = $this->request->param('id');
        if ($_POST)
        {
            $sku = Arr::get($_POST, 'sku', '');
            $product_id = Product::get_productId_by_sku($sku);
            if (!$product_id)
            {
                Message::set('Please enter true sku!', 'error');
                $this->request->redirect('admin/site/activity/freetrial_reports_edit/' . $id);
            }
            require 'inc_config.php';
            $dir = $resource_dir . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR . 'simages' . DIRECTORY_SEPARATOR;
            $images_removed = Arr::get($_POST, 'images_removed', '');
            $imagesRemove = explode(',', $images_removed);
            $image_src = Arr::get($_POST, 'image_src', '');
            foreach ($imagesRemove as $image)
            {
                $image_src = str_replace($image, '', $image_src);
                if ($image && file_exists($dir . $image))
                {
                    unlink($dir . $image);
                    DB::delete('site_images')->where('filename', '=', $image)->execute();
                }
            }
            $imageArr = explode(',', $image_src);
            foreach ($imageArr as $key => $image)
            {
                if (in_array($image, $imagesRemove))
                {
                    unset($imageArr[$key]);
                }
            }
            if (!empty($imageArr))
            {
                $result = DB::select('image')->from('freetrial_reports')->where('id', '=', $id)->and_where('site_id', '=', $this->site_id)->execute('slave')->current();
                if (file_exists($dir . $result['image']))
                {
                    unlink($dir . $result['image']);
                    DB::delete('site_images')->where('filename', '=', $result['image'])->execute();
                }

                $data['image'] = $imageArr[0];
            }
            $data['product_id'] = $product_id;
            $data['name'] = Arr::get($_POST, 'name', '');
            $data['age'] = Arr::get($_POST, 'age', '');
            $data['profession'] = Arr::get($_POST, 'profession', '');
            $data['comments'] = Arr::get($_POST, 'comments', '');
            $data['created'] = time();
            $data['site_id'] = $this->site_id;
            $update = DB::update('freetrial_reports')->set($data)->where('id', '=', $id)->execute();
            if ($update)
                Message::set(__('Report Edit Success'), 'success');
            else
                Message::set(__('Report Edit Failed'), 'error');
            $this->request->redirect('admin/site/activity/freetrial_reports_edit/' . $id);
        }
        $report = DB::select()->from('freetrial_reports')->where('id', '=', $id)->execute('slave')->current();
        $content = View::factory('admin/site/activity_freetrial_reports_edit')->set('report', $report)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_freetrial_reports_delete()
    {
        require 'inc_config.php';
        $dir = $resource_dir . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR . 'simages' . DIRECTORY_SEPARATOR;
        $id = $this->request->param('id');
        $result = DB::select('image')->from('freetrial_reports')->where('id', '=', $id)->execute('slave')->current();
        $image = $result['image'];
        if ($result)
        {
            if ($image && file_exists($dir . $image))
            {
                unlink($dir . $image);
                DB::delete('site_images')->where('filename', '=', $image)->execute();
            }
            $delete = DB::delete('freetrial_reports')->where('id', '=', $id)->execute();
            if ($delete)
            {
                message::set(__('Delete report success'), 'success');
                Request::instance()->redirect('admin/site/activity/freetrial_reports');
            }
        }
        else
        {
            message::set(__('Data not exist'), 'error');
            Request::instance()->redirect('admin/site/activity/freetrial_reports');
        }
    }

    public function action_freetrial_configs()
    {
        $content = View::factory('admin/site/activity_freetrial_configs')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_freetrial_configs_data()
    {
        //TODO fixed the post
        $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $filter_sql = "1";
        $order_sql = '';
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                //TODO add filter items
                // TODO optimize name filter.
                if ($item->field == 'created')
                {
                    $date = explode(' to ', $item->data);
                    $count = count($date);
                    $from = strtotime($date[0]);
                    if ($count == 1)
                    {
                        $to = strtotime($date[0] . ' +1 day -1 second');
                    }
                    else
                    {
                        $to = strtotime($date[1] . ' +1 day -1 second');
                    }
                    $_filter_sql[] = $item->field . " between " . $from . " and " . $to;
                }
                else
                {
                    $_filter_sql[] = $item->field . "='" . $item->data . "'";
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        $count = DB::query(DATABASE::SELECT, 'SELECT COUNT(`id`) AS count FROM `freetrial_configs` WHERE site_id=' . $this->site_id . ' AND '
                . $filter_sql)->execute('slave')->get('count');
        $total_pages = 0;
        $limit = 20;
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM `freetrial_configs` WHERE site_id=' . $this->site_id . ' AND '
                . $filter_sql . ' GROUP BY id ' . $order_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $responce = array();
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $k = 0;
        foreach ($result as $data)
        {
            $responce['rows'][$k]['id'] = $data['id'];
            $responce['rows'][$k]['cell'] = array(
                $data['id'],
                $data['products'],
                $data['chances'],
                $data['endtime'],
                $data['winners'],
                date('Y-m-d', $data['created'])
            );
            $k++;
        }
        echo json_encode($responce);
    }

    public function action_freetrial_config_add()
    {
        if ($_POST)
        {
            $data['products'] = Arr::get($_POST, 'products', '');
            $data['chances'] = Arr::get($_POST, 'chances', '');
            $data['endtime'] = Arr::get($_POST, 'endtime', '');
            if ($data['products'] AND $data['chances'] AND $data['endtime'])
            {
                $data['created'] = time();
                $data['site_id'] = $this->site_id;
                DB::insert('freetrial_configs', array_keys($data))->values($data)->execute();
                Message::set('Add freetrial config success!', 'success');
            }
            else
                Message::set('Add freetrial config failed!', 'error');
            $this->request->redirect('/admin/site/activity/freetrial_configs');
        }
    }

    public function action_freetrial_config_edit()
    {
        if ($_POST)
        {
            $id = Arr::get($_POST, 'id', 0);
            $data['products'] = Arr::get($_POST, 'products', '');
            $data['chances'] = Arr::get($_POST, 'chances', '');
            $data['winners'] = Arr::get($_POST, 'winners', '');
            if ($id AND $data['products'] AND $data['chances'] AND $data['winners'])
            {
                $update = DB::update('freetrial_configs')->set($data)->where('id', '=', $id)->execute();
            }
            else
            {
                $update = 0;
            }
            if ($update)
            {
                Message::set('Update freetrial config success!', 'success');
            }
            else
            {
                Message::set('Update freetrial config failed!', 'error');
            }
            $this->request->redirect('/admin/site/activity/freetrial_configs');
        }
    }

    public function action_freetrial_configs_ajaxdata()
    {
        if ($_POST)
        {
            $id = Arr::get($_POST, 'id', 0);
            if ($id)
            {
                $data = DB::select()->from('freetrial_configs')->where('id', '=', $id)->execute('slave')->current();
                echo json_encode($data);
                exit;
            }
        }
    }

    public function action_share_win()
    {
        $content = View::factory('admin/site/activity_share_win_list')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_share_win_data()
    {
        //TODO fixed the post
        $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $filter_sql = "1";
        $order_sql = '';
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                //TODO add filter items
                // TODO optimize name filter.
                if ($item->field == 'created')
                {
                    $date = explode(' to ', $item->data);
                    $count = count($date);
                    $from = strtotime($date[0]);
                    if ($count == 1)
                    {
                        $to = strtotime($date[0] . ' +1 day -1 second');
                    }
                    else
                    {
                        $to = strtotime($date[1] . ' +1 day -1 second');
                    }
                    $_filter_sql[] = $item->field . " between " . $from . " and " . $to;
                }
                else if ($item->field == 'sku')
                {
                    $product_id = Product::get_productId_by_sku($item->data);
                    $_filter_sql[] = 'product_id=' . $product_id . ' ';
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        $count = DB::query(DATABASE::SELECT, 'SELECT COUNT(`id`) AS count FROM `share_win` WHERE site_id=' . $this->site_id . ' AND '
                . $filter_sql)->execute('slave')->get('count');
        $total_pages = 0;
        $limit = 20;
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT *
        FROM `share_win` WHERE site_id=' . $this->site_id . ' AND '
                . $filter_sql . ' GROUP BY id ' . $order_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $responce = array();
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $k = 0;
        foreach ($result as $data)
        {
            $responce['rows'][$k]['id'] = $data['id'];
            $responce['rows'][$k]['cell'] = array(
                $data['id'],
                date('Y-m-d H:i:s', $data['created']),
                $data['email'],
                Product::instance($data['product_id'])->get('sku'),
                $data['message']
            );
            $k++;
        }
        echo json_encode($responce);
    }

    public function action_share_win_export()
    {
        if ($_POST)
        {
            $skuArr = trim(Arr::get($_POST, 'SKUARR', ''));
            if ($skuArr)
            {
                $skus = explode("\n", $skuArr);
                $sql = '';
                foreach ($skus as $key => $sku)
                {
                    if ($key == count($skus) - 1)
                        $sql .= '"' . $sku . '"';
                    else
                        $sql .= '"' . $sku . '",';
                }
                $result = DB::query(Database::SELECT, 'SELECT f.email, p.sku, f.created FROM share_win f LEFT JOIN products p ON f.product_id=p.id 
                                                WHERE p.sku IN (' . $sql . ') ORDER BY f.email')->execute('slave');
                header("Content-type:application/vnd.ms-excel; charset=UTF-8");
                header('Content-Disposition: attachment; filename="freetrial_' . date('Y-m-d') . '.csv"');
                echo "\xEF\xBB\xBF" . "Email,SKU,Time\n";
                foreach ($result as $data)
                {
                    echo $data['email'] . ',';
                    echo $data['sku'] . ',';
                    echo date('Y-m-d H:i:s', $data['created']) . "\n";
                }
            }
        }
    }

    public function action_share_win_reports()
    {
        $content = View::factory('admin/site/activity_share_win_reports')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_share_win_reports_data()
    {
        //TODO fixed the post
        $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $filter_sql = "1";
        $order_sql = '';
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                //TODO add filter items
                // TODO optimize name filter.
                if ($item->field == 'created')
                {
                    $date = explode(' to ', $item->data);
                    $count = count($date);
                    $from = strtotime($date[0]);
                    if ($count == 1)
                    {
                        $to = strtotime($date[0] . ' +1 day -1 second');
                    }
                    else
                    {
                        $to = strtotime($date[1] . ' +1 day -1 second');
                    }
                    $_filter_sql[] = $item->field . " between " . $from . " and " . $to;
                }
                else if ($item->field == 'sku')
                {
                    $product_id = Product::get_productId_by_sku($item->data);
                    $_filter_sql[] = 'product_id=' . $product_id . ' ';
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        $count = DB::query(DATABASE::SELECT, 'SELECT COUNT(`id`) AS count FROM `share_win_reports` WHERE site_id=' . $this->site_id . ' AND '
                . $filter_sql)->execute('slave')->get('count');
        $total_pages = 0;
        $limit = 20;
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT *
        FROM `share_win_reports` WHERE site_id=' . $this->site_id . ' AND '
                . $filter_sql . ' GROUP BY id ' . $order_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $responce = array();
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $k = 0;
        $domain = Site::instance()->get('domain');
        foreach ($result as $data)
        {
            $email = Customer::instance($data['user_id'])->get('email');
            $responce['rows'][$k]['id'] = $data['id'];
            $responce['rows'][$k]['cell'] = array(
                $data['id'],
                Product::instance($data['product_id'])->get('sku'),
                $data['name'],
                $data['age'],
                $data['profession'],
                date('Y-m-d', $data['created']),
                $data['comments'],
                '<img src="http://' . $domain . '/simages/' . $data['image'] . '" height="200" />',
            );
            $k++;
        }
        echo json_encode($responce);
    }

    public function action_share_win_reports_add()
    {
        if ($_POST)
        {
            $sku = Arr::get($_POST, 'sku', '');
            $product_id = Product::get_productId_by_sku($sku);
            if (!$product_id)
            {
                Message::set('Please enter true sku!', 'error');
                $this->request->redirect('admin/site/activity/share_win_reports_add');
            }
            $imageArr = explode(',', $_POST['image_src']);
            $imagesRemove = explode(',', $_POST['images_removed']);
            foreach ($imagesRemove as $image)
            {
                if ($image && file_exists($dir . $image))
                {
                    unlink($dir . $image);
                    DB::delete('site_images')->where('filename', '=', $image)->execute();
                }
            }

            foreach ($imageArr as $key => $image)
            {
                if (in_array($image, $imagesRemove))
                {
                    unset($imageArr[$key]);
                }
            }

            if (empty($imageArr))
            {
                Message::set(__('Image upload error'), 'error');
                $this->request->redirect('admin/site/activity/share_win_reports_add');
            }
            $data['image'] = $imageArr[0];
            $data['product_id'] = $product_id;
            $data['name'] = Arr::get($_POST, 'name', '');
            $data['age'] = Arr::get($_POST, 'age', '');
            $data['profession'] = Arr::get($_POST, 'profession', '');
            $data['comments'] = Arr::get($_POST, 'comments', '');
            $data['created'] = time();
            $data['site_id'] = $this->site_id;
            $insert = DB::insert('freetrial_reports', array_keys($data))->values($data)->execute();
            if ($insert)
            {
                Message::set(__('Report Add Success'), 'success');
                $this->request->redirect('admin/site/activity/share_win_reports');
            }
            else
            {
                Message::set(__('Report Add Failed'), 'error');
                $this->request->redirect('admin/site/activity/share_win_reports_add');
            }
        }

        $content = View::factory('admin/site/activity_share_win_reports_add')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_share_win_reports_edit()
    {
        $id = $this->request->param('id');
        if ($_POST)
        {
            $sku = Arr::get($_POST, 'sku', '');
            $product_id = Product::get_productId_by_sku($sku);
            if (!$product_id)
            {
                Message::set('Please enter true sku!', 'error');
                $this->request->redirect('admin/site/activity/share_win_reports_edit/' . $id);
            }
            require 'inc_config.php';
            $dir = $resource_dir . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR . 'simages' . DIRECTORY_SEPARATOR;
            $images_removed = Arr::get($_POST, 'images_removed', '');
            $imagesRemove = explode(',', $images_removed);
            $image_src = Arr::get($_POST, 'image_src', '');
            foreach ($imagesRemove as $image)
            {
                $image_src = str_replace($image, '', $image_src);
                if ($image && file_exists($dir . $image))
                {
                    unlink($dir . $image);
                    DB::delete('site_images')->where('filename', '=', $image)->execute();
                }
            }
            $imageArr = explode(',', $image_src);
            foreach ($imageArr as $key => $image)
            {
                if (in_array($image, $imagesRemove))
                {
                    unset($imageArr[$key]);
                }
            }
            if (!empty($imageArr))
            {
                $result = DB::select('image')->from('share_win_reports')->where('id', '=', $id)->and_where('site_id', '=', $this->site_id)->execute('slave')->current();
                if (file_exists($dir . $result['image']))
                {
                    unlink($dir . $result['image']);
                    DB::delete('site_images')->where('filename', '=', $result['image'])->execute();
                }

                $data['image'] = $imageArr[0];
            }
            $data['product_id'] = $product_id;
            $data['name'] = Arr::get($_POST, 'name', '');
            $data['age'] = Arr::get($_POST, 'age', '');
            $data['profession'] = Arr::get($_POST, 'profession', '');
            $data['comments'] = Arr::get($_POST, 'comments', '');
            $data['created'] = time();
            $data['site_id'] = $this->site_id;
            $update = DB::update('share_win_reports')->set($data)->where('id', '=', $id)->execute();
            if ($update)
                Message::set(__('Report Edit Success'), 'success');
            else
                Message::set(__('Report Edit Failed'), 'error');
            $this->request->redirect('admin/site/activity/share_win_reports_edit/' . $id);
        }
        $report = DB::select()->from('share_win_reports')->where('id', '=', $id)->execute('slave')->current();
        $content = View::factory('admin/site/activity_share_win_reports_edit')->set('report', $report)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_share_win_reports_delete()
    {
        require 'inc_config.php';
        $dir = $resource_dir . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR . 'simages' . DIRECTORY_SEPARATOR;
        $id = $this->request->param('id');
        $result = DB::select('image')->from('share_win_reports')->where('id', '=', $id)->execute('slave')->current();
        $image = $result['image'];
        if ($result)
        {
            if ($image && file_exists($dir . $image))
            {
                unlink($dir . $image);
                DB::delete('site_images')->where('filename', '=', $image)->execute();
            }
            $delete = DB::delete('share_win_reports')->where('id', '=', $id)->execute();
            if ($delete)
            {
                message::set(__('Delete report success'), 'success');
                Request::instance()->redirect('admin/site/activity/share_win_reports');
            }
        }
        else
        {
            message::set(__('Data not exist'), 'error');
            Request::instance()->redirect('admin/site/activity/share_win_reports');
        }
    }

    public function action_share_win_configs()
    {
        $content = View::factory('admin/site/activity_share_win_configs')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_share_win_configs_data()
    {
        //TODO fixed the post
        $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $filter_sql = "1";
        $order_sql = '';
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                //TODO add filter items
                // TODO optimize name filter.
                if ($item->field == 'created')
                {
                    $date = explode(' to ', $item->data);
                    $count = count($date);
                    $from = strtotime($date[0]);
                    if ($count == 1)
                    {
                        $to = strtotime($date[0] . ' +1 day -1 second');
                    }
                    else
                    {
                        $to = strtotime($date[1] . ' +1 day -1 second');
                    }
                    $_filter_sql[] = $item->field . " between " . $from . " and " . $to;
                }
                else
                {
                    $_filter_sql[] = $item->field . "='" . $item->data . "'";
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        $count = DB::query(DATABASE::SELECT, 'SELECT COUNT(`id`) AS count FROM `share_win_configs` WHERE site_id=' . $this->site_id . ' AND '
                . $filter_sql)->execute('slave')->get('count');
        $total_pages = 0;
        $limit = 20;
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM `share_win_configs` WHERE site_id=' . $this->site_id . ' AND '
                . $filter_sql . ' GROUP BY id ' . $order_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $responce = array();
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $k = 0;
        foreach ($result as $data)
        {
            $responce['rows'][$k]['id'] = $data['id'];
            $responce['rows'][$k]['cell'] = array(
                $data['id'],
                $data['products'],
                $data['endtime'],
                $data['winners'],
                date('Y-m-d', $data['created'])
            );
            $k++;
        }
        echo json_encode($responce);
    }

    public function action_share_win_config_add()
    {
        if ($_POST)
        {
            $data['products'] = Arr::get($_POST, 'products', '');
            $data['chances'] = Arr::get($_POST, 'chances', '');
            $data['endtime'] = Arr::get($_POST, 'endtime', '');
            if ($data['products'] AND $data['endtime'])
            {
                $data['created'] = time();
                $data['site_id'] = $this->site_id;
                DB::insert('share_win_configs', array_keys($data))->values($data)->execute();
                Message::set('Add share&win config success!', 'success');
            }
            else
                Message::set('Add share&win config failed!', 'error');
            $this->request->redirect('/admin/site/activity/share_win_configs');
        }
    }

    public function action_share_win_config_edit()
    {
        if ($_POST)
        {
            $id = Arr::get($_POST, 'id', 0);
            $data['products'] = Arr::get($_POST, 'products', '');
            $data['chances'] = Arr::get($_POST, 'chances', '');
            $data['winners'] = Arr::get($_POST, 'winners', '');
            if ($id AND $data['products'] AND $data['winners'])
            {
                $update = DB::update('share_win_configs')->set($data)->where('id', '=', $id)->execute();
            }
            else
            {
                $update = 0;
            }
            if ($update)
            {
                Message::set('Update share_win config success!', 'success');
            }
            else
            {
                Message::set('Update share_win config failed!', 'error');
            }
            $this->request->redirect('/admin/site/activity/share_win_configs');
        }
    }

    public function action_share_win_configs_ajaxdata()
    {
        if ($_POST)
        {
            $id = Arr::get($_POST, 'id', 0);
            if ($id)
            {
                $data = DB::select()->from('share_win_configs')->where('id', '=', $id)->execute('slave')->current();
                echo json_encode($data);
                exit;
            }
        }
    }

}

?>