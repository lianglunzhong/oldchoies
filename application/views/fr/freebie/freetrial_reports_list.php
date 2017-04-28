<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Accueil</a>  >  Rapports d'Essai Gratuit</div>
        </div>
        <?php echo Message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <section id="container" class="flr">
            <!-- trial_report -->
            <div class="trial_report trial_report_list">
                <h2>Feedbacks des gagnants</h2>
                <ul class="trial_report_listcon fix">
                    <?php
                    if (!empty($reports)):
                        $domain = Site::instance()->get('domain');
                        foreach ($reports as $report):
                            ?>
                            <li>
                                <a href="<?php echo LANGPATH; ?>/freetrial/reports/<?php echo $report['id']; ?>"><img src="<?php echo 'http://img.choies.com/simages/' . $report['image']; ?>" /></a>
                                <h3><?php echo $report['name']; ?></h3>
                                <a href="<?php echo LANGPATH; ?>/freetrial/reports/<?php echo $report['id']; ?>" class="name"><?php echo strlen($report['comments']) > 80 ? substr($report['comments'], 0, 80) . ' ...' : $report['comments']; ?></a>
                                <a href="<?php echo LANGPATH; ?>/freetrial/reports/<?php echo $report['id']; ?>" class="view_btn btn26 btn40">View Details</a>
                            </li>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </ul>
            </div>
            <?php echo $pagination; ?>
        </section>
        <?php echo View::factory('/catalog_left'); ?>
    </section>
</section>
