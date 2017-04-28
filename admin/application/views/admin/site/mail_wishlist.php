<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body bgcolor="#cccccc" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="font-family:Arial; color:#000; border-left:#9d9799 1px solid;border-right:#9d9799 1px solid;" >
            <tr>
                <td bgcolor="#f3f3f3">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="color:#333333;font-size:10px;">
                        <tr>
                            <td height="26" align="left" style="padding:4px 25px;">See What's In Your Wishlists?</td>
                            <td align="right" style="padding:4px 25px;">Trouble viewing this email? <a  href="#/?utm_source=web&utm_medium=edm&utm_campaign=0813" title="Click here" target="_blank" style="color:#F00;">Click here</a>.</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!---------------------------------- logo & mail ------------------------------------>   
            <tr>
                <td height="75" align="center" valign="middle" bgcolor="#000000">
                    <table width="93%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="left" valign="bottom"><a href="http://www.choies.com/?utm_source=web&utm_medium=edm&utm_campaign=0813" target="_blank" title="CHOIES"><img src="http://www.choies.com/images/logo.gif" width="145" height="40" style="display:block;" border="0" alt="CHOIES   record your inspried fashion"/></a></td>
<!--                            <td align="right" valign="bottom"><img src="http://www.choies.com/images/docs/icon_mail.png" width="19" height="11"  border="0" alt="MAIL TO YOUR FRIENDS"/> <a href="#" target="_blank" title="MAIL TO YOUR FRIENDS" style="font: normal 12px Arial; color:#ffffff; text-decoration:none;">MAIL TO YOUR FRIENDS </a></td>-->
                        </tr>
                    </table>
                </td>
            </tr>

            <!---------------------------------- nav ------------------------------------>   
            <tr>
                <td height="31" align="center" valign="middle" bgcolor="#FFFFFF" style="border-bottom:#333 1px solid;">
                    <table width="93%" border="0" cellspacing="0" cellpadding="0" style="font-size:13px; text-align:center;">
                        <tr>
                            <td width="13%" align="center"><a href="http://www.choies.com/weekly-new/?utm_source=web&utm_medium=edm&utm_campaign=0813" title="NEW IN
                                                              " target="_blank" style="color:#333; text-decoration:none;">NEW IN</a></td>
                            <td width="14%" align="center"><a href="http://www.choies.com/shoes/?utm_source=web&utm_medium=edm&utm_campaign=0813" title="SHOES" target="_blank" style="color:#333; text-decoration:none;">SHOES</a></td>
                            <td width="18%" align="center"><a href="http://www.choies.com/apparels/?utm_source=web&utm_medium=edm&utm_campaign=0813" title="APPARELS" target="_blank" style="color:#333; text-decoration:none;">APPARELS</a></td>
                            <td width="22%" align="center"><a href="http://www.choies.com/accessory/?utm_source=web&utm_medium=edm&utm_campaign=0813" title="ACCESSORIES" target="_blank" style="color:#333; text-decoration:none;">ACCESSORIES</a></td>
                            <td width="14%" align="center"><a href="http://www.choies.com/outlet/?utm_source=web&utm_medium=edm&utm_campaign=0813" title="OUTLET" target="_blank" style="color:#333; text-decoration:none;">OUTLET</a></td>
                            <td width="19%" align="center"><a href="http://www.choies.com/top-sellers/?utm_source=web&utm_medium=edm&utm_campaign=0813" title="TOP SELLERS" target="_blank" style="color:#333; text-decoration:none;">TOP SELLERS </a></td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!---------------------------------- Content ------------------------------------>   

            <tr>
                <td>
                    <img src="http://www.choies.com/images/docs/banner1.jpg" width="700" height="165" border="0" style="display:block;" title="" alt="" />
                </td>
            </tr>
            <tr>
                <td align="center" style="padding:15px 0 20px;">
                    <table width="670" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:18px;">
                                Hi, Choies Lover,<br /><br />
                                Remember the awesome items below? You have saved them in your wish list for long time. <br />
                                Pieces like them are very popular recently and we will run out of stock soon.<br />
                                Hurry in to snap them before they are gone.<br />
                                Enjoy Your Shopping at Choies!
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <?php
            foreach ($wishlists as $key => $wishlist):
                if ($key % 3 == 0)
                    echo '<tr>
                <td align="center" valign="top" style="padding:0 0 15px;">
                    <table border="0" cellspacing="0" cellpadding="0" align="left">
                        <tr>';
                $configs = unserialize($wishlist['configs']);
                $image = array(
                    'id' => 0,
                    'suffix' => 'jpg'
                );
                if(isset($configs['default_image']))
                    $image['id'] = $configs['default_image'];
                elseif(isset($configs['images_order']))
                {
                    $image_order = explode(',', $configs['images_order']);
                    $image['id'] = $image_order[0];
                }
                if(!$image['id'])
                    continue;
                ?>
                <td valign="top" width="226">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="center">
                                <a href="http://www.choies.com/product/<?php echo $wishlist['link']; ?>" title="" target="_blank"><img src="<?php echo Image::link($image, 1); ?>" width="226" height="300" border="0" style="display:block;" title="" alt="" /></a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" width="226">
                                <a href="http://www.choies.com/product/<?php echo $wishlist['link']; ?>" title="" target="_blank" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px; color:#000; text-decoration:none; display:block; margin:5px 0; height:32px; overflow:hidden;">
                                    <?php echo $wishlist['name']; ?>
                                </a>
                            </td>
                        </tr>
                        <tr><td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px; color:#cc0000; text-decoration:none; font-weight:bold;">$<?php echo Product::instance($wishlist['product_id'])->price(); ?></td></tr>
                        <tr>
                            <td align="center">
                                <a href="http://www.choies.com/product/<?php echo $wishlist['link']; ?>" title="" target="_blank"><img src="http://www.choies.com/images/docs/btn.jpg" width="84" height="24" border="0" style="display:block; margin:10px 0;" title="" alt="" /></a>
                            </td>
                        </tr>
                    </table>
                </td>
                <td valign="top" width="5">&nbsp;</td>
                <?php
                if ($key % 3 == 2 OR $key == count($wishlists) - 1)
                    echo '</tr>
                    </table>
                </td>
            </tr>';
            endforeach;
            ?>

            <!---------------------------------- Facebook ------------------------------------>     
            <tr>
                <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="center" valign="middle" bgcolor="#ffffff">
                                <table width="676" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="676" height="40" colspan="2" align="center" valign="middle" bgcolor="#ececec" style="font-size:13px;">Reach Us on Facebook and participate in all kinds of giveaway activities. &nbsp;<a href="http://www.facebook.com/choiesofficial" target="_blank" title="Facebook"><img src="http://www.choies.com/images/docs/icon_facebook.png" alt="Facebook" width="86" height="24" border="0" align="absmiddle"/></a></td>
                                    </tr>
                                    <tr>
                                        <td height="10" bgcolor="#ffffff"><a href="http://blog.choies.com/?utm_source=web&utm_medium=edm&utm_campaign=0813" target="_blank" title="CHOIES BLOG"><img src="http://www.choies.com/images/docs/banner_blog.jpg" width="336" height="108" style="display:block; border-top:#FFF 6px solid; border-bottom:#FFF 6px solid;" border="0" alt="CHOIES BLOG"/></a></td>
                                        <td bgcolor="#ffffff" align="right"><a href="http://www.choies.com/blogger/programme/?utm_source=web&utm_medium=edm&utm_campaign=0813" target="_blank" title="Bloger Wanted"><img src="http://www.choies.com/images/docs/banner_blogerwanted.png" width="336" height="108" style="display:block;border-top:#FFF 6px solid; border-bottom:#FFF 6px solid;" border="0" alt="Bloger Wanted"/></a></td>
                                    </tr>
                                    <tr><td height="3" colspan="2" bgcolor="#333333"></td></tr>
                                </table>
                            </td>
                        </tr>

                        <!---------------------------------- bottom ------------------------------------>   
                        <tr>
                            <?php
                            $email = Site::instance()->get('email');
                            ?>
                            <td align="left" valign="middle" style="font:normal 10px/16px Arial; padding:15px; color:#666666;">If any question, you may contact us directly via <a href="http://messenger.providesupport.com/messenger/01rl3tjgz7wq50rth1bmgy76zj.html" title="LiveChat" target="_blank" style="color:#F00;">LiveChat</a> or by email to <a href="mailto:<?php echo $email; ?>" title="<?php echo $email; ?>" target="_blank" style="color:#F00;"><?php echo $email; ?></a>. To ensure that our messages get to you (and don't go to your junk or bulk email folders), please add <a href="mailto:<?php echo $email; ?>" title="<?php echo $email; ?>" target="_blank" style="color:#F00;"><?php echo $email; ?></a> to your address book.<br/>
                                <br/>
                                Your sincerely,<br/>
                                Choies Team.
                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="color:#fff; font-size:12px;">Choies Clothes, Choies Shoes, Choies Dresses</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>