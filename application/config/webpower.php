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
                'NEWREGISTER' => 112,//before 100
                'REGISTER' => 112,//before 95
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
                'BIRTHDAY'=>98,//before 98
                'PARTIALSHIPPING'=>116,
				'NEWVIP'=>120,
                'ENDVIP'=>121
            ),
            'mail' => array(
                'NEWREGISTER' => 259,
                'REGISTER' => 259,//before 47
                'NEWSLETTER' => 269,//before 48
                'COMPLETE_PROFILE' => 165,//before 49
                'Order Confirmed' => 214,//before 50
                'PENDING PAYMENT' => 51,//before 51
                'GC PENDING' => 213,//before 52
                'PAYSUCCESS' => 210,//before 55
                'UNPAID_MAIL' => 212,//before 53
                'FOGETPASSWORD' => 209,//before 56
                'SHIPPING' => 211,//before 54
                'PICK UP' => 205,//before 99
                '15 OFF CODE REMINDING' => 207,//before 58
                'BLOGGER PAYSUCCESS' => 206,//before 59
                'CONFIRM_MAIL' => 208,//before 57
                'FAILED_MAIL'=>204,//before 100
                'DELAYED_MAIL'=>203,//before 101
                'NEWSPAPER'=>201,//before 121
                'BIRTHDAY'=>126,//before 126
                'PARTIALSHIPPING'=>202,
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
                'NEWREGISTER' => 112,//before 100
                'REGISTER' => 112,//before 95
                'NEWSLETTER' => 118,//before 94
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
                'NEWSPAPER'=>116,//before 97
                'BIRTHDAY'=>98, //before 126
				'NEWVIP'=>121,
                'ENDVIP'=>120
            ),
            'mail' => array(
                'NEWREGISTER' => 263,//before 181
                'REGISTER' => 263,//before 86
                'NEWSLETTER' => 271,//before 87
                'COMPLETE_PROFILE' => 167,//before 88
                'Order Confirmed' => 242,//before 89
                'PENDING PAYMENT' => 90,//before 90
                'GC PENDING' => 241,//before 91
                'PAYSUCCESS' => 238,//before 94
                'UNPAID_MAIL' => 240,//before 92
                'FOGETPASSWORD' => 237,//before 95
                'SHIPPING' => 239,//before 93
                'PICK UP' => 233,//before 105
                '15 OFF CODE REMINDING' => 235,//before 97
                'BLOGGER PAYSUCCESS' => 234,//before 98
                'CONFIRM_MAIL' => 236,//before 96
                'FAILED_MAIL'=>232,//before 106
                'DELAYED_MAIL'=>231,//before 107
                'NEWSPAPER'=>230,//before 119
                'BIRTHDAY'=>124,//before 126
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
                'NEWREGISTER' => 112,//before 100
                'REGISTER' => 112,//before 95
                'NEWSLETTER' => 118,//before 94
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
                'BLOGGER PAYSUCCESS' => 87,//before 87
                'CONFIRM_MAIL' =>109,//before 85
                'FAILED_MAIL'=>113,//before 82
                'DELAYED_MAIL'=>114,//before 81
                'NEWSPAPER'=>116,//before 97
                'BIRTHDAY'=>126//before 126
            ),
            'mail' => array(
                'NEWREGISTER' => 265,//before 182
                'REGISTER' => 265,//before 73
                'NEWSLETTER' => 272,//before 74
                'COMPLETE_PROFILE' => 168,//before 75
                'Order Confirmed' => 256,//before 76
                'PENDING PAYMENT' => 77,//before 77
                'GC PENDING' => 255,//before 78
                'PAYSUCCESS' => 252,//before 81
                'UNPAID_MAIL' => 254,//before 79
                'FOGETPASSWORD' => 251,//before 82
                'SHIPPING' => 253,//before 80
                'PICK UP' => 248,//before 108
                '15 OFF CODE REMINDING' => 249,//before 84
                'BLOGGER PAYSUCCESS' => 85,//before 85
                'CONFIRM_MAIL' => 250,//before 83
                'FAILED_MAIL'=>247,//before 109
                'DELAYED_MAIL'=>246,//before 110
                'NEWSPAPER'=>244,//before 120
                'BIRTHDAY'=>126//before 126
            )
        ),
        
);

