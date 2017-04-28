<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * 操作反馈消息的设置和读取
 *
 */
class Message
{

    /**
     * 取得显示给用户的操作反馈消息
     *
     * @return string 返回一段html代码（完整的DIV），包含消息内容和显示样式
     */
    public static function get()
    {
        $session = Session::instance();
        $message = $session->get('message');
        $session->delete('message');
        return $message;
    }

    /**
     * 设置显示给用户的操作反馈消息
     *
     * @param string $msg 消息内容
     * @param string $type 消息类型，必须为下列三个单词之一：'success'（成功消息，默认）、'error'（错误消息）、'notice'（普通提示消息）
     */
    public static function set($msg, $type = 'success')
    {
        $msg_code = '<div class="remind remind-'.$type.'">'.$msg.'</div>';
        $session = Session::instance();
        $session->set('message', $msg_code);
    }

}
