<?php
$db = mysqli_connect("127.0.0.1","root","","clothesshop");
if(mysqli_connect_errno()){
    echo "Data Base connection failed by following errors: ". mysqli_connect_error();
    die();
}
require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
require_once BASEURL.'helpers/helpers.php';

