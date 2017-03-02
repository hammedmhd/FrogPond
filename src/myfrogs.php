<?php
include 'functions.php';
session_name('FROG');
session_start();

if(isset($_POST['type'])){//adding new frong entry
	$result = queryMysql("SELECT * FROM data");
	$num = $result->num_rows;
	$frogID = $num + 1;
	$type = sanitizeString($_POST['type'];
	$name = sanitizeString($_POST['name']);
	$env = sanitizeString($_POST['environment']);
	$birth = sanitizeString($_POST['birth']);
	$gender = sanitizeString($_POST['gender']);
	$death = sanitizeString($_POST['death']);
	if($birth == ''){
		$birth = date('d-m-Y / h:ia');
	}
	$result = queryMysql("INSERT INTO data VALUES($frogID,'$name','$gender','$type','$env','$birth','$death')");//NEW FROG ENTRY CODE//NEW frog entry
}else if(isset($_POST['asc'])){//view by field ascending
	$asc = $_POST['asc'];
	echo "<div class='page-header'>
				<a style='transform:translate(0,40px); color:green;cursor:pointer' class='fa fa-arrow-circle-left fa-2x' href='index.php'></a>
				<h4 class='text-center head'>".ucfirst($_SESSION['user'])."'s Frogs</h4>
				<i id='editme' class='fa fa-plus-circle fa-2x' style='float:right; transform:translate(0,-27px);color:green;cursor:pointer' onclick='newFrog()'></i>
			</div>";
		echo "<form autocomplete='off' style='padding-bottom:15px; border-radius:10px;' id='newFrog' class='text-center panel panel-success' method='post'>
		<p class='panel-heading' style='width:100%'>New Frog</p>
		Frog Type: <select name='type'>
			<option value='Bufo Asper'>Bufo Asper</option>
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
			<option value='Rhacophorus nigropalmatus'>Rhacophorus nigropalmatus</option>
		</select>
		Male <input type='radio' name='gender' value='M' checked='checked'> Female <input type='radio' name='gender' value='F'><br><br>
		<input type='text' style='width:50%' autofocus='on' class='fixInput text-center' name='name' placeholder='Frog Name'><br>
		<input type='text' style='width:50%' autofocus='on' class='fixInput text-center' name='environment' placeholder='Environment'><br>
		<input type='text' style='width:50%' autofocus='on' class='fixInput text-center' name='birth' placeholder='Birth'><br>
		<input type='text' style='width:50%' autofocus='on' class='fixInput text-center' name='death' placeholder='Death (If not applicable leave empty).'><br><br>
		<input type='submit' class='btn btn-success' value='Add Frog' onclick='submitNewFrog()'>
		</form>
	";

	$result = queryMysql("SELECT * FROM data ORDER BY $asc ASC");
	$num = $result->num_rows;
	if($result->num_rows !== 0){
	echo "<div style='padding:0 0 15px 0; margin-bottom:10px; min-width:100%; overflow:auto; border-radius:10px' class='panel panel-success col-xs-12'>
	<i class='fa fa-pencil' style='float:right; cursor:pointer; transform:translate(10px,p2x)' onclick='editList()'></i>";
	echo "<table class='table table-striped'>
		<thead><tr style='border-bottom:3px solid lightgrey'>
			<th class='text-center'>#ID<span id='frogID' style='cursor:pointer' onclick='FrogsByDesc(this.id)'>&utrif;</span><span id='frogID' style='cursor:pointer' onclick='FrogsByAsc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Name<span id='name' style='cursor:pointer' onclick='FrogsByDesc(this.id)'>&utrif;</span><span id='name' style='cursor:pointer' onclick='FrogsByAsc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Gender<span id='gender'  style='cursor:pointer' onclick='FrogsByDesc(this.id)'>&utrif;</span><span id='gender' style='cursor:pointer' onclick='FrogsByAsc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Type<span id='type' style='cursor:pointer' onclick='FrogsByDesc(this.id)'>&utrif;</span><span id='type' style='cursor:pointer' onclick='FrogsByAsc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Environment<span id='environment' style='cursor:pointer' onclick='FrogsByDesc(this.id)'>&utrif;</span><span id='environment' style='cursor:pointer' onclick='FrogsByAsc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Birth<span id='birth' style='cursor:pointer' onclick='FrogsByDesc(this.id)'>&utrif;</span><span id='birth' style='cursor:pointer' onclick='FrogsByAsc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Death<span id='death' style='cursor:pointer' onclick='FrogsByDesc(this.id)'>&utrif;</span><span id='death' style='cursor:pointer' onclick='FrogsByAsc(this.id)'>&dtrif;</span></th>
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
		echo "<tr>
				<td class='text-center'>" . $row['frogID'] . "</td>
				<td class='text-center'>".$row['name']."</td>
				<td class='text-center'>".$row['gender']."</td>
				<td class='text-center'>".$row['type']."</td>
				<td class='text-center'>".$row['environment']."</td>
				<td class='text-center'>".$row['birth']."</td>
				<td class='text-center'>".$row['death']."</td></tr>";
		}
		echo "</tbody></table>";
	}else{
	echo '<h3>Your Frogs list is empty.</h3>';
}
}else if(isset($_POST['desc'])){//view by field descending
	$desc = $_POST['desc'];
	echo "<div class='page-header'>
				<a style='transform:translate(0,40px); color:green;cursor:pointer' class='fa fa-arrow-circle-left fa-2x' href='index.php'></a>
				<h4 class='text-center head'>".ucfirst($_SESSION['user'])."'s Frogs</h4>
				<i id='editme' class='fa fa-plus-circle fa-2x' style='float:right; transform:translate(0,-27px);color:green;cursor:pointer' onclick='newFrog()'></i>
			</div>";
	echo "<form autocomplete='off' style='padding-bottom:15px; border-radius:10px;' id='newFrog' class='text-center panel panel-success' method='post'>
	<p class='panel-heading' style='width:100%'>New Frog</p>
	Frog Type: <select name='type'>
		<option value='Bufo Asper'>Bufo Asper</option>
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
		<option value='Rhacophorus nigropalmatus'>Rhacophorus nigropalmatus</option>
	</select>
	Male <input type='radio' name='gender' value='M' checked='checked'> Female <input type='radio' name='gender' value='F'><br><br>
	<input type='text' style='width:50%' autofocus='on' class='fixInput text-center' name='name' placeholder='Frog Name'><br>
	<input type='text' style='width:50%' autofocus='on' class='fixInput text-center' name='environment' placeholder='Environment'><br>
	<input type='text' style='width:50%' autofocus='on' class='fixInput text-center' name='birth' placeholder='Birth'><br>
	<input type='text' style='width:50%' autofocus='on' class='fixInput text-center' name='death' placeholder='Death (If not applicable leave empty).'><br><br>
	<input type='submit' class='btn btn-success' value='Add Frog' onclick='submitNewFrog()'>
	</form>
	";


	$result = queryMysql("SELECT * FROM data ORDER BY $desc DESC");
	$num = $result->num_rows;
	if($result->num_rows !== 0){
	echo "<div style='padding:0 0 15px 0; margin-bottom:10px; min-width:100%; overflow:auto; border-radius:10px' class='panel panel-success col-xs-12'>
	<i class='fa fa-pencil' style='float:right; cursor:pointer; transform:translate(10px,p2x)' onclick='editList()'></i>";
	echo "<table class='table table-striped'>
		<thead><tr style='border-bottom:3px solid lightgrey'>
			<th class='text-center'>#ID<span id='frogID' style='cursor:pointer' onclick='FrogsByDesc(this.id)'>&utrif;</span><span id='frogID' style='cursor:pointer' onclick='FrogsByAsc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Name<span id='name' style='cursor:pointer' onclick='FrogsByDesc(this.id)'>&utrif;</span><span id='name' style='cursor:pointer' onclick='FrogsByAsc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Gender<span id='gender'  style='cursor:pointer' onclick='FrogsByDesc(this.id)'>&utrif;</span><span id='gender' style='cursor:pointer' onclick='FrogsByAsc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Type<span id='type' style='cursor:pointer' onclick='FrogsByDesc(this.id)'>&utrif;</span><span id='type' style='cursor:pointer' onclick='FrogsByAsc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Environment<span id='environment' style='cursor:pointer' onclick='FrogsByDesc(this.id)'>&utrif;</span><span id='environment' style='cursor:pointer' onclick='FrogsByAsc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Birth<span id='birth' style='cursor:pointer' onclick='FrogsByDesc(this.id)'>&utrif;</span><span id='birth' style='cursor:pointer' onclick='FrogsByAsc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Death<span id='death' style='cursor:pointer' onclick='FrogsByDesc(this.id)'>&utrif;</span><span id='death' style='cursor:pointer' onclick='FrogsByAsc(this.id)'>&dtrif;</span></th>
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
		echo "<tr>
				<td class='text-center'>" . $row['frogID'] . "</td>
				<td class='text-center'>".$row['name']."</td>
				<td class='text-center'>".$row['gender']."</td>
				<td class='text-center'>".$row['type']."</td>
				<td class='text-center'>".$row['environment']."</td>
				<td class='text-center'>".$row['birth']."</td>
				<td class='text-center'>".$row['death']."</td></tr>";
		}
		echo "</tbody></table>";
	}else{
	echo '<h3>Your Frogs list is empty.</h3>';
}
}else{//main view
	echo "<div class='page-header'>
				<a style='transform:translate(0,40px); color:green;cursor:pointer' class='fa fa-arrow-circle-left fa-2x' href='index.php'></a>
				<h4 class='text-center head'>".ucfirst($_SESSION['user'])."'s Frogs</h4>
				<i id='editme' class='fa fa-plus-circle fa-2x' style='float:right; transform:translate(0,-23px);color:green;cursor:pointer' onclick='newFrog()'></i>
			</div>";
	echo "<form autocomplete='off' style='padding-bottom:15px; border-radius:10px;' id='newFrog' class='text-center panel panel-success' method='post'>
	<p class='panel-heading' style='width:100%'>New Frog</p>
	Frog Type: <select name='type'>
		<option value='Bufo Asper'>Bufo Asper</option>
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
		<option value='Rhacophorus nigropalmatus'>Rhacophorus nigropalmatus</option>
	</select>
	Male <input type='radio' name='gender' value='M' checked='checked'> Female <input type='radio' name='gender' value='F'><br><br>
	<input type='text' style='width:50%' autofocus='on' class='fixInput text-center' name='name' placeholder='Frog Name'><br>
	<input type='text' style='width:50%' autofocus='on' class='fixInput text-center' name='environment' placeholder='Environment'><br>
	<input type='text' style='width:50%' autofocus='on' class='fixInput text-center' name='birth' placeholder='Birth'><br>
	<input type='text' style='width:50%' autofocus='on' class='fixInput text-center' name='death' placeholder='Death (If not applicable leave empty).'><br><br>
	<input type='submit' class='btn btn-success' value='Add Frog' onclick='submitNewFrog()'>
	</form>
	";


	$result = queryMysql("SELECT * FROM data ORDER BY frogID");
	$num = $result->num_rows;
	if($result->num_rows !== 0){
	echo "<div style='padding:0 0 15px 0; margin-bottom:10px; min-width:100%; overflow:auto; border-radius:10px' class='panel panel-success col-xs-12'>
	<i class='fa fa-pencil' style='float:right; cursor:pointer; transform:translate(-2px,5px)' onclick='editList()'></i>";
	echo "<table class='table table-striped'>
		<thead><tr style='border-bottom:3px solid lightgrey'>
			<th class='text-center'>#ID<span id='frogID' style='cursor:pointer' onclick='FrogsByDesc(this.id)'>&utrif;</span><span id='frogID' style='cursor:pointer' onclick='FrogsByAsc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Name<span id='name' style='cursor:pointer' onclick='FrogsByDesc(this.id)'>&utrif;</span><span id='name' style='cursor:pointer' onclick='FrogsByAsc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Gender<span id='gender'  style='cursor:pointer' onclick='FrogsByDesc(this.id)'>&utrif;</span><span id='gender' style='cursor:pointer' onclick='FrogsByAsc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Type<span id='type' style='cursor:pointer' onclick='FrogsByDesc(this.id)'>&utrif;</span><span id='type' style='cursor:pointer' onclick='FrogsByAsc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Environment<span id='environment' style='cursor:pointer' onclick='FrogsByDesc(this.id)'>&utrif;</span><span id='environment' style='cursor:pointer' onclick='FrogsByAsc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Birth<span id='birth' style='cursor:pointer' onclick='FrogsByDesc(this.id)'>&utrif;</span><span id='birth' style='cursor:pointer' onclick='FrogsByAsc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Death<span id='death' style='cursor:pointer' onclick='FrogsByDesc(this.id)'>&utrif;</span><span id='death' style='cursor:pointer' onclick='FrogsByAsc(this.id)'>&dtrif;</span></th>
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
		echo "<tr id='" . $row['frogID'] . "' ondblclick='deleteStockItemRow(this.id)'>
				<td class='text-center'>" . $row['frogID'] . "</td>
				<td class='text-center'>".$row['name']."</td>
				<td class='text-center'>".$row['gender']."</td>
				<td class='text-center'>".$row['type']."</td>
				<td class='text-center'>".$row['environment']."</td>
				<td class='text-center'>".$row['birth']."</td>
				<td class='text-center'>".$row['death']."</td></tr>";
		}
		echo "</tbody></table>";
}else{
	echo '<h3>Your Frogs list is empty.</h3>';
}
}
?>