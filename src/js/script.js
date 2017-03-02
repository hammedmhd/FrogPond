//load into DISPLAY PORTAL
function loadPage(e){
	$('#userView').load(e, function(){
		if(e == 'searchfrogs.php'){
			//$("#userView").css('transform','translate(0,0px)');
		}
	});
}
// UPDATING MALE FROG STATUS BADGE
function updateFrogMale(){
	$.get('male.php', {maleStatus: 1}, function(data){
		$('.green').html(data);
	});
}

//UPDATING FEMALE FROG STATUS BADGE
function updateFrogFemale(){
	$.get('female.php', {femaleStatus: 1}, function(data){
		$('.deepPink').html(data);
	});
}

//SEARCH FROGS Function
function searchFrogs(){
	$('#frog').submit(function(e){
		$('#interact').html('Searching your frogs, please wait...');
		$('.note').fadeIn(500);
		e.preventDefault();
		$.ajax({
			url: 'searchfrogs.php', 
			type: 'post',
			data: $('#frog').serialize(),
			success: function(response){
				$('.note').fadeOut(500, function(){
					$('#userView').html(response);
				});
			}
		});
	});
}

function editUser(){
	if($('#updateUserInfo').is(':visible')){
		$('#updateUserInfo').slideUp();
	}else{
		if($('#deletePanel').is(':visible')) $('#deletePanel').slideUp();
		if($('#newUser').is(':visible')) $('#newUser').slideUp();
		$('#updateUserInfo').slideDown();
	}
}


function DeletePanel(){
	if($('#deletePanel').is(':visible')){
		$('#deletePanel').slideUp();
	}else{
		if($('#updateUserInfo').is(':visible')) $('#updateUserInfo').slideUp();
		$('#deletePanel').slideDown();
	}
}

function newUser(){
	if($('#newUser').is(':visible')){
		$('#newUser').slideUp();
	}else{
		if($('#updateUserInfo').is(':visible')) $('#updateUserInfo').slideUp();
		$('#newUser').slideDown();
	}
}

function newFrog(){
	if($('#newFrog').is(':visible')){
		$('#newFrog').slideUp();
		$('#editme').attr('class','fa fa-plus-circle fa-2x');
	}else{
		$('#editme').attr('class','fa fa-minus-circle fa-2x');
		$('#newFrog').slideDown();
	}
}
//Adding new frog entry
function submitNewFrog(){
	$('#newFrog').submit(function(e){
		if(confirm('Adding a new frog, are you sure?') == true){
		$('#interact').html('Modifiying list of frogs, please wait...');
		$('.note').fadeIn(500);
		e.preventDefault();
		$.post('myfrogs.php', $('#newFrog').serialize(), function(response){
			$('.note').fadeOut(500, function(){
				$('#userView').load('myfrogs.php', function(){
					updateFrogFemale();
					updateFrogMale();
				});
			});
		});
		}else{
		e.preventDefault();
		}
	});
}
//edit my frogs table
function editList(){
	$.get('froglistedit.php', function(response){
			$('#userView').html(response);
	});
}

function deleteUser(){
	$('#interact').html('Logging off and deleting account, please wait...');
	$('.note').fadeIn(500);
	$.post('index.php',	{deleteuser: 1}, function(){
		setTimeout(function(){
			$('.note').fadeOut(500, function(){
					window.location.replace('index.php?logout');
			});
			}, 2000);
	});
}
//load my frogs table
function loadList(){
	$('#userView').load('myfrogs.php');
	updateFrogMale();
	updateFrogFemale();
}
//updating edited table
function updateList(){
	$('#editlist').submit(function(e){
	if(confirm('Updating your frogs list, are you sure?') == true){
	$('#interact').html('Updating frogs list, please wait..');
	$('.note').fadeIn(500);
		e.preventDefault();
		$.post('froglistedit.php', $('#editlist').serialize(), function(response){
			setTimeout(function(){
				$('.note').fadeOut(500, function(){
					updateFrogMale();
					updateFrogFemale();
					$('#userView').load('myfrogs.php');
				});
			}, 1000);
		});
	}else{
		e.preventDefault();
	}
	});
}

function submitUserUpdate(){
	$('#interact').html('Updated your account successfully, and logging out. Please re-sign in to continue');
	$('.note').fadeIn(500);
	$('#updateUserInfo').submit(function(e){
		if(confirm('Updating your accounts login details, are you sure?') == true){
		e.preventDefault();
		$.post('index.php', $('#updateUserInfo').serialize(), function(){
			setTimeout(function(){
				$('.note').fadeOut(500, function(){
					window.location.replace('index.php?logout');
				});
			}, 3500);
		});
		}else{
		e.preventDefault();
		}
	});
}

function submitNewUser(){
	$('#newUser').submit(function(e){
			$('#interact').html('Account created successfully');
			$('.note').fadeIn(500);
		if(confirm('Creating new account, are you sure?') == true){
		e.preventDefault();
		$.post('index.php', $('#newUser').serialize(), function(){
			setTimeout(function(){
				$('.note').fadeOut(500);
			}, 2000);
		});
		}else{
		e.preventDefault();
		}
	});
}

function selectall(s){
	var checkSelectAll = document.getElementById('selectAll');
	var tickthis = document.getElementsByClassName('getcheckbox');
	if(checkSelectAll.checked == true){
		for(var i = 0; i < tickthis.length; i++){
			tickthis[i].checked = true;
		}
	}else{
		for(var i = 0; i < tickthis.length; i++){
			tickthis[i].checked = false;
		}
	}
}

function FrogsByAsc(id){
	$.post('myfrogs.php', {asc: id}, function(data){
		$('#userView').html(data);
	});	
}

function FrogsByDesc(id){
	$.post('myfrogs.php', {desc: id}, function(data){
			$('#userView').html(data);
	});	
}

function desc(id){
	$.post('searchfrogs.php', {desc: id}, function(data){
			$('#userView').html(data);
	});	
}

function asc(id){
	$.post('searchfrogs.php', {asc: id}, function(data){
			$('#userView').html(data);
	});	
}