
		<section id="main">
			<!-- crumbs -->
			<div class="container">
				<div class="crumbs">
					<div>
						<a href="<?php echo LANGPATH; ?>/">home</a>
						<a href="<?php echo LANGPATH; ?>/freetrial/add" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > free trial</a> > freetrial reports
					</div>
					<div class="back visible-xs-inline hidden-sm hidden-md hidden-lg">&lt;&lt;&nbsp;<a class="back" href="window.history.back()">Volver</a>
					</div>
				</div>
			</div>
			<!-- main begin -->
			<section class="container">
				<div class="trial-report trial-report-list">
					<h2>Winners' Feedbacks</h2>
					<ul class="trial-report-listcon">
                    <?php
                    if (!empty($reports)):
                        $domain = Site::instance()->get('domain');
                        foreach ($reports as $report):
                            ?>
						<li class="col-sm-3 col-xs-6">
							<a href="<?php echo LANGPATH; ?>/freetrial/reports/<?php echo $report['id']; ?>">
								<img src="<?php echo 'http://img.choies.com/simages/' . $report['image']; ?>" />
							</a>
							<h3><?php echo $report['name']; ?></h3>
							<a href="<?php echo LANGPATH; ?>/freetrial/reports/<?php echo $report['id']; ?>" class="name"><?php echo strlen($report['comments']) > 80 ? substr($report['comments'], 0, 80) . ' ...' : $report['comments']; ?></a>
							<a href="<?php echo LANGPATH; ?>/freetrial/reports/<?php echo $report['id']; ?>" class="btn btn-primary btn-xs">View Details</a>
						</li>
                            <?php
                        endforeach;
                    endif;
                    ?>
					</ul>
				</div>
            <?php echo $pagination; ?>
			</section>
		</section>
		<!-- footer begin -->

		<!-- gotop -->
		<div id="gotop" class="hide">
			<a href="#" class="xs-mobile-top"></a>
		</div>
	</body>

</html>