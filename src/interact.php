<?php
include 'functions.php';
session_name('FROG');
session_start();

echo "<!DOCTYPE html>
<html>
<head>
   <title>
   </title>
   <link rel='stylesheet' href='css/bootstrap.css'>
      <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
      <link rel='stylesheet' href='css/style.css?3.0'>
		<style>
		#interact{
			border:2px solid #337AB7;
		}
      .table-striped{
         font-size:10px;
      }
      .table-striped td{
         width:35%;
      }
      .m{
         transform:translate(-10px,0);
      }
      .mating{
         transform:translate(-10px,0);
      }

      #box{
         transform:translate(0px,40px);
      }
      #values{
         display:none;
      }
      .red{
         color:red;  
      }
      .green{
         color:limegreen;
      }
		</style>
	</head>
	<body>
		<script src='js/jquery-3.1.1.js'></script>
		<script src='js/bootstrap.min.js'></script>
      <a style='float:left; transform:translate(20px,20px)' href='index.php' onclick='reloadHome()' class='fa fa-arrow-circle-left fa-2x'></a>
		<div id='box' class='text-center col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3'>
		<canvas id='interact'></canvas>
      <div class='text-center col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2'>
         <table class='table table-striped'>
         <th colspan='3' class='text-center'>Mating Test Unit</th>
         <tr><th class='text-center'>Frog ID</th>
         <th class='m text-center'>Mating Status</th>
         <th class='text-center'>No. of times</th>
         </tr>";
         $result = queryMysql("SELECT * FROM data ORDER BY frogID");
         $rows = $result->num_rows;
         for($i = 0; $i < $rows; $i++){
            $result->data_seek($i);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            //if($row['death'] == ''){
              // $row['death'] = '-';
            //}
            echo"<tr><td>".$row['frogID']."</td>
                  <td><p class='mating text-center'>In-active</p></td><td class='amount'>0</td></tr>";
         }
         echo"</table>
      </div>
		</div>
      <table id='values'>
         <th>frogID</th>
         <th>name</th>
         <th>gender</th>
         <th>birth</th>
         <th>death</th>
         <th class='numberofFrogs' id='".$rows."'></th><tr>";
         $result = queryMysql("SELECT * FROM data ORDER BY frogID");
         $rows = $result->num_rows;
          for($i = 0; $i < $rows; $i++){
         $result->data_seek($i);
         $row = $result->fetch_array(MYSQLI_ASSOC);
         echo "'<td class='frog' id='".$row['frogID']."' name='".$row['name']."' gender='".$row['gender']."' birth='".$row['birth']."' death='".$row['death']."'>".$row['frogID']."</td>
               </tr>";
         }
      echo"</table>
      <script src='js/script.js'></script>
      <script src='js/interact.js?0.6'></script>
	</body>
</html>";
?>