<?php
include 'functions.php';

//UPDATING FEMALE STATUS BADGE
if(isset($_GET['femaleStatus'])){
	$result = queryMysql("SELECT * FROM data WHERE gender='F'");
	$num = $result->num_rows;
	echo $num;
}
?>