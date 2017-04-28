<?php

function send_modification_header($timestamp)
{
    $last_modification_date = gmdate("D, d M Y H:i:s \G\M\T", $timestamp);
    $etag = '"'.md5($last_modification_date.' COLA ETAG').'"';
    // Send the headers
    header("Last-Modified: $last_modification_date");
    header("ETag: $etag");
    header('Cache-Control:public');
    header('Pragma:public');
    header('Expires:'.gmdate("D, d M Y H:i:s \G\M\T", $timestamp + (3600 * 24 * 30)));
    // See if the client has provided the required headers
    $if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ?
        strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) : false;
    $if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ?
        stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) : false;
    if( ! $if_modified_since && ! $if_none_match)
    {
        return;
    }
    // At least one of the headers is there - check them
    if($if_none_match && $if_none_match != $etag)
    {
        return; // etag is there but doesn't match
    }
    if($if_modified_since && $if_modified_since < $timestamp)
    {
        return; // if-modified-since is there but doesn't match
    }
    // Nothing has changed since their last request - serve a 304 and exit
    //if (php_sapi_name()=='CGI') {
    //    Header("Status: 304 Not Modified");
    //} else {
    Header("HTTP/1.0 304 Not Modified");
    //}

    exit;
}

//config:

$resource_dir = $_SERVER['COFREE_UPLOAD_DIR'];

$site_id = isset($_GET['site_id']) ? $_GET['site_id'] : 1;

$admin_image_sizes = array(
    99 => array( 120, 120 ),
    100 => array( 100, 50 )
);

$sizes1 = array(
    $site_id => array(
        1 => array(320, 320, 0), // catalog
        2 => array(560, 560, 0), // product
        3 => array(100, 100, 0), // small
        7 => array(256, 256, 0), // lookbook
        8 => array(800, 800, 0), // banner mobile
    )
);

