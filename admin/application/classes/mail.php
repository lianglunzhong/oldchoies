<?php
defined('SYSPATH') or die('No direct script access.');

class Mail
{
    public static function SendTemplateMail($type, $rcpt, $context, $from=NULL, $is_bcc=NULL, $output=FALSE, $isSMTP=false)
    {
//        if(strpos($rcpt, '@hotmail.') or strpos($rcpt, '@live.'))
//            $isSMTP = TRUE;
        $lang = DB::select('lang')->from('accounts_customers')->where('site_id', '=', 1)->where('email', '=', $rcpt)->execute()->get('lang');
        $mail_lang=empty($lang)?"en":$lang;
        if( Kohana::config('webpower.'.$mail_lang.'.active.action')==1 && Kohana::config('webpower.'.$mail_lang.'.mail.'.$type)){
            if(empty($context['firstname']))
                    $context['firstname'] = 'Choieser';
            if(empty($context['site_link']))
                    $context['site_link'] = 'http://www.choies.com';
            if(empty($context['email']))
                    $context['email'] = $rcpt;
            //处理数组
            foreach($context as $k=>$v){
                $mail_content[]=array('name'=>$k,'value'=>$v);
            }
            //WP-ORDER_UNPAID Mail
            ini_set('soap.wsdl_cache_enabled','0');
            $client = new SoapClient(Kohana::config('webpower.'.$mail_lang.'.admin.url'),array('encoding'=>'utf-8'));
            $login = array('username' => Kohana::config('webpower.'.$mail_lang.'.admin.username'), 'password' => Kohana::config('webpower.'.$mail_lang.'.admin.password') );
            try {
                $result = $client->addRecipientsSendMailing(   
                    $login,
                    Kohana::config('webpower.'.$mail_lang.'.admin.campagin'),              //campagin
                    Kohana::config('webpower.'.$mail_lang.'.mail.'.$type),             //mailing
                    array(Kohana::config('webpower.'.$mail_lang.'.group.'.$type)), // GroupID       
                    array(
                        array(
                            'fields' => $mail_content
                        ),
                    ),
                    true,
                    true
                );
                    if($result->status == "OK"){
                        Kohana_log::instance()->add('WP-'.$type, $rcpt . ': OK');
                    }elseif($result->status == "DUPLICATE"){
                        Kohana_log::instance()->add('WP-'.$type, $rcpt . ': '.$result->statusMsg);   
                    }else{
                        // Kohana_log::instance()->add('WP-'.$type, $rcpt . ': '.$result->ERROR);
                    }
                }catch (SoapFault $exception) {   
                    Kohana_log::instance()->add('WP-ERROR', $exception);
                }
        }else{
        if(!$isSMTP)
        {
	    	$mail = DB::select()
	            ->from('core_mails')
	            ->where('site_id', '=', Site::instance()->get('id'))
	            ->where('type', '=', $type)
	            ->where('is_active', '=', 1)
	            ->execute()
	            ->current();
        }
        else 
        {
            $site_id = 1;
        	$mail = DB::select()
	            ->from('core_mails')
                ->where('site_id', '=', $site_id)
	            ->where('type', '=', $type)
	            ->where('is_active', '=', 1)
                ->where('lang', '=', $lang)
	            ->execute()
	            ->current();
        }
        if (!$mail)
            return FALSE;

        if (!$from)
            $from = Site::instance()->get('email');

        $context += array(
			'site_link' => "<a href='http://".Site::instance()->get('domain')."'>".Site::instance()->get('domain')."</a>",
            'site' => Site::instance()->get('domain'),
            'server_email' => Site::instance()->get('email'),
            'server_email_link' => "<a href='mailto:".Site::instance()->get('email')."'>".Site::instance()->get('email')."</a>",
			'contact_us' => "<a href='http://".Site::instance()->get('domain')."/contact-us'>Contact Us</a>",
        );

        $title = self::CompileTemplate($mail['title'], $context);
        $title = "=?UTF-8?B?".base64_encode($title)."?=";
        $body = self::CompileTemplate($mail['template'], $context);
        if ($output) 
            return $body;
        if(!$isSMTP)
        	return self::Send($rcpt, $from, $title, $body,$is_bcc);
        else 
        	return self::SendSMTP($rcpt, $from, $title, $body,$is_bcc);
        }
    }

    public static function Send($rcpt, $from, $subject, $body,$is_bcc=null)
    {
        $mailer = new PHPMailer;
        $mailer->IsSendmail();
        $mailer->IsHTML();
        $mailer->CharSet = 'utf-8';
        try {
            $mailer->SetFrom($from);
            $mailer->FromName = 'Choies';
            foreach ((array)$rcpt as $r)
                $mailer->AddAddress($r);
            $mailer->Subject = $subject;
            $mailer->Body = $body;
            $mailer->Send();
        } catch (Exception $e) {
            return FALSE;
        }

        return TRUE;
    }
    
    public static function SendSMTP($rcpt, $from, $subject, $body,$is_bcc=null)
    {
        $mailer = new PHPMailer;
        $mailer->IsSMTP();
        $mailer->IsHTML();
        //$mailer->Host = "smtp.qq.com";
        $mailer->Host = "smtpcom.263xmail.com";

        $mailer->SMTPAuth   = true;                  // enable SMTP authentication
		//$mailer->SMTPSecure = "ssl";
        $mailer->Port= 25;
        $mailer->CharSet = "UTF-8";
        $mailer->Encoding = "base64";
        if(isset($is_bcc)){
              $mailer->AddBCC($is_bcc);
        }
        //$mailer->Username   = $from;  // GMAIL username
        //$mailer->Password   = "support4u";            // GMAIL password
        
        $mailer->Username   = "ticket@cofreeonline.com";  //  username
        $mailer->Password   = "ticket!";      // password
        
        //backup
        //$mailer->Username   = "ticketbackup@cofreeonline.com";  //  username
        //$mailer->Password   = "ticketbackup!";      // password
        try {
            $mailer->SetFrom($from, 'Choies');
            $mailer->AddReplyTo($from, 'Choies');
            foreach ((array)$rcpt as $r)
                $mailer->AddAddress($r);
            $mailer->Subject = $subject;
            $mailer->Body = $body;
        	$mailer->Send();
        } catch (Exception $e) {
            return FALSE;
        }
        return TRUE;
    }

    protected static function CompileTemplate($template, $context)
    {
        $keys = array();
        foreach (array_keys($context) as $key)
            $keys[] = '{'.$key.'}';

        return str_replace($keys, array_values($context), $template);
    }
}
