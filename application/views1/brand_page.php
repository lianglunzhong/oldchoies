<div class="clearfix"></div>
		<div class="site-content" id="phone-main">
			<div class="main-container clearfix">
				<div class="container brand-list">
            <div class="brand-m">
                <div class="brand-pc hidden-xs">
                    <h3><span>A-Z</span>&nbsp;&nbsp;&nbsp;&nbsp; Brands List</h3>
                    <?php
                    if (isset($brands)) {
                        foreach ($brands as $key => $value) {
                            ?>
                            <ul>
                                <li class="td1"><span class="index"><?php echo $key; ?></span></li>
                                <li class="td2">
                                    <ul>
                                        <?php
                                        foreach ($value as $vbrand)
                                        {
                                            ?>
                                            <li>
                                                <span>
                                                    <a href="<?php echo LANGPATH; ?>/brand/list/<?php echo $vbrand['id']; ?>" target="_blank"><?php if($vbrand['name']=="Alistar"){ echo "<strong>".$vbrand['name']."</strong>"; }else{ echo $vbrand['name'];}?></a>
                                                </span>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </li>
                                </li>
                            </ul>
                            <?php
                        }
                    } ?>
                </div>
            </div>

            <div class="brand-phone hidden-sm hidden-md hidden-lg">
                <?php
                    if (isset($brands)) {
                        foreach ($brands as $key => $value) {
                            ?>
                            <ul>
                                <li class="td1"><span class="index"><?php echo $key; ?></span></li>
                                <li class="td2">
                                    <ul>
                                        <?php
                                        foreach ($value as $vbrand)
                                        {
                                            ?>
                                            <li>
                                                <span>
                                                    <a href="<?php echo LANGPATH; ?>/brand/list/<?php echo $vbrand['id']; ?>"><?php if($vbrand['name']=="Alistar"){ echo "<strong>".$vbrand['name']."</strong>"; }else{ echo $vbrand['name'];}?></a>
                                                </span>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </li>
                                </li>
                            </ul>
                            <?php
                        }
                    } ?>
            </div>
        </div>
				</div>
			</div>
		</div>