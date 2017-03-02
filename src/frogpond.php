<?php
include 'functions.php';
session_name('FROG');
session_start();
$switch;
echo "<div class='page-header'>
				<a style='transform:translate(0,40px); color:green;cursor:pointer' class='fa fa-arrow-circle-left fa-2x' href='index.php'></a>
				<h4 class='text-center head'>Types of frogs</h4>
			</div>";
$result = queryMysql('SELECT * FROM type ORDER BY typeID');
$num = $result->num_rows;
echo "<table id='types' style='width:100%; transform:translate(20px,0); table-layout:fixed'><tr>";
	          for($i = 0; $i < $num; $i++){
	          	$result->data_seek($i);
	          	$row = $result->fetch_array(MYSQLI_ASSOC);
	          	if($i == 3 || $i == 6 || $i == 9 || $i == 12 || $i == 15 || $i == 18 ){
	          		echo '</tr><tr>';
	          	}
	          	echo '<td><img style="width:250px; height:250pxborder-radius:10px" class="text-center" src="img/frogtype/'.$row['name'].'.jpg" alt="'.$row['name'].'"></td>';
	          }
	          echo '</tr></table>';
?>