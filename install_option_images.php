<?php
require_once("config.php");
$connection = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
mysql_select_db(DB_DATABASE, $connection) or die();
mysql_query("SET NAMES UTF8") or die(mysql_error());
mysql_query("ALTER TABLE `" . DB_PREFIX . "product_option_value` ADD `option_image` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
unlink(DIR_APPLICATION.'../install_option_images.php');
echo "PRODUCT OPTION IMAGE WAS SUCCESSFULLY INSTALLED";
?>