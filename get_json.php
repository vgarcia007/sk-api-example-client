<?php
//get json from api
require_once('class_sk_api_client.php');
$API = new SK_API;

//posts
$posts =  $API->get_posts( );

//post
$posts =  $API->get_post($id);

//pages
$posts =  $API->get_pages( );

//page
$posts =  $API->get_page($page_number);

//pages search
$posts =  $API->get_pages_search($search_term);

//page search
$posts =  $API->get_page_search($page_number,$search_term);


//pages tag
$posts =  $API->get_pages_search($tag);

//page tag
$posts =  $API->get_page_search($page_number,$tag);

//search
$posts =  $API->get_search_results($search_term);

//get post by hastag. Example Tag would be #xbox. Needs to start with an '#'
$posts =  $API->get_posts_by_tag($tag);

//get a list of all used tags
$tag_list =  $API->get_tag_list();

//get a list of all used tags with a number how often they are used
$tag_list =  $API->get_tag_list_numbered()
?>
