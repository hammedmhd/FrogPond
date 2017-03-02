<?php
include 'functions.php';
session_name('FROG');
session_start();

if(isset($_POST['typefrog'])){
	$name = $_SESSION['name'] = isset($_POST['name']) ? $_POST['name'] : '';
	$type = $_SESSION['type'] = isset($_POST['typefrog']) ? $_POST['typefrog'] : '';
	$gender = $_SESSION['gender'] = isset($_POST['gender']) ? $_POST['gender'] : '';
	$birth = $_SESSION['birth'] = isset($_POST['birth']) ? $_POST['birth'] : '';
	$death = $_SESSION['death'] = isset($_POST['death']) ? $_POST['death'] : '';
	echo "<div class='page-header'>
				<i id='searchfrogs.php' style='transform:translate(0,40px); color:green;cursor:pointer' class='fa fa-arrow-circle-left fa-2x' onclick='loadPage(this.id)'></i>
				<h4 class='text-center head'>Search My Frogs</h4>
			</div>";
	if(!empty($name)){
		if(!empty($birth)){
			if(!empty($death)){
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' AND birth='$birth' AND name='$name' ORDER BY frogID");
			}else{
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND birth='$birth' AND name='$name' ORDER BY frogID");
			}
		}else{
			if(!empty($death)){
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' AND name='$name' ORDER BY frogID");
			}else{
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND name='$name' ORDER BY frogID");
			}
		}
	}else{
		if(!empty($birth)){
			if(!empty($death)){
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' AND birth='$birth' ORDER BY frogID");
			}else{
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND birth='$birth' ORDER BY frogID");
			}
		}else{
			if(!empty($death)){
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' ORDER BY frogID");
			}else{
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' ORDER BY frogID");
			}
		}
	}
	//$result = queryMysql("SELECT * FROM data ORDER BY frogID");
	$num = $result->num_rows;
	if($result->num_rows !== 0){
	echo "<div style='padding:0 0 15px 0; margin-bottom:10px; min-width:100%; overflow:auto; border-radius:10px' class='panel panel-success col-xs-12'>
	<i class='fa fa-pencil' style='float:right; cursor:pointer; transform:translate(10px,p2x)' onclick='editList()'></i>";
	echo "<table class='table table-striped'>
		<thead><tr style='border-bottom:3px solid lightgrey'>
			<th class='text-center'>#ID<span id='frogID' style='cursor:pointer' onclick='desc(this.id)'>&utrif;</span><span id='frogID' style='cursor:pointer' onclick='asc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Name<span id='name' style='cursor:pointer' onclick='desc(this.id)'>&utrif;</span><span id='name' style='cursor:pointer' onclick='asc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Gender<span id='gender'  style='cursor:pointer' onclick='desc(this.id)'>&utrif;</span><span id='gender' style='cursor:pointer' onclick='asc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Type<span id='type' style='cursor:pointer' onclick='desc(this.id)'>&utrif;</span><span id='type' style='cursor:pointer' onclick='asc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Environment<span id='environment' style='cursor:pointer' onclick='desc(this.id)'>&utrif;</span><span id='environment' style='cursor:pointer' onclick='asc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Birth<span id='birth' style='cursor:pointer' onclick='desc(this.id)'>&utrif;</span><span id='birth' style='cursor:pointer' onclick='asc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Death<span id='death' style='cursor:pointer' onclick='desc(this.id)'>&utrif;</span><span id='death' style='cursor:pointer' onclick='asc(this.id)'>&dtrif;</span></th>
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
		echo "</tbody></table>";//search by field 
}
}else if(isset($_POST['asc'])){
	$asc = $_POST['asc'];
	$name = $_SESSION['name'];
	$type = $_SESSION['type']; 
	$gender = $_SESSION['gender']; 
	$birth = $_SESSION['birth'];
	$death = $_SESSION['death']; 
	echo "<div class='page-header'>
				<i id='searchfrogs.php' style='transform:translate(0,40px); color:green;cursor:pointer' class='fa fa-arrow-circle-left fa-2x' onclick='loadPage(this.id)'></i>
				<h4 class='text-center head'>Search My Frogs</h4>
			</div>";
	if(!empty($name)){
		if(!empty($birth)){
			if(!empty($death)){
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' AND birth='$birth' AND name='$name' ORDER BY $asc ASC");
			}else{
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND birth='$birth' AND name='$name' ORDER BY $asc ASC");
			}
		}else{
			if(!empty($death)){
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' AND name='$name' ORDER BY $asc ASC");
			}else{
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND name='$name' ORDER BY $asc ASC");
			}
		}
	}else{
		if(!empty($birth)){
			if(!empty($death)){
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' AND birth='$birth' ORDER BY $asc ASC");
			}else{
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND birth='$birth' ORDER BY $asc ASC");
			}
		}else{
			if(!empty($death)){
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' ORDER BY $asc ASC");
			}else{
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' ORDER BY $asc");
			}
		}
	}
	//$result = queryMysql("SELECT * FROM data ORDER BY frogID");
	$num = $result->num_rows;
	if($result->num_rows !== 0){
	echo "<div style='padding:0 0 15px 0; margin-bottom:10px; min-width:100%; overflow:auto; border-radius:10px' class='panel panel-success col-xs-12'>
	<i class='fa fa-pencil' style='float:right; cursor:pointer; transform:translate(10px,p2x)' onclick='editList()'></i>";
	echo "<table class='table table-striped'>
		<thead><tr style='border-bottom:3px solid lightgrey'>
			<th class='text-center'>#ID<span id='frogID' style='cursor:pointer' onclick='desc(this.id)'>&utrif;</span><span id='frogID' style='cursor:pointer' onclick='asc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Name<span id='name' style='cursor:pointer' onclick='desc(this.id)'>&utrif;</span><span id='name' style='cursor:pointer' onclick='asc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Gender<span id='gender'  style='cursor:pointer' onclick='desc(this.id)'>&utrif;</span><span id='gender' style='cursor:pointer' onclick='asc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Type<span id='type' style='cursor:pointer' onclick='desc(this.id)'>&utrif;</span><span id='type' style='cursor:pointer' onclick='asc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Environment<span id='environment' style='cursor:pointer' onclick='desc(this.id)'>&utrif;</span><span id='environment' style='cursor:pointer' onclick='asc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Birth<span id='birth' style='cursor:pointer' onclick='desc(this.id)'>&utrif;</span><span id='birth' style='cursor:pointer' onclick='asc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Death<span id='death' style='cursor:pointer' onclick='desc(this.id)'>&utrif;</span><span id='death' style='cursor:pointer' onclick='asc(this.id)'>&dtrif;</span></th>
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
		echo "</tbody></table>";//view by field asc
}
}else if(isset($_POST['desc'])){
	$desc = $_POST['desc'];
	$name = $_SESSION['name'];
	$type = $_SESSION['type']; 
	$gender = $_SESSION['gender']; 
	$birth = $_SESSION['birth'];
	$death = $_SESSION['death']; 
	echo "<div class='page-header'>
				<i id='searchfrogs.php' style='transform:translate(0,40px); color:green;cursor:pointer' class='fa fa-arrow-circle-left fa-2x' onclick='loadPage(this.id)'></i>
				<h4 class='text-center head'>Search My Frogs</h4>
			</div>";
	if(!empty($name)){
		if(!empty($birth)){
			if(!empty($death)){
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' AND birth='$birth' AND name='$name' ORDER BY $desc DESC");
			}else{
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND birth='$birth' AND name='$name' ORDER BY $desc DESC");
			}
		}else{
			if(!empty($death)){
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' AND name='$name' ORDER BY $desc DESC");
			}else{
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND name='$name' ORDER BY $desc DESC");
			}
		}
	}else{
		if(!empty($birth)){
			if(!empty($death)){
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' AND birth='$birth' ORDER BY $desc DESC");
			}else{
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND birth='$birth' ORDER BY $desc DESC");
			}
		}else{
			if(!empty($death)){
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' ORDER BY $desc DESC");
			}else{
				$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' ORDER BY $desc DESC");
			}
		}
	}
	//$result = queryMysql("SELECT * FROM data ORDER BY frogID");
	$num = $result->num_rows;
	if($result->num_rows !== 0){
	echo "<div style='padding:0 0 15px 0; margin-bottom:10px; min-width:100%; overflow:auto; border-radius:10px' class='panel panel-success col-xs-12'>
	<i class='fa fa-pencil' style='float:right; cursor:pointer; transform:translate(10px,p2x)' onclick='editList()'></i>";
	echo "<table class='table table-striped'>
		<thead><tr style='border-bottom:3px solid lightgrey'>
			<th class='text-center'>#ID<span id='frogID' style='cursor:pointer' onclick='desc(this.id)'>&utrif;</span><span id='frogID' style='cursor:pointer' onclick='asc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Name<span id='name' style='cursor:pointer' onclick='desc(this.id)'>&utrif;</span><span id='name' style='cursor:pointer' onclick='asc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Gender<span id='gender'  style='cursor:pointer' onclick='desc(this.id)'>&utrif;</span><span id='gender' style='cursor:pointer' onclick='asc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Type<span id='type' style='cursor:pointer' onclick='desc(this.id)'>&utrif;</span><span id='type' style='cursor:pointer' onclick='asc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Environment<span id='environment' style='cursor:pointer' onclick='desc(this.id)'>&utrif;</span><span id='environment' style='cursor:pointer' onclick='asc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Birth<span id='birth' style='cursor:pointer' onclick='desc(this.id)'>&utrif;</span><span id='birth' style='cursor:pointer' onclick='asc(this.id)'>&dtrif;</span></th>
			<th class='text-center'>Death<span id='death' style='cursor:pointer' onclick='desc(this.id)'>&utrif;</span><span id='death' style='cursor:pointer' onclick='asc(this.id)'>&dtrif;</span></th>
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
		echo "</tbody></table>";//view by field desc
}
}else{
	echo "<div class='page-header'>
				<a style='transform:translate(0,40px); color:green;cursor:pointer' class='fa fa-arrow-circle-left fa-2x' href='index.php'></a>
				<h4 class='text-center head'>Search My Frogs</h4>
			</div>";
	echo "<form autocomplete='off' style='display:block; padding-bottom:15px; border-radius:10px;' id='frog' class='text-center panel panel-success'>
	<p class='panel-heading' style='width:100%'>Search Frogs</p>
	<span style='color:red'>*</span>Frog Type: <select name='typefrog'>
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
	Male <input type='radio' name='gender' value='M' checked='checked'> Female <input type='radio' name='gender' value='F'><br><br>Search By:<br><br>
	<input type='text' style='width:50%' autofocus='on' class='fixInput text-center' name='name' placeholder='Frog Name'><br>
	<input type='text' style='width:50%' autofocus='on' class='fixInput text-center' name='environment' placeholder='Environment'><br>
	<input type='text' style='width:50%' autofocus='on' class='fixInput text-center' name='birth' placeholder='Birth'><br>
	<input type='text' style='width:50%' autofocus='on' class='fixInput text-center' name='death' placeholder='Death'><br><br>
	<input type='submit' class='btn btn-success' value='Search' onclick='searchFrogs()'>
	</form>
	";//main view
}
?>