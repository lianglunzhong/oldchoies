1.添加与修改的文件：application/classes/gdthumb.php[image.php,phpthumb.php,thumbbase.php,thumblib.php,watermark.php，curl.php]
                    application/thumb_plugins目录及下面的文件
                    controller/image.php
                    sprite:ip过滤功能[可以开启]
                    修改了bootstrp.php，防止有头输出
2.赋予目录/media/images-service写权限


概述：传入图片地址，进行缩略，生成本地的原图与缩略图，并且缓存一个小时。
[生成的图片在/media/images-service/网站http_host/图片对应dir/,good_0为原图，good_1为文字水印，good_2为图片水印，good_100_100.jpg为resize后的图片]
1.缩略图（带锐化）：
网上图片地址：http://www.ghdsale.com.au/product_images/GHD0013/0/good.jpg
调用url(<img src='...' />):http://cola.local/image/resize/100/100/aHR0cDovL3d3dy5naGRzYWxlLmNvbS5hdS9wcm9kdWN0X2ltYWdlcy9HSEQwMDEzLzAvZ29vZC5qcGc=(后面的为base64_encode加密之后的图片url)

注：
a.调整锐化度与扫描精度[application/classes/gdthumb.php,L673,L675-676]
b.在sprite.local中设置允许ip，如果允许所有ip，将cola/controller/image.php中的define("FILTER_IP",true);设为false即可




概述：传入图片地址，进行添加水印，生成加了文字或者图片的水印图，并且缓存一个小时。
2.水印
网上图片地址：http://www.ghdhairsales.uk.com/product_images/GHD0010/0/good.jpg
文字水印：http://cola.local/image/watermark/aHR0cDovL3d3dy5naGRoYWlyc2FsZXMudWsuY29tL3Byb2R1Y3RfaW1hZ2VzL0dIRDAwMTAvMC9nb29kLmpwZw==/aGVsbG8gd29ybGQ=/1
图片水印：http://cola.local/image/watermark/aHR0cDovL3d3dy5naGRoYWlyc2FsZXMudWsuY29tL3Byb2R1Y3RfaW1hZ2VzL0dIRDAwMTAvMC9nb29kLmpwZw==/MS5wbmc=/2

注：
a.watermark之后的第一个参数为base64_encode之后的图片地址；第二个参数为base64_encode加密之后的水印字符串(如果是图片水印，则为logo图片的名称，如1.jpg，logo图片要经过ftp上传至/media/images-service/logo/下)
b.可调整水印的位置：[application/classes/watermark.php,L122,0-8]
c.可调整水印透明度：[application/classes/watermark.php,L32]
d.可调整水印字体：[application/classes/controller/image.php,L10],字体文件放在[/media/fonts/下]




数据表images[cola、sprite共用]





