<div style="text-align:center;">
        <table cellspacing="1" cellpadding="1" border="1">
                <?php
                $countries = Site::instance()->countries();
                foreach ($countries as $country)
                {
                        if ($country['isocode'] == $address['country'])
                        {
                                $country_name = $country['name'];
                                break;
                        }
                }
                ?>
                <tr>
                        <td><strong>Name: </strong></td><td colspan="2"><?php echo $celebrity['name']; ?></td>
                </tr>
                <tr>
                        <td><strong>Email: </strong></td><td colspan="2"><?php echo $celebrity['email']; ?></td>
                </tr>
                <tr>
                        <td><strong>Country: </strong></td><td colspan="2"><?php echo isset($country_name) ? $country_name : ''; ?></td>
                </tr>
                <tr>    
                        <td><strong>State: </strong></td><td colspan="2"><?php echo $address['state']; ?><?php echo isset($address['state']) ? $address['state'] : ''; ?></td>
                </tr>
                <tr>
                        <td><strong>City: </strong></td><td colspan="2"><?php echo $address['city']; ?></td>
                </tr>
                <tr>
                        <td><strong>Zip: </strong></td><td colspan="2"><?php echo $address['zip']; ?></td>
                </tr>
                <tr>
                        <td><strong>Address: </strong></td><td colspan="2"><?php echo $address['address']; ?></td>
                </tr>
                <tr>
                        <td><strong>Sex: </strong></td><td colspan="2"><?php echo $celebrity['sex'] == 1 ? 'Man' : 'Woman'; ?></td>
                </tr>
                <tr>
                        <td><strong>Birthday: </strong></td><td colspan="2"><?php echo date('Y-m-d', $celebrity['birthday']); ?></td>
                </tr>
                <tr>
                        <td><strong>Level: </strong></td><td colspan="2"><?php echo $celebrity['level']; ?></td>
                </tr>
                <tr><td colspan="3"><strong>Blogs:</strong></td></tr>
                <div>
                        <?php
                        if (!empty($blogs))
                        {
                                foreach ($blogs as $key => $blog)
                                {
                                        ?>
                                        <tr>
                                                <td><label for="blog_type">Blog Type: </label><?php echo $blog['type']; ?> &nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                <td><label for="blog_url">Blog Url: </label><?php echo $blog['url']; ?> &nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                <td><label for="blog_fanse">Blog Fanse: </label><?php echo $blog['profile']; ?> &nbsp;&nbsp;</td>
                                        </tr>
                                        <?php
                                }
                        }
                        ?>
                </div>
                <?php
                if($celebrity['show_name'])
                {
                ?>
                <tr>
                        <td><strong>Show name: </strong></td><td colspan="2"><?php echo $celebrity['show_name']; ?></td>
                </tr>
                <tr>
                        <td><strong>Detail: </strong></td><td colspan="2">
                                height:<?php echo $celebrity['height']; ?>; weight:<?php echo $celebrity['weight']; ?>; bust:<?php echo $celebrity['bust']; ?>; waist:<?php echo $celebrity['waist']; ?>; hips:<?php echo $celebrity['hips']; ?>
                        </td>
                </tr>
                <?php
                }
                ?>
        </table>
</div>
