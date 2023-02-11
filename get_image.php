<?php
#get image from api and display it
#put this file in your webroot besides index.html

# EXAMPLE URL: https://<YOUR_DOMAIN>/image.php?image=AQADxsIxG6zjOUt-.jpg

# Use it like this in your Template <img src="get_image.php?image=<echo image_file_name_here" />
require_once('class_sk_api_client.php');
$API = new SK_API;
header('Content-type: image/jpg');
echo $API->get_image($_GET['image'] );
?>