<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Invoid 404, redirect invisible product page(404) to recommend product page.
 * created 2011-12-08
 * @author Qin.Chong(Qin.Aeon@gmail.com)
 */
class Controller_Admin_Site_Redirectlink extends Controller_Admin_Site
{

    public function action_list()
    {
        $content = View::factory('admin/site/redirectlink_list')->render();

        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
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
                if (in_array($item->field, array('src_link', 'des_link', 'created')))
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

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;
        if ($totalrows)
            $limit = $totalrows;

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM redirect_links WHERE site_id=' . $this->site_id . $filter_sql)->execute('slave')->current();

        $count = $result['count(id)'];
        $limit = $limit ? $limit : 1;
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM redirect_links WHERE site_id=' . $this->site_id . ' ' .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;
        $i = 0;
        foreach ($result as $link)
        {
            $response['rows'][$i]['id'] = $link['id'];
            $response['rows'][$i]['cell'] = array(
                $link['id'],
                $link['src_link'],
                $link['des_link'],
                date('Y-m-d', $link['created']),
                $link['operator']
            );

            $i++;
        }
        echo json_encode($response);
    }

    public function action_edit()
    {
        $oper = $_REQUEST['oper'];
        $src_link = $_REQUEST['src_link'];
        $des_link = $_REQUEST['des_link'];
        $id = $_REQUEST['id'];

        if ($oper == 'add')
        {
            //@TODO 在添加之前，要先确认原始链接是不是存在，不存在才可以添加。否则会造成数据冗余...
            if ($user = User::instance()->logged_in())
            {
                $user_name = $user['name'];
            }
            else
            {
                $this->request->redirect('/admin/site/redirectlink/list');
            }
            list($insert_id, $res) = DB::insert('redirect_links', array('site_id', 'src_link', 'des_link', 'created', 'operator'))
                ->values(array($this->site_id, $src_link, $des_link, time(), $user_name))
                ->execute();
            if ($res)
            {
                exit(json_encode(array('success' => true, 'errors' => '链接添加成功！')));
            }
            else
            {
                exit(json_encode(array('success' => false, 'errors' => '添加跳转失败！')));
            }
        }
        elseif ($oper == 'edit')
        {
            $res = DB::update('redirect_links')->set(array('src_link' => $src_link, 'des_link' => $des_link))->where('id', '=', $id)->execute();
            if ($res)
            {
                exit(json_encode(array('success' => true, 'errors' => '修改成功！')));
            }
            else
            {
                exit(json_encode(array('success' => false, 'errors' => '请确认数据是否有改动并且正确！')));
            }
        }
        elseif ($oper == 'del')
        {
            $res = DB::delete('redirect_links')->where('id', '=', $id)->execute();
            if ($res)
            {
                exit(json_encode(array('success' => true, 'errors' => '数据已被成功删除！')));
            }
            else
            {
                exit(json_encode(array('success' => false, 'errors' => '删除数据失败！')));
            }
        }
        else
        {
            exit;
        }
    }

}

?>
