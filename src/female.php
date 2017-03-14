<?php
include 'functions.php';
header('Content-Type: charset=UTF-8');

if (isset($_GET['femaleStatus'])) {//UPDATING FEMALE STATUS BADGE
    $result = queryMysql("SELECT * FROM data WHERE gender='F'");
    $num = $result->num_rows;
    echo $num;
}
?>