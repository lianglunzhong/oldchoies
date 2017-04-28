<?php

defined('SYSPATH') OR die('No direct script access.');

class Controller_Admin_Site_Newsletter extends Controller_Admin_Site
{

    public function action_list()
    {
        $content = View::factory('admin/site/newsletter_list')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_delete($id)
    {
        echo ORM::factory('newsletter', $id)->delete() ? 'success' : '删除失败';
    }

    public function action_data()
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

        $filter_sql = "";
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
                    $filter_sql .= " AND " . $item->field . " between " . $from . " and " . $to;
                }
                elseif ($item->field == 'firstname')
                    $filter_sql .= " AND CONCAT(firstname, ' ', lastname) LIKE '%" . $item->data . "%'";
                else
                    $filter_sql .= " AND " . $item->field . "='" . $item->data . "'";
            }
        }

        $result = DB::query(DATABASE::SELECT, 'SELECT COUNT(`newsletters`.`id`) AS num FROM `newsletters` WHERE `newsletters`.site_id=' . $this->site_id . ' '
                . $filter_sql)->execute('slave');
        $count = $result[0]['num'];
        $total_pages = 0;
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

        $result = DB::query(DATABASE::SELECT, 'SELECT `newsletters`.* FROM `newsletters` WHERE `newsletters`.site_id=' . $this->site_id . ' '
                . $filter_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $responce = array();
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $k = 0;
        foreach ($result as $newsletter)
        {
            $responce['rows'][$k]['id'] = $newsletter['id'];
            $responce['rows'][$k]['cell'] = array(
                $newsletter['id'],
                $newsletter['email'],
                $newsletter['firstname'],
                $newsletter['lastname'],
                $newsletter['gender'],
                $newsletter['zip'],
                $newsletter['occupation'],
                date('Y-m-d', $newsletter['birthday']),
                $newsletter['country'],
                date('Y-m-d', $newsletter['created'])
            );
            $k++;
        }
        echo json_encode($responce);
    }

    public function action_export()
    {
        set_time_limit(0);
        if ($_POST)
        {
            $start = Arr::get($_POST, 'start', NULL);
            $end = Arr::get($_POST, 'end', NULL);
            $query = DB::select('*')->from('newsletters');
            $site = Site::instance();
            $file = 'newsletters';
            if ($start)
            {
                $file .= "-from-$start";
                $query->where('created', '>=', strtotime($start));
            }

            if ($end)
            {
                $file .= "-to-$end";
                $query->where('created', '<', strtotime($end));
            }
            $query->where('site_id', '=', $site->get('id'));
            $newsletter = $query->execute('slave');
            /** Error reporting */
            error_reporting(E_ALL);

            date_default_timezone_set('Europe/London');

            /** PHPExcel */
            require_once("PHPExcel.php");

// Create new PHPExcel object
            $objPHPExcel = new PHPExcel();

// Set properties
            $objPHPExcel->getProperties()->setCreator("cofree")
                ->setLastModifiedBy("cofree")
                ->setTitle("Office 2007 XLSX --Newsletter")
                ->setSubject("Office 2007 XLSX --Newsletter")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");

            /*
             * 获取session ：：order_list_excel中的数据！
             */

            $i = 2;

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Time(注册时间)')
                ->setCellValue('B1', 'Email')
                ->setCellValue('C1', 'First Name')
                ->setCellValue('D1', 'Last Name')
                ->setCellValue('E1', 'Gender')
                ->setCellValue('F1', 'Occupation')
                ->setCellValue('G1', 'Birthday')
                ->setCellValue('H1', 'Country');

            foreach ($newsletter as $key => $rs)
            {


                $date = date('Y-m-d H:i:s', $rs['created']);
                if (isset($rs))
                {

                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("A$i", $date)
                        ->setCellValue("B$i", $rs['email'])
                        ->setCellValue("C$i", $rs['firstname'])
                        ->setCellValue("D$i", $rs['lastname'])
                        ->setCellValue("E$i", $rs['gender'])
                        ->setCellValue("F$i", $rs['occupation'])
                        ->setCellValue("G$i", $rs['birthday'])
                        ->setCellValue("H$i", $rs['country']);
                    $i = $i + 1;
                }
                else
                {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("A$i", $date)
                        ->setCellValue("B$i", $rs['email'])
                        ->setCellValue("C$i", $rs['firstname'])
                        ->setCellValue("D$i", $rs['lastname'])
                        ->setCellValue("E$i", $rs['gender'])
                        ->setCellValue("F$i", $rs['occupation'])
                        ->setCellValue("G$i", $rs['birthday'])
                        ->setCellValue("H$i", $rs['country']);
                    $i = $i + 1;
                }

                //  var_dump($i);exit;
//设置单元格自动换行
                //     $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                //        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                //       $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                //       $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                //       $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                //        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                //        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                //         $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                //$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);//setAutoSize(true);//setWidth(90);
//设置单元格内自动换行

                $objPHPExcel->getActiveSheet()->getStyle("A$i")->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle("B$i")->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle("C$i")->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle("D$i")->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle("E$i")->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle("F$i")->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle("G$i")->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle("H$i")->getAlignment()->setWrapText(true);


                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30); //setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
            }
// Rename sheet
            $objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename=' . $file . '.xlsx');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            exit;
            /* header('Content-Type: text/plain');
              header("Content-Disposition: attachment; filename=\"$file.txt\"");
              foreach ($customers as $customer)
              {
              print "{$customer['email']}\n";
              } */
        }
    }

}
