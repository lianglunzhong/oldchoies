<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Doc extends Controller_Admin_Site
{

    public function action_list()
    {
        $languages = Kohana::config('sites.' . $this->site_id . '.language');
        $lang = Arr::get($_GET, 'lang');
        if (!in_array($lang, $languages))
        {
            $lang = '';
        }
        $docs = ORM::factory('doc' . $lang)
                ->where('site_id', '=', $this->site_id)
                ->order_by('id', 'DESC')
                ->find_all();
        $sites = ORM::factory('site')
                ->where('id', '<>', $this->site_id)
                ->find_all();
        $content = View::factory('admin/site/docs_list')
                ->set('docs', $docs)
                ->set('sites', $sites)
                ->set('languages', $languages)
                ->set('lang', $lang)
                ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_add()
    {
        $languages = Kohana::config('sites.' . $this->site_id . '.language');
        $lang = Arr::get($_GET, 'lang');
        if (!in_array($lang, $languages))
        {
            $lang = '';
        }
        if ($_POST)
        {
            $doc = ORM::factory('doc')
                    ->where('link', '=', $_POST['link'])
                    ->where('site_id', '=', $this->site_id)
                    ->find();
            if ($doc->loaded())
            {
                Message::set("Duplicate document link", 'error');
            }
            else
            {
                $new_doc = ORM::factory('doc');
                $new_doc->values(array(
                    'site_id' => $this->site_id,
                    'link' => Arr::get($_POST, 'link', ''),
                    'is_active' => Arr::get($_POST, 'is_active', 1),
                    'name' => Arr::get($_POST, 'name', ''),
                    'content' => Arr::get($_POST, 'content', ''),
                ));

                if ($new_doc->check())
                {
                    $new_doc->save();
                    foreach($languages as $language)
                    {
                        if($language == 'en')
                            continue;
                        $docs = ORM::factory('doc' . $language);
                        $docs->values(array(
                            'id' => $new_doc->id,
                            'site_id' => $this->site_id,
                            'link' => Arr::get($_POST, 'link', ''),
                            'is_active' => Arr::get($_POST, 'is_active', 1),
                            'name' => Arr::get($_POST, 'name', ''),
                            'content' => Arr::get($_POST, 'content', ''),
                        ));
                        if ($docs->check())
                            $docs->save();
                    }
                    message::set('Add document successfully');
                    $this->request->redirect('/admin/site/doc/list' . '?lang=' . $lang);
                }
                Message::set("Add document fail", 'error');
            }
        }
        $this->request->response = View::factory('admin/template')
                ->set('content', View::factory('admin/site/docs_add')->render())
                ->render();
    }

    public function action_delete($id)
    {
        $languages = Kohana::config('sites.' . $this->site_id . '.language');
        $lang = Arr::get($_GET, 'lang');
        if (!in_array($lang, $languages))
        {
            $lang = '';
        }
        $user_id = Session::instance()->get('user_id');
        $users = User::instance($user_id)->get();
        if ($users['role_id'] == 8)
        {
            Message::set('Dont have permission to delete this!', 'notice');
            $this->request->redirect('/admin/site/catalog/list');
        }
        if (ORM::factory('doc' . $lang, $id)->delete())
        {
            message::set('delete document successfully');
        }
        else
        {
            message::set('delete document fail！', 'error');
        }

        $this->request->redirect('/admin/site/doc/list' . '?lang=' . $lang);
    }

    public function action_edit($id)
    {
        $languages = Kohana::config('sites.' . $this->site_id . '.language');
        $lang = Arr::get($_GET, 'lang');
        if (!in_array($lang, $languages))
        {
            $lang = '';
        }
        if(!$lang)
        {
            $user_id = Session::instance()->get('user_id');
            $users = User::instance($user_id)->get();
            if($users['role_id'] == 8)
            {
                $this->request->redirect(URL::current(TRUE) . '?lang=' . $users['lang']);
            }
        }
        $doc = ORM::factory('doc' . $lang)
                ->where('site_id', '=', $this->site_id)
                ->where('id', '=', $id)
                ->find();

        if (!$doc->loaded())
        {
            message::set('This document is not exist!');
            $this->request->redirect('admin/site/doc/list' . '?lang=' . $lang);
        }

        if ($_POST)
        {
            $doc->values(array(
                'site_id' => $this->site_id,
                'meta_title' => Arr::get($_POST, 'meta_title', ''),
                'meta_keywords' => Arr::get($_POST, 'meta_keywords', ''),
                'meta_description' => Arr::get($_POST, 'meta_description', ''),
                'name' => Arr::get($_POST, 'name', ''),
                'link' => Arr::get($_POST, 'link', ''),
                'content' => Arr::get($_POST, 'content', ''),
            ));

            if ($doc->check())
            {
                $doc->save();
                message::set('Edit document successfully');
            }
            $langet = $lang ? '?lang=' . $lang : '';
            $this->request->redirect('/admin/site/doc/edit/' . $id . $langet);
        }

        $content = View::factory('admin/site/docs_edit')
                ->set('doc', $doc)
                ->set('languages', $languages)
                ->set('lang', $lang)
                ->render();

        $this->request->response =
                View::factory('admin/template')
                ->set('content', $content)
                ->render();
    }

    public function action_copy()
    {
        $languages = Kohana::config('sites.' . $this->site_id . '.language');
        $lang = Arr::get($_GET, 'lang');
        if (!in_array($lang, $languages))
        {
            $lang = '';
        }
        $sql = 'select * from docs where site_id=' . $_POST['site_id'] . ' order by id desc';
        $docs = Database::instance($_POST['site_id'])->query(DATABASE::SELECT, $sql, 'Model_DOC');
        foreach ($docs as $doc)
        {
            if (ORM::factory('doc')
                            ->where('link', '=', $doc->link)
                            ->where('site_id', '=', $this->site_id)
                            ->find()->loaded())
                continue;
            else
            {
                $new_doc = ORM::factory('doc');
                $new_doc->values(array(
                    'site_id' => $this->site_id,
                    'name' => $doc->name,
                    'is_active' => 1,
                    'link' => $doc->link,
                    'content' => $doc->content,
                ));

                if ($new_doc->check())
                {
                    $new_doc->save();
                }
            }
        }
        Message::set("Bulk copy successfully.");
        $this->request->redirect('/admin/site/doc/list' . '?lang=' . $lang);
    }

}

?>