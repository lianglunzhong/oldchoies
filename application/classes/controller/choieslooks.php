<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Choieslooks extends Controller_Webpage
{
/*        public function action_vol1()
        {
                $this->template->content = View::factory('/choieslooks/vol1');
        }*/
        
        public function action_sivanna_colors()
        {
                $this->template->content = View::factory('/choieslooks/sivanna_colors');
        }
        
        public function action_video_show()
        {
                $this->template->content = View::factory('/choieslooks/video_show');
        }
}

?>