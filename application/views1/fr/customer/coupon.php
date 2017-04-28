<?php
$conditions1 = 'Tous les articles à plein tarif';
$conditions2 = 'Tous les articles';
?>

        <section id="main">
            <!-- crumbs -->
            <div class="container">
                <div class="crumbs">
                    <div>
                        <a href="<?php echo LANGPATH; ?>/">Accueil</a>
                        <a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > Mon Compte</a> > Mes Coupons
                    </div>
                     <?php echo Message::get(); ?>
                </div>
            </div>
            <!-- main-middle begin -->
            <div class="container">
                <div class="row">
        
        <?php echo View::factory(LANGPATH . '/customer/left'); ?>
        <?php echo View::factory(LANGPATH . '/customer/left_1'); ?>
                    <article id="container" class="user col-sm-9 col-xs-12">
                        <div class="tit">
                            <h2>Mes Coupons</h2>
                        </div>
                        <ul class="JS_tab1 detail-tab1 hidden-xs">
                <li class="on">Coupons Inutilisés</li>
                <li>Coupons Utilisés</li>
                            <p style="left:0px;">
                            <b></b>
                            </p>
                        </ul>
                        <div class="JS_tabcon1 detail-tabcon1 hidden-xs">
                            <div>
                                <div class=" table-responsive">
                                    <table class="user-table">
                                        <tr>
                              <th width="20%">Code de coupons</th>
                            <th width="10%">Type de coupons</th>
                            <th width="10%">Valeur de coupons</th>
                            <th width="20%">Termes & Conditions</th>
                            <th width="10%">Valable à partir de</th>
                                            <th width="10%">Date d’expiration
                                                <a href="?sort=<?php echo isset($_GET['sort']) && $_GET['sort'] == 'date' ? 'date1' : 'date'; ?>" class="icon-turn"></a>
                                            </th>
                                            <th width="10%">Date de Création</th>
                                        </tr>
                     <?php
                        $types = array(
                            1 => 'Remise',
                            2 => 'Réduction',
                            3 => 'largesse',
                            4 => 'changement');
                        foreach($coupons as $coupon):
                            if(!in_array($coupon['code'],$us)){
                            switch ($coupon['type'])
                            {
                                case 1:
                                    $value = $coupon['value'] . '% de réduction';
                                    break;
                                case 2:
                                 $value = Site::instance()->price($coupon['value'], 'code_view'). ' de réduction ' ;
                                    break;
                                case 3:
                                    $value = 'largesse: ' . $coupon['item_sku'];
                                    break;
                                case 4:
                                    $value = 'réduire le prix pour ' . Site::instance()->price($coupon['value'], 'code_view');
                                break;
                                default:
                                    $value = '';
                                    break;
                            }
                            ?>
                                        <tr>
                         <td><?php echo $coupon['code']; ?></td>
                            <td><?php echo isset($types[$coupon['type']]) ? $types[$coupon['type']] : $coupon['type']; ?></td>
                            <td><?php echo $value; ?></td>
                            <td>
                                <?php 
                                    if(isset($coupon['target']))
                                    {
                                        if($coupon['target'] == 'global')
                                        {
                                            echo $conditions2;
                                        }else
                                        {
                                            echo $conditions1;
                                        }                                       
                                    }
                                ?>
                            </td>
                            <td><?php echo date('n/j/Y H:i:s', $coupon['created']); ?></td>
                            <td><?php echo date('n/j/Y H:i:s', $coupon['expired']); ?></td>
                            <td><?php echo date('n/j/Y H:i:s', $coupon['created']); ?></td>
                    </tr>
                     <?php
                            }
                        endforeach;
                        ?>
                                    </table>   
									<span style="float:right;">
                        <?php echo $pagination; ?>
						</span>
                                </div>

                            </div>
                            <div class="hide">
                                <div class=" table-responsive">
                                    <table class="user-table">
                                        <tr>
                            <th width="20%">Code de coupons</th>
                            <th width="10%">Type de coupons</th>
                            <th width="10%">Valeur de coupons</th>
                            <th width="20%">Termes & Conditions</th>
                            <th width="10%">Numéro de Commande</th>
                            <th width="10%">Économiser</th>
                            <th width="10%">Date de l’utilisation</th>
                                        </tr>
                     <?php
                        foreach($used as $data):
                            $currency = Site::instance()->currencies($data['currency']);
                            ?>
                        <tr>
                            <td><?php echo $data['coupon_code']; ?></td>
                            <td> </td>
                            <td> </td>
                            <td>
							<?php 
                                if(isset($coupon['target']))
                                {
                                    if($coupon['target'] == 'global')
                                    {
                                        echo $conditions2;
                                    }else
                                    {
                                        echo $conditions1;
                                    }                                       
                                }
							?>
							</td>
                            <td><a href="<?php echo LANGPATH; ?>/order/view/<?php echo $data['ordernum']; ?>"><?php echo $data['ordernum']; ?></a></td>
                            <td><?php echo $currency['code'] . $data['amount_coupon']; ?></td>
                            <td><?php echo date('n/j/Y H:i:s', $data['created']); ?></td>
                        </tr>
                        <?php
                        endforeach;
                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="coupons-mobile visible-xs-block hidden-sm hidden-md hidden-lg">
                            <ul class="detail-tab">
                                <li class="on">Coupons Inutilisés</li>
                            </ul>
                                <div class=" table-responsive">
                                    <table class="user-table">
                                        <tr>
                            <th width="20%">Code de coupons</th>
                            <th width="10%">Type de coupons</th>
                            <th width="10%">Valeur de coupons</th>
                            <th width="20%">Termes & Conditions</th>
                            <th width="10%">Valable à partir de</th>
                                            <th width="10%">Date d’expiration 
                                                <a href="?sort=<?php echo isset($_GET['sort']) && $_GET['sort'] == 'date' ? 'date1' : 'date'; ?>" class="icon-turn"></a>
                                            </th>
                                            <th width="10%">Date de Création</th>
                                        </tr>
                     <?php
                        $types = array(
                            1 => 'Remise',
                            2 => 'Réduction',
                            3 => 'largesse',
                            4 => 'changement');
                        foreach($coupons as $coupon):
                            $conditions = 'Tous les articles à plein tarif';
                            switch ($coupon['type'])
                            {
                                case 1:
                                    $value = $coupon['value'] . '% de réduction';
                                    break;
                                case 2:
                                    $value = 'de réduction ' . Site::instance()->price($coupon['value'], 'code_view');
                                    break;
                                case 3:
                                    $value = 'largesse: ' . $coupon['item_sku'];
                                    break;
                                case 4:
                                    $value = 'réduire le prix pour ' . Site::instance()->price($coupon['value'], 'code_view');
                                    break;
                                default:
                                    $value = '';
                                    break;
                            }
                            ?>
                        <tr>
                            <td><?php echo $coupon['code']; ?></td>
                            <td><?php echo isset($types[$coupon['type']]) ? $types[$coupon['type']] : $coupon['type']; ?></td>
                            <td><?php echo $value; ?></td>
                            <td>
							<?php 
                                if(isset($coupon['target']))
                                {
                                    if($coupon['target'] == 'global')
                                    {
                                        echo $conditions2;
                                    }else
                                    {
                                        echo $conditions1;
                                    }                                       
                                }
							?>
                            </td>
                            <td><?php echo date('n/j/Y H:i:s', $coupon['created']); ?></td>
                            <td><?php echo date('n/j/Y H:i:s', $coupon['expired']); ?></td>
                            <td><?php echo date('n/j/Y H:i:s', $coupon['created']); ?></td>
                        </tr>
                        <?php
                        endforeach;
                        ?>
                                    </table>
                                </div>
                                <ul class="detail-tab">
                                    <li class="on">Coupons Utilisés</li>
                                </ul>
                                <div class=" table-responsive">
                                    <table class="user-table">
                                        <tr>
                            <th width="20%">Code de coupons</th>
                            <th width="10%">Type de coupons</th>
                            <th width="10%">Valeur de coupons</th>
                            <th width="20%">Termes & Conditions</th>
                            <th width="10%">Numéro de Commande</th>
                            <th width="10%">Économiser</th>
                            <th width="10%">Date de l’utilisation</th>
                                        </tr>
                        <?php
                        foreach($used as $data):
                            $currency = Site::instance()->currencies($data['currency']);
                            ?>
                                        <tr>
                                            <td><?php echo $data['coupon_code']; ?></td>
                                            <td></td>
                                            <td></td>
                            <td>
							<?php 
                                if(isset($coupon['target']))
                                {
                                    if($coupon['target'] == 'global')
                                    {
                                        echo $conditions2;
                                    }else
                                    {
                                        echo $conditions1;
                                    }                                       
                                }
							?>
							</td>
                                            <td><a href="<?php echo LANGPATH; ?>/order/view/<?php echo $data['ordernum']; ?>"><?php echo $data['ordernum']; ?></a></a>
                                            </td>
                                            <td><?php echo $currency['code'] . $data['amount_coupon']; ?></td>
                                            <td><?php echo date('n/j/Y H:i:s', $data['created']); ?></td>
                                        </tr>
                        <?php
                        endforeach;
                        ?>
                                    </table>
                                </div>
                        </div>
                    </article>

                </div>
            </div>
        </section>

        <!-- footer begin -->

        <div id="gotop" class="hide">
            <a href="#" class="xs-mobile-top"></a>
        </div>
