<?php
defined('SYSPATH') OR die('No direct access allowed.');
/**
 * config every sites(use site_id as key)
 *
 * @package
 * @author    FangHao
 * @copyright    © 2010 Cofree Development Group
 */
return array(
        'en'=>array(
            'active'=> array('action'=> 1),
            'admin' => array(
                'username' => 'admin',
                'password' => 'Lovechoies@2015',
                'url' => 'http://choies-service.dmdelivery.com/x/soap-v4.2/wsdl.php',
                'campagin' => 1
            ),
            'group' => array(
                'NEWREGISTER' => 103,
                'REGISTER' => 81,
                'NEWSLETTER' => 122,//before 83
                'COMPLETE_PROFILE' => 119,//before 84
                'Order Confirmed' => 117,//before 85
                'PENDING PAYMENT' => 86,//before 86 订单pending组
                'GC PENDING' => 116,//before 87
                'PAYSUCCESS' => 113,//before 90
                'UNPAID_MAIL' => 115,//before 88
                'FOGETPASSWORD' => 112,//before 91
                'SHIPPING' => 114,//before 89
                'PICK UP' => 109,//before 94
                '15 OFF CODE REMINDING' => 110,//before 93
                'BLOGGER PAYSUCCESS' => 108,//before 90
                'CONFIRM_MAIL' =>111,//before 92
                'FAILED_MAIL'=>107,//before 95
                'NEWSPAPER'=>104,//before 99
                'BIRTHDAY'=>118,
                'PARTIALSHIPPING'=>137,
                'NEWVIP'=>148,
                'ENDVIP'=>149,
                'FAILED_MAIL_HONOOUR'=>151,
                'FAILED_MAIL_FUNDS'=>150
            ),
            'mail' => array(
                'NEWREGISTER' => 257,
                'REGISTER' => 257,//before 27
                'NEWSLETTER' => 268,//before 15
                'COMPLETE_PROFILE' => 164,//before 16
                'Order Confirmed' => 183,//before 17
                'PENDING PAYMENT' => 18,//before 18
                'GC PENDING' => 184,//before 19
                'PAYSUCCESS' => 187,//before 22
                'UNPAID_MAIL' => 185,//before 20
                'FOGETPASSWORD' => 188,//before 23
                'SHIPPING' => 186,//before 21
                'PICK UP' => 191,//before 26
                '15 OFF CODE REMINDING' => 190,//before 25
                'BLOGGER PAYSUCCESS' => 192,//before 28
                'CONFIRM_MAIL' => 189,//before 24
                'FAILED_MAIL'=>193,//before 29
                'NEWSPAPER'=>117,//before 196
                'BIRTHDAY'=>170,
                'PARTIALSHIPPING'=>195,
                'NEWVIP'=>299,
                'ENDVIP'=>300,
                'FAILED_MAIL_HONOOUR'=>311,
                'FAILED_MAIL_FUNDS'=>312
            )
        ),
        'de'=>array(
            'active'=> array('action'=> 1),
            'admin' => array(
                'username' => 'admin',
                'password' => 'Lovechoies@2015',
                'url' => 'http://choies-service.dmdelivery.com/x/soap-v4.2/wsdl.php',
                'campagin' => 2
            ),
            'group' => array(
                'REGISTER' => 95,
                'NEWSLETTER' => 94,
                'COMPLETE_PROFILE' => 93,
                'Order Confirmed' => 92,
                'PENDING PAYMENT' => 91,
                'GC PENDING' => 90,
                'PAYSUCCESS' => 87,
                'UNPAID_MAIL' => 89,
                'FOGETPASSWORD' => 86,
                'SHIPPING' => 88,
                'PICK UP' => 83,
                '15 OFF CODE REMINDING' => 84,
                'BLOGGER PAYSUCCESS' => 87,
                'CONFIRM_MAIL' =>85,
                'FAILED_MAIL'=>82,
                'DELAYED_MAIL'=>81,
                'NEWSPAPER'=>97,
                'BIRTHDAY'=>98,
                'NEWVIP'=>120,
                'ENDVIP'=>121
            ),
            'mail' => array(
                'REGISTER' => 47,
                'NEWSLETTER' => 48,
                'COMPLETE_PROFILE' => 49,
                'Order Confirmed' => 50,
                'PENDING PAYMENT' => 51,
                'GC PENDING' => 52,
                'PAYSUCCESS' => 55,
                'UNPAID_MAIL' => 53,
                'FOGETPASSWORD' => 56,
                'SHIPPING' => 54,
                'PICK UP' => 99,
                '15 OFF CODE REMINDING' => 58,
                'BLOGGER PAYSUCCESS' => 59,
                'CONFIRM_MAIL' => 57,
                'FAILED_MAIL'=>100,
                'DELAYED_MAIL'=>101,
                'NEWSPAPER'=>121,
                'BIRTHDAY'=>126,
				'NEWVIP'=>306,
                'ENDVIP'=>305
            )
        ),
        'es'=>array(
            'active'=> array('action'=> 1),
            'admin' => array(
                'username' => 'admin',
                'password' => 'Lovechoies@2015',
                'url' => 'http://choies-service.dmdelivery.com/x/soap-v4.2/wsdl.php',
                'campagin' => 3
            ),
            'group' => array(
                'NEWREGISTER' => 118,//before 100
                'REGISTER' => 118,//before 95
                'NEWSLETTER' => 119,//before 94
                'COMPLETE_PROFILE' => 102,//before 93
                'Order Confirmed' => 103,//before 92
                'PENDING PAYMENT' => 91,//before 91
                'GC PENDING' => 104,//before 90
                'PAYSUCCESS' => 107,//before 87
                'UNPAID_MAIL' => 105,//before 89
                'FOGETPASSWORD' => 108,//before 86
                'SHIPPING' => 106,//before 88
                'PICK UP' => 111,//before 83
                '15 OFF CODE REMINDING' => 110,//before 84
                'BLOGGER PAYSUCCESS' => 113,//before 87
                'CONFIRM_MAIL' =>109,//before 85
                'FAILED_MAIL'=>114,//before 82
                'DELAYED_MAIL'=>115,//before 81
                'NEWSPAPER'=>117,//before 97
                'BIRTHDAY'=>126,//before 126
                'PARTIALSHIPPING'=>116,
                'NEWVIP'=>120,
                'ENDVIP'=>121,
                'FAILED_MAIL_HONOOUR'=>123,
                'FAILED_MAIL_FUNDS'=>122
            ),
            'mail' => array(
                'NEWREGISTER' => 261,//before 180
                'REGISTER' => 261,//before 60
                'NEWSLETTER' => 270,//before 61
                'COMPLETE_PROFILE' => 166,//before 62
                'Order Confirmed' => 228,//before 63
                'PENDING PAYMENT' => 64,//before 64
                'GC PENDING' => 227,//before 65
                'PAYSUCCESS' => 224,//before 68
                'UNPAID_MAIL' => 226,//before 66
                'FOGETPASSWORD' => 223,//before 69
                'SHIPPING' => 225,//before 67
                'PICK UP' => 219,//before 102
                '15 OFF CODE REMINDING' => 221,//before 71
                'BLOGGER PAYSUCCESS' => 220,//before 72
                'CONFIRM_MAIL' => 222,//before 70
                'FAILED_MAIL'=>218,//before 103
                'DELAYED_MAIL'=>217,//before 104
                'NEWSPAPER'=>215,//before 122
                'BIRTHDAY'=>125,//before 125
                'PARTIALSHIPPING'=>216,
                'NEWVIP'=>301,
                'ENDVIP'=>302,
                'FAILED_MAIL_HONOOUR'=>316,
                'FAILED_MAIL_FUNDS'=>315
            )
        ),
        'fr'=>array(
            'active'=> array('action'=> 1),
            'admin' => array(
                'username' => 'admin',
                'password' => 'Lovechoies@2015',
                'url' => 'http://choies-service.dmdelivery.com/x/soap-v4.2/wsdl.php',
                'campagin' => 4
            ),
            'group' => array(
                'REGISTER' => 95,
                'NEWSLETTER' => 94,
                'COMPLETE_PROFILE' => 93,
                'Order Confirmed' => 92,
                'PENDING PAYMENT' => 91,
                'GC PENDING' => 90,
                'PAYSUCCESS' => 87,
                'UNPAID_MAIL' => 89,
                'FOGETPASSWORD' => 86,
                'SHIPPING' => 88,
                'PICK UP' => 83,
                '15 OFF CODE REMINDING' => 84,
                'BLOGGER PAYSUCCESS' => 87,
                'CONFIRM_MAIL' =>85,
                'FAILED_MAIL'=>82,
                'DELAYED_MAIL'=>81,
                'NEWSPAPER'=>97,
                'BIRTHDAY'=>98,
				'NEWVIP'=>121,
                'ENDVIP'=>120
            ),
            'mail' => array(
                'REGISTER' => 86,
                'NEWSLETTER' => 87,
                'COMPLETE_PROFILE' => 88,
                'Order Confirmed' => 89,
                'PENDING PAYMENT' => 90,
                'GC PENDING' => 91,
                'PAYSUCCESS' => 94,
                'UNPAID_MAIL' => 92,
                'FOGETPASSWORD' => 95,
                'SHIPPING' => 93,
                'PICK UP' => 105,
                '15 OFF CODE REMINDING' => 97,
                'BLOGGER PAYSUCCESS' => 98,
                'CONFIRM_MAIL' => 96,
                'FAILED_MAIL'=>106,
                'DELAYED_MAIL'=>107,
                'NEWSPAPER'=>119,
                'BIRTHDAY'=>124,
				'NEWVIP'=>303,
                'ENDVIP'=>304
            )
        ),
        'ru'=>array(
            'active'=> array('action'=> 1),
            'admin' => array(
                'username' => 'admin',
                'password' => 'Lovechoies@2015',
                'url' => 'http://choies-service.dmdelivery.com/x/soap-v4.2/wsdl.php',
                'campagin' => 5
            ),
            'group' => array(
                'REGISTER' => 95,
                'NEWSLETTER' => 94,
                'COMPLETE_PROFILE' => 93,
                'Order Confirmed' => 92,
                'PENDING PAYMENT' => 91,
                'GC PENDING' => 90,
                'PAYSUCCESS' => 87,
                'UNPAID_MAIL' => 89,
                'FOGETPASSWORD' => 86,
                'SHIPPING' => 88,
                'PICK UP' => 83,
                '15 OFF CODE REMINDING' => 84,
                'BLOGGER PAYSUCCESS' => 87,
                'CONFIRM_MAIL' =>85,
                'FAILED_MAIL'=>82,
                'DELAYED_MAIL'=>81,
                'NEWSPAPER'=>97,
                'BIRTHDAY'=>98
            ),
            'mail' => array(
                'REGISTER' => 73,
                'NEWSLETTER' => 74,
                'COMPLETE_PROFILE' => 75,
                'Order Confirmed' => 76,
                'PENDING PAYMENT' => 77,
                'GC PENDING' => 78,
                'PAYSUCCESS' => 81,
                'UNPAID_MAIL' => 79,
                'FOGETPASSWORD' => 82,
                'SHIPPING' => 80,
                'PICK UP' => 108,
                '15 OFF CODE REMINDING' => 84,
                'BLOGGER PAYSUCCESS' => 85,
                'CONFIRM_MAIL' => 83,
                'FAILED_MAIL'=>109,
                'DELAYED_MAIL'=>110,
                'NEWSPAPER'=>120,
                'BIRTHDAY'=>123
            )
        ),
        
);

