<div id="do_left">
        <div class="navigation">
                <ul>

                        <li>Site Config
                                <ul>
                                        <li><a href="/admin/site/basic/index">Basic Information</a></li>
                                        <li><a href="/admin/site/basic/sns">SNS</a></li>
                                        <li><a href="/admin/site/basic/seo">SEO</a></li>
                                        <li><a href="/admin/site/basic/payment">Payment</a></li>
                                        <li><a href="/admin/site/email/template_list">Email Template</a></li>
                                        <li class="small_language"><a href="/admin/site/email/list">Site Email Setting</a></li>
                                        <li><a href="/admin/site/email/send">Send Email</a></li>
                                        <li><a href="/admin/site/email/logs">Mail logs</a></li>
                                        <li class="small_language"><a href="/admin/site/doc/list">Documents</a></li>
                                        <li><a href="/admin/site/basic/currency">Currency</a></li>
                                        <li><a href="/admin/site/basic/memcache_delete">Memcache Delete</a></li>
                                </ul>
                        </li>

                        <li>Carrier
                                <ul>
                                        <li><a href="/admin/site/country/list">Countries</a></li>
                                        <li><a href="/admin/site/carrier/default">Shipping method</a></li>
                                </ul>
                        </li>

                        <li>Product Set
                                <ul>
                                        <li><a href="/admin/site/set/list">Set list</a></li>
                                        <li><a href="/admin/site/set/add">Set add</a>
                                </ul>
                        </li>

                        <li>Product Attribute
                                <ul>
                                        <li><a href="/admin/site/attribute/list">Attribute list</a></li>
                                        <li><a href="/admin/site/attribute/add">Attribute add</a>
                                </ul>
                        </li>

                        <li>Redirect Links
                                <ul>
                                        <li><a href="/admin/site/redirectlink/list">Links list</a></li>
                                </ul>
                        </li>

                </ul>
        </div>
</div>
<?php
$lang = Arr::get($_GET, 'lang', '');
$lang_url = $lang ? '?lang=' . $lang : '';
if ($lang_url)
{
    ?>
    <script>
        $(function(){
            $("#do_left .navigation li ul li").hide();
            $(".small_language").show();
        })
    </script>
    <?php
}
?>
