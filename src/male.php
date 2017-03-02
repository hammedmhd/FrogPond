<?php
include 'functions.php';

//UPDATING MALE STATUS BADGE
if(isset($_GET['maleStatus'])){
	$result = queryMysql("SELECT * FROM data WHERE gender='M'");
	$num = $result->num_rows;
	echo $num;
}
?>