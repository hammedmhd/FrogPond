<?php
include 'functions.php';
header('Content-Type: charset=UTF-8');

if (isset($_GET['maleStatus'])) {//UPDATING MALE STATUS BADGE
    $result = queryMysql("SELECT * FROM data WHERE gender='M'");
    $num = $result->num_rows;
    echo $num;
}
?>