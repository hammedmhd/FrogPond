<?php
include 'functions.php';
session_name('FROG');
session_start();
header('Content-Type: charset=UTF-8');

if (isset($_POST['type'])) {//NEW FROG ENTRY CODE//NEW frog entry
    $result = queryMysql("SELECT * FROM data");
    $num = $result->num_rows;
    $frogID = $num;
    $type = $_POST['type'];
    $name = sanitizeString($_POST['name']);
    $env = sanitizeString($_POST['environment']);
    $birth = sanitizeString($_POST['birth']);
    $gender = $_POST['gender'];
    $death = sanitizeString($_POST['death']);
    if($birth == ''){
        $birth = date('m/d/Y');
    }
    $result = queryMysql("INSERT INTO data VALUES($frogID,'$name','$gender','$type','$env','$birth','$death')");
} elseif (isset($_POST['asc'])) {//Display my frogs by selected field ascending
    $asc = $_POST['asc'];
    echo "<div class='page-header'>
        <a style='transform:translate(0,40px); color:#337AB7;cursor:pointer' class='fa fa-arrow-circle-left fa-2x' href='index.php'></a>
        <h4 class='text-center head'>".ucfirst($_SESSION['user'])."'s Frogs</h4>
        <i id='editme' class='fa fa-plus-circle fa-2x' style='color:#337AB7;float:right; transform:translate(0,-27px);cursor:pointer' onclick='newFrog()'></i>
    </div>";
    echo "<form autocomplete='off' style='padding-bottom:15px; border-radius:10px;' id='newFrog' class='text-center panel panel-default' method='post'>
    <p class='panel-heading' style='width:100%'>New Frog</p>Frog Type: 
    <select name='type'>
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
        <opion value='Rana nigrovittata'>Rana nigrovittata</option>
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
        <input type='submit' class='btn btn-primary' value='Add Frog' onclick='submitNewFrog()'>
        </form>";

    $result = queryMysql("SELECT * FROM data ORDER BY $asc ASC");
    $num = $result->num_rows;
    if ($result->num_rows !== 0) {
        echo "<div style='padding:0 0 15px 0; margin-bottom:10px; min-width:100%; overflow:auto; border-radius:10px' class='panel panel-default col-xs-12'>
            <i class='fa fa-pencil' style='color:#337AB7;font-size:15px; float:right; cursor:pointer;' onclick='editList()'></i>";
        echo "<table class='table table-striped'>
            <thead>
             <tr style='border-bottom:3px solid lightgrey'>
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
		for ($i = 0; $i < $num; $i++) {
		$result->data_seek($i);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		if ($row['name'] == '') {
            $row['name'] = '-';
        }
		if($row['gender'] == '') {
            $row['gender'] = '-';
        }
		if($row['type'] == '') {
            $row['type'] = '-';
        }
		if($row['environment'] == '') {
            $row['environment'] = '-';
        }
		if($row['birth'] == '') {
            $row['birth'] = '-';
        }
		if($row['death'] == '') {
            $row['death'] = '-';
        }
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
	echo '<h3>Your Frogs list is empty.</h3>';//view by given field asc
	}
} elseif (isset($_POST['desc'])) {//Display my frogs by selected field descending
    $desc = $_POST['desc'];
    echo "<div class='page-header'>
        <a style='transform:translate(0,40px); color:green;cursor:pointer' class='fa fa-arrow-circle-left fa-2x' href='index.php'></a>
        <h4 class='text-center head'>".ucfirst($_SESSION['user'])."'s Frogs</h4>
        <i id='editme' class='fa fa-plus-circle fa-2x' style='float:right; transform:translate(0,-27px);color:green;cursor:pointer' onclick='newFrog()'></i>
			</div>";
	echo "<form autocomplete='off' style='padding-bottom:15px; border-radius:10px;' id='newFrog' class='text-center panel panel-default' method='post'>
	    <p class='panel-heading' style='width:100%'>New Frog</p> Frog Type: 
	        <select name='type'>
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
	    <input type='submit' class='btn btn-primary' value='Add Frog' onclick='submitNewFrog()'>
	    </form>";

    $result = queryMysql("SELECT * FROM data ORDER BY $desc DESC");
    $num = $result->num_rows;
    if ($result->num_rows !== 0) {
        echo "<div style='padding:0 0 15px 0; margin-bottom:10px; min-width:100%; overflow:auto; border-radius:10px' class='panel panel-default col-xs-12'>
            <i class='fa fa-pencil' style='color:#337AB7; font-size:15px; float:right; cursor:pointer;' onclick='editList()'></i>";
        echo "<table class='table table-striped'>
            <thead>
                <tr style='border-bottom:3px solid lightgrey'>
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
        for ($i = 0; $i < $num; $i++) {
            $result->data_seek($i);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if ($row['name'] == '') {
                $row['name'] = '-';
            }
            if ($row['gender'] == '') {
                $row['gender'] = '-';
            } 
            if ($row['type'] == '') {
                $row['type'] = '-';
            }
            if ($row['environment'] == '') {
                $row['environment'] = '-';
            }
            if ($row['birth'] == '') {
                $row['birth'] = '-';
            }
            if ($row['death'] == '') {
                $row['death'] = '-';
            }
            echo "<tr>
                <td class='text-center'>".$row['frogID']."</td>
                <td class='text-center'>".$row['name']."</td>
                <td class='text-center'>".$row['gender']."</td>
                <td class='text-center'>".$row['type']."</td>
                <td class='text-center'>".$row['environment']."</td>
                <td class='text-center'>".$row['birth']."</td>
                <td class='text-center'>".$row['death']."</td></tr>";
            }
            echo "</tbody></table>";
    } else {
        echo '<h3>Your Frogs list is empty.</h3>';//view by given field desc
    }
} else {//Main View
    echo "<div class='page-header'>
        <a style='transform:translate(0,45px); color:#337AB7;cursor:pointer' class='fa fa-arrow-circle-left fa-2x' href='index.php'></a>
        &nbsp;&nbsp;&nbsp;&nbsp;<a href='interact.php' style=''><button style='transform:translate(0,40px); padding-left:20px;' class='btn btn-primary btn-sm'>View Frog Pond<b style='display:inline-block; transform:translate(5px,5px);color:gold;font-size:12px'>Beta</b></button></a>
        <h4 class='text-center head'>".ucfirst($_SESSION['user'])."'s Frogs</h4>
        <i id='editme' class='fa fa-plus-circle fa-2x' style='float:right; transform:translate(0,-23px);color:#337AB7;cursor:pointer' onclick='newFrog()'></i>
        </div>";
    echo "<form autocomplete='off' style='padding-bottom:15px; border-radius:10px;' id='newFrog' class='text-center panel panel-default' method='post'>
        <p class='panel-heading' style='width:100%'>New Frog</p> Frog Type: 
        <select name='type'>
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
    <input type='text' style='width:50%' autofocus='on' class='fixInput text-center' name='name' placeholder='*Frog Name'><br>
    <input type='text' style='width:50%' autofocus='on' class='fixInput text-center' name='environment' placeholder='*Environment'><br>
    <input type='text' style='width:50%' autofocus='on' class='fixInput text-center' name='birth' placeholder='Birth (M/D/Y)'><br>
    <input type='text' style='width:50%' autofocus='on' class='fixInput text-center' name='death' placeholder='Death (M/D/Y) - optional'><br><br>
    <input type='submit' class='btn btn-primary' value='Add Frog' onclick='submitNewFrog()'>
    </form>";

    $result = queryMysql("SELECT * FROM data ORDER BY frogID");
    $num = $result->num_rows;
    if ($result->num_rows !== 0) {//if Frogs available display
        echo "<div style='padding:0 0 15px 0; margin-bottom:10px; min-width:100%; overflow:auto; border-radius:10px' class='panel panel-default col-xs-12'>
            <i class='fa fa-pencil' style='color:#337AB7;font-size:15px;float:right; cursor:pointer;' onclick='editList()'></i>";
        echo "<table class='table table-striped'>
            <thead>
                <tr style='border-bottom:3px solid lightgrey'>
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
        for ($i = 0; $i < $num; $i++) {
            $result->data_seek($i);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if ($row['name'] == '') {
                $row['name'] = '-';
            }
            if ($row['gender'] == '') {
                $row['gender'] = '-';
            } 
            if ($row['type'] == '') {
                $row['type'] = '-';
            }
            if ($row['environment'] == '') {
                $row['environment'] = '-';
            }
            if ($row['birth'] == '') {
                $row['birth'] = '-';
            }
            if ($row['death'] == '') {
                $row['death'] = '-';
            }
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
    }else{//Display message
        echo '<h3>Your Frogs list is empty.</h3>';
    }
}
?>
