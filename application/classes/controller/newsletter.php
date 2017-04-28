<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Newsletter extends Controller_Webpage
{

        public function action_view()
        {
                $country = Site::instance()->countries(LANGUAGE);

                $this->request->response = View::factory('/newsletter')
                    ->set('country', $country)
                    ->render();
        }

        public function action_add()
        {
                if($_POST)
                {
                        $data = array( );
                        $data['site_id'] = Site::instance()->get('id');
                        $data['created'] = time();
                        $data['email'] = Arr::get($_POST, 'email', '');
                        $data['firstname'] = Arr::get($_POST, 'firstname', '');
                        $data['lastname'] = Arr::get($_POST, 'lastname', '');
                        $data['gender'] = Arr::get($_POST, 'gender', '');
                        $data['zip'] = Arr::get($_POST, 'zip', '');
                        $data['occupation'] = Arr::get($_POST, 'occupation', '');
                        $data['birthday'] = strtotime(Arr::get($_POST, 'birthday', ''));

                        if( ! Newsletter::instance()->is_email($data['email']))
                        {
                                $flag = Newsletter::instance()->set($data);
                                if($flag)
                                {
                                        message::set(__('newsletter_edit_success'), 'notice');

                                        $mail_params = array( 'discount_num' => '', 'expiration_date' => '' );
                                        $mail_params['firstname'] = $data['firstname'] ? $data['firstname'] : 'customer';
                                        Mail::SendTemplateMail('NEWSLETTER', $data['email'], $mail_params);

                                        Request::instance()->redirect('newsletter/message');
                                }
                                else
                                {
                                        message::set(__('newsletter_edit_fail'), 'error');
                                }
                        }
                        else
                        {
                                message::set(__('newsletter_email_exits'), 'error');
                        }
                }
                $countries = Site::instance()->countries(LANGUAGE);
                $this->template->content = View::factory('/newsletter/newsletter')
                    ->set('countries', $countries);
        }

        public function action_single_add()
        {
                if($_POST)
                {
                        $data = array( );
                        $data['email'] = Arr::get($_POST, 'email', '');
                        $email = $data['email'];

                        if( ! Newsletter::instance()->is_email($email))
                        {
                                $flag = Newsletter::instance()->set($data);
                                if($flag)
                                {
                                        message::set(__('newsletter_edit_success'), 'notice');

                                        $mail_params = array( 'discount_num' => '', 'expiration_date' => '' );
                                        $mail_params['firstname'] = 'customer';
                                        Mail::SendTemplateMail('NEWSLETTER', $email, $mail_params);

                                        Request::instance()->redirect('newsletter/message');
                                }
                                else
                                {
                                        message::set(__('newsletter_edit_fail'), 'error');
                                }
                        }
                        else
                        {
                                message::set(__('newsletter_email_exits'), 'error');
                        }

                        $this->request->response = View::factory('/newsletter_fail')->render();
                }
        }
        
        public function action_ajax_add()
        {
                if($_POST)
                {
                        $data = array( );
                        $data['email'] = Arr::get($_POST, 'email', '');
                        $email = $data['email'];
                        $result = array();

                        if(preg_match("/([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[.][a-z]{2,3}([.][a-z]{2})?/i",$email))
                        {
                                if(Newsletter::instance()->is_email($data['email']))
                                {
                                        $result['success'] = 0;
                                        $result['message'] = 'Sorry, email has been used.';
                                }
                                else
                                {
                                        $flag = Newsletter::instance()->set($data);
                                        if ($flag)
                                        {
                                                $mail_params = array( 'discount_num' => '', 'expiration_date' => '' );
                                                Mail::SendTemplateMail('NEWSLETTER', $email, $mail_params);
                                                $result['success'] = 1;
                                                $result['message'] = 'You are in Now. Thanks!';
                                        }
                                        else
                                        {
                                                $result['success'] = 0;
                                                $result['message'] = 'Sorry, email has been used.';
                                        }
                                }
                        }
                        else
                        {
                                $result['success'] = 0;
                                $result['message'] = 'Please enter a valid email address.';
                        }

                        echo json_encode($result);
                        exit;
                }
        }

        public function action_message()
        {
                $this->template->content = View::factory('/newsletter/success');
        }

}

