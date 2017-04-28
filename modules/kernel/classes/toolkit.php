<?php defined('SYSPATH') or die('No direct script access.');

class toolkit
{

	public static function hash($password)
	{
		return sha1($password);
	}

	public static function price($price, $action = 'show', $currency_name = NULL)
	{
		$currency = Site::instance()->currency_get($currency_name);

		$price = $price * $currency['rate'];

		switch( $action )
		{
			case 'show' :
				return $currency['code'].$price;
				break;
			case 'data' :
				return $price;
				break;
		}
	}

	public static function curl_pay($API_Endpoint, $nvpStr)
	{
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpStr);
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                $curl_error_no = curl_errno($ch);
                $curl_error_msg = curl_error($ch);
            } else {
                curl_close($ch);
            }
            return $response;
	}
    //支付-->风控
    public static function curl_pay_fk($API_Endpoint, $nvpStr)
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpStr);
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                $curl_error_no = curl_errno($ch);
                $curl_error_msg = curl_error($ch);
                $return = 0;
            } else {
                if($response)
                {
                    $return = 1;
                }else{
                    $return = 0;
                }
                curl_close($ch);
            }
            return $return;
        }catch (Exception $exception){
            kohana::$log->add('curl_error',json_encode($exception->getMessage()));
        }

    }

	//update guo 11.27
	public static function curl_paytrack($API_Endpoint, $nvpStr)
	{
/*		$header = array();
		$header[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36';
		$header[] = 'Connection: close';
		$header[] = '17token: F702DEFBC67EDB455949F46BABAB0C18';
		$header[] = 'Accept-Encoding: gzip';
		$header[] = 'Cache-Control: max-age=0';*/

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("17token: F702DEFBC67EDB455949F46BABAB0C18"));  //构造IP
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpStr);
		$response = curl_exec($ch);
		if(curl_errno($ch))
		{
			$curl_error_no = curl_errno($ch);
			$curl_error_msg = curl_error($ch);
		}
		else
		{
			curl_close($ch);
		}
		return $response;
	}
	
	/**
	 * 判断一个url是否本站的url。
	 * @param <type> $url 用于判断的url字符串
	 * @param <type> $domain 用作判断依据的主域名，如此参数未提供，则取数据库中的本站主域名。
	 */
	public static function is_our_url($url,$domain = NULL)
	{
		$url = parse_url($url);
		if($domain == NULL)
		{
			$domain = URLSTR;
		}
		if(!isset($url['host']) OR preg_match('/^(([-\w\.]+)\.)?'.str_replace('.','\.',$domain).'$/', $url['host']))
		{
			return TRUE;
		}
		return FALSE;
	}

	public static function date_format($time)
	{
        return date('Y-m-d H:i:s', $time);
    }

    public static function fill_zero($num_str,$zeros)
    {
        $nums = explode('.',$num_str);
        $i = 0;
        if(isset($nums[1]))
        {
            $i = strlen($nums[1]);
        }
        $j = $zeros - $i;
        if($j >= 0)
        {
            $num_str = $num_str.($i == 0 ? '.':'').str_repeat('0',$j);
        }
        return $num_str;
    }

    /**
	 * BBCODE to HTML
	 *
	 * @param string $text 
	 * @param string $emoticon 
	 * @return string
	 */
	public static function format_html($text, $whitespace = FALSE, $br = TRUE)
	{
		// Convert special characters to HTML entities
		$text = htmlspecialchars($text);
                
		// image and link
		$regular = array(
			'#\[img\]([\w]+?://[\w\#$%&~/.\-;:=,' . "'" . '?@\[\]+]*?)\[/img\]#is',
			// [img=xxxx://www.kohana.cn]image url[/img]
			'#\[img=([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*?)\]([\w]+?://[\w\#$%&~/.\-;:=,' . "'" . '?@\[\]+]*?)\[/img\]#is',
			// [img=www.kohana.cn]image url[/img]
			'#\[img=((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*?)\]([\w]+?://[\w\#$%&~/.\-;:=,' . "'" . '?@\[\]+]*?)\[/url\]#is',
			
			// [url]xxxx://www.kohana.cn[/url]
			'#\[url\]([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*?)\[/url\]#is',
			// [url]www.kohana.cn[/url]
			'#\[url\]((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*?)\[/url\]#is',
			// [url=xxxx://www.kohana.cn]KohanaCN[/url]
			'#\[url=([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*?)\]([^?\n\r\t].*?)\[/url\]#is',
			// [url=www.kohana.cn]KohanaCN[/url]
			'#\[url=((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*?)\]([^?\n\r\t].*?)\[/url\]#is',
			
//			'/\[b\](.*?)\[\/b\]/i',
			'/\[strong\](.*?)\[\/strong\]/i',
			'/\[i\](.*?)\[\/i\]/i',
			'/\[em\](.*?)\[\/em\]/i',
			'/\[u\](.*?)\[\/u\]/i',
			'/\[s\](.*?)\[\/s\]/i',
			'/\[strike\](.*?)\[\/strike\]/i',
		);
		
		$replace = array
		(
			'<img class="tpi" src="$1" border="0" />',
			'<a href="$1" rel="nofollow external" class="tpa"><img class="code" src="$2" border="0" /></a>',
			'<a href="http://$1" rel="nofollow external" class="tpa"><img class="code" src="$2" border="0" /></a>',
			
			'<a href="$1" rel="nofollow external" class="tpa">$1</a>',
			'<a href="http://$1" rel="nofollow external" class="tpa">http://$1</a>',
			'<a href="$1" rel="nofollow external" class="tpa">$2</a>',
			'<a href="http://$1" rel="nofollow external" class="tpa">$2</a>',
			
//			'<strong>$1</strong>',
			'<strong>$1</strong>',
			'<em>$1</em>',
			'<em>$1</em>',
			'<u>$1</u>',
			'<strike>$1</strike>',
			'<strike>$1</strike>',
		);
		$text = preg_replace($regular, $replace, $text);
		
		// Quote
		preg_match('/\[quote\]/i', $text, $bbcode_quote_open);
		preg_match('/\[\/quote\]/i', $text, $bbcode_quote_close);
		if (count($bbcode_quote_open) == count($bbcode_quote_close))
		{
			$text = str_ireplace("[quote]\n", '[quote]', $text);
			$text = str_ireplace("\n[/quote]", '[/quote]', $text);
			$text = str_ireplace("[quote]\r", '[quote]', $text);
			$text = str_ireplace("\r[/quote]", '[/quote]', $text);
			$text = str_ireplace('[quote]', '<blockquote>', $text);
			$text = str_ireplace('[/quote]', '</blockquote>', $text);
		}
	
		// Code
		preg_match('/\[code\]/i', $text, $bbcode_code_open);
		preg_match('/\[\/code\]/i', $text, $bbcode_code_close);
		if (count($bbcode_code_open) == count($bbcode_code_close))
		{
			$text = str_ireplace("[code]\n", '[code]', $text);
			$text = str_ireplace("\n[/code]", '[/code]', $text);
			$text = str_ireplace("[code]\r", '[code]', $text);
			$text = str_ireplace("\r[/code]", '[/code]', $text);
			$text = str_ireplace('[code]', '<pre class="code">', $text);
			$text = str_ireplace('[/code]', '</pre>', $text);
		}

                // B
		preg_match('/\[b]/i', $text, $bbcode_b_open);
		preg_match('/\[\/b]/i', $text, $bbcode_b_close);
		if (count($bbcode_b_open) == count($bbcode_b_close))
		{
			$text = str_ireplace("[b]\n", '[b]', $text);
			$text = str_ireplace("\n[/b]", '[/b]', $text);
			$text = str_ireplace("[b]\r", '[b]', $text);
			$text = str_ireplace("\r[/b]", '[/b]', $text);
			$text = str_ireplace('[b]', '<strong>', $text);
			$text = str_ireplace('[/b]', '</strong>', $text);
		}
		
		// Inserts HTML line breaks before all newlines in a string
		$text = self::auto_p($text, $whitespace, $br);
		if (strpos($text, '<pre') !== FALSE)
		{
			$text = preg_replace_callback('!(<pre[^>]*>)(.*?)</pre>!is', array('self', 'clean_pre'), $text);
		}
		
		return $text;
	}
	
	/**
	 * Copy Kohana Text::auto_p method
	 * but added one parameter to control if it auto corvert whitespace
	 *
	 * @param string $str 
	 * @param boolean $whitespace 
	 * @param boolean $br 
	 * @return string
	 */
	public static function auto_p($str, $whitespace = FALSE, $br = TRUE)
	{
		// Trim whitespace
		if (($str = trim($str)) === '')
			return '';

		// Standardize newlines
		$str = str_replace(array("\r\n", "\r"), "\n", $str);

		// Trim whitespace on each line
		if ($whitespace === TRUE)
		{
			$str = preg_replace('~^[ \t]+~m', '', $str);
			$str = preg_replace('~[ \t]+$~m', '', $str);
		}

		// The following regexes only need to be executed if the string contains html
		if ($html_found = (strpos($str, '<') !== FALSE))
		{
			// Elements that should not be surrounded by p tags
			$no_p = '(?:p|div|h[1-6r]|ul|ol|li|blockquote|d[dlt]|pre|t[dhr]|t(?:able|body|foot|head)|c(?:aption|olgroup)|form|s(?:elect|tyle)|a(?:ddress|rea)|ma(?:p|th))';

			// Put at least two linebreaks before and after $no_p elements
			$str = preg_replace('~^<'.$no_p.'[^>]*+>~im', "\n$0", $str);
			$str = preg_replace('~</'.$no_p.'\s*+>$~im', "$0\n", $str);
		}

		// Do the <p> magic!
		$str = '<p>'.trim($str).'</p>';
		$str = preg_replace('~\n{2,}~', "</p>\n\n<p>", $str);

		// The following regexes only need to be executed if the string contains html
		if ($html_found !== FALSE)
		{
			// Remove p tags around $no_p elements
			$str = preg_replace('~<p>(?=</?'.$no_p.'[^>]*+>)~i', '', $str);
			$str = preg_replace('~(</?'.$no_p.'[^>]*+>)</p>~i', '$1', $str);
		}

		// Convert single linebreaks to <br />
		if ($br === TRUE)
		{
			$str = preg_replace('~(?<!\n)\n(?!\n)~', "<br />\n", $str);
		}

		return $str;
	}
	
	/**
	 * preg_replace_callback method to clean pre (No <br>, <p> labels)
	 * 
	 *
	 * @param string $matches 
	 * @return string
	 */
	private static function clean_pre($matches)
	{
		if (is_array($matches))
		{
			$text = $matches[1] . $matches[2] . "</pre>";
		}	
		else
		{
			$text = $matches;
		}
		
		$text = str_replace('<br />', '', $text);
		$text = str_replace('<p>', "\n", $text);
		$text = str_replace('</p>', '', $text);

		return $text;
	}

    public static function array_2d_search($array,$keywords,$multiple = FALSE)
    {
        foreach($array as $idx=>$arr)
        {
            $find = TRUE;
            foreach($keywords as $k => $v)
            {
                if(!isset($arr[$k]) OR $arr[$k] != $v)
                {
                    $find = FALSE;
                    break;
                }
            }
            if($find)
            {
                if(!$multiple)
                {
                    return $idx;
                }
                else
                {
                    $keys[] = $idx;
                }
            }
        }

        if($multiple)
        {
            return isset($keys) ? $keys : array();
        }
        return FALSE;
    }

    public static function get_instance($class_name)
    {
        try
        {
            $class = new ReflectionClass($class_name);
            $instance = $class->newInstance();
        }
        catch(Exception $e){
            $instance = FALSE;
        }

        return $instance;
    }

    public static function generate_catalog_query($param,$current_params)
    {
        $queries = array();

        if(isset($param['price_range']))
        {
            if(!empty($param['price_range']) AND (empty($param['price_cancel_self']) OR $param['price_range'] != $current_params['price_range_key']))
            {
                $queries[] = 'prg='.$param['price_range'];
            }
        }
        elseif(!empty($current_params['price_range_key']) AND $current_params['price_range_key'] > 0)
        {
            $queries[] = 'prg='.$current_params['price_range_key'];
        }

        if(!empty($param['option']['single_option_one_time']))
        	$filter_options=array();
        else 
        	$filter_options = $current_params['options'];
        if(isset($param['option']))
        {
            $attribute_id = $param['option']['attribute_id'];
            $option_id = $param['option']['option_id'];
            if(isset($filter_options['at_'.$attribute_id][$option_id]) AND !empty($param['option']['cancel_self']))
            {
                unset($filter_options['at_'.$attribute_id][$option_id]);
            }
            else
            {
                if(!empty($param['option']['single_option_in_one_attribute']))
                {
                    $filter_options['at_'.$attribute_id] = array($option_id => $option_id);
                }
                else
                {
                    $filter_options['at_'.$attribute_id][$option_id] = $option_id;
                }
            }

            if(isset($filter_options['at_'.$attribute_id]) AND ($option_id == 0 OR !count($filter_options['at_'.$attribute_id])))
            {
                unset($filter_options['at_'.$attribute_id]);
            }

        }
        foreach($filter_options as $attr_key => $opts)
        {
            $queries[] = $attr_key.'='.implode('_',array_keys($opts));
        }

        if(isset($param['order_by']))
        {
            if($param['order_by']['by'] !== NULL)
            {
                $queries[] = 'orderby='.$param['order_by']['by'];
                if($param['order_by']['desc'] !== NULL)
                {
                    $queries[] = 'desc='.$param['order_by']['desc'];
                }
            }
            /*if(isset($_GET['page']))
            {
                $queries[] = 'page='.$_GET['page'];
            }*/
        }
        elseif(isset($current_params['order_by']))
        {
            if($current_params['order_by']['by'] !== NULL)
            {
                $queries[] = 'orderby='.$current_params['order_by']['by'];
                if($current_params['order_by']['desc'] !== NULL)
                {
                    $queries[] = 'desc='.$current_params['order_by']['desc'];
                }
            }
        }

        return implode('&',$queries);
    }

    public static function generate_price_range_string($range,$split = ' - ')
    {
        if(count($range) != 2)
        {
            return '';
        }

        if($range[0] == -1)
        {
            $range_string = Site::instance()->price(0,'code_view').$split.Site::instance()->price($range[1],'code_view');
        }
        elseif($range[1] == -1)
        {
            $range_string = Site::instance()->price($range[0],'code_view').'+';
        }
        else
        {
            $range_string = Site::instance()->price($range[0],'code_view').$split.Site::instance()->price($range[1],'code_view');
        }

        return $range_string;
    }
}
