<?php
echo '<?xml version="1.0" encoding="UTF-8"?>
';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo $url_base; ?></loc>
        <lastmod><?php echo date('Y-m-d');?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
<?php
foreach($catalogs as $catalog)
{
?>
    <url>
        <loc><?php echo str_replace(array('{link}','{id}'),array($catalog->link,$catalog->id),$catalog_link_template);?></loc>
        <lastmod><?php echo date('Y-m-d');?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
<?php
}
foreach($products as $product)
{
?>
    <url>
        <loc><?php echo str_replace(array('{link}','{id}'),array($product->link,$product->id),$product_link_template);?></loc>
        <lastmod><?php echo date('Y-m-d');?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
<?php
}
foreach($tags as $tag)
{
?>
      <url>
        <loc><?php echo str_replace('{link}',$tag->url,$tags_link_template);?></loc>
        <lastmod><?php echo date('Y-m-d');?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
      </url>
<?php   
}
?>
</urlset>
