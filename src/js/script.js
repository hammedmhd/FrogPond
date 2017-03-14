window.onload = function(){
	if(typeof(localStorage.newUser) != 'undefined' && localStorage.newUser !== null){
		$('#newUser').slideDown(300);
	}
	if(typeof(localStorage.editUser) != 'undefined' && localStorage.editUser !== null){
		$('#updateUserInfo').slideDown(300);
	}
	if(typeof(localStorage.searchFrogs) != 'undefined' && localStorage.searchFrogs !== null){
		loadPage(localStorage.searchFrogs);
	}
	if(typeof(localStorage.reload) != 'undefined' && localStorage.reload !== null){
		loadPage(localStorage.reload);
		setTimeout(function(){
			if(typeof(localStorage.addFrog) != 'undefined' && localStorage.addFrog !== null){
				$('#newFrog').slideDown(100);
				$('input[name=name]').val(localStorage.name);
				$('select[name=type]').val(localStorage.type);
				$('input[name=environment]').val(localStorage.env);
				$('input[name=birth]').val(localStorage.birth);
				$('input[name=death]').val(localStorage.death);
				$('input[name=gender][value="'+localStorage.gender+'"]').prop('checked', true);
			}
		},500);
	}
	setTimeout(function(){
		localStorage.clear();
	}, 1000);
}

setInterval(function(){
	if($('select[name=typefrog]').val() !== 'All'){
	    $('#frog input[name=name]').fadeIn(500);
	    $('#frog input[name=birth]').fadeIn(500);
		$('#frog input[name=death]').fadeIn(500);
		$('#hideonAll').fadeIn(500);
	}else{
		$('#frog input[name=name]').fadeOut(1000);
		$('#frog input[name=birth]').fadeOut(1000);
		$('#frog input[name=death]').fadeOut(1000);
		$('#hideonAll').fadeOut(1000);
	}
}, 10);

function reloadHome(){
	localStorage.reload = 'myfrogs.php';
}
//load into DISPLAY PORTAL
function loadPage(e){
	$('#userView').load(e);
}
// UPDATING MALE FROG STATUS BADGE
function updateFrogMale(){
	$.get('male.php', {maleStatus: 1}, function(data){
		if(data == 0){
		$('.green').css('background-color','lightgrey');	
		}else{
			$('.green').css('background-color','limegreen');
		}
		$('.green').html(data);

	});
}

//UPDATING FEMALE FROG STATUS BADGE
function updateFrogFemale(){
	$.get('female.php', {femaleStatus: 1}, function(data){
		if(data == 0){
		$('.deepPink').css('background-color','lightgrey');	
		}else{
			$('.deepPink').css('background-color','#fe5b63');
		}
		$('.deepPink').html(data);
	});
}

function dateCompare(birth, death){
	return new Date(death) > new Date(birth);
}

//SEARCH FROGS Function
function searchFrogs(){
	$('#frog').submit(function(e){
		e.preventDefault();
		$('#interact').html('Validating search credentials, please wait...');
		$('.note').fadeIn(500);
		name = $('input[name=name]').val();
		type = $('select[name=typefrog]').val();
		birth = $('input[name=birth]').val();
		death = $('input[name=death]').val();
		gender = $('input[type=radio][name=gender]:checked').val();
		localStorage.n = name;
		localStorage.t = type;
		localStorage.b = birth;
		localStorage.g = gender;
		localStorage.d = death;
		$.ajax({
			url: 'searchfrogs.php', 
			type: 'post',
			data: $('#frog').serialize(),
			success: function(response){
				setTimeout(function(){
					$('.note').fadeOut(500, function(){
						$('#userView').html(response);
					});
				},1000);
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

function sendFrog(n,t,e,g,b,d){
	if(n !== '' && e !== '' && (b == '' || b < d)){
		$('.note').fadeOut(500, function(){
			if(confirm('Adding a new frog, continue?') == true){
				$('#interact').html('Modifiying list of frogs, please wait...');
				$('.note').fadeIn(500);
				$.post('myfrogs.php', $('#newFrog').serialize(), function(response){
					localStorage.reload = 'myfrogs.php';
					setTimeout(function(){
						$('.note').fadeOut(500, function(){
						location.reload();
						});
					}, 2000);
				});
			}else{
				$('.note').fadeIn(1000);
				$('#interact').html('Adding a new frog cancelled, redirecting please wait...');
				localStorage.reload = 'myfrogs.php';
				localStorage.addFrog = true;
				localStorage.name = n;
				localStorage.type = t;
				localStorage.env = e;
				localStorage.gender = g;
				localStorage.birth = b;
				localStorage.death = d;
				setTimeout(function(){
					$('.note').fadeOut(500, function(){
						location.reload();
					});
				}, 3000);
			}
		});
	}else{
		setTimeout(function(){
			$('.note').fadeOut(500, function(){
				$('#interact').html('Validation failed (re-check name/environment), redirecting please wait...');
			});
		}, 1000);
		setTimeout(function(){
			$('.note').fadeIn(500);
		},1500);
		localStorage.reload = 'myfrogs.php';
		localStorage.addFrog = true;
		localStorage.name = n;
		localStorage.type = t;
		localStorage.env = e;
		localStorage.gender = g;	
		localStorage.birth = b;
		localStorage.death = d;
		setTimeout(function(){
			$('.note').fadeOut(500, function(){
				location.reload();
			});
		}, 4000);
	}
}

//Adding new frog entry
function submitNewFrog(){
	$('#newFrog').submit(function(e){
		e.preventDefault();
		$('#interact').html('Validating new frog, please wait...');
		$('.note').fadeIn(500, function(){//VALIDATING NEW FROG
			var name = $('input[name=name]').val();
			var type = $('select[name=type]').val();
			var env = $('input[name=environment]').val();
			var birth = $('input[name=birth]').val();
			var death = $('input[name=death]').val();
			var gender = $('input[type=radio][name=gender]:checked').val();
			//localStorage.reload = 'myfrogs.php';
			//localStorage.addFrog = true;
			localStorage.name = name;
			localStorage.type = type;
			localStorage.env = env;
			localStorage.gender = gender;
			localStorage.birth = birth;
			localStorage.death = death;
			sendFrog(name,type,env,gender,birth,death);
		});
	});
}

//edit my frogs table
function editList(){
	$.get('froglistedit.php', function(response){
			$('#userView').html(response);
	});
}

function editList2(){
	$.get('searchfrogs.php', {editlist: 1}, function(response){
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
			}, 1500);
	});
}
//load my frogs table
function loadList(){
	$('#userView').load('myfrogs.php');
	updateFrogMale();
	updateFrogFemale();
}

function loadList2(){
	$.post('searchfrogs.php', {typefrog: localStorage.t, name: localStorage.n, gender: localStorage.g, birth: localStorage.b, death: localStorage.d}, function(response){
			$('#userView').html(response);
	});
	updateFrogMale();
	updateFrogFemale();
}
//updating edited table
function updateList(){
	$('#editlist').submit(function(e){
	if(confirm('Updating your frogs details, continue?') == true){
	$('#interact').html('Updating frogs list, please wait.');
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
	$('#updateUserInfo').submit(function(e){
		e.preventDefault();
		if(confirm('Updating your account login details, continue?') !== true){
		$('#interact').html('Updating your login details aborted.');
		$('.note').fadeIn(500,function(){
			setTimeout(function(){
				$('.note').fadeOut(500,function(){
					location.reload();
				});
			}, 1500);
		});
		}else{
			var name = $('input[name=usern]').val();
			var pass = $('input[name=passw]').val();
			if(name == '' || pass == ''){
				$('#interact').html('Failed to update, check username/password & try again...');
				$('.note').fadeIn(500);
				setTimeout(function(){
					$('.note').fadeOut(500, function(){
						localStorage.editUser = true;
						location.reload();
					});
				}, 2000);
			}else{
				$('#interact').html('Updating your login details and logging off, please login to continue.');
				$('.note').fadeIn(500,function(){
					$.post('index.php', $('#updateUserInfo').serialize(), function(){
						setTimeout(function(){
							$('.note').fadeOut(500, function(){
								window.location.replace('index.php?logout');
							});
						}, 3500);
					});
				});
			}
		}
	});
}

function submitNewUser(){
	$('#newUser').submit(function(e){
	e.preventDefault();
	if(confirm('Creating new account, continue?') !== true){
		$('#interact').html('Adding new user aborted, please wait...');
		$('.note').fadeIn(500,function(){
			setTimeout(function(){
				$('.note').fadeOut(500,function(){
					location.reload();
				});
			}, 1000);
		});
	}else{
		var name = $('input[name=newuser2]').val();
		var pass = $('input[name=newpassw]').val();
		if(name == '' || pass == ''){
			$('#interact').html('Failed to validate new user, please wait & try again...');
			$('.note').fadeIn(500);
			setTimeout(function(){
				$('.note').fadeOut(500, function(){
					localStorage.newUser = true;
					location.reload();
				});
			}, 2000);
		}else{
			$('#interact').html('Account created successfully');
			$('.note').fadeIn(500);
			$.post('index.php', $('#newUser').serialize(), function(){
			setTimeout(function(){
				$('.note').fadeOut(500,function(){
					location.reload();
				});
			}, 2000);
			});
		}
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