<?php defined('SYSPATH') OR die('No direct access allowed.');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
return array
    (
    'en' => array
            (
                '1' =>array
                    (
                    'id'=>1,
                    'name'=>'new custom register',
                    'flag'=>'REGISTER',
                    'title'=>'Thank you for registering on {site}!',
                    'content'=>'<p>Dear {firstname} ,<br /><br />Welcome to {site}!<br /><br />We are glad you are here and hope you enjoy shopping on {site}.</p><p><strong>Your account information is as follows:<br /></strong><br />User Email is&nbsp; {email},<br /><br />User Password is&nbsp;&nbsp; {password}.<br /><br />Please keep them carefully!<br /><br />To ensure that you continue to receive e-mails from {site} in your inbox, you can add the sender of this e-mail to your address book or white list.<br /><br /><span>What we offer is excellent service and high-quality product.</span><br /><br /><span>If you have any further problems, please feel free to contact us by <em><span style=\"text-decoration: underline;\">online-support</span></em> or email to </span>{server_email}.<br /><br /><br />Yours sincerely,<br /><br />{site_link} Customer Service.</p>',
                    'add_time'=>1258944324,
                    'is_default'=>1,
                    'active'=>1,
                    ),
                '2' =>array
                    (
                    'id'=>2,
                    'name'=>'find password',
                    'flag'=>'FOGETPASSWORD',
                    'title'=>'Your password has been reset successfully!',
                    'content'=>'<p>Dear {firstname},</p><p>Thanks for shopping on our website {site}. Your password has been reset successfully.<br /><br />Your User Email is {email} ,<br /><br />Your User Password is {new_password} .<br /><br />You can change the password later in the user center after logging onto your account.</p><p>If you have any further problems, please feel free to contact us by <em><span style=\"text-decoration: underline;\">online-support</span></em> or email to {server_email}.<br /><br />Yours sincerely,<br /><br />{site_link} Customer Service</p>',
                    'add_time'=>1258944926,
                    'is_default'=>1,
                    'active'=>1,
                    ),
                '3' =>array
                    (
                    'id'=>3,
                    'name'=>'unpay remind',
                    'flag'=>'NOTPAY',
                    'title'=>'Please pay your order on {site}!',
                    'content'=>'<p>Dear {firstname},<br /><br />Thank you for choosing {site_link}. We noticed that you left without completing the purchase, so we&nbsp;send this letter to check</p><p>whether you\'re unsatisfied with our products, service or website.</p><p>If you still interest in our products you can choose to finish the payment by following this link</p><p>{order_view_link}</p><p>It is absolutely safe to purchase on {site}, as we use advanced security technology such as McAfee and Trustwave to protect</p><p>our customers from identity theft, credit card fraud.</p><p>If you have any further problem, please don\'t hesitate to contact us by <em><span style=\"text-decoration: underline;\">online-support</span></em> or email to {server_email_link}.</p><p>Yours sincerely,</p><p>{site_link} Customer Service.</p>',
                    'add_time'=>1258944970,
                    'is_default'=>1,
                    'active'=>1,
                    ),
                '4' =>array
                    (
                    'id'=>4,
                    'name'=>'order pay success',
                    'flag'=>'PAYSUCCESS',
                    'title'=>'Your payment has gone through!',
                    'content'=>'<p>Dear {firstname},</p><p>Thank you for placing an order on {site_link}. We appreciate your trust in us and we will work hard to</p><p>make sure we meet or exceed all of your expectations. We will be processing your order when you read this email.</p><p><strong>Your order details:</strong></p><p>Order number: {order_num}{order_product}<br />Total: {currency}{amount}<br />Your credit card statement will show a charge of {currency}{amount} by {payname}</p><p><strong>Your Shipping Information:</strong></p><p>First Name: {shipping_firstname}<br />Last Name: {shipping_lastname}<br />Address: {address}<br />City: {city}<br />State/Province: {state}<br />Country: {country}<br />Zip/Postal code:{zip}<br />Phone: {phone}</p><p><strong>Link to check order status:</strong></p><p>{order_view_link}</p><p>If there is any doubts, please do contact us immediately so that we could correct it quickly before dispatching the order.</p><p>After your order is dispatched, you will get a confirmation email with the tracking number and tracking link of your order.</p><p>If you do not receive any confirmation email in 5 days, please contact us immediately.</p><p>If you have any further problems, please feel free to contact us by <em><span style=\"text-decoration: underline;\">online-support</span></em> or email to {server_email_link}</p><p>Yours sincerely,</p><p>{site} Customer Service</p>',
                    'add_time'=>1258944991,
                    'is_default'=>1,
                    'active'=>1
                    ),
                '6' =>array
                    (
                    'id'=>6,
                    'name'=>'newsletter confirm',
                    'flag'=>'NEWSLETTER',
                    'title'=>'Welcome to {site}!',
                    'content'=>'<p>Welcome to {site_link} !</p><p>Valued Subscriber,</p><p>Thanks for signing up for the {site} Newsletter,&nbsp;from which&nbsp;you will find the latest style, great discount, gift idea and more. <br />&nbsp;<br />Here is a <strong>5% discount code: {discount_num}(Expiration date: {expiration_date})</strong>,</p><p>which will save you 5% of the price for the products.</p><p>To make sure you can receive our mails to your inbox but not spam box, please add us to your mailing list.</p><p>If you have any questions, please feel free to contact us through {server_email_link}.</p><p>Yours sincerely,</p><p>{site} Customer Service</p>',
                    'add_time'=>1259042481,
                    'is_default'=>1,
                    'active'=>1,
                    ),
                '7' =>array
                    (
                    'id'=>7,
                    'name'=>'tell a friend confirm',
                    'flag'=>'TELLAFRIEND',
                    'title'=>'Your friend {your_name} would like you to visit {site}',
                    'content'=>'<p>Dear&nbsp;{firend_name},</p><p>Your friend {your_name} found a great site called {site_link} and thought you\'d like to check it out!</p><p>{tellfriendmessage}</p><p>Check out from this link:{referer}</p><p>Yours sincerely,</p><p>{site_link} Customer Service</p>',
                    'add_time'=>1259042498,
                    'is_default'=>1,
                    'active'=>1,
                    ),
                '8' =>array
                    (
                    'id'=>8,
                    'name'=>'refund',
                    'flag'=>'REFUND',
                    'title'=>'We have processed a refund back to your account.',
                    'content'=>'<p>Dear {firstname},</p><p>For some reasons, we have issued the refund for the items you ordered.</p><p>Due to the delay of payment gateway, usually you can get the refund in one week.</p><p>Following is the details about refund:</p><p>Your Order No. <strong>{order_num}</strong></p><p>Refund Amount: <strong>{currency} {amount}</strong></p><p><p>Your credit card statement will show a refund of {currency}{amount} by <strong>{payname}.</strong></p></p><p>If you have any further problems, please feel free to contact us by <em><span style=\"text-decoration: underline;\">online-support</span></em> or email to {server_email_link}.</p><p>Yours sincerely,</p><p>{site} Customer Service.</p>',
                    'add_time'=>1259042535,
                    'is_default'=>1,
                    'active'=>1,
                    ),
                '9' =>array
                    (
                    'id'=>9,
                    'name'=>'shipping notice',
                    'flag'=>'SHIPPING',
                    'title'=>'Your order has been dispatched!',
                    'content'=>'<p>Dear {firstname},<br /><br />Thanks for placing an order on our website. Your order (Order No.<strong>{order_num}</strong>)has been dispatched.</p><p>The tracking No. is <strong>{ems_num}</strong>, which will be valid in <strong>48 hours</strong>.</p><p>The tracking link is <strong>{ems_url},&nbsp;</strong>from which&nbsp;you can track your order with the tracking number.</p><p>Notice:</p><p>1,Usually your ordered product will arrive to your appointed location within <strong>7 working days</strong>. If you did not receive your order</p><p>&nbsp;&nbsp; in 9 working days, please contact the carrier and us to ensure the smoothness of the delivery.</p><p>2,The tracking number will be valid in 48 hours. Please check the status of the order online often. Usually the order will be</p><p>&nbsp;&nbsp; delivered in one week. If you can not receive it in 9 days, please contact with the carrier and us to ensure the fully delivery.</p><p>3,After receiving your parcel, please <strong>confirm your receipt</strong> of the shipment in the user center on our website.</p><p>&nbsp; Then you\'ll receive a <strong>discount code</strong> from us by email for your next online purchase.</p><p>4,If you have such problems as in the following list, please contact us as soon as possible, and we will be glad to help you</p><p>&nbsp;&nbsp; at any time:</p><ul><li>Duplicate payments</li><li>Tracking number is invalid in more than 48 hours</li><li>No items received on time/Items lost during the shipping</li><li>Faulty items received</li></ul><p style=\"text-align: left;\">&nbsp;</p><p style=\"text-align: left;\">If you have any further problems, please feel free to contact us by <em><span style=\"text-decoration: underline;\">online-support</span></em> or email to {server_email_link}</p><p style=\"text-align: left;\">Your sincerely,</p><p style=\"text-align: left;\">{site_link} Customer Service</p>',
                    'add_time'=>1259042549,
                    'is_default'=>1,
                    'active'=>1,
                    ),
                '10' =>array
                    (
                    'id'=>10,
                    'name'=>'shipping delay',
                    'flag'=>'TIMELAG',
                    'title'=>'We will dispatch your order ASAP.',
                    'content'=>'<p>Dear {firstname},</p><p>Thanks for placing an order (Order No.<strong>{order_num}</strong>)on our website <strong>{site}</strong>.</p><p>We are sorry to tell you that a few more days will be needed to&nbsp;dispatch your order because our processing system</p><p>is having a heavy load recently. Sorry for all the inconvenience.</p><p>We will try our best to expedite the shipping and provide you with the tracking information as soon as possible.</p><p>If there is no information updated in <strong>next 3 days</strong> or you have other questions, please feel free to contact us at any time.</p><p>If you have any further problems, please feel free to contact us by <em><span style=\"text-decoration: underline;\">online-support</span></em> or email to {server_email_link}.</p><p>Yours sincerely,</p><p>{site} Customer Service</p>',
                    'add_time'=>1259042580,
                    'is_default'=>1,
                    'active'=>1,
                    ),
               '11' =>array
                    (
                    'id'=>11,
                    'name'=>'order delivered',
                    'flag'=>'DELIVERED',
                    'title'=>'5% off Coupon Code for Your Next Purchase',
                    'content'=>'<p>Dear {firstname},</p><p>Thanks for your confirmation of receipt on wensite<strong> {site}</strong>.</p><p>We are glad to know you got your items smoothly (<strong>Ref# {order_num}</strong>). We appreciate your cooperation</p><p>and we\'d like to offer you a <strong>5% off Coupon code</strong> for your next purchase on our website.</p><p>Coupon code: <strong>{discount_num}</strong></p><p>Expiration date: <strong>{date}</strong></p><p>Your credit card statement will show a charge of <strong>{amount}</strong> by <strong>{payname}</strong>.</p><p>If you have any further questions, please feel free to contact us by <em><span style=\"text-decoration: underline;\">online-support</span></em> or email to {server_email_link}.</p><p>Yours sincerely,</p><p>{site} Customer Service</p>',
                    'add_time'=>1259042612,
                    'is_default'=>1,
                    'active'=>1,
                    ),
                '12' =>array(
                    'id'=>12,
                    'name'=>'Contact us',
                    'flag'=>'CONTACTUS',
                    'title'=>'Contact us',
                    'content'=>'<p>{content}</p>',
                    'add_time'=>1260511884,
                    'is_default'=>1,
                    'active'=>1,
                    ),
                '13' =>array(
                    'id'=>13,
                    'name'=>'Costomer Service',
                    'flag'=>'SERVICE',
                    'title'=>'Costomer Service',
                    'content'=>'<p>{content}</p>',
                    'add_time'=>1260511884,
                    'is_default'=>1,
                    'active'=>1,
                    ),
            ),
    );

?>
