1.������޸ĵ��ļ���application/classes/gdthumb.php[image.php,phpthumb.php,thumbbase.php,thumblib.php,watermark.php��curl.php]
                    application/thumb_pluginsĿ¼��������ļ�
                    controller/image.php
                    sprite:ip���˹���[���Կ���]
                    �޸���bootstrp.php����ֹ��ͷ���
2.����Ŀ¼/media/images-serviceдȨ��


����������ͼƬ��ַ���������ԣ����ɱ��ص�ԭͼ������ͼ�����һ���һ��Сʱ��
[���ɵ�ͼƬ��/media/images-service/��վhttp_host/ͼƬ��Ӧdir/,good_0Ϊԭͼ��good_1Ϊ����ˮӡ��good_2ΪͼƬˮӡ��good_100_100.jpgΪresize���ͼƬ]
1.����ͼ�����񻯣���
����ͼƬ��ַ��http://www.ghdsale.com.au/product_images/GHD0013/0/good.jpg
����url(<img src='...' />):http://cola.local/image/resize/100/100/aHR0cDovL3d3dy5naGRzYWxlLmNvbS5hdS9wcm9kdWN0X2ltYWdlcy9HSEQwMDEzLzAvZ29vZC5qcGc=(�����Ϊbase64_encode����֮���ͼƬurl)

ע��
a.�����񻯶���ɨ�辫��[application/classes/gdthumb.php,L673,L675-676]
b.��sprite.local����������ip�������������ip����cola/controller/image.php�е�define("FILTER_IP",true);��Ϊfalse����




����������ͼƬ��ַ���������ˮӡ�����ɼ������ֻ���ͼƬ��ˮӡͼ�����һ���һ��Сʱ��
2.ˮӡ
����ͼƬ��ַ��http://www.ghdhairsales.uk.com/product_images/GHD0010/0/good.jpg
����ˮӡ��http://cola.local/image/watermark/aHR0cDovL3d3dy5naGRoYWlyc2FsZXMudWsuY29tL3Byb2R1Y3RfaW1hZ2VzL0dIRDAwMTAvMC9nb29kLmpwZw==/aGVsbG8gd29ybGQ=/1
ͼƬˮӡ��http://cola.local/image/watermark/aHR0cDovL3d3dy5naGRoYWlyc2FsZXMudWsuY29tL3Byb2R1Y3RfaW1hZ2VzL0dIRDAwMTAvMC9nb29kLmpwZw==/MS5wbmc=/2

ע��
a.watermark֮��ĵ�һ������Ϊbase64_encode֮���ͼƬ��ַ���ڶ�������Ϊbase64_encode����֮���ˮӡ�ַ���(�����ͼƬˮӡ����ΪlogoͼƬ�����ƣ���1.jpg��logoͼƬҪ����ftp�ϴ���/media/images-service/logo/��)
b.�ɵ���ˮӡ��λ�ã�[application/classes/watermark.php,L122,0-8]
c.�ɵ���ˮӡ͸���ȣ�[application/classes/watermark.php,L32]
d.�ɵ���ˮӡ���壺[application/classes/controller/image.php,L10],�����ļ�����[/media/fonts/��]




���ݱ�images[cola��sprite����]





