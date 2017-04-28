<?php

defined('SYSPATH') OR die('No direct script access.');

class Controller_Admin_Site_Review extends Controller_Admin_Site
{

    public function action_list()
    {
        $content = View::factory('admin/site/review_list')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_edit()
    {
        $id = $this->request->param('id');

        $review = ORM::factory('review', $id);
        if ($review->loaded())
        {
            if ($_POST)
            {
                $reply = htmlspecialchars(Arr::get($_POST, 'reply', ''));
                $time = htmlspecialchars(Arr::get($_POST, 'time', time()));
                $shortname = Arr::get($_POST, 'short_name', 0);
                $review->reply = $reply;
                $review->time = strtotime($time);
                $is_process = Arr::get($_POST, 'is_process', '');
                if($is_process == 'on')
                {
                    $review->is_process = 1;
                }
                else
                {
                    $review->is_process = 0;
                }
                $review->save();
                Message::set(__('review_edit_success'));
                $this->request->redirect('admin/site/review/edit/' . $review->id);
            }
            if ($review->is_fake == 1)
                $content_data['user'] = $review->fake_name;
            else
                $content_data['user'] = Customer::instance($review->user_id);
            $content_data['product'] = Product::instance($review->product_id);
            $content_data['review'] = $review;
            $content = View::factory('admin/site/review_edit', $content_data)->render();
            $this->request->response = View::factory('admin/template')->set('content', $content)->render();
        }
        else
        {
            Message::set(__('review_does_not_exist'), 'error');
            $this->request->redirect('/admin/site/review/list');
        }
    }

    public function action_add()
    {
        if ($_POST)
        {
            $_POST = Security::xss_clean($_POST);
            $sku = Arr::get($_POST, 'sku', '');
            $product_id = Product::get_productId_by_sku($sku);
            if (!orm::factory("product")
                    ->where("site_id", "=", $this->site_id)
                    ->where("id", "=", $product_id)
                    ->find()->loaded()
            )
            {
                Message::set("No Such Product!", "error");
            }
            else
            {
                $review = ORM::factory("review");
                $data = array(
                    'product_id' => $product_id,
                    'user_id' => Arr::get($_POST, 'user_id', 0),
                    'firstname' => Arr::get($_POST, 'firstname', ''),
                    'overall' => Arr::get($_POST, 'overall', 5),
                    'quality' => Arr::get($_POST, 'quality', 5),
                    'price' => Arr::get($_POST, 'price', 5),
                    'fitness' => Arr::get($_POST, 'fitness', 5),
                    'height' => Arr::get($_POST, 'height', 0),
                    'weight' => Arr::get($_POST, 'weight', 0),
                    'time' => strtotime(Arr::get($_POST, 'time', time())),
                    'content' => htmlspecialchars(Arr::get($_POST, 'content', '')),
                    'reply' => htmlspecialchars(Arr::get($_POST, 'reply', '')),
                    'site_id' => $this->site_id,
                    'is_approved' => Arr::get($_POST, 'is_approved', 0),
                );

                $attributes = '';
                $attrArr = Arr::get($_POST, 'attributes', array());
                foreach($attrArr as $name => $attr)
                {
                    $attributes .= $name . ': ' . $attr . ';';
                }
                $data['attribute'] = $attributes;

                $review->values($data);
                if($review->save())
                {
                    Message::set('Add reviews success', 'success');
                    $this->request->redirect('/admin/site/review/list');
                }
            }
        }
        $content = View::factory('admin/site/review_add')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_delete()
    {
        $id = $this->request->param('id');

        $review = ORM::factory('review', $id);

        if ($review->loaded())
        {
            //update review_statistics
            $product_id = $review->product_id;
            $statistics = DB::select('overall')->from('reviews')->where('product_id', '=', $product_id)->where('id', '<>', $review->id)->where('is_approved', '=', 1)->execute('slave')->as_array();
            $r_count = count($statistics);
            $rating_sum = 0;
            foreach($statistics as $s)
            {
                $rating_sum += $s['overall'];
            }
            if($r_count > 0)
                $r_rating = round($rating_sum / $r_count, 1);
            else
                $r_rating = 0;
            $data = array(
                'product_id' => $product_id,
                'rating' => (string) $r_rating,
                'quantity' => $r_count,
            );
            $has = DB::select('id')->from('review_statistics')->where('product_id', '=', $product_id)->execute('slave')->get('id');
            if($has)
            {
                DB::update('review_statistics')->set($data)->where('id', '=', $has)->execute();
            }
            else
            {
                DB::insert('review_statistics', array_keys($data))->values($data)->execute();
            }

            $review->delete($id);
            echo 'success';
        }
        else
        {
            echo (__('review_does_not_exist'));
        }
    }

    public function action_data()
    {
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

        $filter_sql = "1";
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                if ($item->field == 'time')
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
                else if ($item->field == 'is_fake')
                {
                    $_filter_sql[] = $item->field . "=" . $item->data;
                }
                else if($item->field == 'sku')
                {
                    $product_id = Product::get_productId_by_sku($item->data);
                    $_filter_sql[] = "product_id=" . $product_id;
                }
                else
                {
                    $_filter_sql[] = $item->field . "='" . $item->data . "'";
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;
        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM reviews WHERE site_id=' . $this->site_id . ' AND ' . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;
        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM reviews WHERE site_id=' . $this->site_id . ' AND ' .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        foreach ($result as $review)
        {
            $sku = Product::instance($review['product_id'])->get('sku');
            $response['rows'][$i]['id'] = $review['id'];
            $response['rows'][$i]['cell'] = array(
                '',
                $review['id'],
                $review['user_id'],
                $sku,
                $review['order_id'],
                $review['overall'],
                $review['quality'],
                $review['price'],
                $review['fitness'],
                $review['content'],
                $review['reply'],
                date('Y-m-d', $review['time']),
                $review['points'],
                $review['is_process'] == 1 ? 'Yes' : 'No',
                $review['is_approved'] == 1 ? 'Yes' : 'No',
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_approve($id)
    {
        $review = ORM::factory('review', $id);
        if (!$review->loaded())
        {
            die("Review with id $id not found");
        }

        $points = intval($_POST['points']);
        //echo $points;die;
        $review->values(array(
            'is_approved' => 1,
            'points' => $points,
        ));

        //update review_statistics
        $product_id = $review->product_id;
        $statistics = DB::select('overall')->from('reviews')->where('product_id', '=', $product_id)->where('is_approved', '=', 1)->execute('slave')->as_array();
        $statistics[] = array(
            'overall' => $review->overall,
        );
        $r_count = count($statistics);
        $rating_sum = 0;
        foreach($statistics as $s)
        {
           $rating_sum += $s['overall'];
        }
        $r_rating = round($rating_sum / $r_count, 1);
        $data = array(
            'product_id' => $product_id,
            'rating' => (string) $r_rating,
            'quantity' => $r_count,
        );
        $has = DB::select('id')->from('review_statistics')->where('product_id', '=', $product_id)->execute('slave')->get('id');
        if($has)
        {
            DB::update('review_statistics')->set($data)->where('id', '=', $has)->execute();
        }
        else
        {
            DB::insert('review_statistics', array_keys($data))->values($data)->execute();
        }

        if($review->user_id == 0)
        {
            if($review->save())
                die('success');
            else
                die('failed to save review data');
        }
        else
        {
            $customer = Customer::instance($review->user_id);
            if (!$customer->get('id'))
            {
               die('failed to get customer data');
            }

            // $customer->add_point(array(
            //     'amount' => $points,
            //     'type' => 'review',
            //     'status' => 'activated',
            // ));

          // if ($customer->point_inc($points) && $review->save())
            if($review->save())
            {

                Mail::SendTemplateMail('REVIEW_POINT', $customer->get('email'), array(
                    'firstname' => $customer->get('firstname'),
                    'product_link' => '<a href="' . Product::instance($review->product_id)->permalink() . '">' . Product::instance($review->product_id)->get('name') . '</a>',
                    ), Site::instance()->get('email'));
               die('success');
            }
            else
            {
                die('failed to save review data');
            }
        }
        
   }

    public function action_unapprove($id)
    {
        $review = ORM::factory('review', $id);
        if (!$review->loaded())
        {
            die("Review with id $id not found");
        }
        $review->values(array(
            'is_approved' => 0,
        ));
        if($review->save())
        {
            //update review_statistics
            $product_id = $review->product_id;
            $statistics = DB::select('id', 'overall')->from('reviews')->where('product_id', '=', $product_id)->where('is_approved', '=', 1)->execute('slave')->as_array();
            $rating_sum = 0;
            foreach($statistics as $key => $s)
            {
                if($s['id'] == $id)
                    unset($statistic[$key]);
                else
                    $rating_sum += $s['overall'];
            }
            $r_count = count($statistics);
            $r_rating = round($rating_sum / $r_count, 1);
            $data = array(
                'product_id' => $product_id,
                'rating' => (string) $r_rating,
                'quantity' => $r_count,
            );
            $has = DB::select('id')->from('review_statistics')->where('product_id', '=', $product_id)->execute('slave')->get('id');
            if($has)
            {
                DB::update('review_statistics')->set($data)->where('id', '=', $has)->execute();
            }
            else
            {
                DB::insert('review_statistics', array_keys($data))->values($data)->execute();
            }
            die('success');
        }
        else
            die('failed to unapprove review');
    }

    public function action_special_bulk()
    {
        $file_types = array(
            "application/vnd.ms-excel",
            "text/csv",
            "application/csv",
            "text/comma-separated-values",
            "application/octet-stream",
            "application/oct-stream"
        );
        if (!isset($_FILES) || (!in_array($_FILES["file"]["type"], $file_types)))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        $admin = Session::instance()->get('user_id');
        $success = array();
   //     $types = Kohana::config('promotion.types');
        while ($data = fgetcsv($handle))
        {

            try
            {
                if ($data[0] == 'SKU' OR $data[0] == 'sku')
                {
                    $row++;
                    continue;
                }
                $array = array();
                if ($data[0])
                {

                    $sku = $data[0];
                    $t = $data[1];
                    $proid = Product::get_productId_by_sku($sku);
                    $att =  Product::instance($proid)->get('attributes');
                    $con = count($att['Size']) -1;
                    $r = rand(0,$con);
                    $array['attribute'] = 'Size: '.$att['Size'][$r].';';
                    $array['product_id'] = $proid;
                    $array['time'] = strtotime($t);
                    $array['firstname'] = $data[2];
                    $array['height'] = $data[3];
                    $array['weight'] = $data[4];
                    $array['Content'] = $data[5];
                    $array['is_approved'] = 1;
                    $array['site_id'] = 1;
                    $array['overall'] = rand(4,5);
                    $array['quality'] = rand(4,5);
                    $array['price'] = rand(4,5);
                    $array['fitness'] = 3;




                        if ($array)
                        {
                            $result = DB::insert('reviews', array_keys($array))->values($array)->execute();
                            if ($result){

                     //update review_statistics
                    $statistics = DB::select('overall')->from('reviews')->where('product_id', '=', $proid)->where('is_approved', '=', 1)->execute('slave')->as_array();
                    $r_count = count($statistics);
                    $rating_sum = 0;
                    foreach($statistics as $s)
                    {
                        $rating_sum += $s['overall'];
                    }
                    if($r_count > 0)
                        $r_rating = round($rating_sum / $r_count, 1);
                    else
                        $r_rating = 0;
            $datass = array(
                'product_id' => $proid,
                'rating' => (string) $r_rating,
                'quantity' => $r_count,
            );
            $has = DB::select('id')->from('review_statistics')->where('product_id', '=', $proid)->execute('slave')->get('id');

            if($has)
            {
                DB::update('review_statistics')->set($datass)->where('id', '=', $has)->execute();
            }
            else
            {
                DB::insert('review_statistics', array_keys($datass))->values($datass)->execute();
            }
            
                                $success[] = $sku;
                            }
                        }

                    $row++;
                }
            }
            catch (Exception $e)
            {
                $error[] = "Add Row " . $row . " Fail: " . $e->getMessage();
                $row++;
            }
        }
        if (isset($error))
            echo(implode("<br/>", $error));
        echo '<br/>';
        $successes = implode("<br/>", $success);
        die("Success skus:<br/>" . $successes);
    }

    public function action_do_process()
    {
        if($_POST)
        {
            $data = array(
                'success' => 0,
            );
            $ids = trim(Arr::get($_POST, 'ids', ''));
            $ids = substr($ids, 1);
            if($ids)
            {
                $update = DB::query(Database::UPDATE, 'UPDATE `reviews` SET `is_process` = 1 WHERE `id` IN (' . $ids . ')')->execute();
                if($update)
                {
                    $data['success'] = 1;
                    $data['message'] = 'Update reviews process success!';
                }
                else
                {
                    $data['message'] = 'Update reviews process failed!';
                }
            }
            echo json_encode($data);
            exit;
        }
    }

     public function action_special_bulk11()
    {
        $file_types = array(
            "application/vnd.ms-excel",
            "text/csv",
            "application/csv",
            "text/comma-separated-values",
            "application/octet-stream",
            "application/oct-stream"
        );
        if (!isset($_FILES) || (!in_array($_FILES["file"]["type"], $file_types)))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        $admin = Session::instance()->get('user_id');
        $success = array();
        //$types = Kohana::config('promotion.types');
        while ($data = fgetcsv($handle))
        {
            try
            {
                if ($data[0] == 'SKU' OR $data[0] == 'sku')
                {
                    $row++;
                    continue;
                }
                //$array = array();
                if ($data[0])
                {
                    $sku = $data[0];
                    $t = $data[1];
                    $proid = Product::get_productId_by_sku($sku);
                    $update = DB::select('quantity')->from('review_statistics')->where('product_id', '=', $proid)->execute()->get('quantity');
                    $datas['quantity'] = $t + $update;
                    $updates = DB::update('review_statistics')->set($datas)->where('product_id', '=', $proid)->execute();
                    print_r($updates);
                    $row++;
                }
            }
            catch (Exception $e)
            {
                $error[] = "Add Row " . $row . " Fail: " . $e->getMessage();
                $row++;
            }
        }
        if (isset($error))
            echo(implode("<br/>", $error));
        echo '<br/>';
        $successes = implode("<br/>", $success);
        die("Success skus:<br/>" . $successes);
    }

    public function action_export()
    {
        if (!$_POST)
        {
            die('invalid request');
        }

        $date = strtotime(Arr::get($_POST, 'date', 0));
        // 添加更新结束时间
        $date_end = Arr::get($_POST, 'date_end', 0);

        if ($date_end)
        {
            $file_name = "reviews-" . date('Y-m-d', $date) . '_' . $date_end . ".csv";
            $date_end = strtotime($date_end);
        }
        else
        {
            $file_name = "reviews-" . date('Y-m-d', $date) . ".csv";
            $date_end = $date + 86400;
        }
        // echo $date . '-' . $date_end;exit;

        header("Content-type:application/vnd.ms-excel; charset=UTF-8");
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        echo "\xEF\xBB\xBF" . "User ID,Email,SKU,Order ID,Overall,Quality,Price,Fitness,Content,Reply,Time,Points\n";
        
        $result = DB::query(Database::SELECT, 'SELECT * FROM `reviews` WHERE `is_approved` = 1 AND `time` BETWEEN ' . $date . ' AND ' . $date_end)->execute('slave');
        foreach ($result as $review)
        {
            $content = str_replace(array("\n", ","), array(" ", "，"), $review['content']);
            $reply = str_replace(array("\n", ","), array(" ", "，"), $review['reply']);
            echo $review['user_id'] . ',';
            echo Customer::instance($review['user_id'])->get('email') . ',';
            echo Product::instance($review['product_id'])->get('sku') . ',';
            echo $review['order_id'] . ',';
            echo $review['overall'] . ',';
            echo $review['quality'] . ',';
            echo $review['price'] . ',';
            echo $review['fitness'] . ',';
            echo $content . ',';
            echo $reply . ',';
            echo date('Y-m-d H:i:s', $review['time']) . ',';
            echo $review['points'] . ',';
            echo "\n";
        }
    }

    public function action_video()
    {
        $content = View::factory('admin/site/video_list')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_deleteVideo()
    {
        $id = $this->request->param('id');
        $review = ORM::factory('reviewmedia', $id);
        if ($review->loaded())
        {
            $review->delete($id);
            echo 'success';
        }
        else
        {
            echo 'What you want does not exists !';
        }
    }

    public function action_editVideo()
    {
        $id = $this->request->param('id');
        $review = ORM::factory('reviewmedia', $id);
        if ($review->loaded())
        {
            if ($_POST)
            {
                $caption = htmlspecialchars(Arr::get($_POST, 'video_caption', ''));
                $url_add = htmlspecialchars(Arr::get($_POST, 'video_url', ''));
                $created = htmlspecialchars(Arr::get($_POST, 'time', time()));
                $checked = Arr::get($_POST, 'valid', 0);
                //$remarks = htmlspecialchars(Arr::get($_POST,'video_remarks',NULL));   此处留着备用
                if ($caption && $url_add && $created)
                {
                    $review->caption = $caption;
                    $review->url_add = $url_add;
                    $review->created = strtotime($created);
                    $review->checked = $checked;
                    //$review->remarks = $remarks;
                    $review->save();
                    Message::set('Video Edit Success', 'success');
                    $this->request->redirect('admin/site/review/editvideo/' . $review->id);
                }
                else
                {
                    Message::set('Caption and VideoURL must not be Null', 'error');
                    $this->request->redirect('admin/site/review/editvideo/' . $review->id);
                }
            }
            $content_data['product'] = Product::instance($review->product_id);
            $content_data['review'] = $review;
            $content = View::factory('admin/site/video_edit', $content_data)->render();
            $this->request->response = View::factory('admin/template')->set('content', $content)->render();
        }
        else
        {
            Message::set('Make sure that the video exists', 'error');
            $this->request->redirect('/admin/site/review/list');
        }
    }

    public function action_dataVideo()
    {
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

        $filter_sql = "1";
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                if ($item->field == 'time')
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
                else if ($item->field == 'product_id')
                {
                    $product_id = Product::get_productId_by_sku($item->data);
                    $_filter_sql[] = $item->field . "=" . $product_id;
                }
                else if ($item->field == 'is_fake')
                {
                    $_filter_sql[] = $item->field . "=" . $item->data;
                }
                else
                {
                    $_filter_sql[] = $item->field . "='" . $item->data . "'";
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
        {
            $limit = $totalrows;
        }
        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM review_media WHERE ' . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }
        else
        {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;
        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM review_media WHERE ' .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        foreach ($result as $review)
        {
            $response['rows'][$i]['id'] = $review['id'];
            $response['rows'][$i]['cell'] = array(
                $review['id'],
                Product::instance($review['product_id'])->get('sku') . '(' . $review['product_id'] . ')',
                Customer::instance($review['customer_id'])->get('email') . '(' . $review['customer_id'] . ')',
                $review['caption'],
                $review['url_add'],
                $review['checked'] == 1 ? 'Yes' : 'No',
                date('Y-m-d', $review['created']),
            );
            $i++;
        }
        echo json_encode($response);
    }

    //以下是 giveaway 审核功能部分
    public function action_giveaway()
    {
        $content = View::factory('admin/site/giveaway_list')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_exEmailGiveaway()
    {
        if ($_POST)
        {
            $stage = Arr::get($_POST, 'stage', NULL);
            if ($stage)
            {
                $rs = DB::query(Database::SELECT, 'select distinct c.email from customers c left join giveaway g on c.id = g.user_id where g.mark = \'' . $stage . '\' order by c.id desc')->as_object()->execute('slave');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment; filename="Giveaway Customers Email of ' . $stage . '.csv"');
                echo "Email\n";
                foreach ($rs as $v)
                {
                    echo $v->email . "\n";
                }
            }
            else
            {
                echo 'Sorry! Server is too busy.';
            }
        }
        else
        {
            echo 'Parameter Error!';
        }
    }

    public function action_toggle()
    {
        $g_id = Arr::get($_POST, 'gid', 0);
        $result = DB::select('is_valid')->from('giveaway')->where('id', '=', $g_id)->execute('slave')->get('is_valid', 0);
        if ($result)
        {
            $aff_row = DB::update('giveaway')->set(array('is_valid' => 0))->where('id', '=', $g_id)->execute();
        }
        else
        {
            $aff_row = DB::update('giveaway')->set(array('is_valid' => 1))->where('id', '=', $g_id)->execute();
        }
        if ($aff_row)
        {
            echo 'success';
            exit;
        }
        else
        {
            echo 'Failed, try again!';
            exit;
        }
    }

    public function action_deleteGiveaway()
    {
        $g_id = Arr::get($_POST, 'gid', 0);
        $aff_row = DB::delete('giveaway')->where('id', '=', $g_id)->execute();
        if ($aff_row)
        {
            echo 'success';
            exit;
        }
        else
        {
            echo 'Failed, try again!';
            exit;
        }
    }

    public function action_dataGiveaway()
    {
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

        $filter_sql = "1";
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                if ($item->field == 'time')
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
                else if ($item->field == 'is_fake')
                {
                    $_filter_sql[] = $item->field . "=" . $item->data;
                }
                else
                {
                    $_filter_sql[] = $item->field . "='" . $item->data . "'";
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
        {
            $limit = $totalrows;
        }
        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM giveaway WHERE ' . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }
        else
        {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;
        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM giveaway WHERE ' .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        foreach ($result as $giveaway)
        {
            if (preg_match('|``|', $giveaway['comments']))
            {
                $comment = explode('|``|', $giveaway['comments'], 2);
            }
            else
            {
                $comment = array('<b style="color:#f99f9f;">(Unknown)</b>', $giveaway['comments']);
            }
            $response['rows'][$i]['id'] = $giveaway['id'];
            $response['rows'][$i]['cell'] = array(
                $giveaway['id'],
                Customer::instance($giveaway['user_id'])->get('email') . '(' . $giveaway['user_id'] . ')',
                $giveaway['firstname'] . ' • ' . $giveaway['lastname'],
                $comment[0],
                $comment[1],
                $giveaway['mark'],
                date('Y-m-d', $giveaway['created']),
                $giveaway['is_valid'],
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_video_add()
    {
        if ($_POST)
        {
            $review = array();
            $review['email'] = Arr::get($_POST, 'email', '');
            $review['customer_id'] = Customer::instance()->is_register($review['email']);
            $sku = Arr::get($_POST, 'sku', '');
            $url = Arr::get($_POST, 'url', '');
            ;
            $v = strpos($url, 'v=');
            if ($v == False)
                $review['url_add'] = substr($url, -11, 11);
            else
                $review['url_add'] = substr($url, $v + 2, 11);
            $review['created'] = time();
            if ($sku AND $review['url_add'])
            {
                $review['product_id'] = Product::get_productId_by_sku($sku);
                if ($review['product_id'])
                {
                    DB::insert('review_media', array_keys($review))->values($review)->execute();
                    echo json_encode('success');
                }
                else
                    echo json_encode('failed');
            }
            else
                echo json_encode('failed');
        }
    }

    public function action_upload_video()
    {
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        while ($data = fgetcsv($handle))
        {
            if ($row == 1)
            {
                $row++;
                continue;
            }
            try
            {
                $data = Security::xss_clean($data);
                $review = array();
                $review['email'] = $data[0];
                $review['customer_id'] = Customer::instance()->is_register($review['email']);
                $url = $data[2];
                $v = strpos($url, 'v=');
                if ($v == False)
                    $review['url_add'] = substr($url, -11, 11);
                else
                    $review['url_add'] = substr($url, $v + 2, 11);
                if(strlen($review['url_add']) != 11)
                {
                    $error[] = "Add Row $row Fail: ".$review['url_add']." is Invalid id";
                    continue;
                }
                $review['created'] = time();
                $skus = explode(';', $data[1]);
                foreach ($skus as $sku)
                {
                    $review['product_id'] = Product::get_productId_by_sku($sku);
                    if ($review['product_id'])
                    {
                        DB::insert('review_media', array_keys($review))->values($review)->execute();
                        DB::update('products')->set(array('has_pick' => 1))->where('id', '=', $review['product_id'])->execute();
                    }
                }
                $row++;
            }
            catch (Exception $e)
            {
                $error[] = "Add Row " . $row . " Fail: " . $e->getMessage();
                $row++;
            }
        }
        if (isset($error))
            echo(implode("<br/>", $error));
        echo '<br/>';
        $num = $row - count($error) - 2;
        die("Upload " . $num . " celebrities successfully.");
    }

    public function action_product_attributes()
    {
        $data = array();
        $sku = Arr::get($_POST, 'sku', '');
        if($sku)
        {
            $product_id = Product::get_productId_by_sku($sku);
            if($product_id)
            {
                $attributes = Product::instance($product_id)->get('attributes');
                $html = '';
                foreach($attributes as $name => $attrs)
                {
                    $html .= '<label>' . $name . ':</label>&nbsp;&nbsp;&nbsp;<select name="attributes[' . $name . ']">';
                    foreach($attrs as $attr)
                    {
                        $html .= '<option value="' . $attr . '">' . $attr . '</option>';
                    }
                    $html .= '</select><br>';
                    $data['success'] = 1;
                    $data['html'] = $html;
                }
            }
        }
        else
        {
            $data['success'] = 0;
        }

        echo json_encode($data);
        exit;
    }

}
