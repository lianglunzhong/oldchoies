<?php
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo $url_base; ?></loc>
        <lastmod><?php echo date('Y-m-d');?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
<?php
foreach($products as $product)
{
	if($product->link == 'no-link') continue;
?>
    <url>
        <loc><?php echo str_replace(array('{link}','id'),array($product->link,$product->id),$product_link_template);?></loc>
        <lastmod><?php echo date('Y-m-d');?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
<?php
}
?>
</urlset>
