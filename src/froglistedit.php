<?php
include 'functions.php';
session_name('FROG');
session_start();
// updating submitted form values
if(isset($_POST['frogID'])){
	$num = count($_POST['frogID']);
	for($i = 0; $i < $num; $i++){
		$name = $_POST['editname'][$i];
		$type = $_POST['edittype'][$i];
		$gender = $_POST['editgender'][$i];
		$env = $_POST['editenv'][$i];
		$birth = $_POST['editbirth'][$i];
		$death = $_POST['editdeath'][$i];;
		$frogID = $_POST['frogID'][$i];
		if(isset($_POST['toDelete'][$i])){
			$id = $_POST['toDelete'][$i];
			echo 'to delete: ' . $_POST["toDelete"][$i];
			queryMysql("DELETE FROM data WHERE frogID='".$id."'");
		}else{
			$result = queryMysql("SELECT * FROM data WHERE frogID='".$frogID."'");
			$row = $result->fetch_array(MYSQLI_ASSOC);
				if($gender !== $row['gender']){
					$result = queryMysql("UPDATE data SET gender='$gender' WHERE frogID='".$frogID."'");
				}
				if($name !== $row['name']){
					$result = queryMysql("UPDATE data SET name='$name' WHERE frogID='".$frogID."'");
				}
				if($type !== $row['type']){
					$result = queryMysql("UPDATE data SET type='$type' WHERE frogID='".$frogID."'");
				}
				if($birth !== $row['birth']){
					$result = queryMysql("UPDATE data SET birth='$birth' WHERE frogID='".$frogID."'");
				}
				if($env !== $row['environment']){
					$result = queryMysql("UPDATE data SET environment='$env' WHERE frogID='".$frogID."'");
				}
				if($death !== $row['death']){
					$result = queryMysql("UPDATE data SET death='$death' WHERE frogID='".$frogID."'");
				}
		}
	}
}


$male = '<select name="editgender[]"><option value="M" selected="selected">M</option><option value="F">F</option></select>';
$female = '<select name="editgender[]"><option value="M">M</option><option value="F" selected="selected">F</option></select>';
$neutral = '<select name="editgender[]"><option value="M">M</option><option value="F">F</option></select>';

$results;
echo "<div class='page-header'>
				<i style='transform:translate(0,40px); color:green;cursor:pointer' class='fa fa-arrow-circle-left fa-2x' onclick='loadList()'></i>
				<h4 class='text-center head'>".ucfirst($_SESSION['user'])."'s Frogs Editing</h4>
	</div>";

	$result = queryMysql("SELECT * FROM data ORDER BY frogID");
	$num = $result->num_rows;
	if($result->num_rows !== 0){
	echo "<i class='fa fa-times' style='float:right; cursor:pointer; transform:translate(0px,0px)' onclick='loadList()'></i><div style='padding:0 0 15px 0; margin-bottom:10px; min-width:100%; overflow:auto; border-radius:10px' class='panel panel-success col-xs-12'>
		<form id='editlist'>";
	echo "<table class='table table-striped special'>
		<thead><tr style='border-bottom:3px solid lightgrey'>
			<th><input type='checkbox' id='selectAll' onchange='selectall()'></th>
			<th class='text-center'>#ID</th>
			<th class='text-center'>Name</th>
			<th class='text-center'>Gender</th>
			<th class='text-center'>Type</th>
			<th class='text-center'>Environment</th>
			<th class='text-center'>Birth</th>
			<th class='text-center'>Death</th>
			</tr>
		</thead>
		<tbody>";
		for($i = 0; $i < $num; $i++){
		$result->data_seek($i);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		if($row['name'] == '') $row['name'] = '-';
		if($row['gender'] == '') $row['gender'] = '-'; 
		if($row['type'] == '') $row['type'] = '-';
		if($row['environment'] == '') $row['environment'] = '-';
		if($row['birth'] == '') $row['birth'] = '-';
		if($row['death'] == '') $row['death'] = '-';
		if($row['gender'] == 'M'){
			$results = $male;
		}else if($row['gender'] == 'F'){
			$results = $female;
		}
		//type default selection initialization on editing screen.
		$t = "<option value='Bufo Asper'>Bufo Asper</option>
		<option value='Bufo Divergens'>Bufo Divergens</option>
		<option value='Megophrys nasuta'>Megophrys nasuta</option>
		<option value='Kaloula baleata'>Kaloula baleata</option>
		<option value='Kalophrynus pleurostigma'>Kalophrynus pleurostigma</option>
		<option value='Microhyla berdmorei'>Microhyla berdmorei</option>
		<option value='Rana chalconota'>Rana chalconota</option>
		<option value='Rana baramica'>Rana baramica</option>
		<option value='Rana glandulosa'>Rana glandulosa</option>
		<option value='Rana erythrea'>Rana erythrea</option>
		<option value='Rana nigrovittata'>Rana nigrovittata</option>
		<option value='Limnonectes malesiana'>Limnonectes malesiana</option>
		<option value='Nyctixalus pictus'>Nyctixalus pictus</option>
		<option value='Polypedates colleti'>Polypedates colleti</option>
		<option value='Polypedates macrotis'>Polypedates macrotis</option>
		<option value='Rhacophorus appendiculatus'>Rhacophorus appendiculatus</option>
		<option value='Rhacophorus reinwardti'>Rhacophorus reinwardti</option>
		<option value='Rhacophorus nigropalmatus'>Rhacophorus nigropalmatus</option>";
		$o = str_replace("'>".$row['type'],"' selected='selected'>".$row['type'],$t);

		//table body content
		echo "<tr id='" . $row['frogID'] . "' ondblclick='deleteStockItemRow(this.id)'>
				<td><input type='checkbox' name='toDelete[]' onchange='selectMe(this)' value='".$row['frogID']."' id='".$row['frogID']."' class='getcheckbox'></td>
				<td class='text-center'>".$row['frogID']."</td>
				<input type='hidden' name='frogID[]' value='".$row['frogID']."'>
				<td class='text-center'><input type='text' class='fixInput' name='editname[]' value='".$row['name']."'</td>
				<td class='text-center'>".$results."</td>
				<td class='text-center'><select name='edittype[]' name='type'>".$o."</select></td>
				<td class='text-center'><input type='text' class='fixInput' name='editenv[]' value='".$row['environment']."'></td>
				<td class='text-center'><input type='text' class='fixInput' name='editbirth[]' value='".$row['birth']."'></td>
				<td class='text-center'><input type='text' class='fixInput' name='editdeath[]' value='".$row['death']."'></td></tr>";
		}
		echo "<tr><td><input type='submit' value='Update' class='btn btn-success' style='float:left' onclick='updateList()'></td><td></td><td></td><td></td><td></td><td><td/><td></td></tr></tbody></table></form>";
	}
?>