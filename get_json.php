<?php
//get json from api
require_once('class_sk_api_client.php');
$API = new SK_API;

//posts
$posts =  $API->get_posts( );

//post
$posts =  $API->get_post($id);
?>