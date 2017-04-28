<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <title><?php echo Site::instance()->get('domain'); ?> </title>
                <link type="image/x-icon" rel="shortcut icon" href="/favicon.ico" />
                <link type="text/css" rel="stylesheet" href="/media/css/all.css" media="all" id="mystyle" charset="utf-8" />
                <link type="text/css" href="/media/js/jquery-ui/jquery-ui-1.8.1.custom.css" rel="stylesheet" id="uistyle" />
                <link rel="stylesheet" type="text/css" media="screen" href="/media/css/ui.jqgrid.css" />
                <script type="text/javascript" src="/media/js/jquery-1.4.2.min.js"></script>
                <script type="text/javascript" src="/media/js/jquery-ui-1.8.1.custom.min.js"></script>
                <script src="/media/js/grid.locale-cn.js" type="text/javascript"></script>
                <script src="/media/js/jquery.jqGrid.min.js" type="text/javascript"></script>
                <script src="/media/js/jquery.center.js" type="text/javascript"></script>
                <script type="text/javascript" src="/media/js/global.js"></script>
                <script type="text/javascript" src="/media/js/index.js"></script>
                <?php
                //role edit
                $user_id = Session::instance()->get('user_id');
                $edits = User::instance($user_id)->get_edits();
                if (!empty($edits))
                {
                        $uri = $_SERVER['REQUEST_URI'];
                        $uris = explode('/', $uri);
                        if(!in_array($uris[3], $edits))
                        {
                                echo '<script type="text/javascript" src="/media/js/role.js"></script>';
                        }
                }
                ?>
        </head>
        <body>

                <div id="do_header">
                <!--<h1><a href="#"><img src="logo.gif" alt="Shadmin"></a></h1>-->
                        <div class="menu">Welcome
                                <?php
                                if ($user = User::instance()->logged_in())
                                {
                                        echo $user['name'];
                                        ?>
                                        | <a href="/admin/user/password/<?php echo $user['id']; ?>">Profile</a>
                                        <?php
                                }
                                if ($user['role_id'] == 0):
                                        ?>
                                        | <a href="/admin/user/edit">Settings</a> | <a href="/admin/sys/user/list">User List</a>
                                <?php endif; ?>
                                | <a href="/manage/product/update_log" style="color: orange; font-weight: bold;">Manage</a> | <a href="/admin/user/logout">Logout</a></div>
                </div>

                <!--<div id="do_nav">
                    <ul>
                        <li><a href="">订单</a></li>
                        <li><a href="">产品</a></li>
                        <li><a href="">国家物流</a></li>
                        <li><a href="">管理员</a></li>
                        <li><a href="/admin//sys/site/list">系统管理</a></li>
                        <li><a href="/admin/site/doc/list">站点1选中</a></li>
                    </ul>
                </div>-->

                <div id="do_sub_nav">
                        <ul>
                                <?php
                                // role control
                                $links = kohana::config('roles.links');
                                $views = array();
                                if ($user_id)
                                {
                                        $views = User::instance($user_id)->get_views();
                                }
                                $langUrl = '';
                                if($user['lang'] != 'en' AND $user['lang'] != 'zh' AND Arr::get($_GET, 'lang', '') == '')
                                    $langUrl = '?lang=' . $user['lang'];
                                if (!empty($views))
                                {
                                        $pages = kohana::config('roles.pages');
                                        foreach ($links as $name => $link)
                                        {
                                                if (in_array($pages[$name], $views))
                                                {
                                                    if($name == 'System' AND $user['role_id'] == 8)
                                                    {
                                                        ?>
                                                        <li><a href="/admin/site/doc/list<?php echo $langUrl; ?>">Documents</a></li>
                                                        <li><a href="/admin/site/attribute/small/<?php echo $user['lang']; ?>">Attributes</a></li>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <li><a href="/admin/site/<?php echo $link . $langUrl; ?>"><?php echo $name; ?></a></li>
                                                        <?php
                                                    }
                                                }
                                        }
                                }
                                else
                                {
                                        foreach ($links as $name => $link)
                                        {
                                                ?>
                                                <li><a href="/admin/site/<?php echo $link . $langUrl; ?>"><?php echo $name; ?></a></li>
                                                <?php
                                        }
                                }
                                ?>
                        </ul>
                </div>

                <div id="do_wrapper">
                        <?php
//输出可能会有的操作反馈信息：
                        echo message::get();

                        echo $content;
                        ?>
                </div>

                <div id="do_footer">
                        <span class="left"><a href="#">Dashboard</a> | <a href="#">Clients</a> | <a href="#">Reports</a> | <a href="#">System</a></span>
                        <span class="right">© 2009 Shadmin. All Rights Reserved.</span>
                </div>
                </div>
        </body>
</html>
