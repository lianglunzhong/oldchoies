<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Ga extends Controller_Admin_Site
{

    private $user_name = "shijiangming09@gmail.com";
    private $user_pass = "kqiaje159/";
    private $report_id = 'ga:32176633';

    public function action_page_list()
    {
        $page = Arr::get($_REQUEST, 'page', 1);
        $limit = 20;
        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 1;

        $date_start = Arr::get($_POST, 'from', '');
        $date_end = Arr::get($_POST, 'to', '');
        if (!$date_start)
            $date_start = date('Y-m-d', strtotime('1 month ago'));
        if (!$date_end)
            $date_end = date('Y-m-d', strtotime('yesterday'));
        $sort = '-ga:pageviews';
        $ga = new Ga();
        $login = $ga->login($this->user_name, $this->user_pass);
        var_dump($login);exit;
        if ($ga->login($this->user_name, $this->user_pass))
        {
            $data = $ga->data($this->report_id, 'ga:pagePath', 'ga:pageviews,ga:uniquePageviews,ga:visits,ga:newVisits,ga:bounces', $sort, $date_start, $date_end, $limit, $start);
        }
        // print_r($data);exit;
        $content = View::factory('admin/site/ga_page_list')
            ->set('data', $data)
            ->set('date_start', $date_start)
            ->set('date_end', $date_end)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_source_list()
    {
        $limit = 20;
        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 1;

        $date_start = Arr::get($_POST, 'from', '');
        $date_end = Arr::get($_POST, 'to', '');
        if (!$date_start)
            $date_start = date('Y-m-d', strtotime('1 month ago'));
        if (!$date_end)
            $date_end = date('Y-m-d', strtotime('yesterday'));
        $sort = '-ga:visits';
        $ga = new Ga();
        if ($ga->login($this->user_name, $this->user_pass))
        {
            $data = $ga->data($this->report_id, 'ga:source', 'ga:visits,ga:newVisits,ga:bounces', '', $date_start, $date_end, $limit, $start);
        }
        $content = View::factory('admin/site/ga_source_list')
            ->set('data', $data)
            ->set('date_start', $date_start)
            ->set('date_end', $date_end)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_page_export()
    {
        if ($_POST)
        {
            $date_start = Arr::get($_POST, 'from', '');
            $date_end = Arr::get($_POST, 'to', '');
            if (!$date_start)
                $date_start = date('Y-m-d', strtotime('1 month ago'));
            if (!$date_end)
                $date_end = date('Y-m-d', strtotime('yesterday'));
            $filename = "page_$date_start-$date_end.csv";
            $search = Arr::get($_POST, 'search', '');
            if (!$search)
            {
                message::set('GA page export faild');
                $this->request->redirect('admin/site/ga/page_list');
            }
            $search_arr = explode("\n", $search);
            $ga = new Ga();

            if ($ga->login($this->user_name, $this->user_pass))
            {
                foreach ($search_arr as $key => $value)
                {
                    $search_arr[$key] = "ga:pagePath%3D%3D" . trim($value);
                }
                $filters = implode(",", $search_arr);
                $data = $ga->data($this->report_id, 'ga:pagePath', 'ga:pageviews,ga:uniquePageviews,ga:visits,ga:newVisits,ga:bounces', '', $date_start, $date_end, 1000, 1, $filters);

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment; filename="ga-' . $filename);
                echo "URL,PageViews,UniquePageViews,Visits,NewVisits,Bounces\n";
                foreach ($data as $metric => $count)
                {
                    echo $metric . ",";
                    echo $count['ga:pageviews'] . ",";
                    echo $count['ga:uniquePageviews'] . ",";
                    echo $count['ga:visits'] . ",";
                    echo $count['ga:newVisits'] . ",";
                    echo $count['ga:bounces'];
                    echo "\n";
                }
                $data = $ga->data($this->report_id, '', 'ga:bounces,ga:newVisits,ga:visits,ga:pageviews,ga:uniquePageviews', '', $date_start, $date_end);
                foreach ($data as $metric => $count)
                {
                    echo ",,,,,$metric: $count\n";
                }
            }
        }
    }

    public function action_source_export()
    {
        $date_start = Arr::get($_POST, 'from', '');
        $date_end = Arr::get($_POST, 'to', '');
        if (!$date_start)
            $date_start = '2012-06-01';
        if (!$date_end)
            $date_end = date('Y-m-d');
        $filename = "source_$date_start-$date_end.csv";
        $search = Arr::get($_POST, 'search', '');
        if (!$search)
        {
            message::set('GA page export faild');
            $this->request->redirect('admin/site/ga/page_list');
        }
        $search_arr = explode("\n", $search);
        $ga = new Ga();

        if ($ga->login($this->user_name, $this->user_pass))
        {
            $searchs = array();
            foreach ($search_arr as $key => $value)
            {
                $domain = substr($value, 0, strpos($value, '/'));
                $uri = substr($value, strpos($value, '/'));
                $searchs[$key] = "ga:source%3D%3D" . trim($domain) . ";ga:referralPath%3D%3D" . $uri;
            }
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="ga-' . $filename);
            echo "URL,Visits,NewVisits\n";
            
            foreach($searchs as $key => $filters)
            {
                $data = $ga->data($this->report_id, 'ga:source', 'ga:visits,ga:newVisits', '', $date_start, $date_end, 1000, 1, $filters);
                echo $search_arr[$key] . ",";
                foreach ($data as $metric => $count)
                {
                    echo $count['ga:visits'] . ",";
                    echo $count['ga:newVisits'];
                }
                echo "\n";
            }
        }
    }
    
    public function action_test()
    {
        $date_start = Arr::get($_POST, 'from', '');
        $date_end = Arr::get($_POST, 'to', '');
        $date_start = '2012-06-01';
        if (!$date_start)
            $date_start = date('Y-m-d', strtotime('1 month ago'));
        if (!$date_end)
            $date_end = date('Y-m-d');
        echo $date_start . '-' . $date_end;
        $filename = "source_$date_start-$date_end.csv";
        $ga = new Ga();

        if ($ga->login($this->user_name, $this->user_pass))
        {
            $filters = 'ga:source%3D%3Dlookbook.nu;ga:referralPath%3D%3D/look/4230661-When-the-power-of-love-overcomes-the-love-of-power';
            $data = $ga->data($this->report_id, 'ga:referralPath', 'ga:visits,ga:newVisits', '', $date_start, $date_end, 10, 1,$filters);

//            header('Content-Type: application/vnd.ms-excel');
//            header('Content-Disposition: attachment; filename="ga-' . $filename);
            echo "URL,Visits,NewVisits\n";
            foreach ($data as $metric => $count)
            {
                echo $metric . ",";
                echo $count['ga:visits'] . ",";
                echo $count['ga:newVisits'] . "\n";
            }
        }
    }

    public function action_import_data()
    {
        if($_FILES)
        {
            if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream"))
                die("Only csv file type is allowed!");
            $handle = fopen($_FILES["file"]["tmp_name"], "r");
            $row = 0;
            echo 'INSERT INTO `ga_product` (`customer_sign`, `created`, `product_id`, `time_on_page`) VALUES';
            echo "\n";
            while ($data = fgetcsv($handle))
            {
                $row ++;
                if($row == 1 || !trim($data[0]))
                    continue;
                $customer_sign = trim($data[0]);
                $created = trim($data[1]);
                $created = str_replace('T', ' ', $created);
                $created = strtotime($created);
                $page = trim($data[2]);
                $pos = strpos($page, '?');
                $pos_p = strpos($page, '_p');
                if($pos_p === FALSE)
                    continue;
                if($pos !== FALSE)
                {
                    $product_id = substr($page, $pos_p + 2, $pos - $pos_p - 2);
                }
                else
                {
                    $product_id = substr($page, $pos_p + 2);
                }
                $time_on_page = trim($data[4]);
                if($row % 100 == 0)
                {
                    echo '("'.$customer_sign.'", "'.$created.'", "'.$product_id.'", "'.$time_on_page.'");';
                    echo "\n" . 'INSERT INTO `ga_product` (`customer_sign`, `created`, `product_id`, `time_on_page`) VALUES';
                }
                else
                {
                    echo '("'.$customer_sign.'", "'.$created.'", "'.$product_id.'", "'.$time_on_page.'"),';
                }
                echo "\n";
            }
        }
        else
        {
            echo '<form enctype="multipart/form-data" method="post" action="">
                    <input id="file" type="file" name="file">
                    <input type="submit" value="submit" name="submit">
                </form>';
        }
    }

    public function action_import_product_relate()
    {
        if($_POST)
        {
            $product_ids = Arr::get($_POST, 'product_ids', '');
            $productArr = explode("\n", $product_ids);
            foreach ($productArr as $product_id)
            {
                $customers = DB::select('customer_sign')->from('ga_product')->where('product_id', '=', $product_id)->execute();
                $customers_sql = array();
                foreach($customers as $customer)
                {
                    $customers_sql[] = "'" . $customer['customer_sign'] . "'"; 
                }
                if(!empty($customers_sql))
                {
                    $relates = DB::query(Database::SELECT, 'SELECT product_id, COUNT(product_id) AS count_p FROM ga_product 
                        WHERE customer_sign IN (' . implode(',', $customers_sql) . ') GROUP BY product_id ORDER BY count_p DESC LIMIT 100')
                        ->execute();
                    $relate_array = array();
                    foreach($relates as $relate)
                    {
                        if($relate['product_id'] != $product_id)
                            $relate_array[] = $relate['product_id'];
                    }
                    if(!empty($relate_array))
                        DB::insert('ga_product_relate', array('product_id', 'relate', 'relate_count'))->values(array('product_id' => $product_id, 'relate' => implode(',', $relate_array), 'relate_count' => count($relate_array)))->execute();
                }
            }
        }
        echo '<form method="post" action="">
                <textarea name="product_ids" cols="40" rows="20"></textarea><br/>
                <input type="submit" value="submit" name="submit">
            </form>';
    }

}

?>