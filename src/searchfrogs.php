<?php
include 'functions.php';
session_name('FROG');
session_start();
header('Content-Type: charset=UTF-8');

if (isset($_POST['typefrog'])) {//if user posts search credentials
    $name = $_SESSION['name'] = isset($_POST['name']) ? sanitizeString($_POST['name']) : '';
    $type = $_SESSION['type'] = isset($_POST['typefrog']) ? sanitizeString($_POST['typefrog']) : '';
    $gender = $_SESSION['gender'] = isset($_POST['gender']) ? sanitizeString($_POST['gender']) : '';
    $birth = $_SESSION['birth'] = isset($_POST['birth']) ? sanitizeString($_POST['birth']) : '';
    $death = $_SESSION['death'] = isset($_POST['death']) ? sanitizeString($_POST['death']) : '';
    echo "<div class='page-header'>
        <i id='searchfrogs.php' style='transform:translate(0,40px); color:#337AB7;cursor:pointer' class='fa fa-arrow-circle-left fa-2x' onclick='loadPage(this.id)'></i>
        <h4 class='text-center head'>Scanning My Frogs</h4>
        </div>";
    if($type !== 'All'){
        if (!empty($name)) {
            if (!empty($birth)) {
                if (!empty($death)) {
                    $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' AND birth='$birth' AND name='$name' ORDER BY frogID");
                } else {
            $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND birth='$birth' AND name='$name' ORDER BY frogID");
                }
            } else {
                if (!empty($death)) {
                    $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' AND name='$name' ORDER BY frogID");
                } else {
            $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND name='$name' ORDER BY frogID");
                }
            }
        } else {
        if (!empty($birth)) {
            if (!empty($death)) {
                $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' AND birth='$birth' ORDER BY frogID");
            } else {
                $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND birth='$birth' ORDER BY frogID");
            }
        } else {
            if (!empty($death)) {
                $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' ORDER BY frogID");
            } else {
                $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' ORDER BY frogID");
            }
        }
    }
    }else{
        $result = queryMysql("SELECT * FROM data WHERE gender='$gender' ORDER BY frogID");
    }
    
    //$result = queryMysql("SELECT * FROM data ORDER BY frogID");
    $num = $result->num_rows;
    if ($result->num_rows !== 0) {
    echo "<div style='padding:0 0 15px 0; margin-bottom:10px; min-width:100%; overflow:auto; border-radius:10px' class='panel panel-default col-xs-12'>
        <i class='fa fa-pencil' style='font-size:15px; color:#337AB7; float:right; cursor:pointer;' onclick='editList2()'></i>";

    echo "<table class='table table-striped'>
        <thead>
            <tr style='border-bottom:3px solid lightgrey'>
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
                <td class='text-center'>" . $row['frogID'] . "</td>
                <td class='text-center'>".$row['name']."</td>
                <td class='text-center'>".$row['gender']."</td>
                <td class='text-center'>".$row['type']."</td>
                <td class='text-center'>".$row['environment']."</td>
                <td class='text-center'>".$row['birth']."</td>
                <td class='text-center'>".$row['death']."</td></tr>";
            }
            echo "</tbody></table>"; 
    }
} elseif (isset($_POST['asc'])) {//view frogs by ascending field on user select
    $asc = $_POST['asc'];
    $name = isset($_SESSION['name']) ? $_SESSION['name']: '';
    $type =  isset($_SESSION['type']) ? $_SESSION['type'] : '';
    $gender =  isset($_SESSION['gender']) ? $_SESSION['gender'] : '';
    $birth =  isset($_SESSION['birth']) ? $_SESSION['birth'] : '';
    $death =  isset($_SESSION['death']) ? $_SESSION['death'] : '';
    echo "<div class='page-header'>
        <i id='searchfrogs.php' style='transform:translate(0,40px); color:#337AB7;cursor:pointer' class='fa fa-arrow-circle-left fa-2x' onclick='loadPage(this.id)'></i>
        <h4 class='text-center head'>Search My Frogs</h4>
        </div>";
    if($type !== 'All'){
        if (!empty($name)) {
            if (!empty($birth)) {
                if (!empty($death)) {
                    $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' AND birth='$birth' AND name='$name' ORDER BY $asc ASC");
                } else {
                    $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND birth='$birth' AND name='$name' ORDER BY $asc ASC");
                }
            } else {
                if (!empty($death)) {
                    $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' AND name='$name' ORDER BY $asc ASC");
                } else {
                    $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND name='$name' ORDER BY $asc ASC");
                }
            }
        } else {
            if (!empty($birth)) {
        	    if (!empty($death)) {
        	        $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' AND birth='$birth' ORDER BY $asc ASC");
        	    } else {
        	        $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND birth='$birth' ORDER BY $asc ASC");
        	    }
        	} else {
        	    if (!empty($death)) {
        	        $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' ORDER BY $asc ASC");
        	    } else {
        	    	$result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' ORDER BY $asc ASC");
        	    }
        	}
        }
    }else{
        $result = queryMysql("SELECT * FROM data WHERE gender='$gender' ORDER BY $asc ASC");
    }
    //$result = queryMysql("SELECT * FROM data ORDER BY frogID");
    $num = $result->num_rows;
    if ($result->num_rows !== 0) {
        echo "<div style='padding:0 0 15px 0; margin-bottom:10px; min-width:100%; overflow:auto; border-radius:10px' class='panel panel-default col-xs-12'>
            <i class='fa fa-pencil' style='float:right; color:#337AB7;font-size:15px; cursor:pointer;' onclick='editList2()'></i>";
        echo "<table class='table table-striped'>
            <thead>
                <tr style='border-bottom:3px solid lightgrey'>
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
                <td class='text-center'>" . $row['frogID'] . "</td>
                <td class='text-center'>".$row['name']."</td>
                <td class='text-center'>".$row['gender']."</td>
                <td class='text-center'>".$row['type']."</td>
                <td class='text-center'>".$row['environment']."</td>
                <td class='text-center'>".$row['birth']."</td>
                <td class='text-center'>".$row['death']."</td>
                </tr>";
        }
		echo "</tbody></table>";//view by field asc
	}//if Ascending by field
} elseif (isset($_POST['desc'])) {//view frogs by descending field on user select
    $desc = $_POST['desc'];
    $name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
    $type =  isset($_SESSION['type']) ? $_SESSION['type'] : '';
    $gender = isset($_SESSION['gender']) ? $_SESSION['gender'] : '';
    $birth =  isset($_SESSION['birth']) ? $_SESSION['birth'] : '';
    $death =  isset($_SESSION['death']) ? $_SESSION['death'] : '';
    echo "<div class='page-header'>
        <i id='searchfrogs.php' style='transform:translate(0,40px);color:#337AB7;cursor:pointer' class='fa fa-arrow-circle-left fa-2x' onclick='loadPage(this.id)'></i>
        <h4 class='text-center head'>Search My Frogs</h4>
        </div>";
    if($type !== 'All'){     
        if (!empty($name)) {
            if (!empty($birth)) {
                if (!empty($death)) {
                    $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' AND birth='$birth' AND name='$name' ORDER BY $desc DESC");
                } else {
                    $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND birth='$birth' AND name='$name' ORDER BY $desc DESC");
                }
            } else {
                if (!empty($death)) {
                    $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' AND name='$name' ORDER BY $desc DESC");
                } else {
                    $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND name='$name' ORDER BY $desc DESC");
                }
            }
        } else {
            if (!empty($birth)) {
                if (!empty($death)) {
                    $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' AND birth='$birth' ORDER BY $desc DESC");
                } else {
                    $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND birth='$birth' ORDER BY $desc DESC");
                }
            } else {
                if (!empty($death)) {
                    $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' ORDER BY $desc DESC");
                } else {
                    $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' ORDER BY $desc DESC");
                }
            }
        }
    }else{
        $result = queryMysql("SELECT * FROM data WHERE gender='$gender' ORDER BY $desc DESC");
    }
    //$result = queryMysql("SELECT * FROM data ORDER BY frogID");
    $num = $result->num_rows;
    if($result->num_rows !== 0){
        echo "<div style='padding:0 0 15px 0; margin-bottom:10px; min-width:100%; overflow:auto; border-radius:10px' class='panel panel-default col-xs-12'>
            <i class='fa fa-pencil' style='font-size:15px; float:right; color:#337AB7; cursor:pointer; transform:translate(10px,p2x)' onclick='editList2()'></i>";
        echo "<table class='table table-striped'>
            <thead>
            <tr style='border-bottom:3px solid lightgrey'>
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
                <td class='text-center'>" . $row['frogID'] . "</td>
                <td class='text-center'>".$row['name']."</td>
                <td class='text-center'>".$row['gender']."</td>
                <td class='text-center'>".$row['type']."</td>
                <td class='text-center'>".$row['environment']."</td>
                <td class='text-center'>".$row['birth']."</td>
                <td class='text-center'>".$row['death']."</td>
                </tr>";
        }
        echo "</tbody></table>";//view by field desc
    }
} elseif (isset($_GET['editlist'])) {
    $name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
    $type =  isset($_SESSION['type']) ? $_SESSION['type'] : '';
    $gender =  isset($_SESSION['gender']) ? $_SESSION['gender'] : '';
    $birth =  isset($_SESSION['birth']) ? $_SESSION['birth'] : '';
    $death =  isset($_SESSION['death']) ? $_SESSION['death'] : '';

    //Initialize View for editing data
    $male = '<select name="editgender[]"><option value="M" selected="selected">M</option><option value="F">F</option></select>';
    $female = '<select name="editgender[]"><option value="M">M</option><option value="F" selected="selected">F</option></select>';
    $neutral = '<select name="editgender[]"><option value="M">M</option><option value="F">F</option></select>';

    $results;
    echo "<div class='page-header'>
        <i style='transform:translate(0,40px); color:#337AB7;cursor:pointer' class='fa fa-arrow-circle-left fa-2x' onclick='loadList2()'></i>
        <h4 class='text-center head'>".ucfirst($_SESSION['user'])."'s Frogs Editing</h4>
        </div>";
    if($type !== 'All'){
        if (!empty($name)) {
            if (!empty($birth)) {
                if (!empty($death)) {
                    $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' AND birth='$birth' AND name='$name' ORDER BY FrogID");
                } else {
                    $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND birth='$birth' AND name='$name' ORDER BY FrogID");
                }
            } else {
                if (!empty($death)) {
                    $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' AND name='$name' ORDER BY FrogID");
                } else {
                    $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND name='$name' ORDER BY FrogID");
                }
            }
        } else {
            if (!empty($birth)) {
                if (!empty($death)) {
                    $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' AND birth='$birth' ORDER BY FrogID");
                } else {
                    $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND birth='$birth' ORDER BY FrogID");
                }
            } else {
                if (!empty($death)) {
                    $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' AND death='$death' ORDER BY FrogID");
                } else {
                    $result = queryMysql("SELECT * FROM data WHERE type='$type' AND gender='$gender' ORDER BY FrogID");
                }
            }
        }
    }else{
        $result = queryMysql("SELECT * FROM data WHERE gender='$gender' ORDER BY frogID");
    }

    $num = $result->num_rows;
    if ($result->num_rows !== 0) {
        echo "<i class='fa fa-minus-circle' style='font-size:15;float:right;color:#337AB7;cursor:pointer;' onclick='loadList2()'></i><div style='padding:0 0 15px 0; margin-bottom:10px; min-width:100%; overflow:auto; border-radius:10px' class='panel panel-default col-xs-12'>
        <form id='editlist'>";

        echo "<table class='table table-striped special'>
            <thead>
            <tr style='border-bottom:3px solid lightgrey'>
                <th style='max-width:20px'><input type='checkbox' id='selectAll' onchange='selectall()'></th>
                <th class='text-center'>#ID</th>
                <th class='text-center'>Name</th>
                <th class='text-center'>Gender</th>
                <th class='text-center'>Type</th>
                <th class='text-center'>Environment</th><th class='text-center'>Birth</th>
                <th class='text-center'>Death</th>
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
        if ($row['gender'] == 'M') {
            $results = $male;
        } else if ($row['gender'] == 'F') {
            $results = $female;
        }
        //Frog type default selection initialization on editing screen.
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
    echo "<tr><td><input type='submit' value='Update' class='btn btn-primary' style='float:left' onclick='updateList()'></td><td></td><td></td><td></td><td></td><td><td/><td></td></tr></tbody></table></form></div>";
    }    
} else {//Main View for searching frog data
	echo "<div class='page-header'>
	    <a style='transform:translate(0,40px); color:#337AB7;cursor:pointer' class='fa fa-arrow-circle-left fa-2x' href='index.php'></a>
	    <h4 class='text-center head'>Search My Frogs</h4>
	    </div>";
	echo "<form autocomplete='off' style='display:block; padding-bottom:15px; border-radius:10px;' id='frog' class='text-center panel panel-default'>
	    <p class='panel-heading' style='width:100%'>Search Frogs</p>
	    <span style='color:red'>*</span>Frog Type: 
	    <select autofocus='on' name='typefrog'>
            <option value='All'>All</option>
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
	    Male <input type='radio' name='gender' value='M' checked='checked'> Female <input type='radio' name='gender' value='F'><br><br><span id='hideonAll'>Search By:</span><br><br>
	    <input type='text' style='width:50%' class='fixInput text-center' name='name' placeholder='Frog Name'><br>
	    <input type='text' style='width:50%' class='fixInput text-center' name='birth' placeholder='Birth (M/D/Y)'><br>
	    <input type='text' style='width:50%' class='fixInput text-center' name='death' placeholder='Death (M/D/Y)'><br><br>
	    <input type='submit' class='btn btn-primary' value='Search' onclick='searchFrogs()'>
	    </form>";
}
?>